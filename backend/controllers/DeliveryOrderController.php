<?php

namespace backend\controllers;

use Yii;
use backend\models\DeliveryOrder;
use backend\models\DeliveryOrderSearch;
use backend\models\DeliveryOrderItems;
use backend\models\SalesOrder;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DeliveryOrderController implements the CRUD actions for DeliveryOrder model.
 */
class DeliveryOrderController extends Controller
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
     * Lists all DeliveryOrder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DeliveryOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DeliveryOrder model.
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
     * Creates a new DeliveryOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $userId = \Yii::$app->user->identity->id;
        $model = new DeliveryOrder();
        $model1 = new DeliveryOrderItems();
        if(Yii::$app->request->post()):
            $result=Yii::$app->request->post();
            $model->customer_id=(int) $result['DeliveryOrder']['customer_id'];
            // var_dump($result['DeliveryOrder']['customer_id']);die;
            // var_dump($result);die;
        endif;
        // var_dump($result['SalesOrder']);
        // var_dump(sizeof($result['Purchaserequestitems']['item_id']));die;
        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {

            for($i=0;$i<sizeof($result['DeliveryOrderItems']['item_id']);$i++){
                $model1 = new DeliveryOrderItems();
                $model1->item_id=$result['DeliveryOrderItems']['item_id'][$i];
                $model1->quantity=$result['DeliveryOrderItems']['quantity'][$i];
                $model1->price=$result['DeliveryOrderItems']['price'][$i];
                $model1->unit_id=$result['DeliveryOrderItems']['unit_id'][$i];
                $model1->tax=$result['DeliveryOrderItems']['tax'][$i];
                $model1->total=$result['DeliveryOrderItems']['total'][$i];
                $model1->do_id=$model->id;
                
                $model1->save(false);
            }
            return $this->redirect(['view', 'id' => $model->id]);


        // $model = new DeliveryOrder();
        // $model1 = new DeliveryOrderItems();
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
    public function actionCreatedo($id){
        $model = SalesOrder::find()->where(['id'=>$id])->one();
        $model1 = new DeliveryOrder();
        $modelpr = new DeliveryOrderItems();
        if(Yii::$app->request->post()):
            $result=Yii::$app->request->post();
            $model1->customer_id=(int) $result['DeliveryOrder']['customer_id'];
            $model1->do_created_by=(int) $result['DeliveryOrder']['do_created_by'];
            $model1->so_id=(int) $result['DeliveryOrder']['so_id'];
            // var_dump($result);die;
        endif;
    
         if ($model1->load(Yii::$app->request->post()) && $model1->save(false)) {
            for($i=0;$i<sizeof($result['DeliveryOrderItems']['item_id']);$i++){
                $model2 = new DeliveryOrderItems();
                $model2->item_id=$result['DeliveryOrderItems']['item_id'][$i];
                $model2->quantity=$result['DeliveryOrderItems']['quantity'][$i];
                $model2->so_quantity=$result['DeliveryOrderItems']['quantity'][$i];
                $model2->price=$result['DeliveryOrderItems']['price'][$i];
                $model2->unit_id=$result['DeliveryOrderItems']['unit_id'][$i];
                $model2->tax=$result['DeliveryOrderItems']['tax'][$i];
                $model2->total=$result['DeliveryOrderItems']['total'][$i];
                $model2->do_id=$model1->id;
                
                $model2->save(false);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('createdo', [
            'modelpr' => $modelpr,
            'model'=> $model,
            'model1'=> $model1,
            'type' => 'update',
        ]);
    }
    /**
     * Updates an existing DeliveryOrder model.
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
        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            
             for($i=0;$i<sizeof($result['DeliveryOrderItems']['item_id']);$i++){
                if(isset($result['DeliveryOrderItems']['id'][$i])){
                    $model1 = DeliveryOrderItems::find()->where(['id'=>$result['DeliveryOrderItems']['id'][$i]])->one();
                }else{
                    $model1 = new DeliveryOrderItems();
                }
                $model1->item_id=$result['DeliveryOrderItems']['item_id'][$i];
                $model1->quantity=$result['DeliveryOrderItems']['quantity'][$i];
                $model1->price=$result['DeliveryOrderItems']['price'][$i];
                $model1->unit_id=$result['DeliveryOrderItems']['unit_id'][$i];
                $model1->tax=$result['DeliveryOrderItems']['tax'][$i];
                $model1->total=$result['DeliveryOrderItems']['total'][$i];
                $model1->do_id=$model->id;
                
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
     * Deletes an existing DeliveryOrder model.
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

    public function actionPodetails(){
        $po_id=Yii::$app->request->post('po_id');
        $modelpr=SalesOrder::find()->where(['id'=>(int) $po_id])->one();
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
     * Finds the DeliveryOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DeliveryOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DeliveryOrder::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
