<?php

namespace backend\controllers;

use Yii;
use backend\models\GoodsReceiptNote;
use backend\models\GrnItems;
use backend\models\StockHistory;
use backend\models\Items;
use backend\models\StockDistribution;
use backend\models\PurchasePrice;
use backend\models\GoodsReceiptNoteSearch;
use backend\models\Purchaseorder;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GoodsReceiptNoteController implements the CRUD actions for GoodsReceiptNote model.
 */
class GoodsReceiptNoteController extends Controller
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
	 * Lists all GoodsReceiptNote models.
	 * @return mixed
	 */
	 public function actionIndex()
	{
		$searchModel = new GoodsReceiptNoteSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->renderAjax('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single GoodsReceiptNote model.
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
	 * Creates a new GoodsReceiptNote model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{ 
		$branch_id=Yii::$app->user->identity->branch_id;
		$modellastnumber = GoodsReceiptNote::find()->select('grn_number')->where(['branch_id'=>$branch_id])->orderBy('id desc')->limit(1)->one();
		$userId = \Yii::$app->user->identity->id;
		$model = new GoodsReceiptNote();
		$model1 = new GrnItems();
		// $modelitem = new Items();
		
		// if(Yii::$app->request->post()):
		//     $result=Yii::$app->request->post();
		//     $model->supplier_id=(int) $result['GoodsReceiptNote']['supplier_id'];
		//     $model->subtotal=(double) $result['GoodsReceiptNote']['subtotal'];
		//     $model->discount=(double) $result['GoodsReceiptNote']['discount'];
		//     $model->discount_percent=(double) $result['GoodsReceiptNote']['discount_percent'];
		//     $model->vat_percent=(double) $result['GoodsReceiptNote']['vat_percent'];
		//     $model->total_tax=(double) $result['GoodsReceiptNote']['total_tax'];
		//     $model->grand_total=(double) $result['GoodsReceiptNote']['grand_total'];
		//     // var_dump($result);die;
		// endif;
		// var_dump($result['Purchaseorder']);
		// var_dump(sizeof($result['Purchaserequestitems']['item_id']));die;
		if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
			$result=Yii::$app->request->post();
			for($i=0;$i<sizeof($result['GrnItems']['item_id']);$i++){
				$model1 = new GrnItems();
				$model1->item_id=$result['GrnItems']['item_id'][$i];
				$model1->quantity=$result['GrnItems']['quantity'][$i];
				$model1->price=$result['GrnItems']['price'][$i];
				$model1->unit_id=$result['GrnItems']['unit_id'][$i];
				$model1->total_price =$result['GrnItems']['total_price'][$i];
				$model1->dis_type =(isset($result['GrnItems']['dis_type'])?$result['GrnItems']['dis_type'][$i]:NULL);
				$model1->discount_percentage=(isset($result['GrnItems']['discount_percentage'])?$result['GrnItems']['discount_percentage'][$i]:NULL);
				$model1->discount_amount=(isset($result['GrnItems']['discount_amount'])?$result['GrnItems']['discount_amount'][$i]:NULL);
				$model1->net_amount=(isset($result['GrnItems']['net_amount'])?$result['GrnItems']['net_amount'][$i]:NULL);
				$model1->vat_rate=(isset($result['GrnItems']['vat_rate'])?$result['GrnItems']['vat_rate'][$i]:NULL);
				$model1->tax=(isset($result['GrnItems']['tax'])?$result['GrnItems']['tax'][$i]:NULL);
				$model1->total=$result['GrnItems']['total'][$i];
				$model1->grn_id=$model->id;
				$model1->save(false);

				// stock
	
				$modelitem=Items::find()->where(['id'=>$result['GrnItems']['item_id'][$i]])->one();
				// $modelstock = StockHistory::find()->where(['item_id'=>$result['GrnItems']['item_id'][$i]])->orderBy(['id' => SORT_DESC])->one();
				$modelstock = StockHistory::find()->where(['item_id' => $result['GrnItems']['item_id'][$i],'branch_id'=>$branch_id])->orderBy('id desc')->limit(1)->one();
				$modelstocksave=new StockHistory();
				$modelstocksave->item_id=$result['GrnItems']['item_id'][$i];
				$modelstocksave->opening_stock=$result['GrnItems']['quantity'][$i];
				$modelstocksave->previous_stock=(isset($modelstock->current_stock)?$modelstock->current_stock:$result['GrnItems']['quantity'][$i]);
				$modelstocksave->current_stock=$modelstocksave->opening_stock+$modelstocksave->previous_stock;
				$modelstocksave->type=$modelitem->type;
				$modelstocksave->date=date('Y-m-d');
				$modelstocksave->branch_id=$branch_id;
				$modelstocksave->order_id=$model->id;
				$modelstocksave->source_type='goods-receipt-note';
				$modelstocksave->code='stk'.$model->prefix_id.$model->grn_number;
				
				// $modelstock->quantity=$result['GrnItems']['quantity'][$i];
				// $model1->closing_stock=$result['GrnItems']['quantity'][$i];
				$modelstocksave->save(false);

				$modelstockdistribution=new StockDistribution();
				$modelstockdistribution->stock_id=$modelstocksave->id;
				$modelstockdistribution->item_id=$result['GrnItems']['item_id'][$i];
				$modelstockdistribution->opening_stock=$result['GrnItems']['quantity'][$i];
				$modelstockdistribution->previous_stock=0;
				$modelstockdistribution->current_stock=$result['GrnItems']['quantity'][$i];
				$modelstockdistribution->code='stk'.$model->prefix_id.$model->grn_number;
				$modelstockdistribution->save(false);
				//current_stock
				// $stockin=ItemStock::find()->where(['item_id'=>$result['GrnItems']['item_id'][$i],'type'=>'in'])->sum('quantity');
				// $stockout=ItemStock::find()->where(['item_id'=>$result['GrnItems']['item_id'][$i],'type'=>'out'])->sum('quantity');
				// $modelitem=Items::find()->where(['id'=>$result['GrnItems']['item_id'][$i]])->one();
				$modelitem->current_stock=$modelstocksave->current_stock;
				$modelitem->save(false);

				$modelpurchaseprice=new PurchasePrice();
				$modelpurchaseprice->item_id=$result['GrnItems']['item_id'][$i];
				// $modelpurchaseprice->type=$modelitem->type;
				$modelpurchaseprice->stock_id=$modelstocksave->id;
				$modelpurchaseprice->purchase_price=$result['GrnItems']['price'][$i];
				$modelpurchaseprice->code='stk'.$model->prefix_id.$model->grn_number;
				$modelpurchaseprice->save(false);
			}
			echo json_encode(["success" => true, "message" => "Goods Receipt Note has been created."]);
			exit;


		// $model = new GoodsReceiptNote();
		// $model1 = new GrnItems();
		// if ($model->load(Yii::$app->request->post()) && $model->save()) {
		//     return $this->redirect(['view', 'id' => $model->id]);
		// }
	}

		return $this->renderAjax('create', [
			'model' => $model,
			'modellastnumber'=>$modellastnumber,
			'type'=>'create',
			'model1' => $model1,
		]);
	}
	public function actionCreategrn($id){
		// var_dump($id);die;
		if(!isset($id)){
			$id==Yii::$app->request->post('po_id');
		}
		$branch_id=Yii::$app->user->identity->branch_id;
		$modellastnumber = GoodsReceiptNote::find()->select('grn_number')->where(['branch_id'=>$branch_id])->orderBy('id desc')->limit(1)->one();
		$model = Purchaseorder::find()->where(['id'=>$id])->one();
		$model1 = new GoodsReceiptNote();
		$modelpr = new GrnItems();
		// if(Yii::$app->request->post()):
		//     $result=Yii::$app->request->post();
		//     $model1->supplier_id=(int) $result['GoodsReceiptNote']['supplier_id'];
		//     $model1->grn_created_by=(int) $result['GoodsReceiptNote']['grn_created_by'];
		//     $model1->po_id=(int) $result['GoodsReceiptNote']['po_id'];
		//     $model1->subtotal=(double) $result['GoodsReceiptNote']['subtotal'];
		//     $model1->discount=(double) $result['GoodsReceiptNote']['discount'];
		//     $model1->discount_percent=(double) $result['GoodsReceiptNote']['discount_percent'];
		//     $model1->vat_percent=(double) $result['GoodsReceiptNote']['vat_percent'];
		//     $model1->total_tax=(double) $result['GoodsReceiptNote']['total_tax'];
		//     $model1->grand_total=(double) $result['GoodsReceiptNote']['grand_total'];
		//     // var_dump($result);die;
		// endif;
		
		 if ($model1->load(Yii::$app->request->post()) && $model1->save(false)) {
			$result=Yii::$app->request->post();
			$flag_qty=0;
			$count=0;
			for($i=0;$i<sizeof($result['GrnItems']['item_id']);$i++){
				$model2 = new GrnItems();
				$model2->item_id=$result['GrnItems']['item_id'][$i];
				$model2->po_quantity=$result['GrnItems']['po_quantity'][$i];
				$model2->quantity=$result['GrnItems']['quantity'][$i];
				$model2->remaining_quantity=$model2->po_quantity-$model2->quantity;
				if($model2->remaining_quantity==0){
					$flag_qty++;
				}
				$model2->price=$result['GrnItems']['price'][$i];
				$model2->unit_id=$result['GrnItems']['unit_id'][$i];
				$model2->total_price =$result['GrnItems']['total_price'][$i];
				$model2->dis_type =(isset($result['GrnItems']['dis_type'])?$result['GrnItems']['dis_type'][$i]:NULL);
				$model2->discount_percentage=(isset($result['GrnItems']['discount_percentage'])?$result['GrnItems']['discount_percentage'][$i]:NULL);
				$model2->discount_amount=(isset($result['GrnItems']['discount_amount'])?$result['GrnItems']['discount_amount'][$i]:NULL);
				$model2->net_amount=(isset($result['GrnItems']['net_amount'])?$result['GrnItems']['net_amount'][$i]:NULL);
				$model2->vat_rate=(isset($result['GrnItems']['vat_rate'])?$result['GrnItems']['vat_rate'][$i]:NULL);
				$model2->tax=(isset($result['GrnItems']['tax'])?$result['GrnItems']['tax'][$i]:NULL);
				$model2->total=$result['GrnItems']['total'][$i];
				$model2->grn_id=$model1->id;
				
				$model2->save(false);
				$count++;

				$modelstock = StockHistory::find()->where(['item_id' => $result['GrnItems']['item_id'][$i],'branch_id'=>$branch_id])->orderBy('id desc')->limit(1)->one();
				$modelstocksave=new StockHistory();
				$modelstocksave->item_id=$result['GrnItems']['item_id'][$i];
				$modelstocksave->opening_stock=$result['GrnItems']['quantity'][$i];
				$modelstocksave->previous_stock=(isset($modelstock->current_stock)?$modelstock->current_stock:$result['GrnItems']['quantity'][$i]);
				$modelstocksave->current_stock=$modelstocksave->opening_stock+$modelstocksave->previous_stock;
				$modelstocksave->type=$modelitem->type;
				$modelstocksave->date=date('Y-m-d');
				$modelstocksave->branch_id=$branch_id;
				$modelstocksave->order_id=$model1->id;
				$modelstocksave->source_type='goods-receipt-note';
				$modelstocksave->code='stk'.$model1->prefix_id.$model1->grn_number;
				// $modelstock->quantity=$result['GrnItems']['quantity'][$i];
				// $model1->closing_stock=$result['GrnItems']['quantity'][$i];
				$modelstocksave->save(false);
				$modelstockdistribution=new StockDistribution();
				$modelstockdistribution->stock_id=$modelstocksave->id;
				$modelstockdistribution->item_id=$result['GrnItems']['item_id'][$i];
				$modelstockdistribution->opening_stock=$result['GrnItems']['quantity'][$i];
				$modelstockdistribution->previous_stock=0;
				$modelstockdistribution->current_stock=$result['GrnItems']['quantity'][$i];
				$modelstockdistribution->code='stk'.$model1->prefix_id.$model1->grn_number;
				$modelstockdistribution->save(false);


				$modelpurchaseprice=new PurchasePrice();
				$modelpurchaseprice->item_id=$result['GrnItems']['item_id'][$i];
				// $modelpurchaseprice->type=$modelitem->type;
				$modelpurchaseprice->stock_id=$modelstocksave->id;
				$modelpurchaseprice->purchase_price=$result['GrnItems']['price'][$i];
				$modelpurchaseprice->code='stk'.$model1->prefix_id.$model1->grn_number;
				$modelpurchaseprice->save(false);
			}
			if($flag_qty==$count){
				$model->process_status='completed';
			}else{
				$model->process_status='processing';
			}
			$model->save(false);
			echo json_encode(["success" => true, "message" => "Goods Receipt Note has been created."]);
			exit;
		}
		return $this->renderAjax('creategrn', [
			'modelpr' => $modelpr,
			'model'=> $model,
			'modellastnumber'=>$modellastnumber,
			'model1'=> $model1,
			'type' => 'update',
		]);
	}
	/**
	 * Updates an existing GoodsReceiptNote model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{   
		$branch_id=Yii::$app->user->identity->branch_id;
		$model = $this->findModel($id);
		//  if(Yii::$app->request->post()):
		//     $result=Yii::$app->request->post();
		//     $model->subtotal=(double) $result['GoodsReceiptNote']['subtotal'];
		//     $model->discount=(double) $result['GoodsReceiptNote']['discount'];
		//     $model->discount_percent=(double) $result['GoodsReceiptNote']['discount_percent'];
		//     $model->vat_percent=(double) $result['GoodsReceiptNote']['vat_percent'];
		//     $model->total_tax=(double) $result['GoodsReceiptNote']['total_tax'];
		//     $model->grand_total=(double) $result['GoodsReceiptNote']['grand_total'];
		// endif;
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$result=Yii::$app->request->post();
			$flag_qty=0;
			$count=0;
			 for($i=0;$i<sizeof($result['GrnItems']['item_id']);$i++){
				if(isset($result['GrnItems']['id'][$i])){
					$model1 = GrnItems::find()->where(['id'=>$result['GrnItems']['id'][$i]])->one();
				}else{
					$model1 = new GrnItems();
				}
				$model1->item_id=$result['GrnItems']['item_id'][$i];
				$model1->quantity=$result['GrnItems']['quantity'][$i];
				if($model->po_id){
					$model1->po_quantity=(int) $result['GrnItems']['po_quantity'][$i];
					$model1->remaining_quantity=$model1->po_quantity-$model1->quantity;
					if($model1->remaining_quantity==0){
						$flag_qty++;
					}
				}
				$model1->price=$result['GrnItems']['price'][$i];
				$model1->unit_id=$result['GrnItems']['unit_id'][$i];
				$model1->total_price =$result['GrnItems']['total_price'][$i];
				$model1->dis_type =(isset($result['GrnItems']['dis_type'])?$result['GrnItems']['dis_type'][$i]:NULL);
				$model1->discount_percentage=(isset($result['GrnItems']['discount_percentage'])?$result['GrnItems']['discount_percentage'][$i]:NULL);
				$model1->discount_amount=(isset($result['GrnItems']['discount_amount'])?$result['GrnItems']['discount_amount'][$i]:NULL);
				$model1->net_amount=(isset($result['GrnItems']['net_amount'])?$result['GrnItems']['net_amount'][$i]:NULL);
				$model1->vat_rate=(isset($result['GrnItems']['vat_rate'])?$result['GrnItems']['vat_rate'][$i]:NULL);
				$model1->tax=(isset($result['GrnItems']['tax'])?$result['GrnItems']['tax'][$i]:NULL);
				$model1->total=$result['GrnItems']['total'][$i];
				$model1->grn_id=$model->id;
				
				$model1->save(false);
				$count++;


				// $modelstock = StockHistory::find()->where(['item_id' => $result['GrnItems']['item_id'][$i],'branch_id'=>$branch_id])->orderBy('id desc')->limit(1)->one();
				// if(StockHistory::find()->where([['item_id' => $result['GrnItems']['item_id'][$i],'branch_id'=>$branch_id,'code'=>'stk'.$model1->prefix_id.$model1->grn_number])->exists()){
				// 	$modelstocksave=StockHistory::find()->where([['item_id' => $result['GrnItems']['item_id'][$i],'branch_id'=>$branch_id,'code'=>'stk'.$model1->prefix_id.$model1->grn_number])->one();
				// }
				// else
				// {                    
				//   $modelstocksave=new StockHistory();
				// } 

				
				// $modelstocksave->item_id=$result['GrnItems']['item_id'][$i];
				// $modelstocksave->opening_stock=$result['GrnItems']['quantity'][$i];
				// $modelstocksave->previous_stock=(isset($modelstock->current_stock)?$modelstock->current_stock:$result['GrnItems']['quantity'][$i]);
				// $modelstocksave->current_stock=$modelstocksave->opening_stock+$modelstocksave->previous_stock;
				// $modelstocksave->type=$modelitem->type;
				// $modelstocksave->date=date('Y-m-d');
				// $modelstocksave->branch_id=$branch_id;
				// $modelstocksave->order_id=$model1->id;
				// $modelstocksave->source_type='goods-receipt-note';
				// $modelstocksave->code='stk'.$model1->prefix_id.$model1->grn_number;
				// // $modelstock->quantity=$result['GrnItems']['quantity'][$i];
				// // $model1->closing_stock=$result['GrnItems']['quantity'][$i];
				// $modelstocksave->save(false);

				// if(StockHistory::find()->where([['item_id' => $result['GrnItems']['item_id'][$i],'branch_id'=>$branch_id,'code'=>'stk'.$model1->prefix_id.$model1->grn_number])->exists()){
				// 	$modelstocksave=StockDistribution::find()->where([['item_id' => $result['GrnItems']['item_id'][$i],'code'=>'stk'.$model1->prefix_id.$model1->grn_number])->one();
				// }
				// else
				// {                    
				//   $modelstockdistribution=new StockDistribution();
				// } 
				
				// $modelstockdistribution->item_id=$result['GrnItems']['item_id'][$i];
				// $modelstockdistribution->opening_stock=$result['GrnItems']['quantity'][$i];
				// $modelstockdistribution->previous_stock=0;
				// $modelstockdistribution->current_stock=$result['GrnItems']['quantity'][$i];
				// $modelstockdistribution->code='stk'.$model1->prefix_id.$model1->grn_number;
				// $modelstockdistribution->save(false);

				// if(StockHistory::find()->where([['item_id' => $result['GrnItems']['item_id'][$i],'branch_id'=>$branch_id,'code'=>'stk'.$model1->prefix_id.$model1->grn_number])->exists()){
				// 	$modelstocksave=PurchasePrice::find()->where([['item_id' => $result['GrnItems']['item_id'][$i],'code'=>'stk'.$model1->prefix_id.$model1->grn_number])->one();
				// }
				// else
				// {                    
				//   $modelpurchaseprice=new PurchasePrice();
				// } 
				
				// $modelpurchaseprice->item_id=$result['GrnItems']['item_id'][$i];
				// $modelpurchaseprice->purchase_price=$result['GrnItems']['price'][$i];
				// $modelpurchaseprice->code='stk'.$model1->prefix_id.$model1->grn_number;
				// $modelpurchaseprice->save(false);




			}
			if($flag_qty==$count){
				$model->process_status='completed';
			}else{
				$model->process_status='processing';
			}
			$model->save(false);
			echo json_encode(["success" => true, "message" => "Goods Receipt Note has been updated."]);
			exit;
		}

		return $this->renderAjax('update', [
			'model' => $model,
			'type'  =>'update',
		]);
	}

	/**
	 * Deletes an existing GoodsReceiptNote model.
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
		$modelpr=Purchaseorder::find()->where(['id'=>(int) $po_id])->one();
		 return $this->renderAjax('create', [
			'modelpr' => $modelpr,
		]);
	}

	public function actionChangeStatus($id){
		$model = $this->findModel($id);
		$model->status = ($model->status == 0)?1:0;
		$model->save();
		echo json_encode(["success" => true, "message" => "Goods Receipt Note Status has been changed."]);
			exit;
	}
	/**
	 * Finds the GoodsReceiptNote model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return GoodsReceiptNote the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = GoodsReceiptNote::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
