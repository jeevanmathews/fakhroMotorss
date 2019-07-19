<?php

namespace backend\controllers;

use Yii;
use backend\models\Items;
use backend\models\ItemsSearch;
use backend\models\Itemfeature;
use backend\models\StockHistory;
use backend\models\StockDistribution;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Variants;
use backend\models\Variantfeatures;
use backend\models\Itempricing;
use backend\models\Spareparts;
use backend\models\Accessories;



/**
 * ItemsController implements the CRUD actions for Items model.
 */
class ItemsController extends Controller
{
    /**
     * {@inheritdoc}
     */
	public function beforeAction($action)
    {       
        Yii::$app->common->checkPermission('ItemsController', Yii::$app->controller->action->id);
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
     * Lists all Items models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ItemsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

       $page_id = "items".time();
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
     * Displays a single Items model.
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
     * Creates a new Items model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $branch_id=Yii::$app->common->branchid->branch_id;
        $model = new Items();
        $modelprice=new Itempricing();
        // var_dump();die;
        // if(Yii::$app->request->post()):
        // $model->unit_id=(int) Yii::$app->request->post()['Items']['unit_id'];
        // $model->manufacturing_date=(string) Yii::$app->request->post()['Items']['manufacturing_date'];
        // // $modelprice->purchase_price=(int) Yii::$app->request->post()['Itempricing']['purchase_price'];
        // // $modelprice->selling_price=(int) Yii::$app->request->post()['Itempricing']['selling_price'];
        // $model->type=Yii::$app->request->post()['Items']['type'];
        // var_dump(Yii::$app->request->post()['Items']['type']);die;
        // endif;
        if ($model->load(Yii::$app->request->post()) ) {
            $result=Yii::$app->request->post();
            $model->itemgroup_id=end($result['parent_id']);
            if($model->save()){
           if ($modelprice->load(Yii::$app->request->post())){
                $modelprice->item_id=$model->id;
                $modelprice->type=$model->type;
                $modelprice->save(false);
            }
			if(isset(Yii::$app->request->post()['Itemfeature']))
			{
                $features=Yii::$app->request->post()['Itemfeature']['feature_id'];
                $valuesid=Yii::$app->request->post()['Itemfeature']['value_id'];
    			
                if($features){
                    // var_dump($features);die;
                    for ($i=0; $i <sizeof($features) ; $i++) { 
                        $model1 = new Itemfeature();
                        $model1->item_id=$model->id;
                        $model1->feature_id=$features[$i];
                        $model1->value_id=$valuesid[$i];
                        $model1->save();
                    }
                }
			}
            if($model->opening_stock!=""){
                $modelstocksave=new StockHistory();
                $modelstocksave->item_id=$model->id;
                $modelstocksave->code='stk'.$model->id.substr($model->item_name,0,3);
                $modelstocksave->opening_stock=$model->opening_stock;
                $modelstocksave->previous_stock=0;
                $modelstocksave->current_stock=$model->opening_stock;
                $modelstocksave->type=(string) Yii::$app->request->post()['Items']['type'];
                $modelstocksave->date=date('Y-m-d');
                $modelstocksave->branch_id=$branch_id;
                $modelstocksave->save(false);
                $modelitem=Items::findOne($model->id);
                $modelitem->current_stock=$modelstocksave->current_stock;
                $modelitem->save(false);

                $modelstockdistribution=new StockDistribution();
                $modelstockdistribution->stock_id=$modelstocksave->id;
                $modelstockdistribution->item_id=$model->id;
                $modelstockdistribution->opening_stock=$model->opening_stock;
                $modelstockdistribution->previous_stock=0;
                $modelstockdistribution->current_stock=$model->opening_stock;
                $modelstockdistribution->code='stk'.$model->id.substr($model->item_name,0,3);
                $modelstockdistribution->save(false);


            }
             // Yii::$app->session->setFlash('success', 'Item has been added successfully.'); 
             echo json_encode(["success" => true, "message" => "Item has been created", 'redirect' => Yii::$app->getUrlManager()->createUrl(['items/update','id' => $model->id])]);
            exit;
        }
    }

        return $this->renderAjax('create', [
            'model' => $model,
            'modelprice'=>$modelprice,
        ]);
    }

