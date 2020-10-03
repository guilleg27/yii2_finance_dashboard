<?php
namespace backend\controllers;

use Yii;
use backend\models\FixedCost;
use backend\models\search\FixedCostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;

/**
 * FixedCostController implements the CRUD actions for FixedCost model.
 */
class FixedCostController extends Controller
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
                        'actions' => ['bulkDelete'],
                        'roles'   => ['fixed-cost/bulkDelete'],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['create'],
                        'roles'   => ['fixed-cost/create'],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['delete'],
                        'roles'   => ['fixed-cost/delete'],
                    ],
                    [

                        'allow'   => true,
                        'actions' => ['index'],
                        'roles'   => ['fixed-cost/index'],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['update'],
                        'roles'   => ['fixed-cost/update'],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['view'],
                        'roles'   => ['fixed-cost/view'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all FixedCost models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $params        = Yii::$app->request->queryParams;
        $request       = Yii::$app->request;
        $get           = $request->get();
        $startDate     = isset($get['startDate']) ? $get['startDate'] : date('Y-m-01',strtotime('NOW -1 month'));
        $endDate       = isset($get['endDate']) ? $get['endDate'] : date('Y-m-01',strtotime('NOW -1 month'));

        $fixedCost = new FixedCost;
        $dataFixedCost = $fixedCost->getCosts();
        // var_dump($fixedCost->getCosts());
        $searchModel     = new FixedCostSearch();
        $fixedCostSearch = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider    = $fixedCostSearch['dataProvider'];
        $fixedCostData   = $fixedCostSearch['data'];
        $businessModels  = [];
        $categories      = [];
        $data            = [];
        $timeData        = [];

        foreach ($fixedCostData as $key => $value) {
            $data[$value->businessModel->business_model][$value->costCategory->cost_category] = $value->cost;
            $period = date('F/Y', strtotime($value->period));
            if(isset($timeData[$period]))
                $timeData[$period] += $value->cost;
            else
                $timeData[$period] = $value->cost;

        }

        $periodos = array_keys($timeData);
        $costos = array_values($timeData);

        $colors = ['#388E3C', '#7CB342', '#CDDC39', '#FFEB3B', '#80CBC4', '#26A69A', '#f28f43', '#77a1e5', '#c42525', '#a6c96a'];
        $i = 0;

        foreach ($data as $business_model_name => $business_model) {
            array_push($businessModels, ['y'=>array_sum($business_model), 'name'=>$business_model_name, 'color'=>$colors[$i]]);
            foreach ($business_model as $categorie_name => $value)
                array_push($categories, ['y'=>floatval($value), 'name'=>$categorie_name, 'color'=>$colors[$i]]);
            $i++;
        }

        return $this->render('index', [
            'searchModel'    => $searchModel,
            'dataProvider'   => $dataProvider,
            'startDate'      => $startDate,
            'endDate'        => $endDate,
            'chart'          => [
                                    'businessModels' => $businessModels, 
                                    'categories'     => $categories, 
                                    'periodos'       => $periodos,
                                    'costos'         => $costos
                                ]
        ]);
    }


    /**
     * Displays a single FixedCost model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "FixedCost #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new FixedCost model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new FixedCost();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new FixedCost",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new FixedCost",
                    'content'=>'<span class="text-success">Create FixedCost success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Create new FixedCost",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing FixedCost model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update FixedCost #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "FixedCost #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update FixedCost #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing FixedCost model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing FixedCost model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the FixedCost model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FixedCost the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FixedCost::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
