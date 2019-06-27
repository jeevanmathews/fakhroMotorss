<?php

namespace backend\controllers;

use Yii;
use backend\models\PurchaseReturn;
use backend\models\PurchaseReturnItems;
use backend\models\PurchaseReturnSearch;
use backend\models\GoodsReceiptNote;
use backend\models\PurchaseInvoice;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\StockHistory;
use backend\models\Items;
use yii\data\ActiveDataProvider;
/**
 * PurchaseReturnController implements the CRUD actions for PurchaseReturn model.
 */
class PurchaseReturnController extends Controller
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
     * Lists all PurchaseReturn models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PurchaseReturnSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $page_id = "purchase-return".time();
        if(isset(Yii::$app->request->queryParams['page_id'])){
            $page_id = Yii::$app->request->queryParams['page_id'];
        }
        return $this->renderAjax('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'page_id' => $page_id
        ]);
    }


    public function actionReturn($id){
        $return =$this->findModel($id);

        $itemsquery = PurchaseReturnItems::find();
        // $materialquery = JobcardInvoiceMaterial::find();
        
        $itemsquery->andFilterWhere([
            'prtn_id' => $return->id,
        ]);
        $itemsdataProvider = new ActiveDataProvider([
            'query' => $itemsquery,
            'sort' => false
        ]);

        // $materialquery->andFilterWhere([
        //     'return_id' => $return->id,
        // ]);
        // $materialdataProvider = new ActiveDataProvider([
        //     'query' => $materialquery,
        //     'sort' => false
        // ]);       
        return $this->renderAjax('_return',compact('return','itemsdataProvider'));
    }
    /**
     * Displays a single PurchaseReturn model.
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
     * Creates a new PurchaseReturn model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     public function actionCreate()
    {
        $branch_id=Yii::$app->common->branchid->branch_id;
        $userId = \Yii::$app->user->identity->id;
        $model = new PurchaseReturn();
        $model1 = new PurchaseReturnItems();
        if(Yii::$app->request->post()):
            $result=Yii::$app->request->post();
            $model->supplier_id=(int) $result['PurchaseReturn']['supplier_id'];
            if(isset($result['PurchaseReturn']['discount_type']) && $result['PurchaseReturn']['discount_type']=="percentage" && $result['PurchaseReturn']['discount']!=""){
               $model->discount_percent= $result['PurchaseReturn']['discount'];
               $model->discount=0;
            }
            if(isset($result['PurchaseReturn']['discount_type'])){
                $model->discount_type= $result['PurchaseReturn']['discount_type'];
            }
            if(isset($result['PurchaseReturn']['vat_percent'])){
                 $model->vat_percent=$result['PurchaseReturn']['vat_percent'];
            }
            // var_dump($result['PurchaseReturn']['supplier_id']);die;
            // var_dump($model->discount_type);die;
        endif;
        // var_dump($result['GoodsReceiptNote']);
        // var_dump(sizeof($result['Purchaserequestitems']['item_id']));die;
        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {

            for($i=0;$i<sizeof($result['PurchaseReturnItems']['item_id']);$i++){
                $model1 = new PurchaseReturnItems();
                $model1->item_id=$result['PurchaseReturnItems']['item_id'][$i];
                $model1->quantity=$result['PurchaseReturnItems']['quantity'][$i];
                $model1->price=$result['PurchaseReturnItems']['price'][$i];
                $model1->unit_id=$result['PurchaseReturnItems']['unit_id'][$i];
                $model1->total_price =$result['PurchaseReturnItems']['total_price'][$i];
                $model1->dis_type =(isset($result['PurchaseReturnItems']['dis_type'])?$result['PurchaseReturnItems']['dis_type'][$i]:NULL);
                $model1->discount_percentage=(isset($result['PurchaseReturnItems']['discount_percentage'])?$result['PurchaseReturnItems']['discount_percentage'][$i]:NULL);
                $model1->discount_amount=(isset($result['PurchaseReturnItems']['discount_amount'])?$result['PurchaseReturnItems']['discount_amount'][$i]:NULL);
                $model1->net_amount=(isset($result['PurchaseReturnItems']['net_amount'])?$result['PurchaseReturnItems']['net_amount'][$i]:NULL);
                $model1->vat_rate=(isset($result['PurchaseReturnItems']['vat_rate'])?$result['PurchaseReturnItems']['vat_rate'][$i]:NULL);
                $model1->tax=(isset($result['PurchaseReturnItems']['tax'])?$result['PurchaseReturnItems']['tax'][$i]:NULL);
                $model1->total=$result['PurchaseReturnItems']['total'][$i];

                $model1->prtn_id=$model->id;
                
                $model1->save(false);

                $modelitem=Items::find()->where(['id'=>$result['PurchaseReturnItems']['item_id'][$i]])->one();
                // $modelstock = StockHistory::find()->where(['item_id'=>$result['GrnItems']['item_id'][$i]])->orderBy(['id' => SORT_DESC])->one();
                $modelstock = StockHistory::find()->where(['item_id' => $result['PurchaseReturnItems']['item_id'][$i],'branch_id'=>$branch_id])->orderBy('id desc')->limit(1)->one();
                $modelstocksave=new StockHistory();
                $modelstocksave->item_id=$result['PurchaseReturnItems']['item_id'][$i];
                $modelstocksave->opening_stock=0;//$result['PurchaseReturnItems']['quantity'][$i];
                $modelstocksave->previous_stock=(isset($modelstock->current_stock)?$modelstock->current_stock:0);
                $modelstocksave->reduced_stock=$result['PurchaseReturnItems']['quantity'][$i];
                $modelstocksave->current_stock=$modelstocksave->previous_stock-$modelstocksave->reduced_stock;
                $modelstocksave->type=$modelitem->type;
                $modelstocksave->date=date('Y-m-d');
                $modelstocksave->branch_id=$branch_id;
                $modelstocksave->save(false);

                $modelitem->current_stock=$modelstocksave->current_stock;
                $modelitem->save(false);

            }
            echo json_encode(["success" => true, "message" => "PurchaseReturn has been created", 'redirect' => Yii::$app->getUrlManager()->createUrl(['purchase-return/update','id' => $model->id])]);
            exit;


        // $model = new PurchaseReturn();
        // $model1 = new PurchaseReturnItems();
        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->id]);
        // }
    }

        return $this->renderAjax('create', [
            'model' => $model,
            'type'=>'create',
            'model1' => $model1,
        ]);
    }
    public function actionCreateprtn($id){
        $branch_id=Yii::$app->common->branchid->branch_id;
        $model = GoodsReceiptNote::find()->where(['id'=>$id])->one();
        $model1 = new PurchaseReturn();
        $modelpr = new PurchaseReturnItems();
        if(Yii::$app->request->post()):
            $result=Yii::$app->request->post();
            $model1->supplier_id=(int) $result['PurchaseReturn']['supplier_id'];
            $model1->prtn_created_by=(int) $result['PurchaseReturn']['prtn_created_by'];
            $model1->grn_id=(int) $result['PurchaseReturn']['grn_id'];
            if(isset($result['PurchaseReturn']['discount_type']) && $result['PurchaseReturn']['discount_type']=="percentage" && $result['PurchaseReturn']['discount']!=""){
               $model1->discount_percent= $result['PurchaseReturn']['discount'];
               $model1->discount=0;
            }
            if(isset($result['PurchaseReturn']['discount_type'])){
                $model1->discount_type= $result['PurchaseReturn']['discount_type'];
            }
            if(isset($result['PurchaseReturn']['vat_percent'])){
                 $model1->vat_percent=$result['PurchaseReturn']['vat_percent'];
            }
        endif;
         if ($model1->load(Yii::$app->request->post()) && $model1->save(false)) {
             $flag_qty=0;
            $count=0;
            for($i=0;$i<sizeof($result['PurchaseReturnItems']['item_id']);$i++){
                $model2 = new PurchaseReturnItems();
                $model2->item_id=$result['PurchaseReturnItems']['item_id'][$i];
                $model2->quantity=$result['PurchaseReturnItems']['quantity'][$i];
                $model2->grn_quantity=(isset($result['PurchaseReturnItems']['grn_quantity'])?(int) $result['PurchaseReturnItems']['grn_quantity'][$i]:NULL);
                $model2->remaining_quantity=$model2->grn_quantity-$model2->quantity;
                if($model2->remaining_quantity==0){
                    $flag_qty++;
                }
                $model2->price=$result['PurchaseReturnItems']['price'][$i];
                $model2->unit_id=$result['PurchaseReturnItems']['unit_id'][$i];
                $model2->total_price =$result['PurchaseReturnItems']['total_price'][$i];
                $model2->dis_type =(isset($result['PurchaseReturnItems']['dis_type'])?$result['PurchaseReturnItems']['dis_type'][$i]:NULL);
                $model2->discount_percentage=(isset($result['PurchaseReturnItems']['discount_percentage'])?$result['PurchaseReturnItems']['discount_percentage'][$i]:NULL);
                $model2->discount_amount=(isset($result['PurchaseReturnItems']['discount_amount'])?$result['PurchaseReturnItems']['discount_amount'][$i]:NULL);
                $model2->net_amount=(isset($result['PurchaseReturnItems']['net_amount'])?$result['PurchaseReturnItems']['net_amount'][$i]:NULL);
                $model2->vat_rate=(isset($result['PurchaseReturnItems']['vat_rate'])?$result['PurchaseReturnItems']['vat_rate'][$i]:NULL);
                $model2->tax=(isset($result['PurchaseReturnItems']['tax'])?$result['PurchaseReturnItems']['tax'][$i]:NULL);
                $model2->total=$result['PurchaseReturnItems']['total'][$i];
                $model2->prtn_id=$model1->id;
                
                $model2->save(false);
              $count++;

              $modelitem=Items::find()->where(['id'=>$result['PurchaseReturnItems']['item_id'][$i]])->one();
            // $modelstock = StockHistory::find()->where(['item_id'=>$result['GrnItems']['item_id'][$i]])->orderBy(['id' => SORT_DESC])->one();
            $modelstock = StockHistory::find()->where(['item_id' => $result['PurchaseReturnItems']['item_id'][$i],'branch_id'=>$branch_id])->orderBy('id desc')->limit(1)->one();
            $modelstocksave=new StockHistory();
            $modelstocksave->item_id=$result['PurchaseReturnItems']['item_id'][$i];
            $modelstocksave->opening_stock=0;//$result['PurchaseReturnItems']['quantity'][$i];
            $modelstocksave->previous_stock=(isset($modelstock->current_stock)?$modelstock->current_stock:0);
            $modelstocksave->reduced_stock=$result['PurchaseReturnItems']['quantity'][$i];
            $modelstocksave->current_stock=$modelstocksave->previous_stock-$modelstocksave->reduced_stock;
            $modelstocksave->type=$modelitem->type;
            $modelstocksave->date=date('Y-m-d');
            $modelstocksave->branch_id=$branch_id;
            $modelstocksave->save(false);

            $modelitem->current_stock=$modelstocksave->current_stock;
            $modelitem->save(false);
            }
            // if($flag_qty==$count){
            $model->process_status='completed';
        // }else{
            // $model->process_status='processing';
        // }
            $model->save(false);
            
            
           echo json_encode(["success" => true, "message" => "Purchase Return has been created."]);
            exit;
        }
        return $this->renderAjax('createprtn', [
            'modelpr' => $modelpr,
            'model'=> $model,
            'model1'=> $model1,
            'type' => 'update',
        ]);
    }

     public function actionCreateprtninv($id){
        $branch_id=Yii::$app->common->branchid->branch_id;
        // var_dump($branch_id);die;
        $model = PurchaseInvoice::find()->where(['id'=>$id])->one();
        $model1 = new PurchaseReturn();
        $modelpr = new PurchaseReturnItems();
        if(Yii::$app->request->post()):
            $result=Yii::$app->request->post();
            $model1->supplier_id=(int) $result['PurchaseReturn']['supplier_id'];
            $model1->prtn_created_by=(int) $result['PurchaseReturn']['prtn_created_by'];
            $model1->inv_id=(int) $result['PurchaseReturn']['inv_id'];
            if(isset($result['PurchaseReturn']['discount_type']) && $result['PurchaseReturn']['discount_type']=="percentage" && $result['PurchaseReturn']['discount']!=""){
               $model1->discount_percent= $result['PurchaseReturn']['discount'];
               $model1->discount=0;
            }
            if(isset($result['PurchaseReturn']['discount_type'])){
                $model1->discount_type= $result['PurchaseReturn']['discount_type'];
            }
            if(isset($result['PurchaseReturn']['vat_percent'])){
                 $model1->vat_percent=$result['PurchaseReturn']['vat_percent'];
            }
            // var_dump($result);die;
        endif;
    
         if ($model1->load(Yii::$app->request->post()) && $model1->save(false)) {
             $flag_qty=0;
            $count=0;
            for($i=0;$i<sizeof($result['PurchaseReturnItems']['item_id']);$i++){
                $model2 = new PurchaseReturnItems();
                $model2->item_id=$result['PurchaseReturnItems']['item_id'][$i];
                $model2->grn_quantity=(isset($result['PurchaseReturnItems']['grn_quantity'])?(int) $result['PurchaseReturnItems']['grn_quantity'][$i]:NULL);
                $model2->quantity=$result['PurchaseReturnItems']['quantity'][$i];
                $model2->remaining_quantity=$model2->grn_quantity-$model2->quantity;
                  if($model2->remaining_quantity==0){
                        $flag_qty++;
                    }
               
                $model2->price=$result['PurchaseReturnItems']['price'][$i];
                $model2->unit_id=$result['PurchaseReturnItems']['unit_id'][$i];
                $model2->total_price =$result['PurchaseReturnItems']['total_price'][$i];
                $model2->dis_type =(isset($result['PurchaseReturnItems']['dis_type'])?$result['PurchaseReturnItems']['dis_type'][$i]:NULL);
                $model2->discount_percentage=(isset($result['PurchaseReturnItems']['discount_percentage'])?$result['PurchaseReturnItems']['discount_percentage'][$i]:NULL);
                $model2->discount_amount=(isset($result['PurchaseReturnItems']['discount_amount'])?$result['PurchaseReturnItems']['discount_amount'][$i]:NULL);
                $model2->net_amount=(isset($result['PurchaseReturnItems']['net_amount'])?$result['PurchaseReturnItems']['net_amount'][$i]:NULL);
                $model2->vat_rate=(isset($result['PurchaseReturnItems']['vat_rate'])?$result['PurchaseReturnItems']['vat_rate'][$i]:NULL);
                $model2->tax=(isset($result['PurchaseReturnItems']['tax'])?$result['PurchaseReturnItems']['tax'][$i]:NULL);
                $model2->total=$result['PurchaseReturnItems']['total'][$i];
                $model2->prtn_id=$model1->id;
                
                $model2->save(false);

                 $count++;
           
            // if($flag_qty==$count){
                $model->process_status='completed';
            // }else{
                // $model->process_status='processing';
            // }
            $model->save(false);
            $modelitem=Items::find()->where(['id'=>$result['PurchaseReturnItems']['item_id'][$i]])->one();
                // $modelstock = StockHistory::find()->where(['item_id'=>$result['GrnItems']['item_id'][$i]])->orderBy(['id' => SORT_DESC])->one();
            $modelstock = StockHistory::find()->where(['item_id' => $result['PurchaseReturnItems']['item_id'][$i],'branch_id'=>$branch_id])->orderBy('id desc')->limit(1)->one();
            $modelstocksave=new StockHistory();
            $modelstocksave->item_id=$result['PurchaseReturnItems']['item_id'][$i];
            $modelstocksave->opening_stock=0;//$result['PurchaseReturnItems']['quantity'][$i];
            $modelstocksave->previous_stock=(isset($modelstock->current_stock)?$modelstock->current_stock:0);//(($modelstock->current_stock)?$modelstock->current_stock:$result['PurchaseReturnItems']['quantity'][$i]);
            $modelstocksave->reduced_stock=$result['PurchaseReturnItems']['quantity'][$i];
            $modelstocksave->current_stock=$modelstocksave->previous_stock-$modelstocksave->reduced_stock;
            $modelstocksave->type=$modelitem->type;
            $modelstocksave->date=date('Y-m-d');
            $modelstocksave->branch_id=$branch_id;
            $modelstocksave->save(false);

            $modelitem->current_stock=$modelstocksave->current_stock;
            $modelitem->save(false);
             }
           echo json_encode(["success" => true, "message" => "Purchase Return has been created."]);
            exit;
        }
        return $this->renderAjax('createprtninv', [
            'modelpr' => $modelpr,
            'model'=> $model,
            'model1'=> $model1,
            'type' => 'update',
        ]);
    }
    /**
     * Updates an existing PurchaseReturn model.
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
             if(isset($result['PurchaseReturn']['discount_type']) && $result['PurchaseReturn']['discount_type']=="percentage" && $result['PurchaseReturn']['discount']!=""){
               $model->discount_percent= $result['PurchaseReturn']['discount'];
               $model->discount=0;
            }
            if(isset($result['PurchaseReturn']['discount_type'])){
                $model->discount_type= $result['PurchaseReturn']['discount_type'];
            }
            if(isset($result['PurchaseReturn']['vat_percent'])){
                 $model->vat_percent=$result['PurchaseReturn']['vat_percent'];
            }
        endif;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             $flag_qty=0;
            $count=0;
             for($i=0;$i<sizeof($result['PurchaseReturnItems']['item_id']);$i++){
                if(isset($result['PurchaseReturnItems']['id'][$i])){
                    $model1 = PurchaseReturnItems::find()->where(['id'=>$result['PurchaseReturnItems']['id'][$i]])->one();
                }else{
                    $model1 = new PurchaseReturnItems();
                }
                $model1->item_id=$result['PurchaseReturnItems']['item_id'][$i];
                $model1->quantity=$result['PurchaseReturnItems']['quantity'][$i];
                $model1->grn_quantity=(isset($result['PurchaseReturnItems']['grn_quantity'])?$result['PurchaseReturnItems']['grn_quantity'][$i]:NULL);
                 if($model->grn_id){
                    // $model1->grn_quantity=(int) $result['GrnItems']['grn_quantity'][$i];
                    $model1->remaining_quantity=$model1->grn_quantity-$model1->quantity;
                    if($model1->remaining_quantity==0){
                        $flag_qty++;
                    }
                }

                $model1->price=$result['PurchaseReturnItems']['price'][$i];
                $model1->unit_id=$result['PurchaseReturnItems']['unit_id'][$i];
                $model1->total_price =$result['PurchaseReturnItems']['total_price'][$i];
                $model1->dis_type =(isset($result['PurchaseReturnItems']['dis_type'])?$result['PurchaseReturnItems']['dis_type'][$i]:NULL);
                $model1->discount_percentage=(isset($result['PurchaseReturnItems']['discount_percentage'])?$result['PurchaseReturnItems']['discount_percentage'][$i]:NULL);
                $model1->discount_amount=(isset($result['PurchaseReturnItems']['discount_amount'])?$result['PurchaseReturnItems']['discount_amount'][$i]:NULL);
                $model1->net_amount=(isset($result['PurchaseReturnItems']['net_amount'])?$result['PurchaseReturnItems']['net_amount'][$i]:NULL);
                $model1->vat_rate=(isset($result['PurchaseReturnItems']['vat_rate'])?$result['PurchaseReturnItems']['vat_rate'][$i]:NULL);
                $model1->tax=(isset($result['PurchaseReturnItems']['tax'])?$result['PurchaseReturnItems']['tax'][$i]:NULL);
                $model1->total=$result['PurchaseReturnItems']['total'][$i];

                $model1->prtn_id=$model->id;
                
                $model1->save(false);
             $count++;
            }
            if($flag_qty==$count){
                $model->process_status='completed';
            }else{
                $model->process_status='processing';
            }
            $model->save(false);
            echo json_encode(["success" => true, "message" => "Purchase Return has been updated."]);
            exit;
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'type'  =>'update',
        ]);
    }

    /**
     * Deletes an existing PurchaseReturn model.
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
        if($model->save()){
            echo json_encode(["success" => true, "message" => "Status has been changed.",'redirect'=>Yii::$app->getUrlManager()->createUrl(['purchase-return/index'])]);
            exit;
        }
    }
    /**
     * Finds the PurchaseReturn model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PurchaseReturn the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PurchaseReturn::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
