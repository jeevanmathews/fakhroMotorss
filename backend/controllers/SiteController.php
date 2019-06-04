<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginForm;
use backend\models\User;
use backend\models\Company;
use backend\models\CompanySettings;
use backend\models\SignupForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'launch'],
                        'allow' => true,
                    ],
                    [
                        // 'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
      return $this->redirect(['dashboard']);
        // return $this->render('index');
    }

    /**
     * Displays Launch Page.
     *
     * @return string
     */
    public function actionLaunch()
    {
      
      $this->layout = "launch";

      $user = new SignupForm();    
      $model = new Company();
      $login = new LoginForm();

      $user->scenario = "register";
      $screen = "";
      $post = Yii::$app->request->post(); 

      if(isset($post['createCompany'])){     

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
          $settings = new CompanySettings;
          $settings->company_id = $model->id;
          $settings->save(false);
          Yii::$app->session->setFlash('success', 'Congartulations! Your company has been configured and please create an admin account to login and manage your business.'); 
          $screen = 'signup';                
        }
      }else if(isset($post['signup'])){ 
        if($user->load(Yii::$app->request->post())){ 
            $user->branch_id = 1;
            if ($user->signup()) {
              Yii::$app->session->setFlash('success', 'Account has been created successfully! Please login.');
              return $this->redirect(['login']);
            }
          }
      }else if(Company::findOne(1)){
        return $this->redirect(['login']);
      }       
      
      return $this->render('launch', ['model' => $model, 'screen' => $screen, 'user' => $user]);     
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {      
        if(!Company::findOne(1)){
          return $this->redirect(['launch']);
        }
        $this->layout = "login";
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
      public function actionDashboard()
    {
      $model=Company::findone(1);
       return $this->render('dashboard', [
                'model' => $model,
          ]);
    }
}
