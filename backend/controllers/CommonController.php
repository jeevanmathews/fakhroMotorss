<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * Site controller
 */
class CommonController extends Controller
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
                      
                        'allow' => true,                       
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
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
     * Ajax Validation for Model Rules
     *
     * @return string
     */
    public function actionValidateEntry(){

        return Yii::$app->common->validateEntry(Yii::$app->request->post());
        
    } 

    /**
     * Permission check for user roles
     *
     * @return string
     */
    public function actionNoPermission(){

        return $this->renderAjax('/system/no-permission');
        
    } 
  
}
