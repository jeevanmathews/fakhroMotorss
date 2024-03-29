<?php

namespace backend\controllers;

use Yii;
use backend\models\AmcType;
use backend\models\AmcTypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AmcTypeController implements the CRUD actions for AmcType model.
 */
class AmcTypeController extends Controller
{

    /*Check Permission for this controller actions
    **/
    public function beforeAction($action)
    {       
        Yii::$app->common->checkPermission('AmcTypeController', Yii::$app->controller->action->id);
        return parent::beforeAction($action);  
    }

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
     * Lists all AmcType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AmcTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $page_id = "amc-type".time();
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
     * Displays a single AmcType model.
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
     * Creates a new AmcType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AmcType();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //echo json_encode(["success" => true, "message" => "AmcType has been created."]);
        echo json_encode(["success" => true, "message" => "AmcType has been created", 'redirect' => Yii::$app->getUrlManager()->createUrl(['amc-type/update','id' => $model->id])]);
        exit;         
    }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AmcType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        echo json_encode(["success" => true, "message" => "AmcType has been updated."]);
        exit;       
         }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AmcType model.
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
            echo json_encode(["success" => true, "message" => "AmcType status has been changed", 'redirect' => Yii::$app->getUrlManager()->createUrl(['amc-type/index'])]);
         exit;
     }
    }

    /**
     * Finds the AmcType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AmcType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AmcType::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
