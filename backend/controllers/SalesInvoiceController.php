<?php

namespace backend\controllers;

use Yii;
use backend\models\SalesInvoice;
use backend\models\SalesInvoiceItems;
use backend\models\SalesInvoiceSearch;
use backend\models\DeliveryOrder;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SalesInvoiceController implements the CRUD actions for SalesInvoice model.
 */
class SalesInvoiceController extends Controller
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
     * Lists all SalesInvoice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SalesInvoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SalesInvoice model.
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
     * Creates a new SalesInvoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $userId = \Yii::$app->user->identity->id;
        $model = new SalesInvoice();
        $model1 = new SalesInvoiceItems();
        if(Yii::$app->request->post()):
            $result=Yii::$app->request->post();
            $model->supplier_id=(int) $result['SalesInvoice']['supplier_id'];
            // var_dump($result['SalesInvoice']['customer_id']);die;
            // var_dump($result);die;
        endif;
        // var_dump($result['DeliveryOrder']);
        // var_dump(sizeof($result['Purchaserequestitems']['item_id']));die;
        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {

            for($i=0;$i<sizeof($result['SalesInvoiceItems']['item_id']);$i++){
                $model1 = new SalesInvoiceItems();
                $model1->item_id=$result['SalesInvoiceItems']['item_id'][$i];
                $model1->quantity=$result['SalesInvoiceItems']['quantity'][$i];
                $model1->price=$result['SalesInvoiceItems']['price'][$i];
                $model1->unit_id=$result['SalesInvoiceItems']['unit_id'][$i];
                $model1->tax=$result['SalesInvoiceItems']['tax'][$i];
                $model1->total=$result['SalesInvoiceItems']['total'][$i];
                $model1->inv_id=$model->id;
                
                $model1->save(false);
            }
            return $this->redirect(['view', 'id' => $model->id]);


        // $model = new SalesInvoice();
        // $model1 = new SalesInvoiceItems();
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
    public function actionCreateinv($id){
        $model = DeliveryOrder::find()->where(['id'=>$id])->one();
        $model1 = new SalesInvoice();
        $modelpr = new SalesInvoiceItems();
        if(Yii::$app->request->post()):
            $result=Yii::$app->request->post();
            $model1->supplier_id=(int) $result['SalesInvoice']['supplier_id'];
            $model1->inv_created_by=(int) $result['SalesInvoice']['do_created_by'];
            $model1->grn_id=(int) $result['SalesInvoice']['grn_id'];
            // var_dump($result);die;
        endif;
    
         if ($model1->load(Yii::$app->request->post()) && $model1->save(false)) {
            for($i=0;$i<sizeof($result['SalesInvoiceItems']['item_id']);$i++){
                $model2 = new SalesInvoiceItems();
                $model2->item_id=$result['SalesInvoiceItems']['item_id'][$i];
                $model2->quantity=$result['SalesInvoiceItems']['quantity'][$i];
                $model2->do_quantity=$result['DeliveryOrderItems']['quantity'][$i];
                $model2->price=$result['SalesInvoiceItems']['price'][$i];
                $model2->unit_id=$result['SalesInvoiceItems']['unit_id'][$i];
                $model2->tax=$result['SalesInvoiceItems']['tax'][$i];
                $model2->total=$result['SalesInvoiceItems']['total'][$i];
                $model2->inv_id=$model1->id;
                
                $model2->save(false);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('createinv', [
            'modelpr' => $modelpr,
            'model'=> $model,
            'model1'=> $model1,
            'type' => 'update',
        ]);
    }
    /**
     * Updates an existing SalesInvoice model.
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
            
             for($i=0;$i<sizeof($result['SalesInvoiceItems']['item_id']);$i++){
                if(isset($result['SalesInvoiceItems']['id'][$i])){
                    $model1 = SalesInvoiceItems::find()->where(['id'=>$result['SalesInvoiceItems']['id'][$i]])->one();
                }else{
                    $model1 = new SalesInvoiceItems();
                }
                $model1->item_id=$result['SalesInvoiceItems']['item_id'][$i];
                $model1->quantity=$result['SalesInvoiceItems']['quantity'][$i];
                $model1->price=$result['SalesInvoiceItems']['price'][$i];
                $model1->unit_id=$result['SalesInvoiceItems']['unit_id'][$i];
                $model1->tax=$result['SalesInvoiceItems']['tax'][$i];
                $model1->total=$result['SalesInvoiceItems']['total'][$i];
                $model1->inv_id=$model->id;
                
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
     * Deletes an existing SalesInvoice model.
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
        $do_id=Yii::$app->request->post('do_id');
        $modelpr=DeliveryOrder::find()->where(['id'=>(int) $do_id])->one();
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
     * Finds the SalesInvoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SalesInvoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SalesInvoice::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
