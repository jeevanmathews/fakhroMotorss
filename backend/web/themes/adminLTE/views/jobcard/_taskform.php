<?php

use yii\helpers\Html;
use common\components\AutoForm;
use yii\helpers\ArrayHelper;
use backend\models\Tasks;
use backend\models\Employees;
use backend\models\TaskType;

/* @var $this yii\web\View */
/* @var $model backend\models\Jobcard */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = AutoForm::begin(["id" => "task-".time().(($jobcardTask->isNewRecord)?"create":"update")."-form"]); ?>
    <div class="box-body">

        <div class="row"> 
            <div class="col-md-12">
                <h5 class="heading"><span><?php echo (!$jobcardTask->isNewRecord)?"Update":"Assign New";?> Task</span> </h5>
                <div class="col-md-6">
                    <?php
                        if(!$jobcardTask->isNewRecord){
                        $args = ($jobcardTask->task->tasktype->vehicle_type == "required")?["status" => 1, 'type' => $jobcardTask->task->type, 'vehicle_type' => $jobcardTask->task->vehicle_type]:["status" => 1, 'type' => $jobcardTask->task->type];
                        $jobcardTask->task_type = $jobcardTask->task->tasktype;
                        }
                    ?>   

                    <?=$form->field($jobcardTask, 'task_type')->dropDownList(
                            ArrayHelper::map(TaskType::find()->all(), 'id', 'task_type'),
                             ['prompt' => 'Select Task Type','class' => 'form-control select2 type', 
                            
                        'onchange'=>'
                            $.get( "'.Yii::$app->getUrlManager()->createUrl(['tasks/tasksbytype', 'vehicle_type' => $vehicle_type]).'&type="+$(this).val(), function( data ) {
                            $(document).find(".main-body:visible").find( "#jobcardtask-task_id" ).html(data);
                       });
                        ']);?>

                    <?= $form->field($jobcardTask, 'task_id', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(['0' => 'Add New Task']+(($jobcardTask->isNewRecord)?[]:ArrayHelper::map(Tasks::find()->where($args)->all(), 'id', 'namewithPrice')), ["prompt" => "Select a Task"]) ?>

                     <?= $form->field($jobcardTask, 'mechanic_id', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(Employees::find()->where(["status" => 1, "designation_id" => 4, "branch_id" => Yii::$app->user->identity->branch_id])->all(), 'id', 'fullname'), ["prompt" => "Assign a Mechanic"]) ?>                   

                    <?= $form->field($jobcardTask, 'billing_rate')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($jobcardTask, 'discount')->radioList(['discount_percent' => 'Rate (%)','discount_amount' => 'Amount'], ['item' => function ($index, $label, $name, $checked, $value){ 
                            return "<label><input type='radio' name='$name' value='$value'> $label <input type='".(($value == "discount_percent")?"number":"text")."' class='hide' max='100' min='0' name='JobcardTask[$value]' value=''></label>";
                        }
                        ]) ?>

                    <?= $form->field($jobcardTask, 'note')->textarea(['rows' => 6]) ?>
                    
                    <?= $form->field($jobcardTask, 'status')->dropDownList([ 'open' => 'Open', 'inprogress' => 'Inprogress', 'hold' => 'Hold', 'completed' => 'completed', 'reopen' => 'Reopen'], ['prompt' => '']) ?>                   
                </div>                               
            </div>
        </div>

        </div>
    <!-- /.box-body -->  
    <div class="box-footer">
        <?= html::HiddenInput('jobcard_id', $jobcardTask->jobcard_id) ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
<?php AutoForm::end(); ?>


<script type="text/javascript">
     $(document).ready(function(){
        var taskId = $("#jobcardtask-task_id:visible").find("option:selected").html(); 
        taskId = (taskId)?taskId:"";
        var tabId = $(".main-body:visible").attr("tab_id"); 
     
        loadTaskData(taskId, tabId);

        $("[tab_id='"+tabId+"']").find("[name='JobcardTask[discount_percent]']").val("<?=$jobcardTask->discount_percent?>");
        $("[tab_id='"+tabId+"']").find("[name='JobcardTask[discount_amount]']").val("<?=$jobcardTask->discount_amount?>");
        $("[tab_id='"+tabId+"']").find("[value='<?=$jobcardTask->discount?>']").prop('checked', true);
        showDiscount('<?=$jobcardTask->discount?>', tabId);        
    });

    $( function() {
    $( ".datepicker" ).datepicker({
      defaultDate: new Date(),
      dateFormat: "dd/mm/yy",
      changeMonth: true,
      changeYear: true,
      yearRange: "1930:2030",
    });
    });
</script>
