<?php

namespace backend\controllers;

use Yii;
use backend\models\Purchaserequest;
use backend\models\PurchaserequestSearch;
use backend\models\Purchaserequestitems;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PurchaserequestController implements the CRUD actions for Purchaserequest model.
 */
class PurchaseRequestController extends Controller
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
     * Lists all Purchaserequest models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new PurchaserequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderAjax('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Purchaserequest model.
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
     * Creates a new Purchaserequest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {   
        $branch_id=Yii::$app->user->identity->branch_id;
        $modellastnumber = Purchaserequest::find()->select('pr_number')->where(['branch_id'=>$branch_id])->orderBy('id desc')->limit(1)->one();
        $userId = \Yii::$app->user->identity->id;
        $model = new Purchaserequest();
        $model1 = new Purchaserequestitems();

        // if(Yii::$app->request->post()):
        //     $result=Yii::$app->request->post();
        //     $model->subtotal=(double) $result['Purchaserequest']['subtotal'];
        //     $model->discount=(double) $result['Purchaserequest']['discount'];
        //     $model->discount_percent=(double) $result['Purchaserequest']['discount_percent'];
        //     $model->vat_percent=(double) $result['Purchaserequest']['vat_percent'];
        //     $model->total_tax=(double) $result['Purchaserequest']['total_tax'];
        //     $model->grand_total=(double) $result['Purchaserequest']['grand_total'];
        //     // var_dump($result);die;
        // endif;
        // var_dump($result['Purchaserequest']);
        // var_dump(sizeof($result['Purchaserequestitems']['item_id']));die;
        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            $result=Yii::$app->request->post();
            for($i=0;$i<sizeof($result['Purchaserequestitems']['item_id']);$i++){
                $model1 = new Purchaserequestitems();
                $model1->item_id=$result['Purchaserequestitems']['item_id'][$i];
                $model1->quantity=$result['Purchaserequestitems']['quantity'][$i];
                $model1->price=$result['Purchaserequestitems']['price'][$i];
                $model1->unit_id=$result['Purchaserequestitems']['unit_id'][$i];
                $model1->total_price =$result['Purchaserequestitems']['total_price'][$i];
                $model1->dis_type =(isset($result['Purchaserequestitems']['dis_type'])?$result['Purchaserequestitems']['dis_type'][$i]:NULL);
                $model1->discount_percentage=(isset($result['Purchaserequestitems']['discount_percentage'])?$result['Purchaserequestitems']['discount_percentage'][$i]:NULL);
                $model1->discount_amount=(isset($result['Purchaserequestitems']['discount_amount'])?$result['Purchaserequestitems']['discount_amount'][$i]:NULL);
                $model1->net_amount=(isset($result['Purchaserequestitems']['net_amount'])?$result['Purchaserequestitems']['net_amount'][$i]:NULL);
                $model1->vat_rate=(isset($result['Purchaserequestitems']['vat_rate'])?$result['Purchaserequestitems']['vat_rate'][$i]:NULL);
                $model1->tax=(isset($result['Purchaserequestitems']['tax'])?$result['Purchaserequestitems']['tax'][$i]:NULL);
                $model1->total=$result['Purchaserequestitems']['total'][$i];
                $model1->pr_id=$model->id;
                
                $model1->save(false);
            }
            echo json_encode(["success" => true, "message" => "Purchase Requisition has been created."]);
            exit;
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'modellastnumber'=> $modellastnumber,
            'type'  =>'create',
            'model1'=>$model1,
        ]);
    }

    /**
     * Updates an existing Purchaserequest model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

            $model = $this->findModel($id);
        //  if(Yii::$app->request->post()):
        //     $result=Yii::$app->request->post();
        //     // var_dump($result);die;
        //     $model->subtotal=(double) $result['Purchaserequest']['subtotal'];
        //     $model->discount=(double) $result['Purchaserequest']['discount'];
        //     $model->discount_percent=(double) $result['Purchaserequest']['discount_percent'];
        //     $model->vat_percent=(double) $result['Purchaserequest']['vat_percent'];
        //     $model->total_tax=(double) $result['Purchaserequest']['total_tax'];
        //     $model->grand_total=(double) $result['Purchaserequest']['grand_total'];
        // endif;
            
        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            $result=Yii::$app->request->post();
             for($i=0;$i<sizeof($result['Purchaserequestitems']['item_id']);$i++){
                if(isset($result['Purchaserequestitems']['id'][$i])){
                    $model1 = Purchaserequestitems::find()->where(['id'=>$result['Purchaserequestitems']['id'][$i]])->one();
                }else{
                    $model1 = new Purchaserequestitems();
                }
                $model1->item_id=$result['Purchaserequestitems']['item_id'][$i];
                $model1->quantity=$result['Purchaserequestitems']['quantity'][$i];
                $model1->price=$result['Purchaserequestitems']['price'][$i];
                $model1->unit_id=$result['Purchaserequestitems']['unit_id'][$i];
                $model1->total_price =$result['Purchaserequestitems']['total_price'][$i];
                $model1->dis_type =(isset($result['Purchaserequestitems']['dis_type'])?$result['Purchaserequestitems']['dis_type'][$i]:NULL);
                $model1->discount_percentage=(isset($result['Purchaserequestitems']['discount_percentage'])?$result['Purchaserequestitems']['discount_percentage'][$i]:NULL);
                $model1->discount_amount=(isset($result['Purchaserequestitems']['discount_amount'])?$result['Purchaserequestitems']['discount_amount'][$i]:NULL);
                $model1->net_amount=(isset($result['Purchaserequestitems']['net_amount'])?$result['Purchaserequestitems']['net_amount'][$i]:NULL);
                $model1->vat_rate=(isset($result['Purchaserequestitems']['vat_rate'])?$result['Purchaserequestitems']['vat_rate'][$i]:NULL);
                $model1->tax=(isset($result['Purchaserequestitems']['tax'])?$result['Purchaserequestitems']['tax'][$i]:NULL);
                $model1->total=$result['Purchaserequestitems']['total'][$i];
                $model1->pr_id=$model->id;
                
                $model1->save(false);
            }
                echo json_encode(["success" => true, "message" => "Purchase Requisition has been updated."]);
                exit;
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'type'  =>'update',
        ]);
    }

    /**
     * Deletes an existing Purchaserequest model.
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
        $model->save();
        echo json_encode(["success" => true, "message" => "Purchase Requisition Status has been created."]);
        exit;
    }

    /**
     * Finds the Purchaserequest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Purchaserequest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Purchaserequest::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
