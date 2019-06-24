<?php

namespace backend\controllers;

use Yii;
use backend\models\CarModel;
use backend\models\CarModelSearch;
use backend\models\Make;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CarModelController implements the CRUD actions for CarModel model.
 */
class CarModelController extends Controller
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
     * Lists all CarModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CarModelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $page_id = "car-model".time();
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
     * Displays a single CarModel model.
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
     * Creates a new CarModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CarModel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            echo json_encode(["success" => true, "message" => "Model has been created"]);
            exit;
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CarModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {            
            echo json_encode(["success" => true, "message" => "Model has been updated"]);
            exit;
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CarModel model.
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

    public function actionMakes($manufacturer_id){
        $makes = Make::find()->where(['manufacturer_id' => $manufacturer_id])->all();
        if($makes){
            echo '<option value="">Select A Make</option>';
            foreach($makes as $make){
                echo '<option value="'.$make->id.'">'.$make->make.'</option>';
            }
        }else{
            echo '<option value="">No Records Added</option>';
        }        
        exit;
    }

    public function actionModels($make_id){
        $models = CarModel::find()->where(['make_id' => $make_id])->all();
        if($models){
            echo '<option value="">Select A Model</option>';
            foreach($models as $model){
                echo '<option value="'.$model->id.'">'.$model->model.'</option>';
            }
        }else{
            echo '<option value="">No Records Added</option>';
        }        
        exit;
    }

    /**
     * Finds the CarModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CarModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CarModel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
