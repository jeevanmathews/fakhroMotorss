<?php

namespace backend\controllers;

use Yii;
use backend\models\Quotation;
use backend\models\QuotationSearch;
use yii\web\Controller;
use backend\models\QuotationItems;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * QuotationController implements the CRUD actions for Quotation model.
 */
class QuotationController extends Controller
{
    /**
     * {@inheritdoc}
     */

    public function beforeAction($action)
    {       
        Yii::$app->common->checkPermission('QuotationController', Yii::$app->controller->action->id);
        return parent::beforeAction($action);  
    } 
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
     * Lists all Quotation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new QuotationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $page_id = "quotation".time();
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
     * Displays a single Quotation model.
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
     * Creates a new Quotation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
	 public function actionCreate()
    {
        $branch_id=Yii::$app->user->identity->branch_id;
        $userId = \Yii::$app->user->identity->id;
        $modellastnumber = Quotation::find()->select('qtn_number')->where(['branch_id'=>$branch_id])->orderBy('id desc')->limit(1)->one();
        
        $model = new  Quotation();
        $model1 = new  QuotationItems();
        // if(Yii::$app->request->post()):
        //     $result=Yii::$app->request->post();
        //     var_dump($result);die;
        // endif;
        // var_dump($result['Purchaserequest']);
        // var_dump(sizeof($result[' Quotation']['item_id']));die;
        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
             $result=Yii::$app->request->post();
            for($i=0;$i<sizeof($result['QuotationItems']['item_id']);$i++){
                $model1 = new  QuotationItems();
                $model1->item_id=$result['QuotationItems']['item_id'][$i];
                $model1->quantity=$result['QuotationItems']['quantity'][$i];
                $model1->price=$result['QuotationItems']['price'][$i];
                $model1->unit_id=$result['QuotationItems']['unit_id'][$i];
                $model1->total_price =$result['QuotationItems']['total_price'][$i];
                $model1->dis_type =(isset($result['QuotationItems']['dis_type'])?$result['QuotationItems']['dis_type'][$i]:NULL);
                $model1->discount_percentage=(isset($result['QuotationItems']['discount_percentage'])?$result['QuotationItems']['discount_percentage'][$i]:NULL);
                $model1->discount_amount=(isset($result['QuotationItems']['discount_amount'])?$result['QuotationItems']['discount_amount'][$i]:NULL);
                $model1->net_amount=(isset($result['QuotationItems']['net_amount'])?$result['QuotationItems']['net_amount'][$i]:NULL);
                $model1->vat_rate=(isset($result['QuotationItems']['vat_rate'])?$result['QuotationItems']['vat_rate'][$i]:NULL);
                $model1->tax=(isset($result['QuotationItems']['tax'])?$result['QuotationItems']['tax'][$i]:NULL);
                $model1->total=$result['QuotationItems']['total'][$i];
                $model1->qtn_id=$model->id;
                
                $model1->save(false);
            }
            echo json_encode(["success" => true, "message" => "Quotation has been created", 'redirect' => Yii::$app->getUrlManager()->createUrl(['quotation/update','id' => $model->id])]);
            exit;
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'model1'=>$model1,
            'modellastnumber'=>$modellastnumber,
        ]);
    }

    /**
     * Updates an existing Quotation model.
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
             for($i=0;$i<sizeof($result['QuotationItems']['item_id']);$i++){
                if(isset($result['QuotationItems']['id'][$i])){
                    $model1 =  QuotationItems::find()->where(['id'=>$result['QuotationItems']['id'][$i]])->one();
                }else{
                    $model1 = new  QuotationItems();
                }
                $model1->item_id=$result['QuotationItems']['item_id'][$i];
                $model1->quantity=$result['QuotationItems']['quantity'][$i];
                $model1->price=$result['QuotationItems']['price'][$i];
                $model1->unit_id=$result['QuotationItems']['unit_id'][$i];
                $model1->total_price =$result['QuotationItems']['total_price'][$i];
                $model1->dis_type =(isset($result['QuotationItems']['dis_type'])?$result['QuotationItems']['dis_type'][$i]:NULL);
                $model1->discount_percentage=(isset($result['QuotationItems']['discount_percentage'])?$result['QuotationItems']['discount_percentage'][$i]:NULL);
                $model1->discount_amount=(isset($result['QuotationItems']['discount_amount'])?$result['QuotationItems']['discount_amount'][$i]:NULL);
                $model1->net_amount=(isset($result['QuotationItems']['net_amount'])?$result['QuotationItems']['net_amount'][$i]:NULL);
                $model1->vat_rate=(isset($result['QuotationItems']['vat_rate'])?$result['QuotationItems']['vat_rate'][$i]:NULL);
                $model1->tax=(isset($result['QuotationItems']['tax'])?$result['QuotationItems']['tax'][$i]:NULL);
                $model1->total=$result['QuotationItems']['total'][$i];

                $model1->qtn_id=$model->id;
                
                $model1->save(false);
            }
             echo json_encode(["success" => true, "message" => "Quotation has been updated", 'redirect' => Yii::$app->getUrlManager()->createUrl(['quotation/update','id' => $model->id])]);
            exit;
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing Quotation model.
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
            echo json_encode(["success" => true, "message" => "Status has been changed.",'redirect'=>Yii::$app->getUrlManager()->createUrl(['purchase-request/index'])]);
            exit;
        }
    }
    /**
     * Finds the Quotation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Quotation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Quotation::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
