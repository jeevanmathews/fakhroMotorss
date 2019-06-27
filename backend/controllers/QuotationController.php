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

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        return $this->render('view', [
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
        $userId = \Yii::$app->user->identity->id;
        $model = new  Quotation();
        $model1 = new  QuotationItems();
        if(Yii::$app->request->post()):
            $result=Yii::$app->request->post();
        
            // var_dump($result);die;
        endif;
        // var_dump($result['Purchaserequest']);
        // var_dump(sizeof($result[' Quotation']['item_id']));die;
        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {

            for($i=0;$i<sizeof($result['QuotationItems']['item_id']);$i++){
                $model1 = new  QuotationItems();
                $model1->item_id=$result['QuotationItems']['item_id'][$i];
                $model1->quantity=$result['QuotationItems']['quantity'][$i];
                $model1->price=$result['QuotationItems']['price'][$i];
                $model1->unit_id=$result['QuotationItems']['unit_id'][$i];
                $model1->tax=$result['QuotationItems']['tax'][$i];
                $model1->total=$result['QuotationItems']['total'][$i];
                $model1->qtn_id=$model->id;
                
                $model1->save(false);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'type'  =>'create',
            'model1'=>$model1,
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
         if(Yii::$app->request->post()):
            $result=Yii::$app->request->post();
            // var_dump($result);die;
        endif;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
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
                $model1->tax=$result['QuotationItems']['tax'][$i];
                $model1->total=$result['QuotationItems']['total'][$i];
                $model1->qtn_id=$model->id;
                
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
        $model->save();
        return $this->redirect(['index']);
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