    /**
     * Updates an existing Items model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $branch_id=Yii::$app->common->branchid->branch_id;
        $model = $this->findModel($id);
        $modelprice=Itempricing::find()->where(['item_id'=>$id])->one();
        $itemgroup_id=$model->itemgroup_id;
        if ($model->load(Yii::$app->request->post())) {
            $result=Yii::$app->request->post();
            if(isset($result['parent_id']) && !empty(array_filter($result['parent_id']))):
                $model->itemgroup_id=end($result['parent_id']);
            else:
                $model->itemgroup_id=$itemgroup_id;
            endif;
            $model->save();
			 if ($modelprice->load(Yii::$app->request->post())) {
            $modelprice->type=Yii::$app->request->post()['Items']['type'];
			//var_dump($modelprice);
			//die;
            $modelprice->save(false);
			 }
            if(isset(Yii::$app->request->post()['Itemfeature']))
            {
            $features=Yii::$app->request->post()['Itemfeature']['feature_id'];
            $valuesid=Yii::$app->request->post()['Itemfeature']['value_id'];
            if($features){
                // var_dump($features);die;
                for ($i=0; $i <sizeof($features) ; $i++) { 
                    $model1=Itemfeature::find()->where(['item_id'=>$model->id,'feature_id'=>$features[$i]])->one();
                    // var_dump($model1);die;
                    // $model1->item_id=$model->id;
                    // $model1->feature_id=$features[$i];
                    $model1->value_id=$valuesid[$i];
                    $model1->save();
                }
            }
        }
          if($model->opening_stock!=""){
                $modelstocksave=new StockHistory();
                $modelstocksave->item_id=$model->id;
                $modelstocksave->code='stk'.$model->id.substr($model->item_name,0,3);
                $modelstocksave->opening_stock=$model->opening_stock;
                $modelstocksave->previous_stock=0;
                $modelstocksave->current_stock=$model->opening_stock;
                $modelstocksave->type=(string) Yii::$app->request->post()['Items']['type'];
                $modelstocksave->date=date('Y-m-d');
                $modelstocksave->branch_id=$branch_id;
                $modelstocksave->save(false);
                $modelitem=Items::findOne($model->id);
                $modelitem->current_stock=$modelstocksave->current_stock;
                $modelitem->save(false);

                $modelstockdistribution=new StockDistribution();
                $modelstockdistribution->stock_id=$modelstocksave->id;
                $modelstockdistribution->item_id=$model->id;
                $modelstockdistribution->opening_stock=$model->opening_stock;
                $modelstockdistribution->previous_stock=0;
                $modelstockdistribution->current_stock=$model->opening_stock;
                $modelstockdistribution->code='stk'.$model->id.substr($model->item_name,0,3);
                $modelstockdistribution->save(false);


            }
           
           echo json_encode(["success" => true, "message" => "Item has been updated."]);
            exit;
        }

        $results= Variantfeatures::find()->where(['variant_id' => (int)$model->variant_id])->joinWith(['feature'])->asArray()->all();
        $typesarray=array();
        $types=array();
        if($results){
            foreach ($results as $res) {          
                if(!in_array($res['feature_id'], $typesarray)):
                    $typesarray[]=$res['feature_id'];
                    $types[$res['feature_id']]['type']=$res['feature']['name'];
                    $types[$res['feature_id']]['values'][]=array('value_id'=>$res['id'],'value'=>$res['value']);
                else :
                     $types[$res['feature_id']]['values'][]=array('value_id'=>$res['id'],'value'=>$res['value']);
                endif;
            }

        }
        // $model->types=$types;
        // var_dump($model);die;
        return $this->renderAjax('update', [
            'model' => $model,
            'types' => $types,
            'modelprice'=>$modelprice,
        ]);
    }
    public function actionAccessories($type="accessories",$parent_id) 
     {
        return $this->renderPartial('_itemdropdown',compact('parent_id','type')); 
     }
      public function actionSpares($type="spares",$parent_id) 
     {
        return $this->renderPartial('_itemdropdown',compact('parent_id','type')); 
     }
    /**
     * Deletes an existing Items model.
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
    public function actionVariantsbymodel(){
        $model=Yii::$app->request->post('model_id');
        $results= Variants::find()->select(['id','name'])->where(['model_id' => (int)$model])->asArray()->all();
        return json_encode($results);        
        // var_dump($results); // // ->select('items')
                 // ->where(['model_id' => (int)$model])
                 // ->asArray()
                 // ->all();
    }
	
    public function actionFeaturesbyvariant(){
        $variant=Yii::$app->request->post('variant_id');
        $results= Variantfeatures::find()->where(['variant_id' => (int)$variant])->joinWith(['feature'])->asArray()->all();
        $typesarray=array();
        if($results){
            foreach ($results as $res) {
                // var_dump($res['feature']['name']);die;           
                if(!in_array($res['feature_id'], $typesarray)):
                    // $types[$res['feature_id']]['type']=$res['feature']['name'];
                    $typesarray[]=$res['feature_id'];
                    $types[$res['feature_id']]['type']=$res['feature']['name'];
                    // $types[$res['feature_id']]=$res['feature']['name'];
                    // $types[$res['feature_id']]=$res['feature']['name'];
                    $types[$res['feature_id']]['values'][]=array('value_id'=>$res['id'],'value'=>$res['value']);
                    // var_dump($res['value']);
                // $types['feature_id'][]=$res['feature_id'];
                // $types['feature_id']['name'][]=$res['feature']['name'];
                // $types['feature'][]=$res['feature']['name'];
                else :
                     $types[$res['feature_id']]['values'][]=array('value_id'=>$res['id'],'value'=>$res['value']);
                endif;
                // $types[$res['feature_id']][]=$res['value'];
                // $types['feature_id']['values'][]=$res['value'];
                // $types[$res['feature_id']]['values'][]=array($res['id']=>$res['value']);
                // $types[$res['feature_id']]['feature_id'][]=$res['id'];
            }
        }
        // var_dump($types);
        return json_encode($types);
        // return json_encode($results->feature);        
        // var_dump($results); // // ->select('items')
                 // ->where(['model_id' => (int)$model])
                 // ->asArray()
                 // ->all();
    }
    public function actionItemprice(){
        $id=Yii::$app->request->post('item_id');
        $model = $this->findModel($id);
        $data['item_id']=$id;
        $data['selling_price']=$model->pricing->selling_price;
        $data['vat']=$model->vat;
        $data['unit_id']=$model->unit_id;
        // $data['vat']
        // var_dump($model->pricing);die;
        return json_encode($data);
    }
    /**
     * Finds the Items model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Items the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Items::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
