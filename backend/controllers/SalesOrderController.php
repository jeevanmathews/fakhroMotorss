<?php

namespace backend\controllers;

use Yii;
use backend\models\Qutation;
use backend\models\QutationItems;
use backend\models\SalesOrder;
use backend\models\SalesOrderItems;
use backend\models\SalesOrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SalesOrderController implements the CRUD actions for SalesOrder model.
 */
class SalesOrderController extends Controller
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
     * Lists all SalesOrder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SalesOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SalesOrder model.
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
     * Creates a new SalesOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
	public function actionCreate()
    {
        $userId = \Yii::$app->user->identity->id;
        $model = new SalesOrder();
        $model1 = new SalesOrderItems();
        if(Yii::$app->request->post()):
            $result=Yii::$app->request->post();
            $model->customer_id=(int) $result['SalesOrder']['customer_id'];
            // var_dump($result['SalesOrder']['supplier_id']);die;
            // var_dump($result);die;
        endif;
        // var_dump($result['Purchaserequest']);
        // var_dump(sizeof($result['Purchaserequestitems']['item_id']));die;
        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {

            for($i=0;$i<sizeof($result['SalesOrderItems']['item_id']);$i++){
                $model1 = new SalesOrderItems();
                $model1->item_id=$result['SalesOrderItems']['item_id'][$i];
                $model1->quantity=$result['SalesOrderItems']['quantity'][$i];
                $model1->price=$result['SalesOrderItems']['price'][$i];
                $model1->unit_id=$result['SalesOrderItems']['unit_id'][$i];
                $model1->tax=$result['SalesOrderItems']['tax'][$i];
                $model1->total=$result['SalesOrderItems']['total'][$i];
                $model1->so_id=$model->id;
                
                $model1->save(false);
            }
            return $this->redirect(['view', 'id' => $model->id]);


        // $model = new SalesOrder();
        // $model1 = new SalesOrderItems();
        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->id]);
        // }
    }

        return $this->render('create', [
            'model' => $model,
            'type'=>'create',
            'model1' => $model1,
        ]);
    }
    public function actionCreateso($id){
        $model = Qutation::find()->where(['id'=>$id])->one();
        $model1 = new SalesOrder();
        $modelpr = new SalesOrderItems();
        if(Yii::$app->request->post()):
            $result=Yii::$app->request->post();
            $model1->customer_id=(int) $result['SalesOrder']['customer_id'];
            $model1->so_created_by=(int) $result['SalesOrder']['so_created_by'];
            $model1->qtn_id=(int) $result['SalesOrder']['qtn_id'];
            // var_dump($result);die;
        endif;
    
         if ($model1->load(Yii::$app->request->post()) && $model1->save(false)) {
            for($i=0;$i<sizeof($result['SalesOrderItems']['item_id']);$i++){
                $model2 = new SalesOrderItems();
                $model2->item_id=$result['SalesOrderItems']['item_id'][$i];
                $model2->quantity=$result['SalesOrderItems']['quantity'][$i];
                $model2->qtn_quantity=$result['QutationItems']['quantity'][$i];
                $model2->price=$result['SalesOrderItems']['price'][$i];
                $model2->unit_id=$result['SalesOrderItems']['unit_id'][$i];
                $model2->tax=$result['SalesOrderItems']['tax'][$i];
                $model2->total=$result['SalesOrderItems']['total'][$i];
                $model2->so_id=$model1->id;
                
                $model2->save(false);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('createso', [
            'modelpr' => $modelpr,
            'model'=> $model,
            'model1'=> $model1,
            'type' => 'update',
        ]);
    }
    /**
     * Updates an existing SalesOrder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
         if(Yii::$app->request->post()):
            $result=Yii::$app->request->post();
            // var_dump($result);die;
        endif;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
             for($i=0;$i<sizeof($result['SalesOrderItems']['item_id']);$i++){
                if(isset($result['SalesOrderItems']['id'][$i])){
                    $model1 = SalesOrderItems::find()->where(['id'=>$result['SalesOrderItems']['id'][$i]])->one();
                }else{
                    $model1 = new SalesOrderItems();
                }
                $model1->item_id=$result['SalesOrderItems']['item_id'][$i];
                $model1->quantity=$result['SalesOrderItems']['quantity'][$i];
                $model1->price=$result['SalesOrderItems']['price'][$i];
                $model1->unit_id=$result['SalesOrderItems']['unit_id'][$i];
                $model1->tax=$result['SalesOrderItems']['tax'][$i];
                $model1->total=$result['SalesOrderItems']['total'][$i];
                $model1->so_id=$model->id;
                
                $model1->save(false);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'type'  =>'update',
        ]);
    }

    /**
     * Deletes an existing SalesOrder model.
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

    public function actionPrdetails(){
        $pr_id=Yii::$app->request->post('pr_id');
        $modelpr=Qutation::find()->where(['id'=>(int) $qtn_id])->one();
         return $this->render('create', [
            'modelpr' => $modelpr,
        ]);
    }

    public function actionChangeStatus($id){
        $model = $this->findModel($id);
        $model->status = ($model->status == 0)?1:0;
        $model->save();
        return $this->redirect(['index']);
    }

    /**
     * Finds the SalesOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SalesOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SalesOrder::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}