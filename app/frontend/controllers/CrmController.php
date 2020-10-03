<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Crm;
use frontend\models\CrmSearch;
use frontend\models\TypeCrm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CrmController implements the CRUD actions for Crm model.
 */
class CrmController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Crm models.
     * @return mixed
     */
    public function actionIndex($type = NULL)
    {
        if(!is_null($type))
            $filters = [
                'contact_id'     => NULL,
                'client_id'      => NULL,
                'advertisers_id' => NULL,
                'user_id'        => NULL,
                'crm.type_crm_id'    => $type,
            ];
        else{
            $types = [];
            return $this->render('select', [
                'types' => TypeCrm::find()->all(),
            ]);   
        }

        $searchModel  = new CrmSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $filters);
        $crm          = new Crm;

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'graphic'      => $crm->getTotalGraphic(),
        ]);
    }

    /**
     * Displays a single Crm model.
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
     * Creates a new Crm model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Crm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Crm model.
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
     * Deletes an existing Crm model.
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
     * Finds the Crm model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Crm the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Crm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * [actionUpdateStatus description]
     * @param  [type] $id     [description]
     * @param  [type] $status [description]
     * @return [type]         [description]
     */
    public function actionUpdateStatus($id, $status, $comment)
    {
        $model                = $this->findModel($id);
        $newModel             = new Crm;
        $newModel->attributes = $model->attributes;
        unset($newModel->date);
        $newModel->status_crm_id = $status;
        $newModel->comment       = $comment;
        $newModel->save();

        \Yii::$app->response->format = 'json';

        return $newModel;
    }

    /**
     * Lists all Crm models.
     * @return mixed
     */
    public function actionDetail($client, $advertiser, $user, $contact)
    {
        $filters = [
            'client_id'      => $client,
            'advertisers_id' => $advertiser,
            'user_id'        => $user,
            'contact_id'     => $contact,
            'crm.type_crm_id'=> NULL,
        ];
        // $filters = null;
        $searchModel  = new CrmSearch();
        

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $filters);
        $crm          = new Crm;

        return $this->render('detail', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'graphic'      => $crm->getTotalGraphic($filters),
        ]);
    }
}
