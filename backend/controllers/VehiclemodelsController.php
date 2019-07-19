<?php

namespace backend\controllers;

use Yii;
use backend\models\Vehiclemodels;
use backend\models\Variants;
use backend\models\Customfeatures;
use backend\models\Variantfeatures;
use backend\models\Vehicletype;
use backend\models\Manufacturer;
use backend\models\VehiclemodelsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
/**
 * VehiclemodelsController implements the CRUD actions for Vehiclemodels model.
 */
class VehiclemodelsController extends Controller
{
    /**
     * {@inheritdoc}
     */
	public function beforeAction($action)
    {       
        Yii::$app->common->checkPermission('VehiclemodelsController', Yii::$app->controller->action->id);
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
     * Lists all Vehiclemodels models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VehiclemodelsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $page_id = "vehiclemodels".time();
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
     * Displays a single Vehiclemodels model.
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
     * Creates a new Vehiclemodels model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Vehiclemodels();
        $model2 = new Variants();
        $model3 = new Customfeatures();
        $manufacturer = ArrayHelper::map(Manufacturer::find()->all(), 'id', 'name');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            echo json_encode(["success" => true, "message" => "Vehiclemodel has been created", 'redirect' => Yii::$app->getUrlManager()->createUrl(['vehiclemodels/update','id' => $model->id])]);
            exit;
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'model2'=> $model2,
            'model3'=> $model3,                    
            'manufacturer'=>$manufacturer,
        ]);
    }
    public function actionVariant($id){       
        
        $model = $this->findModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => Variants::find()               
        ]);    
        $dataProvider->query->andWhere(['model_id'=>$id]);   
        
        $model2 = new Variants();
        $model3 = new Customfeatures();
        $model4 = new Variantfeatures();
      
        if ($model2->load(Yii::$app->request->post()) && $model2->save()) { 
            $post = Yii::$app->request->post();
            $loop = 1; 
            $features = array_values(array_filter($post['Customfeatures']['name']));
            
            foreach($features as $feature){ 
                $cus_feature = Customfeatures::findOne(trim($feature));                
                if($cus_feature)
                    $feature_id = $cus_feature->id;             
                else {
                    $cus_feature = Customfeatures::find()->where(["name" => ucfirst(trim($feature))])->one(); 
                    if($cus_feature){
                        $feature_id = $cus_feature->id;
                    }else{
                        $cus_feature = new Customfeatures;
                        $cus_feature->name = ucfirst($feature);
                        $cus_feature->save(false);
                        $feature_id = $cus_feature->id;
                    }
                }
                //Save Value for feature                
                if(isset($post['Customfeatures']['value'.$loop])){
                    $values = $post['Customfeatures']['value'.$loop];
                    foreach ($values as $value) {
                        $variant_feature = new Variantfeatures();
                        $variant_feature->variant_id = $model2->id;
                        $variant_feature->feature_id = $feature_id;
                        $variant_feature->value = $value;
                        $variant_feature->save(false);
                    }    
                }
                $loop++;
            }            
            $model2 = new Variants();
            echo json_encode(["success" => true, "message" => "Variant has been created."]);
            exit;
        }              
        return $this->renderAjax('variants', [
            'model'         =>  $model,
            'dataProvider'  =>  $dataProvider,
            'model2'        =>  $model2,
            'model3'        =>  $model3,
            'model4'        =>  $model4
        ]);
    }
    /**
     * Updates an existing Vehiclemodels model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {   
        $model = $this->findModel($id);
        $types= ArrayHelper::map(Vehicletype::find()->all(), 'id', 'name');
        $manufacturer = ArrayHelper::map(Manufacturer::find()->all(), 'id', 'name');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
           echo json_encode(["success" => true, "message" => "Vehicle has been updated."]);
            exit;
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'types'=>$types,
            'manufacturer'=>$manufacturer,
        ]);
    }
    public function actionVariantfeatures($id){
     
        $model = $this->findVariantsModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => Variantfeatures::find()                
        ]);
           $dataProvider->query->andWhere(['variant_id'=>$model->id]);
           // var_dump($dataProvider->getModels());die;
         return $this->renderAjax('features', [
            'dataProvider' => $dataProvider,
            'model'=>$model,
            'check'=>array(),
            // 'manufacturer'=>$manufacturer,
        ]);
    }

    public function actionUpdateVariant($id){
        $model = Variants::findOne($id);
        $custumFeature = new Customfeatures();
        $variantFeature = new Variantfeatures();  

        if ($model->load(Yii::$app->request->post()) & $model->save()) { 
            $post = Yii::$app->request->post();
            $loop = 1; 
            $features = array_values(array_filter($post['Customfeatures']['name']));
            $variantFeatures = [];
            foreach($features as $feature){ 
                $cus_feature = Customfeatures::findOne(trim($feature));                
                if($cus_feature)
                    $feature_id = $cus_feature->id;             
                else {
                    $cus_feature = Customfeatures::find()->where(["name" => ucfirst(trim($feature))])->one(); 
                    if($cus_feature){
                        $feature_id = $cus_feature->id;
                    }else{
                        $cus_feature = new Customfeatures;
                        $cus_feature->name = ucfirst($feature);
                        $cus_feature->save(false);
                        $feature_id = $cus_feature->id;
                    }
                }
                //Save Value for feature                
                if(isset($post['Variantfeatures']['value'.$loop])){
                    $values = $post['Variantfeatures']['value'.$loop];
                    foreach ($values as $value) {
                        $variantfeature = Variantfeatures::find()->where(["variant_id" => $model->id, "feature_id" => $feature_id, "value" => $value])->one();  
                        if($variantfeature){
                            $variantFeatures[] = $variantfeature->id; 
                        }else{
                            $variant_feature = new Variantfeatures();
                            $variant_feature->variant_id = $model->id;
                            $variant_feature->feature_id = $feature_id;
                            $variant_feature->value = $value;
                            $variant_feature->save(false);
                            $variantFeatures[] = $variant_feature->id;
                        }                       
                    }    
                }
                $loop++;
            }
            if(count($variantFeatures)){
                // Delete Unwanted features.
                Yii::$app->db->createCommand("DELETE FROM `variant_features` WHERE `id` not in (".implode(",", $variantFeatures).") and variant_id = ".$model->id)->execute();
            } 
        }
        return $this->renderAjax('updateVariant', [          
            'model' => $model,
            'features' => $model->variantfeaturesArray(), 
            'custumFeature' => $custumFeature,
            'variantFeature' => $variantFeature         
        ]);
    }

    /**
     * Change status of model.
     * If it is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionChangeFeatureStatus($id){
        $model =$this->findVariantfeaturesModel($id);
        $model->status = ($model->status == 0)?1:0;
        $model->save();
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    /**
     * Change status of model.
     * If it is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */

    public function actionChangeStatus($id){
        $model = $this->findModel($id);
        $model->status = ($model->status == 0)?1:0;
        if($model->save()){
            echo json_encode(["success" => true, "message" => "Vehiclemodels status has been changed", 'redirect' => Yii::$app->getUrlManager()->createUrl(['vehiclemodels/index'])]);
         exit;
     }
    }
    /**
     * Deletes an existing Vehiclemodels model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionEditfeature($id){
        $model = $this->findVariantfeaturesModel($id);
       
        $features = ArrayHelper::map(Customfeatures::find()->all(), 'id', 'type');
        // var_dump($model->varient[0]->model_id);die;
        if(Yii::$app->request->post()){ 
            // var_dump(Yii::$app->request->post());die;
            $model1= Customfeatures::findOne($id);
            if ($model1->load(Yii::$app->request->post()) && $model1->save()) {
               echo json_encode(["success" => true, "message" => "Feature has been changed."]);
            exit;
            }
        }
        return $this->renderAjax('update_features', [
        'model' => $model,
        'features'=>$features,
        ]);
    }

    public function actionAddfeatures($id){
        // $prev= Customfeatures::find()->where(['type' => 'Colour' ,'value'=>'Red'])->one();
        var_dump(Yii::$app->request->post());die;
        $vehicle = $this->findVariantsModel($id);
        $model = new Customfeatures();
        $features = ArrayHelper::map(Customfeatures::find()->all(), 'id', 'type');
        // $model2 = new Variants();
        // $model3 = new Customfeatures();
        // $model4 = new Variantfeatures();
        // var_dump(Yii::$app->request->post());die;
        if (Yii::$app->request->post()) {
            $variant_id=$id;
            $typessize=sizeof(Yii::$app->request->post()['Customfeatures']['type']);
            $types=Yii::$app->request->post()['Customfeatures']['type'];
           
            $data=Yii::$app->request->post();
            for($i=1;$i<=$typessize;$i++){
                if($types[$i-1]!=''){ 
                    $multiple= $data['Customfeatures']['multiple'.$i];
                    $value= $data['Customfeatures']['value'.$i];
                    // var_dump($sizeof($value));die;
                    // if($multiple=='yes'){
                        for ($j=0; $j < sizeof($value) ; $j++) {
                        if(is_nan($types[$i-1])){ 
                            if(!Customfeatures::find()->where(['type' => $types[$i-1] ,'value'=>$value[$j]])->exists()){ 
                                $model3 = new Customfeatures();
                                $model3->type=$types[$i-1];
                                $model3->multiple=$multiple;
                                $model3->value=$value[$j];
                                $model3->save();
                                $feature_id=Yii::$app->db->getLastInsertID();
                            }else{
                                $prev= Customfeatures::find()->where(['type' => $types[$i-1] ,'value'=>$value[$j]])->one();
                                $feature_id=$prev->id;
                            }
                        }else{
                            $prev= Customfeatures::findOne($types[$i-1]);
                            $feature_id=$prev->id;
                        }
                            $model4 = new Variantfeatures();
                            
                            $model4->variant_id=(int) $variant_id;
                            $model4->feature_id=(int) $feature_id;
                            $model4->save();
                        }
                    // }else{

                    // }
                }
            }
            // return $this->redirect(['variant', 'id' => $model->id]);
        }



         return $this->renderAjax('addfeatures', [
        'model' => $model,
        'vehicle'=>$vehicle,
        'features'=>$features,
        ]);
    }
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Vehiclemodels model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Vehiclemodels the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Vehiclemodels::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
     protected function findVariantsModel($id)
    {
        if (($model = Variants::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
     protected function findVariantfeaturesModel($id)
    {
        if (($model = Variantfeatures::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
