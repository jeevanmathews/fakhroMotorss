<?php

namespace backend\controllers;

use Yii;
use backend\models\Spareparts;
use backend\models\SparepartsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SparepartsController implements the CRUD actions for Spareparts model.
 */
class SparepartsController extends Controller
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
     * Lists all Spareparts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SparepartsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderAjax('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Spareparts model.
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
     * Creates a new Spareparts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Spareparts();

        if ($model->load(Yii::$app->request->post())) {
            $result=Yii::$app->request->post();
            $model->itemgroup_id=end($result['parent_id']);
            $model->save();
            echo json_encode(["success" => true, "message" => "Spare Part has been created."]);
            exit;
        }
        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Spareparts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $itemgroup_id=$model->itemgroup_id;
        if ($model->load(Yii::$app->request->post())) {
            $result=Yii::$app->request->post();
            // var_dump(array_filter($result['parent_id']));die;
            if(!empty(array_filter($result['parent_id']))):
                $model->itemgroup_id=end($result['parent_id']);
            else:
                $model->itemgroup_id=$itemgroup_id;
            endif;
            $model->save();
            echo json_encode(["success" => true, "message" => "Spare Part has been created."]);
            exit;
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Spareparts model.
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
             echo json_encode(["success" => true, "message" => "Status has been changed."]);
             exit;

          }
        
    }

      public function actionLists($type="spares",$parent_id) 
     {
        return $this->renderPartial('_itemdropdown',compact('parent_id','type')); 
     }
    /**
     * Finds the Spareparts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Spareparts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Spareparts::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
