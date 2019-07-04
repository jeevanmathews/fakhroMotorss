<?php

namespace backend\controllers;

use Yii;
use backend\models\Departments;
use backend\models\departmentsSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Designations;
/**
 * DepartmentsController implements the CRUD actions for Departments model.
 */
class DepartmentsController extends Controller
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
     * Lists all Departments models.
     * @return mixed
     */
   /* public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Departments::find(),
            ]);

        return $this->renderAjax('index', [
            'dataProvider' => $dataProvider,
            ]);
    }*/
    public function actionIndex()
    {
        $searchModel = new departmentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $page_id = "departments".time();
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
     * Displays a single Departments model.
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
     * Creates a new Departments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Departments();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
           echo json_encode(["success" => true, "message" => "Departments has been created", 'redirect' => Yii::$app->getUrlManager()->createUrl(['departments/update','id' => $model->id])]);
            exit;
        }
     

        return $this->renderAjax('create', [
            'model' => $model,
            ]);
    }

    /**
     * Updates an existing Departments model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            echo json_encode(["success" => true, "message" => "Department has been updated."]);
            exit;
        }

        return $this->renderAjax('update', [
            'model' => $model,
            ]);
    }

    public function actionDesignation($department_id){
        $designations = Designations::find()->where(['department_id' => $department_id])->all();
        if($designations){
            echo '<option value="">Select A Make</option>';
            foreach($designations as $designation){
                echo '<option value="'.$designation->id.'">'.$designation->name.'</option>';
            }
        }else{
            echo '<option value="">No Records Added</option>';
        }        
        exit;
    }

    /**
     * Deletes an existing Departments model.
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

    /**
     * Finds the Departments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Departments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Departments::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
