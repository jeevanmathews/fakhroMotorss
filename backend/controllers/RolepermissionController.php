<?php

namespace backend\controllers;

use Yii;
use backend\models\RolePermission;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Roles;

/**
 * RolepermissionController implements the CRUD actions for RolePermission model.
 */
class RolepermissionController extends Controller
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
     * Lists all RolePermission models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => RolePermission::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RolePermission model.
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
     * Creates a new RolePermission model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {   
        
        $result=array();
        if($res=Yii::$app->request->post()){
            $role = Roles::findOne($res['role_id']);  
            $old_permissions = $role->permissionAry; 
            
            foreach ($res['permission_id'] as $value) {
                if($value){
                    if(!in_array($value, $role->permissionAry))
                        $result[] = array($res['role_id'],$value);
                    else
                        unset($old_permissions[array_search($value, $old_permissions)]);                     
                }                
            }
            if($result){
                Yii::$app->db
                ->createCommand()
                ->batchInsert('role_permission', ['role_id','permission_id'],$result)
                ->execute();
            }
            if($old_permissions){
                foreach($old_permissions as $permission){
                  RolePermission::find()->where(['role_id' => $res['role_id'], 'permission_id' => $permission])->one()->delete();  
              }                
            }            
        } 
        echo json_encode(["success" => true, "message" => "Role(s) has been updated.", 'redirect' => Yii::$app->getUrlManager()->createUrl(['permissionmaster/permissions', 'id' => $res['role_id']])]);
            exit;        
    }

    /**
     * Updates an existing RolePermission model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RolePermission model.
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
     * Finds the RolePermission model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RolePermission the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RolePermission::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
