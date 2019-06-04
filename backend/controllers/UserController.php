<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\SignupForm;
use backend\models\Branches;
use backend\models\Roles;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $branches = ArrayHelper::map(Branches::find()->all(), 'id', 'name');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'branches'=>$branches
        ]);
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
      public function actionSignup()
    {  
        // echo '<pre>';var_dump(Yii::$app->request->post());echo '</pre>';die;
        $model = new SignupForm();
        $branches = ArrayHelper::map(Branches::find()->all(), 'id', 'name');
        if ($model->load(Yii::$app->request->post())) {

            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
            'branches'=>$branches
        ]);
    }
     public function actionRoles(){
        $id = (int) Yii::$app->request->get('id');
             $dataProvider = new ActiveDataProvider([
            'query' => Roles::find()
        ]);
          return $this->render('roles', [
            'dataProvider' => $dataProvider,
            'user_id'       =>$id
        ]);
    }
    public function actionSetroles(){
            $userdata= Yii::$app->request->post();
            $user = User::findOne($userdata['id']);
            $user->role_id = $userdata['role_id'];
            if ($user->save()) {
                 return $this->redirect(['user/index']);
            }

    }
    public function actionUniqueemail(){
        $userdata= Yii::$app->request->post();
        $user = User::find()->where(['email'=>$userdata['email']])->all();
        // var_dump($user,$userdata['email']);die;
        if($user){
            return 1;
        }else{
            return 0;
        }
    }
}
