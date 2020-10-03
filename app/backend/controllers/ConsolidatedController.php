<?php
namespace backend\controllers;

use Yii;
use backend\models\Consolidated;
use backend\models\FixedCost;
use backend\models\search\ConsolidatedSearch;
use backend\models\search\FixedCostSearch;
use backend\models\search\InvoiceValidationSearch;
use backend\models\search\ProvidersValidationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ConsolidatedController implements the CRUD actions for Consolidated model.
 */
class ConsolidatedController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['admin'],
                        'roles'   => ['consolidated/admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Consolidated models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ConsolidatedSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Consolidated model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Consolidated model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Consolidated();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Consolidated model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Consolidated model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Consolidated model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Consolidated the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Consolidated::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

	public function actionAdmin()
    {
        $dataGraphic = ["months"=>[], "revenue_invoiced"=>[], "spend_invoiced"=>[], "profit_invoiced"=>[], "objective_revenue"=>[]];
        $dataChartFixedCostsByCategory = [];
        $dataChartFixedCostsByModel    = [];
        $goalCompletionByModel = [
            "Branding"=>["avg_profit"=>0,"avg_rev"=>0,"profit"=>0,"rev"=>0],
            "Media Buying"=>["avg_profit"=>0,"avg_rev"=>0,"profit"=>0,"rev"=>0],
            "Performance"=>["avg_profit"=>0,"avg_rev"=>0,"profit"=>0,"rev"=>0],
            "Global"=>["avg_profit"=>0,"avg_rev"=>0,"profit"=>0,"rev"=>0]
            ];
        $totalSum = [
            "revenue" => ["server"=>0, "transaction"=>0, "agency_commission"=>0, "to_validate"=>0, "validated"=>0, "invoiced"=>0, "manual"=>0, "transaction"=>0],
            "spend" => ["server"=>0, "off"=>0, "transaction"=>0, "to_validate"=>0, "validated"=>0, "invoiced"=>0, "manual"=>0, "fixed_cost"=>0],
            "profit" => ["invoiced"=>0, "manual"=>0 ],
            "objective" => ["profit"=>0,"revenue"=>0]
            ];

        $request = Yii::$app->request;
        $params  = $request->queryParams;
        $get     = $request->get();

        $startDate       = isset($get['startDate']) ? $get['startDate'] : date('Y-m-01',strtotime('NOW -1 month'));
        $endDate         = isset($get['endDate']) ? $get['endDate'] : date('Y-m-01',strtotime('NOW -1 month'));
        $businessModelId = isset($get['businessModelId']) ? $get['businessModelId'] : NULL ;

        /* Datos consolidados por mes (Revenue y gastos de media) */
        $model        = new Consolidated;
        $searchModel  = new ConsolidatedSearch();
        $dataProvider = $searchModel->search($params);

        /* Datos de los costos fijos por mes */
        $searchModelFixedCosts = new FixedCostSearch();
        $dataFixedCosts        = $searchModelFixedCosts->search($params)['dataProvider'];
        $fixedCostRecords      = $dataFixedCosts->getModels();

        /*Data para el grid (Pensar una Refactorización) */
        $dataProviderGrid = $searchModel->searchGrid($params);
        
        /* Costos fijos agrupados por modelo */
        $paramsFixedCostByModel = $params;
        $paramsFixedCostByModel["groupByModel"] = TRUE;
        $dataFixedCostsByModel        = $searchModelFixedCosts->search($paramsFixedCostByModel)['dataProvider'];
        $fixedCostRecordsByModel      = $dataFixedCostsByModel->getModels();
        $i=0;
        foreach ($fixedCostRecordsByModel as $key => $record) {
            $dataChartFixedCostsByModel[$i]=[$record->description,floatval($record->cost)];
            $i++;
        }

        /* Costos fijos agrupados por categoria de costo */
        $paramsFixedCostsByCategory = $params;
        $paramsFixedCostsByCategory["groupByCostCategory"] = TRUE;
        $dataFixedCostsByCategory        = $searchModelFixedCosts->search($paramsFixedCostsByCategory)['dataProvider'];
        $fixedCostRecordsByCategory      = $dataFixedCostsByCategory->getModels();
        $i=0;
        foreach ($fixedCostRecordsByCategory as $key => $record) {
            $dataChartFixedCostsByCategory[$i]=[$record->description,floatval($record->cost)];
            $i++;
        }

        //Porcentajes de revenue invoiceado por modelo de negocio y fecha
        $dataProviderGridAverages = $searchModel->searchGridAverages($params);

        //$totals: Array con los totales para las metricas
        foreach($dataProvider->getModels() as $record) {
            $totalSum["revenue"]["server"]            += $record->revenue_server; 
            $totalSum["revenue"]["transaction"]       += $record->revenue_transaction; 
            $totalSum["revenue"]["to_validate"]       += $record->revenue_to_validate;
            $totalSum["revenue"]["validated"]         += $record->revenue_validated;
            $totalSum["revenue"]["manual"]            += $record->revenue_manual;
            $totalSum["revenue"]["invoiced"]          += $record->revenue_invoiced;
            $totalSum["revenue"]["agency_commission"] += $record->agency_commission;
            $totalSum["spend"]["server"]              += $record->spend_server; 
            $totalSum["spend"]["off"]                 += $record->spend_off; 
            $totalSum["spend"]["transaction"]         += $record->spend_transaction; 
            $totalSum["spend"]["to_validate"]         += $record->spend_to_validate; 
            $totalSum["spend"]["validated"]           += $record->spend_validated; 
            $totalSum["spend"]["invoiced"]            += $record->spend_invoiced; 
            $totalSum["spend"]["manual"]              += $record->spend_manual; 
            $totalSum["profit"]["invoiced"]           += $record->revenue_invoiced - $record->spend_invoiced; 
            $totalSum["objective"]["revenue"]         += $record->objective_revenue; 
            $totalSum["objective"]["profit"]          += $record->objective_profit; 
        }
        $totalSum["revenue"]["not_validated"] = floatval($totalSum["revenue"]["to_validate"]-$totalSum["revenue"]["validated"]);
        foreach($fixedCostRecords as $record)
        {
            $totalSum["spend"]["fixed_cost"] += $record->cost;
        }
        $totalSum["spend"]["not_validated"] = $totalSum["spend"]["to_validate"] - $totalSum["spend"]["validated"];
        $totalSum["spend"]["final"]         = $totalSum["spend"]["invoiced"] + $totalSum["spend"]["fixed_cost"];

        $searchModelProvidersValidation = new ProvidersValidationSearch();
        $spendPaid = $searchModelProvidersValidation->getAmountPaidByPeriod($startDate,$endDate)->getModels();
        $totalSum["spend"]["paid"] = !empty($spendPaid) ? $spendPaid[0]->amount : 0;

        // $dataGraphic: data para el gŕafico de progreso por mes
        $paramsResultGraphic = $params;
        $paramsResultGraphic["groupByMonth"] = TRUE;
        $resultGraphic = $searchModel->search($paramsResultGraphic);
        foreach($resultGraphic->getModels() as $record)
        {
            $dataGraphic["months"][]            = date('F',strtotime($record->period));
            $dataGraphic["revenue_invoiced"][]  = floatval($record->revenue_invoiced);
            $dataGraphic["spend_invoiced"][]    = floatval($record->spend_invoiced);
            $dataGraphic["profit_invoiced"][]   = floatval($record->revenue_invoiced - $record->spend_invoiced); 
            $dataGraphic["objective_revenue"][] = floatval($record->objective_profit); 
        }

        //goalCompletionByModel: Data para el gŕafico de porcentaje de objetivo cumplido por modelo
        $paramsGoalCompletion = $params;
        $paramsGoalCompletion["groupByModel"] = TRUE;
        $resultGoalCompletion = $searchModel->search($paramsGoalCompletion);
        $objective_profit=0;
        $objective_revenue=0;
        $profit=0;
        $revenue=0;

        foreach($resultGoalCompletion->getModels() as $record)
        {
            switch ($record->businessModelName) {
                case 'Branding':
                    $goalCompletionByModel["Branding"]["profit"]     = floatval($record->revenue_validated - $record->spend_validated);
                    $goalCompletionByModel["Branding"]["rev"]        = floatval($record->revenue_validated);
                    $goalCompletionByModel["Branding"]["avg_profit"] = $record->objective_profit != 0 ? ($record->revenue_validated - $record->spend_validated) * 100 / $record->objective_profit : 0;
                    $goalCompletionByModel["Branding"]["avg_rev"]    = $record->objective_revenue != 0 ? $record->revenue_validated * 100 / $record->objective_revenue : 0;
                    $profit            += floatval($record->revenue_validated - $record->spend_validated);
                    $revenue           += floatval($record->revenue_validated);
                    $objective_revenue += floatval($record->objective_revenue);
                    $objective_profit  += floatval($record->objective_profit);
                    break;

                case 'Media Buying':
                    $goalCompletionByModel["Media Buying"]["profit"]     = floatval($record->revenue_validated - $record->spend_validated);
                    $goalCompletionByModel["Media Buying"]["rev"]        = floatval($record->revenue_validated);
                    $goalCompletionByModel["Media Buying"]["avg_profit"] = $record->objective_profit != 0 ? ($record->revenue_validated - $record->spend_validated) * 100 / $record->objective_profit : 0;
                    $goalCompletionByModel["Media Buying"]["avg_rev"]    = $record->objective_revenue != 0 ? $record->revenue_validated * 100 / $record->objective_revenue : 0;
                    $profit            += floatval($record->revenue_validated - $record->spend_validated);
                    $revenue           += floatval($record->revenue_validated);
                    $objective_revenue += floatval($record->objective_revenue);
                    $objective_profit  += floatval($record->objective_profit);
                    break;

                case 'Performance':
                    $goalCompletionByModel["Performance"]["profit"]     = floatval($record->revenue_validated - $record->spend_validated);
                    $goalCompletionByModel["Performance"]["rev"]        = floatval($record->revenue_validated);
                    $goalCompletionByModel["Performance"]["avg_profit"] = $record->objective_profit != 0 ? ($record->revenue_validated - $record->spend_validated) * 100 / $record->objective_profit : 0;
                    $goalCompletionByModel["Performance"]["avg_rev"]    = $record->objective_revenue != 0 ? $record->revenue_validated * 100 / $record->objective_revenue : 0;
                    $profit            += floatval($record->revenue_validated - $record->spend_validated);
                    $revenue           += floatval($record->revenue_validated);
                    $objective_revenue += floatval($record->objective_revenue);
                    $objective_profit  += floatval($record->objective_profit);
                    break;
                
                default:
                    # code...
                    break;
            }
            $goalCompletionByModel["Global"]["avg_rev"] = $objective_revenue != 0 ? $revenue * 100 / $objective_revenue : 0;
            $goalCompletionByModel["Global"]["avg_profit"] = $objective_profit != 0 ? $profit * 100 / $objective_profit : 0;
        }

        /* PORCENTAJES REVENUE */
        $avgRevenue["validated"]     = $totalSum["revenue"]["to_validate"] != 0 ? number_format(round($totalSum["revenue"]["validated"] * 100 / $totalSum["revenue"]["to_validate"],2), $totalSum["revenue"]["to_validate"] == $totalSum["revenue"]["validated"] ? 0 : 2 ) : 0;
        $avgRevenue["not_validated"] = $totalSum["revenue"]["to_validate"] != 0 ? number_format(round($totalSum["revenue"]["not_validated"] * 100 / $totalSum["revenue"]["to_validate"],2), $totalSum["revenue"]["to_validate"] == $totalSum["revenue"]["not_validated"] ? 0 : 2) : 0;
        $avgRevenue["invoiced"]      = $totalSum["revenue"]["to_validate"] != 0 ? number_format(round($totalSum["revenue"]["invoiced"] * 100 / $totalSum["revenue"]["to_validate"],2),$totalSum["revenue"]["to_validate"] == $totalSum["revenue"]["invoiced"] ? 0 : 2) : 0;

        /* PORCENTAJES SPEND */
        $avgSpend["validated"]     = $totalSum["spend"]["to_validate"] != 0 ? number_format(round($totalSum["spend"]["validated"] * 100 / $totalSum["spend"]["to_validate"],2), $totalSum["spend"]["to_validate"] == $totalSum["spend"]["validated"] ? 0 : 2) : 0;
        $avgSpend["not_validated"] = $totalSum["spend"]["to_validate"] != 0 ? number_format(round($totalSum["spend"]["not_validated"] * 100 / $totalSum["spend"]["to_validate"],2),$totalSum["spend"]["to_validate"] == $totalSum["spend"]["not_validated"] ? 0 : 2) : 0;
        $avgSpend["invoiced"]      = $totalSum["spend"]["to_validate"] != 0 ? number_format(round($totalSum["spend"]["invoiced"] * 100 / $totalSum["spend"]["to_validate"],2),$totalSum["spend"]["to_validate"] == $totalSum["spend"]["invoiced"] ? 0 : 2) : 0;

        /* Data para los grid de invoice pendientes */
        $searchModelInvoiceValidation  = new InvoiceValidationSearch();
        $paramsInvoice = $params;
        $paramsInvoice["notInvoiced"] = TRUE;
        $paramsInvoice["validated"] = TRUE;
        $paramsInvoice["type"] = "Revenue";
        $dataProviderPendingInvoiceRevenue = $searchModelInvoiceValidation->search($paramsInvoice);
        $paramsInvoice["type"] = "Spend";
        $dataProviderPendingInvoiceSpend = $searchModelInvoiceValidation->search($paramsInvoice);

        return $this->render('admin', [
            'model'                             => $model,
            'searchModel'                       => $searchModel,
            'dataProvider'                      => $dataProvider,
            'startDate'                         => $startDate,
            'endDate'                           => $endDate,
            'businessModelId'                   => $businessModelId,
            'totalSum'                          => $totalSum,
            'dataGraphic'                       => $dataGraphic,
            'goalCompletionByModel'             => $goalCompletionByModel,
            'dataChartFixedCostsByModel'        => $dataChartFixedCostsByModel,
            'dataChartFixedCostsByCategory'     => $dataChartFixedCostsByCategory,
            'avgRevenue'                        => $avgRevenue,
            'avgSpend'                          => $avgSpend,
            'dataProviderGrid'                  => $dataProviderGrid,
            'dataProviderPendingInvoiceRevenue' => $dataProviderPendingInvoiceRevenue,
            'dataProviderPendingInvoiceSpend'   => $dataProviderPendingInvoiceSpend,
            'dataProviderGridAverages'          => $dataProviderGridAverages
        ]);
    }
}
