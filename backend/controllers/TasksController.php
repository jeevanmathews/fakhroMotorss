<?php

namespace backend\controllers;

use Yii;
use backend\models\Tasks;
use backend\models\TasksSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TasksController implements the CRUD actions for Tasks model.
 */
class TasksController extends Controller
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
     * Lists all Tasks models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TasksSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['type'=>'service']);
        return $this->renderAjax('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionService()
    {
        $searchModel = new TasksSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tasks model.
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
     * Creates a new Tasks model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($jobcard_id="")
    {       
        $model = new Tasks();
	    if ($model->load(Yii::$app->request->post())) {
          
		$res = Yii::$app->request->post();
		$day_in_min = (intval($res['days'])*1440);
		$hour_in_min =(intval($res['hours'])*60);
		$min = (intval($res['minutes']));	
		
		$total_min = $day_in_min+$hour_in_min+$min;
		$model->total_time = $total_min; 
			if($model->save())
            {
                if(isset($res['jobcard_id'])){
                    if($task_id = $model->assignTask($res['jobcard_id'])){
                        echo json_encode(["success" => true, "message" => "Task has been created", 'redirect' => Yii::$app->getUrlManager()->createUrl(['jobcard/update', 'id' => $res['jobcard_id'], 'taskId' => $task_id])]);exit;
                        exit;
                    }  
                }else{
                    echo json_encode(["success" => true, "message" => "Task has been created"]);
                    exit;
                }
				return $this->redirect(['view', 'id' => $model->id]);
			}
        }
		$day=array();	
	    for($i=1;$i<=20;$i++)
		{
		 $day[$i]=$i;
		}
		
		$hour=array();
		for($i=1;$i<=23;$i++)
		{
		 $hour[$i]=$i;
		}
		$minutes=array();
		for($i=1;$i<=59;$i++)
		{
		 $minutes[$i]=$i;
		}
		
        return $this->renderAjax('create', [
            'model' => $model,
			'day' => $day,
			'hour' => $hour,
			'minutes'=>$minutes,
			'type'=>'create',
            'jobcard_id' => $jobcard_id
        ]);
		
	}
    /**
     * Updates an existing Tasks model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
      if ($model->load(Yii::$app->request->post())) {
		$res = Yii::$app->request->post();
		//var_dump($res);die;
		$day_in_min = (intval($res['days'])*1440);
		$hour_in_min =(intval($res['hours'])*60);
		$min = (intval($res['minutes']));
		
		
		$total_min = $day_in_min+$hour_in_min+$min;
		$model->total_time = $total_min;
			if($model->save())
            {
				return $this->redirect(['view', 'id' => $model->id]);
			}
			else
			{
				print_r($model->getErrors());
			}
        }
        
		$day=array();	
	    for($i=1;$i<=20;$i++)
		{
		 $day[$i]=$i;
		}
		$hour=array();
		for($i=1;$i<=23;$i++)
		{
		 $hour[$i]=$i;
		}
		$minutes=array();
		for($i=1;$i<=59;$i++)
		{
		 $minutes[]=$i;
		}
        return $this->render('update', [
            'model' => $model,
			'day' =>$day,
			'hour' => $hour,
			'minutes'=>$minutes,
			'type'=>'update',
        ]);
    }
	
    /**
     * Deletes an existing Tasks model.
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

    /**
     * Finds the Tasks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tasks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tasks::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
