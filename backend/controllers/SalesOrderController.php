<?php

namespace backend\controllers;

use Yii;
use backend\models\Quotation;
use backend\models\QuotationItems;
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

        return $this->renderAjax('index', [
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
        return $this->renderAjax('view', [
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
        $branch_id=Yii::$app->user->identity->branch_id;
        $modellastnumber = Quotation::find()->select('qtn_number')->where(['branch_id'=>$branch_id])->orderBy('id desc')->limit(1)->one();
        $model = new SalesOrder();
        $model1 = new SalesOrderItems();
        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
             $result=Yii::$app->request->post();
            for($i=0;$i<sizeof($result['SalesOrderItems']['item_id']);$i++){
                $model1 = new SalesOrderItems();
                $model1->item_id=$result['SalesOrderItems']['item_id'][$i];
                $model1->quantity=$result['SalesOrderItems']['quantity'][$i];
                $model1->price=$result['SalesOrderItems']['price'][$i];
                $model1->unit_id=$result['SalesOrderItems']['unit_id'][$i];
                $model1->total_price =$result['SalesOrderItems']['total_price'][$i];
                $model1->dis_type =(isset($result['SalesOrderItems']['dis_type'])?$result['SalesOrderItems']['dis_type'][$i]:NULL);
                $model1->discount_percentage=(isset($result['SalesOrderItems']['discount_percentage'])?$result['SalesOrderItems']['discount_percentage'][$i]:NULL);
                $model1->discount_amount=(isset($result['SalesOrderItems']['discount_amount'])?$result['SalesOrderItems']['discount_amount'][$i]:NULL);
                $model1->net_amount=(isset($result['SalesOrderItems']['net_amount'])?$result['SalesOrderItems']['net_amount'][$i]:NULL);
                $model1->vat_rate=(isset($result['SalesOrderItems']['vat_rate'])?$result['SalesOrderItems']['vat_rate'][$i]:NULL);
                $model1->tax=(isset($result['SalesOrderItems']['tax'])?$result['SalesOrderItems']['tax'][$i]:NULL);
                $model1->total=$result['SalesOrderItems']['total'][$i];
                $model1->so_id=$model->id;
                
                $model1->save(false);
            }
            echo json_encode(["success" => true, "message" => "Sales Order has been created", 'redirect' => Yii::$app->getUrlManager()->createUrl(['sales-order/update','id' => $model->id])]);
            exit;
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'model1' => $model1,
            'modellastnumber'=>$modellastnumber,
        ]);
    }
    public function actionCreateso($id){
        $model = Quotation::find()->where(['id'=>$id])->one();
        $model1 = new SalesOrder();
        $modelpr = new SalesOrderItems();
        $branch_id=Yii::$app->user->identity->branch_id;
        $modellastnumber = Quotation::find()->select('qtn_number')->where(['branch_id'=>$branch_id])->orderBy('id desc')->limit(1)->one();

         if ($model1->load(Yii::$app->request->post()) && $model1->save(false)) {
            $result=Yii::$app->request->post();
             $flag_qty=0;
            for($i=0;$i<sizeof($result['SalesOrderItems']['item_id']);$i++){
                $model2 = new SalesOrderItems();
                if($model2->remaining_quantity==0){
                    $flag_qty++;
                }
                $model2->item_id=$result['SalesOrderItems']['item_id'][$i];
                $model2->quantity=$result['SalesOrderItems']['quantity'][$i];
                $model2->qtn_quantity=$result['QuotationItems']['quantity'][$i];
                $model2->price=$result['SalesOrderItems']['price'][$i];
                $model2->unit_id=$result['SalesOrderItems']['unit_id'][$i];
                $model2->total_price =$result['SalesOrderItems']['total_price'][$i];
                $model2->dis_type =(isset($result['SalesOrderItems']['dis_type'])?$result['SalesOrderItems']['dis_type'][$i]:NULL);
                $model2->discount_percentage=(isset($result['SalesOrderItems']['discount_percentage'])?$result['SalesOrderItems']['discount_percentage'][$i]:NULL);
                $model2->discount_amount=(isset($result['SalesOrderItems']['discount_amount'])?$result['SalesOrderItems']['discount_amount'][$i]:NULL);
                $model2->net_amount=(isset($result['SalesOrderItems']['net_amount'])?$result['SalesOrderItems']['net_amount'][$i]:NULL);
                $model2->vat_rate=(isset($result['SalesOrderItems']['vat_rate'])?$result['SalesOrderItems']['vat_rate'][$i]:NULL);
                $model2->tax=(isset($result['SalesOrderItems']['tax'])?$result['SalesOrderItems']['tax'][$i]:NULL);
                $model2->total=$result['SalesOrderItems']['total'][$i];
                $model2->so_id=$model1->id;
                
                $model2->save(false);
            }
            if($flag_qty==$count){
                $model->process_status='completed';
            }else{
                $model->process_status='processing';
            }
            $model->save(false);
            echo json_encode(["success" => true, "message" => "Sales Order has been created", 'redirect' => Yii::$app->getUrlManager()->createUrl(['sales-order/update','id' => $model1->id])]);  
            exit;
        }
        return $this->renderAjax('createso', [
            'modelpr' => $modelpr,
            'model'=> $model,
            'model1'=> $model1,
            'modellastnumber'=>$modellastnumber,
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
            $flag_qty=0;
             $count=0;
             for($i=0;$i<sizeof($result['SalesOrderItems']['item_id']);$i++){
                if(isset($result['SalesOrderItems']['id'][$i])){
                    $model1 = SalesOrderItems::find()->where(['id'=>$result['SalesOrderItems']['id'][$i]])->one();
                }else{
                    $model1 = new SalesOrderItems();
                }
               
                
                $model1->item_id=$result['SalesOrderItems']['item_id'][$i];
                $model1->quantity=$result['SalesOrderItems']['quantity'][$i];
                if($model->qtn_id){
                    $model1->qtn_quantity=(int) $result['SalesOrderItems']['qtn_quantity'][$i];
                    $model1->remaining_quantity=$model1->qtn_quantity-$model1->quantity;
                    if($model1->remaining_quantity==0){
                        $flag_qty++;
                    }
                }
                $model1->price=$result['SalesOrderItems']['price'][$i];
                $model1->unit_id=$result['SalesOrderItems']['unit_id'][$i];
                $model1->total_price =$result['SalesOrderItems']['total_price'][$i];
                $model1->dis_type =(isset($result['SalesOrderItems']['dis_type'])?$result['SalesOrderItems']['dis_type'][$i]:NULL);
                $model1->discount_percentage=(isset($result['SalesOrderItems']['discount_percentage'])?$result['SalesOrderItems']['discount_percentage'][$i]:NULL);
                $model1->discount_amount=(isset($result['SalesOrderItems']['discount_amount'])?$result['SalesOrderItems']['discount_amount'][$i]:NULL);
                $model1->net_amount=(isset($result['SalesOrderItems']['net_amount'])?$result['SalesOrderItems']['net_amount'][$i]:NULL);
                $model1->vat_rate=(isset($result['SalesOrderItems']['vat_rate'])?$result['SalesOrderItems']['vat_rate'][$i]:NULL);
                $model1->tax=(isset($result['SalesOrderItems']['tax'])?$result['SalesOrderItems']['tax'][$i]:NULL);
                $model1->total=$result['SalesOrderItems']['total'][$i];
                $model1->so_id=$model->id;
                $model1->save(false);
                $count++;
            }
            if($flag_qty==$count){
                $model->process_status='completed';
            }else{
                $model->process_status='processing';
            }
            $model->save(false);
            echo json_encode(["success" => true, "message" => "Sales Order has been updated", 'redirect' => Yii::$app->getUrlManager()->createUrl(['sales-order/update','id' => $model1->id])]);  
            exit;
        }

        return $this->renderAjax('update', [
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


     public function actionChangeStatus($id){
        $model = $this->findModel($id);
        $model->status = ($model->status == 0)?1:0;
        if($model->save(false)){
            echo json_encode(["success" => true, "message" => "Status has been changed.",'redirect'=>Yii::$app->getUrlManager()->createUrl(['sales-order/index'])]);
            exit;
        }
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