<?php

namespace backend\controllers;

use Yii;
use backend\models\Purchaserequest;
use backend\models\Purchaserequestitems;
use backend\models\Purchaseorder;
use backend\models\Purchaseorderitems;
use backend\models\PurchaseorderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PurchaseorderController implements the CRUD actions for Purchaseorder model.
 */
class PurchaseOrderController extends Controller
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
     * Lists all Purchaseorder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PurchaseorderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

       $page_id = "purchase-order".time();
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
     * Displays a single Purchaseorder model.
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
     * Creates a new Purchaseorder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $branch_id=Yii::$app->user->identity->branch_id;
        $modellastnumber = Purchaseorder::find()->select('po_number')->where(['branch_id'=>$branch_id])->orderBy('id desc')->limit(1)->one();
        $userId = \Yii::$app->user->identity->id;
        $model = new Purchaseorder();
        $model1 = new Purchaseorderitems();
        // if(Yii::$app->request->post()):
        //     $result=Yii::$app->request->post();
        //     $model->supplier_id=(int) $result['Purchaseorder']['supplier_id'];
        //     $model->subtotal=(double) $result['Purchaseorder']['subtotal'];
        //     $model->discount=(double) $result['Purchaseorder']['discount'];
        //     $model->discount_percent=(double) $result['Purchaseorder']['discount_percent'];
        //     $model->vat_percent=(double) $result['Purchaseorder']['vat_percent'];
        //     $model->total_tax=(double) $result['Purchaseorder']['total_tax'];
        //     $model->grand_total=(double) $result['Purchaseorder']['grand_total'];
        //     // var_dump($result);die;
        // endif;
        // var_dump($result['Purchaserequest']);
        // var_dump(sizeof($result['Purchaserequestitems']['item_id']));die;
        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            $result=Yii::$app->request->post();
            for($i=0;$i<sizeof($result['Purchaseorderitems']['item_id']);$i++){
                $model1 = new Purchaseorderitems();
                $model1->item_id=$result['Purchaseorderitems']['item_id'][$i];
                $model1->quantity=$result['Purchaseorderitems']['quantity'][$i];
                $model1->price=$result['Purchaseorderitems']['price'][$i];
                $model1->unit_id=$result['Purchaseorderitems']['unit_id'][$i];
                $model1->total_price =$result['Purchaseorderitems']['total_price'][$i];
                $model1->dis_type =(isset($result['Purchaseorderitems']['dis_type'])?$result['Purchaseorderitems']['dis_type'][$i]:NULL);
                $model1->discount_percentage=(isset($result['Purchaseorderitems']['discount_percentage'])?$result['Purchaseorderitems']['discount_percentage'][$i]:NULL);
                $model1->discount_amount=(isset($result['Purchaseorderitems']['discount_amount'])?$result['Purchaseorderitems']['discount_amount'][$i]:NULL);
                $model1->net_amount=(isset($result['Purchaseorderitems']['net_amount'])?$result['Purchaseorderitems']['net_amount'][$i]:NULL);
                $model1->vat_rate=(isset($result['Purchaseorderitems']['vat_rate'])?$result['Purchaseorderitems']['vat_rate'][$i]:NULL);
                $model1->tax=(isset($result['Purchaseorderitems']['tax'])?$result['Purchaseorderitems']['tax'][$i]:NULL);
                $model1->total=$result['Purchaseorderitems']['total'][$i];



                $model1->po_id=$model->id;
                
                $model1->save(false);
            }
            echo json_encode(["success" => true, "message" => "Purchase Order has been created."]);
            exit;


        // $model = new Purchaseorder();
        // $model1 = new Purchaseorderitems();
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
    public function actionCreatepo($id){
        $branch_id=Yii::$app->user->identity->branch_id;
        $modellastnumber = Purchaseorder::find()->select('po_number')->where(['branch_id'=>$branch_id])->orderBy('id desc')->limit(1)->one();
        $model = Purchaserequest::find()->where(['id'=>$id])->one();
        $model1 = new Purchaseorder();
        $modelpr = new Purchaseorderitems();
        // if(Yii::$app->request->post()):
        //     $result=Yii::$app->request->post();
        //     $model1->supplier_id=(int) $result['Purchaseorder']['supplier_id'];
        //     $model1->po_created_by=(int) $result['Purchaseorder']['po_created_by'];
        //     $model1->pr_id=(int) $result['Purchaseorder']['pr_id'];
        //     $model1->subtotal=(double) $result['Purchaseorder']['subtotal'];
        //     $model1->discount=(double) $result['Purchaseorder']['discount'];
        //     $model1->discount_percent=(double) $result['Purchaseorder']['discount_percent'];
        //     $model1->vat_percent=(double) $result['Purchaseorder']['vat_percent'];
        //     $model1->total_tax=(double) $result['Purchaseorder']['total_tax'];
        //     $model1->grand_total=(double) $result['Purchaseorder']['grand_total'];
        //     // var_dump($result);die;
        // endif;
    
         if ($model1->load(Yii::$app->request->post()) && $model1->save(false)) {
            $result=Yii::$app->request->post();
            $flag_qty=0;
            $count=0;
            for($i=0;$i<sizeof($result['Purchaseorderitems']['item_id']);$i++){
                $model2 = new Purchaseorderitems();
                $model2->item_id=$result['Purchaseorderitems']['item_id'][$i];
                $model2->quantity=$result['Purchaseorderitems']['quantity'][$i];
                $model2->pr_quantity=$result['Purchaseorderitems']['pr_quantity'][$i];
                $model2->remaining_quantity=$model2->pr_quantity-$model2->quantity;
                if($model2->remaining_quantity==0){
                    $flag_qty++;
                }
                $model2->price=$result['Purchaseorderitems']['price'][$i];
                $model2->unit_id=$result['Purchaseorderitems']['unit_id'][$i];
                $model2->total_price =$result['Purchaseorderitems']['total_price'][$i];
                $model2->dis_type =(isset($result['Purchaseorderitems']['dis_type'])?$result['Purchaseorderitems']['dis_type'][$i]:NULL);
                $model2->discount_percentage=(isset($result['Purchaseorderitems']['discount_percentage'])?$result['Purchaseorderitems']['discount_percentage'][$i]:NULL);
                $model2->discount_amount=(isset($result['Purchaseorderitems']['discount_amount'])?$result['Purchaseorderitems']['discount_amount'][$i]:NULL);
                $model2->net_amount=(isset($result['Purchaseorderitems']['net_amount'])?$result['Purchaseorderitems']['net_amount'][$i]:NULL);
                $model2->vat_rate=(isset($result['Purchaseorderitems']['vat_rate'])?$result['Purchaseorderitems']['vat_rate'][$i]:NULL);
                $model2->tax=(isset($result['Purchaseorderitems']['tax'])?$result['Purchaseorderitems']['tax'][$i]:NULL);
                $model2->total=$result['Purchaseorderitems']['total'][$i];
                $model2->po_id=$model1->id;
                $model2->save(false);
                $count++;
            }
            if($flag_qty==$count){
                $model->process_status='completed';
            }else{
                $model->process_status='processing';
            }
            $model->save(false);
            echo json_encode(["success" => true, "message" => "Purchase Order has been created."]);
            exit;
        }
        return $this->renderAjax('createpo', [
            'modelpr' => $modelpr,
            'model'=> $model,
            'modellastnumber'=>$modellastnumber,
            'model1'=> $model1,
            'type' => 'update',
        ]);
    }
    /**
     * Updates an existing Purchaseorder model.
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
            $flag_qty=0;
            $count=0;
             for($i=0;$i<sizeof($result['Purchaseorderitems']['item_id']);$i++){
                if(isset($result['Purchaseorderitems']['id'][$i])){
                    $model1 = Purchaseorderitems::find()->where(['id'=>$result['Purchaseorderitems']['id'][$i]])->one();
                }else{
                    $model1 = new Purchaseorderitems();
                }
                $model1->item_id=$result['Purchaseorderitems']['item_id'][$i];
                $model1->quantity=$result['Purchaseorderitems']['quantity'][$i];
                if($model->pr_id){
                    $model1->pr_quantity=(int) $result['Purchaseorderitems']['pr_quantity'][$i];
                    $model1->remaining_quantity=$model1->pr_quantity-$model1->quantity;
                    if($model1->remaining_quantity==0){
                        $flag_qty++;
                    }
                }
                $model1->price=$result['Purchaseorderitems']['price'][$i];
                $model1->unit_id=$result['Purchaseorderitems']['unit_id'][$i];
                $model1->tax=$result['Purchaseorderitems']['tax'][$i];
                $model1->total=$result['Purchaseorderitems']['total'][$i];
                $model1->po_id=$model->id;
                
                $model1->save(false);
                $count++;
            }
            if($flag_qty==$count){
                $model->process_status='completed';
            }else{
                $model->process_status='processing';
            }
            $model->save(false);
             echo json_encode(["success" => true, "message" => "Purchase Order has been updated."]);
            exit;
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'type'  =>'update',
        ]);
    }

    /**
     * Deletes an existing Purchaseorder model.
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
        $modelpr=Purchaserequest::find()->where(['id'=>(int) $pr_id])->one();
         return $this->renderAjax('create', [
            'modelpr' => $modelpr,
        ]);
    }

    public function actionChangeStatus($id){
        $model = $this->findModel($id);
        $model->status = ($model->status == 0)?1:0;
        if($model->save(false)){
            echo json_encode(["success" => true, "message" => "Status has been changed.",'redirect'=>Yii::$app->getUrlManager()->createUrl(['purchase-order/index'])]);
            exit;
        }
    }

    /**
     * Finds the Purchaseorder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Purchaseorder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Purchaseorder::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
