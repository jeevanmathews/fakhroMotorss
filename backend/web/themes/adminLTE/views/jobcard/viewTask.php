<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Jobcard */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'My Tasks', 'url' => ['mytasks']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="content-main-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= Html::encode("Jobcard No: ".$model->jobcard_id."/ Task: ".$model->task->task) ?>        
      </h1>
    </section>
     <section class="content">
    <!-- SELECT2 EXAMPLE -->
    <div class="box box-default">   
        <div class="box-body">
        <div class="row">
            <div class="col-md-6"> 
            <p>
                <?= Html::a('Change Status', ['task-status', 'taskId' => $model->id], ['class' => 'btn btn-primary']) ?>                
            </p>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'label' => 'Jobcard Number',
                        'value' => $model->jobcard_id
                    ],       
                    'task.task',
                    'start_date_time',
                    'end_date_time',
                    [
                        'label' => 'Allowed Time',
                        'value' => Yii::$app->common->getTimedisplay($model->task->total_time*60)
                    ],
                    [
                        'label' => 'Logged Time',
                        'value' => Yii::$app->common->getTimedisplay($model->total_time*60)
                    ],     
                    'status',            
        			'note:ntext',			
                ],
            ]) ?>
            </div>
        </div>             
        </div>
        </div>
    </section>
</div>
