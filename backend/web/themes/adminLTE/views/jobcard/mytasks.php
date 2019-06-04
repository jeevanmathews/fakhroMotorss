<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\JobcardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-main-wrapper">

    <section class="content-header">
      <h1>
        <?= Html::encode($this->title) ?>        
      </h1>
    </section>
    <section class="content">
    <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">   

        <div class="box-body">
        <div class="row">
        <div class="col-md-12"> 
  
        <?= GridView::widget([
        'dataProvider' => $taskdataProvider,                
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],   
            'task.task',  
            'jobcard_id',                                        
            'start_date_time',   
            'end_date_time', 
            [
                'label' => 'Allowed Time',
                'value' => function ($model, $key, $index, $widget){                   
                    return Yii::$app->common->getTimedisplay($model->task->total_time*60);
                },  
            ] ,        
            [
                'attribute' => 'total_time',
                'value' => function ($model, $key, $index, $widget){
                    return Yii::$app->common->getTimedisplay($model->total_time*60);
                },  
            ], 
            'status', 
            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view}{update}',
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['task-status', 'taskId' => $model->id]);
                    },                              
                'view'  =>  function ($url, $model, $key) {
                     return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['view-task', 'taskId' => $model->id]);
                    }
                ]
            ],
        ],                   
        ]); ?>  
        </div>
        </div>
        </div>
        </div>
          <!-- /.box -->
    </section>
</div>
