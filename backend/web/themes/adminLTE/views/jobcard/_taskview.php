<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Jobcard */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="content-main-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Task Details 
      </h1>
    </section>
    
    <section class="content">
    <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">   

        <div class="box-body">
        <div class="row">
            <div class="col-md-12"> 
                <div class="row">
                    <div class="col-md-12">                 
                        <?= DetailView::widget([
                        'model' => $task,
                        'options' => ['class' => 'table table-striped table-bordered detail-view table-hover'],
                        'attributes' => [       
                            'task.task',                            
                            [
                                'attribute' => 'task.total_time',
                                'value' => Yii::$app->common->getTimedisplay($task->task->total_time*60)
                            ], 
                            'task_rate',   
                            'billable',
                            'tax_enabled',
                            'tax_rate',                          
                            'billing_rate',
                            [
                                'label' => 'Mechanic',
                                'value' => (($task->mechanic)?$task->mechanic->fullname:"(not set)")
                            ],
                            'start_date_time',
                            'end_date_time',
                            [
                                'attribute' => 'total_time',
                                'value' => Yii::$app->common->getTimedisplay($task->total_time*60)
                            ],                            
                            'status',
                            'note:ntext'
                            ],
                    ]) ?>
                    </div>
                </div>             
        </div>
        </div>
        </div>
        </div>
          <!-- /.box -->
    </section>
</div>