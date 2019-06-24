<?php

namespace backend\controllers;

use Yii;
use backend\models\Employees;
use backend\models\EmployeesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\User;
use backend\models\SignupForm;
/**
 * EmployeesController implements the CRUD actions for Employees model.
 */
class EmployeesController extends Controller
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
     * Lists all Employees models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmployeesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

       $page_id = "employees".time();
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
     * Displays a single Employees model.
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
     * Creates a new Employees model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Employees();
        $model1 = new SignupForm();
        if($res=Yii::$app->request->post()){
            $userid=NULL;
            $login=$res['Employees']['login'];
            if($login==1){
                $users = new User();
                $users->username = $res['SignupForm']['username'];
                $users->email = $res['Employees']['email'];
                $users->firstname = $res['Employees']['first_name'];
                $users->lastname = $res['Employees']['last_name'];
                $users->role_id = $res['SignupForm']['role_id'];
                $users->branch_id = $res['SignupForm']['branch_id'];
                $users->setPassword($res['SignupForm']['password']);
                $users->generateAuthKey(); 
                if($users->save(false)){
                    $userid=$users->id;
                    $model->user_id=$userid;
                    $model->branch_id = $res['SignupForm']['branch_id'];
                }
            }
            // if($model->load(Yii::$app->request->post())){
            //     var_dump($model->first_name);die;
            // }
            // if($model->save()){
            //      return $this->redirect(['view', 'id' => $model->id]);
            // }
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
            echo json_encode(["success" => true, "message" => "Staff has been cretaed."]);
            exit;
            }
        }
       

        return $this->renderAjax('create', [
            'model' => $model,
            'model1'=>$model1,
            'type'  =>'create'
        ]);
    }

    /**
     * Updates an existing Employees model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        // var_dump(Yii::$app->request->post());die;
        $model = $this->findModel($id);
        $model1 = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $res=Yii::$app->request->post();
            if($model->login==1){
                $model2 = User::find()->where(['id'=>$model->user_id])->one();
                // var_dump($model2);die;
                $model2->email = $res['Employees']['email'];
                $model2->firstname = $res['Employees']['first_name'];
                $model2->lastname = $res['Employees']['last_name'];
                $model2->role_id = $res['User']['role_id'];
                $model2->branch_id = $res['User']['branch_id'];
                if($model2->save(false)){
                 echo json_encode(["success" => true, "message" => "Staff has been updated."]);
                    exit;
                }    
            }
            
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'model1' => $model1,
            'type'  =>'update'
        ]);
    }

    /**
     * Deletes an existing Employees model.
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

    public function actionChangeStatus($id){
        $model = $this->findModel($id);
        $model->status = ($model->status == 0)?1:0;
          if($model->save()){
            echo json_encode(["success" => true, "message" => "Staff status has been changed", 'redirect' => Yii::$app->getUrlManager()->createUrl(['employees/index'])]);
         exit;
     }
    }

    
    /**
     * Finds the Employees model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Employees the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Employees::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
