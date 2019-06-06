<?php

namespace backend\controllers;

use Yii;
use backend\models\PurchaseInvoice;
use backend\models\PurchaseInvoiceSearch;
use backend\models\PurchaseInvoiceItems;
use backend\models\GoodsReceiptNote;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Purchaseorder;
use yii\data\ActiveDataProvider;

/**
 * PurchaseInvoiceController implements the CRUD actions for PurchaseInvoice model.
 */
class PurchaseInvoiceController extends Controller
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
     * Lists all PurchaseInvoice models.
     * @return mixed
     */
     public function actionIndex()
    {
        $searchModel = new PurchaseInvoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderAjax('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PurchaseInvoice model.
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


    public function actionInvoice($id){
        $invoice =$this->findModel($id);

        $itemsquery = PurchaseInvoiceItems::find();
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
     * Creates a new PurchaseInvoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $userId = \Yii::$app->user->identity->id;
        $branch_id=Yii::$app->user->identity->branch_id;
        $modellastnumber = PurchaseInvoice::find()->select('inv_number')->where(['branch_id'=>$branch_id])->orderBy('id desc')->limit(1)->one();
        
        $model = new PurchaseInvoice();
        $model1 = new PurchaseInvoiceItems();
        // if(Yii::$app->request->post()):
        //     $result=Yii::$app->request->post();
        //     $model->supplier_id=(int) $result['PurchaseInvoice']['supplier_id'];
        //     if(isset($result['PurchaseInvoice']['discount_type']) && $result['PurchaseInvoice']['discount_type']=="percentage" && $result['PurchaseInvoice']['discount']!=""){
        //        $model->discount_percent= $result['PurchaseInvoice']['discount'];
        //        $model->discount=0;
        //     }
        //     if(isset($result['PurchaseInvoice']['discount_type'])){
        //         $model->discount_type= $result['PurchaseInvoice']['discount_type'];
        //     }
        //     if(isset($result['PurchaseInvoice']['vat_percent'])){
        //          $model->vat_percent=$result['PurchaseInvoice']['vat_percent'];
        //     }
        //     // var_dump($result['PurchaseInvoice']['supplier_id']);die;
        //     // var_dump($model->discount_type);die;
        // endif;
        // var_dump($result['GoodsReceiptNote']);
        // var_dump(sizeof($result['Purchaserequestitems']['item_id']));die;
        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            $result=Yii::$app->request->post();
            for($i=0;$i<sizeof($result['PurchaseInvoiceItems']['item_id']);$i++){
                $model1 = new PurchaseInvoiceItems();
                $model1->item_id=$result['PurchaseInvoiceItems']['item_id'][$i];
                $model1->quantity=$result['PurchaseInvoiceItems']['quantity'][$i];
                $model1->price=$result['PurchaseInvoiceItems']['price'][$i];
                $model1->unit_id=$result['PurchaseInvoiceItems']['unit_id'][$i];
                $model1->total_price =$result['PurchaseInvoiceItems']['total_price'][$i];
                $model1->dis_type =(isset($result['PurchaseInvoiceItems']['dis_type'])?$result['PurchaseInvoiceItems']['dis_type'][$i]:NULL);
                $model1->discount_percentage=(isset($result['PurchaseInvoiceItems']['discount_percentage'])?$result['PurchaseInvoiceItems']['discount_percentage'][$i]:NULL);
                $model1->discount_amount=(isset($result['PurchaseInvoiceItems']['discount_amount'])?$result['PurchaseInvoiceItems']['discount_amount'][$i]:NULL);
                $model1->net_amount=(isset($result['PurchaseInvoiceItems']['net_amount'])?$result['PurchaseInvoiceItems']['net_amount'][$i]:NULL);
                $model1->vat_rate=(isset($result['PurchaseInvoiceItems']['vat_rate'])?$result['PurchaseInvoiceItems']['vat_rate'][$i]:NULL);
                $model1->tax=(isset($result['PurchaseInvoiceItems']['tax'])?$result['PurchaseInvoiceItems']['tax'][$i]:NULL);
                $model1->total=$result['PurchaseInvoiceItems']['total'][$i];

                $model1->inv_id=$model->id;
                
                $model1->save(false);
            }
             echo json_encode(["success" => true, "message" => "Invoice has been created."]);
            exit;


        // $model = new PurchaseInvoice();
        // $model1 = new PurchaseInvoiceItems();
        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->id]);
        // }
    }

        return $this->renderAjax('create', [
            'model' => $model,
            'type'=>'create',
            'modellastnumber'=>$modellastnumber,
            'model1' => $model1,
        ]);
    }
    public function actionCreateinv($id){
        $branch_id=Yii::$app->user->identity->branch_id;
        $modellastnumber = PurchaseInvoice::find()->select('inv_number')->where(['branch_id'=>$branch_id])->orderBy('id desc')->limit(1)->one();
        
        $model = GoodsReceiptNote::find()->where(['id'=>$id])->one();
        $model1 = new PurchaseInvoice();
        $modelpr = new PurchaseInvoiceItems();
        // if(Yii::$app->request->post()):
        //     $result=Yii::$app->request->post();
        //     $model1->supplier_id=(int) $result['PurchaseInvoice']['supplier_id'];
        //     $model1->inv_created_by=(int) $result['PurchaseInvoice']['inv_created_by'];
        //     $model1->grn_id=(int) $result['PurchaseInvoice']['grn_id'];
        //     if(isset($result['PurchaseInvoice']['discount_type']) && $result['PurchaseInvoice']['discount_type']=="percentage" && $result['PurchaseInvoice']['discount']!=""){
        //        $model1->discount_percent= $result['PurchaseInvoice']['discount'];
        //        $model1->discount=0;
        //     }
        //     if(isset($result['PurchaseInvoice']['discount_type'])){
        //         $model1->discount_type= $result['PurchaseInvoice']['discount_type'];
        //     }
        //     if(isset($result['PurchaseInvoice']['vat_percent'])){
        //          $model1->vat_percent=$result['PurchaseInvoice']['vat_percent'];
        //     }
        // endif;
         if ($model1->load(Yii::$app->request->post()) && $model1->save(false)) {
            $result=Yii::$app->request->post();
            $flag_qty=0;
            $count=0;
            for($i=0;$i<sizeof($result['PurchaseInvoiceItems']['item_id']);$i++){
                $model2 = new PurchaseInvoiceItems();
                $model2->item_id=$result['PurchaseInvoiceItems']['item_id'][$i];
                $model2->quantity=$result['PurchaseInvoiceItems']['quantity'][$i];
                $model2->grn_quantity=(isset($result['PurchaseInvoiceItems']['grn_quantity'])?(int) $result['PurchaseInvoiceItems']['grn_quantity'][$i]:NULL);
                $model2->remaining_quantity=$model2->grn_quantity-$model2->quantity;
                if($model2->remaining_quantity==0){
                    $flag_qty++;
                }
                $model2->price=$result['PurchaseInvoiceItems']['price'][$i];
                $model2->unit_id=$result['PurchaseInvoiceItems']['unit_id'][$i];
                $model2->total_price =$result['PurchaseInvoiceItems']['total_price'][$i];
                $model2->dis_type =(isset($result['PurchaseInvoiceItems']['dis_type'])?$result['PurchaseInvoiceItems']['dis_type'][$i]:NULL);
                $model2->discount_percentage=(isset($result['PurchaseInvoiceItems']['discount_percentage'])?$result['PurchaseInvoiceItems']['discount_percentage'][$i]:NULL);
                $model2->discount_amount=(isset($result['PurchaseInvoiceItems']['discount_amount'])?$result['PurchaseInvoiceItems']['discount_amount'][$i]:NULL);
                $model2->net_amount=(isset($result['PurchaseInvoiceItems']['net_amount'])?$result['PurchaseInvoiceItems']['net_amount'][$i]:NULL);
                $model2->vat_rate=(isset($result['PurchaseInvoiceItems']['vat_rate'])?$result['PurchaseInvoiceItems']['vat_rate'][$i]:NULL);
                $model2->tax=(isset($result['PurchaseInvoiceItems']['tax'])?$result['PurchaseInvoiceItems']['tax'][$i]:NULL);
                $model2->total=$result['PurchaseInvoiceItems']['total'][$i];
                $model2->inv_id=$model1->id;
                
                $model2->save(false);
              $count++;
            }
            if($flag_qty==$count){
                $model->process_status='completed';
            }else{
                $model->process_status='processing';
            }
            $model->save(false);
            echo json_encode(["success" => true, "message" => "Invoice has been created."]);
            exit;
        }
        return $this->renderAjax('createinv', [
            'modelpr' => $modelpr,
            'model'=> $model,
             'modellastnumber'=>$modellastnumber,
            'model1'=> $model1,
            'type' => 'update',
        ]);
    }

     public function actionCreatepoinv($id){
        $branch_id=Yii::$app->user->identity->branch_id;
        $modellastnumber = PurchaseInvoice::find()->select('inv_number')->where(['branch_id'=>$branch_id])->orderBy('id desc')->limit(1)->one();
        
        $model = Purchaseorder::find()->where(['id'=>$id])->one();
        $model1 = new PurchaseInvoice();
        $modelpr = new PurchaseInvoiceItems();
        // if(Yii::$app->request->post()):
        //     $result=Yii::$app->request->post();
        //     $model1->supplier_id=(int) $result['PurchaseInvoice']['supplier_id'];
        //     $model1->inv_created_by=(int) $result['PurchaseInvoice']['inv_created_by'];
        //     $model1->po_id=(int) $result['PurchaseInvoice']['po_id'];
        //     if(isset($result['PurchaseInvoice']['discount_type']) && $result['PurchaseInvoice']['discount_type']=="percentage" && $result['PurchaseInvoice']['discount']!=""){
        //        $model1->discount_percent= $result['PurchaseInvoice']['discount'];
        //        $model1->discount=0;
        //     }
        //     if(isset($result['PurchaseInvoice']['discount_type'])){
        //         $model1->discount_type= $result['PurchaseInvoice']['discount_type'];
        //     }
        //     if(isset($result['PurchaseInvoice']['vat_percent'])){
        //          $model1->vat_percent=$result['PurchaseInvoice']['vat_percent'];
        //     }
        //     // var_dump($result);die;
        // endif;
    
         if ($model1->load(Yii::$app->request->post()) && $model1->save(false)) {
             $result=Yii::$app->request->post();
             $flag_qty=0;
            $count=0;
            for($i=0;$i<sizeof($result['PurchaseInvoiceItems']['item_id']);$i++){
                $model2 = new PurchaseInvoiceItems();
                $model2->item_id=$result['PurchaseInvoiceItems']['item_id'][$i];
                $model2->grn_quantity=(isset($result['PurchaseInvoiceItems']['grn_quantity'])?(int) $result['PurchaseInvoiceItems']['grn_quantity'][$i]:NULL);
                $model2->quantity=$result['PurchaseInvoiceItems']['quantity'][$i];
                $model2->remaining_quantity=$model2->grn_quantity-$model2->quantity;
                  if($model2->remaining_quantity==0){
                        $flag_qty++;
                    }
               
                $model2->price=$result['PurchaseInvoiceItems']['price'][$i];
                $model2->unit_id=$result['PurchaseInvoiceItems']['unit_id'][$i];
                $model2->total_price =$result['PurchaseInvoiceItems']['total_price'][$i];
                $model2->dis_type =(isset($result['PurchaseInvoiceItems']['dis_type'])?$result['PurchaseInvoiceItems']['dis_type'][$i]:NULL);
                $model2->discount_percentage=(isset($result['PurchaseInvoiceItems']['discount_percentage'])?$result['PurchaseInvoiceItems']['discount_percentage'][$i]:NULL);
                $model2->discount_amount=(isset($result['PurchaseInvoiceItems']['discount_amount'])?$result['PurchaseInvoiceItems']['discount_amount'][$i]:NULL);
                $model2->net_amount=(isset($result['PurchaseInvoiceItems']['net_amount'])?$result['PurchaseInvoiceItems']['net_amount'][$i]:NULL);
                $model2->vat_rate=(isset($result['PurchaseInvoiceItems']['vat_rate'])?$result['PurchaseInvoiceItems']['vat_rate'][$i]:NULL);
                $model2->tax=(isset($result['PurchaseInvoiceItems']['tax'])?$result['PurchaseInvoiceItems']['tax'][$i]:NULL);
                $model2->total=$result['PurchaseInvoiceItems']['total'][$i];
                $model2->inv_id=$model1->id;
                
                $model2->save(false);

                 $count++;
            }
            if($flag_qty==$count){
                $model->process_status='completed';
            }else{
                $model->process_status='processing';
            }
            $model->save(false);
             echo json_encode(["success" => true, "message" => "Invoice has been created."]);
            exit;
        }
        return $this->renderAjax('createpoinv', [
            'modelpr' => $modelpr,
            'model'=> $model,
            'model1'=> $model1,
            'modellastnumber'=>$modellastnumber,
            'type' => 'update',
        ]);
    }
    /**
     * Updates an existing PurchaseInvoice model.
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
             if(isset($result['PurchaseInvoice']['discount_type']) && $result['PurchaseInvoice']['discount_type']=="percentage" && $result['PurchaseInvoice']['discount']!=""){
               $model->discount_percent= $result['PurchaseInvoice']['discount'];
               $model->discount=0;
            }
            if(isset($result['PurchaseInvoice']['discount_type'])){
                $model->discount_type= $result['PurchaseInvoice']['discount_type'];
            }
            if(isset($result['PurchaseInvoice']['vat_percent'])){
                 $model->vat_percent=$result['PurchaseInvoice']['vat_percent'];
            }
        endif;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             $flag_qty=0;
            $count=0;
             for($i=0;$i<sizeof($result['PurchaseInvoiceItems']['item_id']);$i++){
                if(isset($result['PurchaseInvoiceItems']['id'][$i])){
                    $model1 = PurchaseInvoiceItems::find()->where(['id'=>$result['PurchaseInvoiceItems']['id'][$i]])->one();
                }else{
                    $model1 = new PurchaseInvoiceItems();
                }
                $model1->item_id=$result['PurchaseInvoiceItems']['item_id'][$i];
                $model1->quantity=$result['PurchaseInvoiceItems']['quantity'][$i];
                $model1->grn_quantity=(isset($result['PurchaseInvoiceItems']['grn_quantity'])?$result['PurchaseInvoiceItems']['grn_quantity'][$i]:NULL);
                 if($model->grn_id){
                    // $model1->grn_quantity=(int) $result['GrnItems']['grn_quantity'][$i];
                    $model1->remaining_quantity=$model1->grn_quantity-$model1->quantity;
                    if($model1->remaining_quantity==0){
                        $flag_qty++;
                    }
                }

                $model1->price=$result['PurchaseInvoiceItems']['price'][$i];
                $model1->unit_id=$result['PurchaseInvoiceItems']['unit_id'][$i];
                $model1->total_price =$result['PurchaseInvoiceItems']['total_price'][$i];
                $model1->dis_type =(isset($result['PurchaseInvoiceItems']['dis_type'])?$result['PurchaseInvoiceItems']['dis_type'][$i]:NULL);
                $model1->discount_percentage=(isset($result['PurchaseInvoiceItems']['discount_percentage'])?$result['PurchaseInvoiceItems']['discount_percentage'][$i]:NULL);
                $model1->discount_amount=(isset($result['PurchaseInvoiceItems']['discount_amount'])?$result['PurchaseInvoiceItems']['discount_amount'][$i]:NULL);
                $model1->net_amount=(isset($result['PurchaseInvoiceItems']['net_amount'])?$result['PurchaseInvoiceItems']['net_amount'][$i]:NULL);
                $model1->vat_rate=(isset($result['PurchaseInvoiceItems']['vat_rate'])?$result['PurchaseInvoiceItems']['vat_rate'][$i]:NULL);
                $model1->tax=(isset($result['PurchaseInvoiceItems']['tax'])?$result['PurchaseInvoiceItems']['tax'][$i]:NULL);
                $model1->total=$result['PurchaseInvoiceItems']['total'][$i];

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
            'type'  =>'update',
        ]);
    }

    /**
     * Deletes an existing PurchaseInvoice model.
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
        $modelpr=GoodsReceiptNote::find()->where(['id'=>(int) $do_id])->one();
         return $this->renderAjax('create', [
            'modelpr' => $modelpr,
        ]);
    }

    public function actionChangeStatus($id){
        $model = $this->findModel($id);
        $model->status = ($model->status == 0)?1:0;
        $model->save();
         echo json_encode(["success" => true, "message" => "Invoice Status has been changed."]);
            exit;
    }
    /**
     * Finds the PurchaseInvoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PurchaseInvoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PurchaseInvoice::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
