<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\AutoForm;


/* @var $this yii\web\View */
/* @var $model backend\models\Jobcard */

$this->title = "Jobcard Number: ".$task->jobcard_id."/Task: ".$task->task->task;
$this->params['breadcrumbs'][] = ['label' => 'My Tasks', 'url' => ['mytasks']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="content-main-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= Html::encode($this->title) ?>        
      </h1>
    </section>
    <section class="content">
      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">        
        <?php $form = AutoForm::begin(); ?>
        <div class="box-body">
            <div class="row"> 
                <div class="col-md-offset-1 col-md-4">
                    <div class="task-status-view">
                      <h4 class="text-center">Task Status : <span style="color:<?=$status_colors[$task->status]?> !important;"> <?php echo ucfirst($task->status) ?> </span></h4>
                      <a class="btn btn-block" onclick="openTaskLog(<?=$task->id?>)" href="javascript:;">View Log</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5 class="heading"><span>Update Task Status</span> </h5>
                    <?= $form->field($log, 'status')->dropDownList($taskAry, ['prompt' => 'Select Status']) ?>
                    <?= $form->field($log, 'comment')->textArea() ?>
                </div>
            </div>
        </div>
        <!-- /.box-body -->  
        <div class="box-footer">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
        <?php AutoForm::end(); ?>
      </div>
        <!-- /.box -->
    </section>
</div>
<div id="task-log" class="modal">
 
</div>

<script type="text/javascript">

  function openTaskLog(job_taskId){ 
    $.post('<?=Yii::$app->getUrlManager()->createUrl(['jobcard/task-log'])?>', { job_taskId: job_taskId })
      .done(function( data ) {          
               $("#task-log").html(data);  
               $("#task-log").modal(); 
      });
  }
</script>
