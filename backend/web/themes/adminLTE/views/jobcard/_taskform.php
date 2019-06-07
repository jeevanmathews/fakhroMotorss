<?php

use yii\helpers\Html;
use common\components\AutoForm;
use yii\helpers\ArrayHelper;
use backend\models\Tasks;
use backend\models\Employees;

/* @var $this yii\web\View */
/* @var $model backend\models\Jobcard */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = AutoForm::begin(); ?>
    <div class="box-body">

        <div class="row"> 
            <div class="col-md-12">
                <h5 class="heading"><span><?php echo (!$jobcardTask->isNewRecord)?"Update":"Assign New";?> Task</span> </h5>
                <div class="col-md-6">
                    <?= $form->field($jobcardTask, 'task_id', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(['0' => 'Add New Task']+ArrayHelper::map(Tasks::find()->where(["status" => 1])->all(), 'id', 'namewithPrice'), ["prompt" => "Select a Task"]) ?>

                     <?= $form->field($jobcardTask, 'mechanic_id', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(Employees::find()->where(["status" => 1, "designation_id" => 4, "branch_id" => Yii::$app->user->identity->branch_id])->all(), 'id', 'fullname'), ["prompt" => "Assign a Mechanic"]) ?>                   

                    <?= $form->field($jobcardTask, 'billing_rate')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($jobcardTask, 'discount')->radioList(['discount_percent' => 'Rate (%)','discount_amount' => 'Amount'], ['item' => function ($index, $label, $name, $checked, $value){ 
                            return "<label><input type='radio' name='$name' value='$value'> $label <input type='".(($value == "discount_percent")?"number":"text")."' class='hide' max='100' min='0' name='JobcardTask[$value]' value=''></label>";
                        }
                        ]) ?>

                    <?= $form->field($jobcardTask, 'note')->textarea(['rows' => 6]) ?>
                    
                    <?= $form->field($jobcardTask, 'status')->dropDownList([ 'open' => 'Open', 'inprogress' => 'Inprogress', 'hold' => 'Hold', 'completed' => 'completed', 'reopen' => 'Reopen'], ['prompt' => '']) ?> 
                    <a class="hide" id="add-new" href="/fakhromotorss/backend/web/index.php?r=jobcard%2Findex">Jobcard</a>
                </div>                               
            </div>
        </div>

        </div>
    <!-- /.box-body -->  
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
<?php AutoForm::end(); ?>


<script type="text/javascript">

    $(document).ready(function(){
        var taskId = $("#jobcardtask-task_id").find("option:selected").html(); 

        loadTaskData(taskId);

        $("[name='JobcardTask[discount_percent]']").val("<?=$jobcardTask->discount_percent?>");
        $("[name='JobcardTask[discount_amount]']").val("<?=$jobcardTask->discount_amount?>");
        $("[value='<?=$jobcardTask->discount?>']").prop('checked', true);
        showDiscount('<?=$jobcardTask->discount?>');

        $("[name='JobcardTask[discount]']").click(function(){     
        showDiscount($(this).val());
        });
        function showDiscount(discval){
            if(discval == "discount_amount"){
                $("[name='JobcardTask[discount_amount]']").removeClass("hide");
                $("[name='JobcardTask[discount_percent]']").addClass("hide");
            }else{
                $("[name='JobcardTask[discount_percent]']").removeClass("hide");
                $("[name='JobcardTask[discount_amount]']").addClass("hide");
            }
        }
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

    function loadTaskData(sel){
        if(!sel.split("-")[1]){
            $(".field-jobcardtask-billing_rate").addClass("hide");
            $(".field-jobcardtask-discount").addClass("hide");
        } else{
            $(".field-jobcardtask-billing_rate").removeClass("hide");
            if(sel.split("-")[1]) $("#jobcardtask-billing_rate").val(sel.split(" ").reverse()[0]);
            $("#jobcardtask-billing_rate").attr("disabled", "disabled"); 
            $(".field-jobcardtask-discount").removeClass("hide"); 
        } 
        console.log(sel.split(" ").length)
    }

    $("#jobcardtask-task_id").change(function(){
        var sel = $(this).find("option:selected").html();
        if($(this).find("option:selected").val() == "0"){

            $.ajax({
          url: "<?php echo Yii::$app->getUrlManager()->createUrl(['tasks/create', 'jobcard_id' => $jobcardTask->jobcard_id]);?>",
          aSync: false,
          dataType: "html",
          success: function(data) {
            var tabId = $(this).closest(".main-body").attr("tab_id");
            $(".main-body").addClass("hide");
            $('div[tab_id="'+tabId+'"]').remove();
            $(".container-body").append($(data));            
            $(document).find("#"+$(".main-body").attr("id")).attr("tab_id", tabId)
          }});

           //$("#add-new").trigger("click");
        }
        loadTaskData(sel);
    }); 
</script>
