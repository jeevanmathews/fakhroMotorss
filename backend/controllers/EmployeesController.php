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
use backend\models\Roles;
use backend\models\UserRole;
use yii\data\ActiveDataProvider;
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
        if($model->load(Yii::$app->request->post())){
            if($model->save()) {
                if($model->login){
                    $model1->scenario = 'register';
                    if($model1->load(Yii::$app->request->post()) && !$model1->validate()){
                        if($errors = Yii::$app->common->showModelErrors($model1, ['username', 'password', 'confirmPassword'])){                       
                            echo json_encode(["error" => true, "message" =>  "Employee Created, but user cannot be created! </br>". $errors, 'redirect' => Yii::$app->getUrlManager()->createUrl(['employees/update', 'id' => $model->id])]);
                            exit;
                        }
                    }
                    $users = new User();
                    $users->username = $model1->username;
                    $users->email = $model->email;
                    $users->firstname = $model->first_name;
                    $users->lastname = $model->last_name;               
                    $users->branch_id = $model->branch_id;
                    $users->status = 0;
                    $users->setPassword($model1->password);
                    $users->generateAuthKey(); 
                    if($users->save(false)){
                        $model->user_id = $users->id;   
                        $model->save();                 
                    }
                } 
                echo json_encode(["success" => true, "message" => "Staff has been created.", 'redirect' => Yii::$app->getUrlManager()->createUrl(['employees/update', 'id' => $model->id])]);
                exit;
            } else{
                echo json_encode(["error" => true, "message" => Yii::$app->common->showModelErrors($model)]);
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
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                $model2 = User::find()->where(['id'=>$model->user_id])->one();
                if($model->login==1){                            
                    if(!$model2) {
                        $model1->scenario = 'register';
                        if($model1->load(Yii::$app->request->post()) && !$model1->validate()){
                            if($errors = Yii::$app->common->showModelErrors($model1, ['username', 'password', 'confirmPassword'])){                       
                                echo json_encode(["error" => true, "message" =>  $errors]);
                                exit;
                            }
                        }
                        $model2 = new User();
                        $model2->username = $model1->username;
                        $model2->setPassword($model1->password);
                        $model2->generateAuthKey(); 
                        $model2->status = ($model->status == 0)?0:10;
                    }
                    $model2->email = $model->email;
                    $model2->firstname = $model->first_name;
                    $model2->lastname = $model->last_name;               
                    $model2->branch_id = $model->branch_id;
                    if($model2->save(false)){
                        if(!$model->user_id){
                            $model->user_id = $model2->id;
                            $model->save();
                        }
                        echo json_encode(["success" => true, "message" => "Staff & User has been updated.", 'redirect' => Yii::$app->getUrlManager()->createUrl(['employees/update', 'id' => $model->id])]);
                        exit;
                    }    
                }else{
                    if($model2) {
                        $model2->status = 0;
                        $model2->save();
                    }
                }
                echo json_encode(["success" => true, "message" => "Staff has been updated."]);
                exit; 

            }else{
                echo json_encode(["error" => true, "message" => Yii::$app->common->showModelErrors($model)]);
                exit;
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
            $user = User::findOne($model->user_id);
            if($user){
                $user->status = ($model->status == 0)?0:10;
                $user->save();
            }
            echo json_encode(["success" => true, "message" => "Staff status has been changed", 'redirect' => Yii::$app->getUrlManager()->createUrl(['employees/index'])]);
            exit;
        }
    }

    public function actionRoles($id){
        $model = $this->findModel($id);        
        $roles = Roles::find()->where(["status" => 1])->all();
        $userRoles = $model->userRoles;
         $dataProvider = new ActiveDataProvider([
            'query' => Roles::find()
                ->where(["status" => 1])             
        ]);

        if(Yii::$app->request->post()){
            $oldRoles = $userRoles;
            foreach (Yii::$app->request->post()['roles'] as $role_id) {
                if(!in_array($role_id, $userRoles)){
                    $userRole = new UserRole();
                    $userRole->user_id = $model->user_id;
                    $userRole->role_id = $role_id;
                    $userRole->save();
                }else{
                    unset($oldRoles[array_search($role_id, $oldRoles)]);
                }
            }
            if($oldRoles){
                foreach($oldRoles as $role){
                  UserRole::find()->where(['user_id' => $model->user_id, 'role_id' => $role])->one()->delete();  
              }                
            }
        }

        return $this->renderAjax('_roles', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'userRoles' => $userRoles
        ]);
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
