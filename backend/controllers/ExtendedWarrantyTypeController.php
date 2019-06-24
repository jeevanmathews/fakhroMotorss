<?php

namespace backend\controllers;

use Yii;
use backend\models\ExtendedWarrantyType;
use backend\models\ExtendedWarrantyTypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ExtendedWarrantyTypeController implements the CRUD actions for ExtendedWarrantyType model.
 */
class ExtendedWarrantyTypeController extends Controller
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
     * Lists all ExtendedWarrantyType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ExtendedWarrantyTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

       $page_id = "extended-warranty-type".time();
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
     * Displays a single ExtendedWarrantyType model.
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
     * Creates a new ExtendedWarrantyType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ExtendedWarrantyType();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        echo json_encode(["success" => true, "message" => "ExtendedWarrantyType has been created."]);
        exit;
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ExtendedWarrantyType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        echo json_encode(["success" => true, "message" => "ExtendedWarrantyType has been updated."]);
        exit;        
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ExtendedWarrantyType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->renderAjax(['index']);
    }
	public function actionChangeStatus($id)
	{
        $model = $this->findModel($id);
        $model->status = ($model->status == 0)?1:0;
       
   if($model->save()){
            echo json_encode(["success" => true, "message" => "Branchtypes status has been changed", 'redirect' => Yii::$app->getUrlManager()->createUrl(['branchtypes/index'])]);
         exit;
     }
    }


    /**
     * Finds the ExtendedWarrantyType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ExtendedWarrantyType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ExtendedWarrantyType::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
