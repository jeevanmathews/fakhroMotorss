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
         $page_id = "purchase-invoice".time();
        if(isset(Yii::$app->request->queryParams['page_id'])){
            $page_id = Yii::$app->request->queryParams['page_id'];
        }
        return $this->renderAjax('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'page_id'=>$page_id
        ]);
    }
     public function actionInvoice($id){
        $invoice =$this->findModel($id);

        $itemsquery = SalesInvoiceItems::find();
        // $materialquery = JobcardInvoiceMaterial::find();
        
        $itemsquery->andFilterWhere([
            'inv_id' => $invoice->id,
        ]);
        $itemsdataProvider = new ActiveDataProvider([
            'query' => $itemsquery,
            'sort' => false
        ]);

        // $materialquery->andFilterWhere([
        //     'invoice_id' => $invoice->id,
        // ]);
        // $materialdataProvider = new ActiveDataProvider([
        //     'query' => $materialquery,
        //     'sort' => false
        // ]);       
        return $this->renderAjax('_invoice',compact('invoice','itemsdataProvider'));
    }
    /**
     * Displays a single SalesInvoice model.
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
     * Creates a new SalesInvoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $userId = \Yii::$app->user->identity->id;
        $branch_id=Yii::$app->user->identity->branch_id;
        $modellastnumber = SalesInvoice::find()->select('inv_number')->where(['branch_id'=>$branch_id])->orderBy('id desc')->limit(1)->one();
        $model = new SalesInvoice();
        $model1 = new SalesInvoiceItems();
        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            $result=Yii::$app->request->post();
            for($i=0;$i<sizeof($result['SalesInvoiceItems']['item_id']);$i++){
                $model1 = new SalesInvoiceItems();
                $model1->item_id=$result['SalesInvoiceItems']['item_id'][$i];
                $model1->quantity=$result['SalesInvoiceItems']['quantity'][$i];
                $model1->price=$result['SalesInvoiceItems']['price'][$i];
                $model1->unit_id=$result['SalesInvoiceItems']['unit_id'][$i];
                $model1->total_price =$result['SalesInvoiceItems']['total_price'][$i];
                $model1->dis_type =(isset($result['SalesInvoiceItems']['dis_type'])?$result['SalesInvoiceItems']['dis_type'][$i]:NULL);
                $model1->discount_percentage=(isset($result['SalesInvoiceItems']['discount_percentage'])?$result['SalesInvoiceItems']['discount_percentage'][$i]:NULL);
                $model1->discount_amount=(isset($result['SalesInvoiceItems']['discount_amount'])?$result['SalesInvoiceItems']['discount_amount'][$i]:NULL);
                $model1->net_amount=(isset($result['SalesInvoiceItems']['net_amount'])?$result['SalesInvoiceItems']['net_amount'][$i]:NULL);
                $model1->vat_rate=(isset($result['SalesInvoiceItems']['vat_rate'])?$result['SalesInvoiceItems']['vat_rate'][$i]:NULL);
                $model1->tax=(isset($result['SalesInvoiceItems']['tax'])?$result['SalesInvoiceItems']['tax'][$i]:NULL);
                $model1->total=$result['SalesInvoiceItems']['total'][$i];

                $model1->inv_id=$model->id;


                
                $model1->save(false);
            }
            echo json_encode(["success" => true, "message" => "Invoice has been created", 'redirect' => Yii::$app->getUrlManager()->createUrl(['sales-invoice/update','id' => $model->id])]);
            exit;
    }

        return $this->renderAjax('create', [
            'model' => $model,
            'model1' => $model1,
            'modellastnumber'=>$modellastnumber
        ]);
    }
    public function actionCreateinv($id){
        $model = DeliveryOrder::find()->where(['id'=>$id])->one();
        $branch_id=Yii::$app->user->identity->branch_id;
        $modellastnumber = SalesInvoice::find()->select('inv_number')->where(['branch_id'=>$branch_id])->orderBy('id desc')->limit(1)->one();
        $model1 = new SalesInvoice();
        $modelpr = new SalesInvoiceItems();
         if ($model1->load(Yii::$app->request->post()) && $model1->save(false)) {
            $flag_qty=0;
            $count=0;
            $result=Yii::$app->request->post();
            for($i=0;$i<sizeof($result['SalesInvoiceItems']['item_id']);$i++){
                $model1 = new SalesInvoiceItems();
              
                $model1->item_id=$result['SalesInvoiceItems']['item_id'][$i];
                $model1->quantity=$result['SalesInvoiceItems']['quantity'][$i];
                $model1->do_quantity=(isset($result['SalesInvoiceItems']['do_quantity'])?(int) $result['SalesInvoiceItems']['do_quantity'][$i]:NULL);
                $model1->remaining_quantity=$model1->do_quantity-$model1->quantity;
                if($model1->remaining_quantity==0){
                    $flag_qty++;
                }
                $model1->price=$result['SalesInvoiceItems']['price'][$i];
                $model1->unit_id=$result['SalesInvoiceItems']['unit_id'][$i];
                $model1->total_price =$result['SalesInvoiceItems']['total_price'][$i];
                $model1->dis_type =(isset($result['SalesInvoiceItems']['dis_type'])?$result['SalesInvoiceItems']['dis_type'][$i]:NULL);
                $model1->discount_percentage=(isset($result['SalesInvoiceItems']['discount_percentage'])?$result['SalesInvoiceItems']['discount_percentage'][$i]:NULL);
                $model1->discount_amount=(isset($result['SalesInvoiceItems']['discount_amount'])?$result['SalesInvoiceItems']['discount_amount'][$i]:NULL);
                $model1->net_amount=(isset($result['SalesInvoiceItems']['net_amount'])?$result['SalesInvoiceItems']['net_amount'][$i]:NULL);
                $model1->vat_rate=(isset($result['SalesInvoiceItems']['vat_rate'])?$result['SalesInvoiceItems']['vat_rate'][$i]:NULL);
                $model1->tax=(isset($result['SalesInvoiceItems']['tax'])?$result['SalesInvoiceItems']['tax'][$i]:NULL);
                $model1->total=$result['SalesInvoiceItems']['total'][$i];
                $model1->inv_id=$model1->id;
                
                $model1->save(false);
                $count++;
            }
            if($flag_qty==$count){
                $model->process_status='completed';
            }else{
                $model->process_status='processing';
            }
            $model->save(false);
            echo json_encode(["success" => true, "message" => "Invoice has been created", 'redirect' => Yii::$app->getUrlManager()->createUrl(['sales-invoice/update','id' => $model->id])]);
            exit;
        }
        return $this->renderAjax('createinv', [
            'modelpr' => $modelpr,
            'model'=> $model,
            'model1'=> $model1,
            'modellastnumber'=>$modellastnumber
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
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $result=Yii::$app->request->post();
            $flag_qty=0;
            $count=0;
             for($i=0;$i<sizeof($result['SalesInvoiceItems']['item_id']);$i++){
                if(isset($result['SalesInvoiceItems']['id'][$i])){
                    $model1 = SalesInvoiceItems::find()->where(['id'=>$result['SalesInvoiceItems']['id'][$i]])->one();
                }else{
                    $model1 = new SalesInvoiceItems();
                }
                $model1->item_id=$result['SalesInvoiceItems']['item_id'][$i];
                $model1->quantity=$result['SalesInvoiceItems']['quantity'][$i];
                $model1->do_quantity=(isset($result['SalesInvoiceItems']['do_quantity'])?$result['SalesInvoiceItems']['do_quantity'][$i]:NULL);
                 if($model->grn_id){
                    // $model1->do_quantity=(int) $result['GrnItems']['do_quantity'][$i];
                    $model1->remaining_quantity=$model1->do_quantity-$model1->quantity;
                    if($model1->remaining_quantity==0){
                        $flag_qty++;
                    }
                }

                $model1->price=$result['SalesInvoiceItems']['price'][$i];
                $model1->unit_id=$result['SalesInvoiceItems']['unit_id'][$i];
                $model1->total_price =$result['SalesInvoiceItems']['total_price'][$i];
                $model1->dis_type =(isset($result['SalesInvoiceItems']['dis_type'])?$result['SalesInvoiceItems']['dis_type'][$i]:NULL);
                $model1->discount_percentage=(isset($result['SalesInvoiceItems']['discount_percentage'])?$result['SalesInvoiceItems']['discount_percentage'][$i]:NULL);
                $model1->discount_amount=(isset($result['SalesInvoiceItems']['discount_amount'])?$result['SalesInvoiceItems']['discount_amount'][$i]:NULL);
                $model1->net_amount=(isset($result['SalesInvoiceItems']['net_amount'])?$result['SalesInvoiceItems']['net_amount'][$i]:NULL);
                $model1->vat_rate=(isset($result['SalesInvoiceItems']['vat_rate'])?$result['SalesInvoiceItems']['vat_rate'][$i]:NULL);
                $model1->tax=(isset($result['SalesInvoiceItems']['tax'])?$result['SalesInvoiceItems']['tax'][$i]:NULL);
                $model1->total=$result['SalesInvoiceItems']['total'][$i];

                $model1->inv_id=$model->id;
                
                $model1->save(false);
             $count++;
            }
            if($flag_qty==$count){
                $model->process_status='completed';
            }else{
                $model->process_status='processing';
            }
            $model->save(false);
            echo json_encode(["success" => true, "message" => "Invoice has been updated."]);
            exit;
        }

        return $this->renderAjax('update', [
            'model' => $model,
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

    public function actionChangeStatus($id){
        $model = $this->findModel($id);
        $model->status = ($model->status == 0)?1:0;
       if($model->save()){
            echo json_encode(["success" => true, "message" => "Status has been changed.",'redirect'=>Yii::$app->getUrlManager()->createUrl(['sales-invoice/index'])]);
            exit;
        }    
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
