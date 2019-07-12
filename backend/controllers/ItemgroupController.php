<?php

namespace backend\controllers;

use Yii;
use backend\models\itemgroup;
use backend\models\ItemgroupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ItemgroupController implements the CRUD actions for itemgroup model.
 */
class ItemgroupController extends Controller
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
     * Lists all itemgroup models.
     * @return mixed
     */
    public function actionIndex($type="accessories")
    {
         $itemgroup = Yii::$app->db->createCommand("select id, parent_id as parent,category_name from itemgroup where type='$type'")->queryAll();
        return $this->renderAjax('index', [
            'itemgroup' => $itemgroup,
            'type' =>$type,
        ]);
    }

    /**
     * Displays a single itemgroup model.
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
     * Creates a new itemgroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($type)
    {
        $model = new itemgroup();
	
        if ($model->load(Yii::$app->request->post())) {
		$Array = Yii::$app->request->post();
		if(isset($Array['parent_id']))
		{
		$res   = end($Array['parent_id']);	
		}
		else{
			$res='add_new';
		}
		
		if($res=='add_new')
		{
			$res =0;
		}
        else
		{
		$res=end($Array['parent_id']);
		}
        $model->parent_id     = $res;
		
		if(isset($Array['default_value']))
		{
	     $model->category_name = $Array['default_value'];	

		}
		else
		{
		  $model->category_name =	$Array['category_name'];	
			
		}
		if($model->save())
        {
		echo json_encode(["success" => true, "message" => "Itemgroup has been created."]);
        exit;
		}
		else
		{
		print_r($model->getErrors());
		}
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'type'=>$type,
        ]);
    }

    /**
     * Updates an existing itemgroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id,$type)
    {
		$model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post())) {
		$Array = Yii::$app->request->post();
		$res   = end($Array['parent_id']);	
		if($res=='add_new')
		{
			$res =0;
		}
        else
		{
		$res=end($Array['parent_id']);
		}
        $model->parent_id     = $res;
		
		if(isset($Array['default_value']))
		{
	     $model->category_name = $Array['default_value'];	

		}
		else
		{
		  $model->category_name =	$Array['category_name'];	
			
		}
		if($model->save())
        {
		echo json_encode(["success" => true, "message" => "Itemgroup has been updated."]);
        exit;
		}
		else
		{
		print_r($model->getErrors());
		}
        }

        return $this->render('update', [
            'model' => $model,
            'type' =>$type,
        ]);
    }
	/*public function actionAccessories()
	{
	    $type=Yii::$app->request->post('type');
		//$results= Itemgroup::find()->select(['id','name'])->asArray()->all();
		//echo $results->createCommand()->getRawSql();
		$results=ArrayHelper::map(Itemgroup::find()->where(['type'=>$type,'parent_id'=>0])->all(), 'id', 'category_name');
		echo $results->createCommand()->getRawSql();
		return json_encode($results); 
	}*/

    /**
     * Deletes an existing itemgroup model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
	 public function actionLists($type="",$parent_id) 
	 {
		

		return $this->renderPartial('_itemdropdown',compact('parent_id','type')); 
	 }
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->renderAjax(['index']);
    }

    /**
     * Finds the itemgroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return itemgroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = itemgroup::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
