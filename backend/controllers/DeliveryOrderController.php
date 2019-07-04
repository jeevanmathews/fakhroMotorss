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
        $page_id = "goods-receipt-note".time();
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
     * Displays a single DeliveryOrder model.
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
     * Creates a new DeliveryOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $userId = \Yii::$app->user->identity->id;

        $branch_id=Yii::$app->user->identity->branch_id;
        $modellastnumber = SalesOrder::find()->select('so_number')->where(['branch_id'=>$branch_id])->orderBy('id desc')->limit(1)->one();
        $model = new DeliveryOrder();
        $model1 = new DeliveryOrderItems();

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            $result=Yii::$app->request->post();
            for($i=0;$i<sizeof($result['DeliveryOrderItems']['item_id']);$i++){
                $model1 = new DeliveryOrderItems();
                
                $model1->item_id=$result['DeliveryOrderItems']['item_id'][$i];
                $model1->quantity=$result['DeliveryOrderItems']['quantity'][$i];
                $model1->price=$result['DeliveryOrderItems']['price'][$i];
                $model1->unit_id=$result['DeliveryOrderItems']['unit_id'][$i];
                $model1->total_price =$result['DeliveryOrderItems']['total_price'][$i];
                $model1->dis_type =(isset($result['DeliveryOrderItems']['dis_type'])?$result['DeliveryOrderItems']['dis_type'][$i]:NULL);
                $model1->discount_percentage=(isset($result['DeliveryOrderItems']['discount_percentage'])?$result['DeliveryOrderItems']['discount_percentage'][$i]:NULL);
                $model1->discount_amount=(isset($result['DeliveryOrderItems']['discount_amount'])?$result['DeliveryOrderItems']['discount_amount'][$i]:NULL);
                $model1->net_amount=(isset($result['DeliveryOrderItems']['net_amount'])?$result['DeliveryOrderItems']['net_amount'][$i]:NULL);
                $model1->vat_rate=(isset($result['DeliveryOrderItems']['vat_rate'])?$result['DeliveryOrderItems']['vat_rate'][$i]:NULL);
                $model1->tax=(isset($result['DeliveryOrderItems']['tax'])?$result['DeliveryOrderItems']['tax'][$i]:NULL);
                $model1->total=$result['DeliveryOrderItems']['total'][$i];

                $model1->do_id=$model->id;
                
                $model1->save(false);
            }
            echo json_encode(["success" => true, "message" => "Delivery Order has been created", 'redirect' => Yii::$app->getUrlManager()->createUrl(['delivery-order/update','id' => $model->id])]);
            exit;

        }

        return $this->renderAjax('create', [
            'model' => $model,
            'modellastnumber'=>$modellastnumber,
            'model1' => $model1,
            ]);
    }
    public function actionCreatedo($id){
        $model = SalesOrder::find()->where(['id'=>$id])->one();
        $model1 = new DeliveryOrder();
        $modelpr = new DeliveryOrderItems();
        $branch_id=Yii::$app->user->identity->branch_id;
        $modellastnumber = SalesOrder::find()->select('so_number')->where(['branch_id'=>$branch_id])->orderBy('id desc')->limit(1)->one();
        
        if ($model1->load(Yii::$app->request->post()) && $model1->save(false)) {
            $flag_qty=0;
            $count=0;
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


                $model2->item_id=$result['DeliveryOrderItems']['item_id'][$i];
                $model2->so_quantity=$result['DeliveryOrderItems']['so_quantity'][$i];
                $model2->quantity=$result['DeliveryOrderItems']['quantity'][$i];
                $model2->remaining_quantity=$model2->po_quantity-$model2->quantity;
                if($model2->remaining_quantity==0){
                    $flag_qty++;
                }
                $model2->price=$result['DeliveryOrderItems']['price'][$i];
                $model2->unit_id=$result['DeliveryOrderItems']['unit_id'][$i];
                $model2->total_price =$result['DeliveryOrderItems']['total_price'][$i];
                $model2->dis_type =(isset($result['DeliveryOrderItems']['dis_type'])?$result['DeliveryOrderItems']['dis_type'][$i]:NULL);
                $model2->discount_percentage=(isset($result['DeliveryOrderItems']['discount_percentage'])?$result['DeliveryOrderItems']['discount_percentage'][$i]:NULL);
                $model2->discount_amount=(isset($result['DeliveryOrderItems']['discount_amount'])?$result['DeliveryOrderItems']['discount_amount'][$i]:NULL);
                $model2->net_amount=(isset($result['DeliveryOrderItems']['net_amount'])?$result['DeliveryOrderItems']['net_amount'][$i]:NULL);
                $model2->vat_rate=(isset($result['DeliveryOrderItems']['vat_rate'])?$result['DeliveryOrderItems']['vat_rate'][$i]:NULL);
                $model2->tax=(isset($result['DeliveryOrderItems']['tax'])?$result['DeliveryOrderItems']['tax'][$i]:NULL);
                $model2->total=$result['DeliveryOrderItems']['total'][$i];
                $model2->do_id=$model1->id;
                
                $model2->save(false);
                $count++;
                
            }
            if($flag_qty==$count){
                $model->process_status='completed';
            }else{
                $model->process_status='processing';
            }
            $model->save(false);
            echo json_encode(["success" => true, "message" => "Delivery Order has been created."]);
            exit;
        }
        return $this->renderAjax('createdo', [
            'modelpr' => $modelpr,
            'model'=> $model,
            'model1'=> $model1,
            'modellastnumber'=>$modellastnumber,
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
        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            $flag_qty=0;
            $count=0; 
            for($i=0;$i<sizeof($result['DeliveryOrderItems']['item_id']);$i++){
                if(isset($result['DeliveryOrderItems']['id'][$i])){
                    $model1 = DeliveryOrderItems::find()->where(['id'=>$result['DeliveryOrderItems']['id'][$i]])->one();
                }else{
                    $model1 = new DeliveryOrderItems();
                }
                $model1->item_id=$result['DeliveryOrderItems']['item_id'][$i];
                $model1->quantity=$result['DeliveryOrderItems']['quantity'][$i];
                if($model->so_id){
                    $model1->so_quantity=(int) $result['DeliveryOrderItems']['so_quantity'][$i];
                    $model1->remaining_quantity=$model1->so_quantity-$model1->quantity;
                    if($model1->remaining_quantity==0){
                        $flag_qty++;
                    }
                }
                $model1->price=$result['DeliveryOrderItems']['price'][$i];
                $model1->unit_id=$result['DeliveryOrderItems']['unit_id'][$i];
                $model1->total_price =$result['DeliveryOrderItems']['total_price'][$i];
                $model1->dis_type =(isset($result['DeliveryOrderItems']['dis_type'])?$result['DeliveryOrderItems']['dis_type'][$i]:NULL);
                $model1->discount_percentage=(isset($result['DeliveryOrderItems']['discount_percentage'])?$result['DeliveryOrderItems']['discount_percentage'][$i]:NULL);
                $model1->discount_amount=(isset($result['DeliveryOrderItems']['discount_amount'])?$result['DeliveryOrderItems']['discount_amount'][$i]:NULL);
                $model1->net_amount=(isset($result['DeliveryOrderItems']['net_amount'])?$result['DeliveryOrderItems']['net_amount'][$i]:NULL);
                $model1->vat_rate=(isset($result['DeliveryOrderItems']['vat_rate'])?$result['DeliveryOrderItems']['vat_rate'][$i]:NULL);
                $model1->tax=(isset($result['DeliveryOrderItems']['tax'])?$result['DeliveryOrderItems']['tax'][$i]:NULL);
                $model1->total=$result['DeliveryOrderItems']['total'][$i];

                $model1->do_id=$model->id;
                
                $model1->save(false);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->renderAjax('update', [
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

    public function actionChangeStatus($id){
        $model = $this->findModel($id);
        $model->status = ($model->status == 0)?1:0;
        if($model->save(false)){
            echo json_encode(["success" => true, "message" => "Status has been changed.",'redirect'=>Yii::$app->getUrlManager()->createUrl(['delivery-order/index'])]);
            exit;
        }
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
