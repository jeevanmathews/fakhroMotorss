<?php

namespace backend\controllers;

use Yii;
use backend\models\suppliergroup;
use backend\models\suppliergroupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SuppliergroupController implements the CRUD actions for suppliergroup model.
 */
class SuppliergroupController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all suppliergroup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new suppliergroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

       $page_id = "suppliergroup".time();
        if(isset(Yii::$app->request->queryParams['page_id'])){
            $page_id = Yii::$app->request->queryParams['page_id'];
        }
        return $this->renderAjax('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'page_id' => $page_id
        ]);
    }

    /**
     * Displays a single suppliergroup model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new suppliergroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new suppliergroup();

        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        {
        echo json_encode(["success" => true, "message" => "Suppliergroup has been created."]);
        exit;         
         }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing suppliergroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        {
        echo json_encode(["success" => true, "message" => "Suppliergroup has been updated."]);
        exit;         
         }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing suppliergroup model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionChangeStatus($id)
      {
        $model = $this->findModel($id);
        $model->status = ($model->status == 0)?1:0;
       
        if($model->save()){
            echo json_encode(["success" => true, "message" => "Suppliergroup status has been changed", 'redirect' => Yii::$app->getUrlManager()->createUrl(['suppliergroup/index'])]);
         exit;
     }
    }

    /**
     * Finds the suppliergroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return suppliergroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = suppliergroup::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
