<?php

use yii\helpers\Html;
use common\components\AutoForm;
use yii\helpers\ArrayHelper;
use backend\models\Tasks;
use backend\models\Accessories;
use backend\models\Spareparts;

/* @var $this yii\web\View */
/* @var $model backend\models\Jobcard */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = AutoForm::begin(["id" => "material-".time().(($jobcardMaterial->isNewRecord)?"create":"update")."-form"]); ?>
    <div class="box-body">

        <div class="row"> 
            <div class="col-md-12">
                <h5 class="heading"><span><?php echo (!$jobcardMaterial->isNewRecord)?"Update":"Add New";?> Material</span> </h5>
                <div class="col-md-6">
                    <?= $form->field($jobcardMaterial, 'material_type', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(['accessories' => 'Accessories', 'spares' => 'Spares'], ["prompt" => "Select a Task"]) ?>

                    <?= $form->field($jobcardMaterial, 'material_id', ['inputOptions' => ["class" => "form-control select2 accessory"], 'options' => ['class' => 'form-group field-jobcardmaterial-material_id accessories required']])->dropDownList(ArrayHelper::map(Accessories::find()->where(["status" => 1])->all(), 'id', 'namewithPrice'), ["prompt" => "Select an Accessory"]) ?> 

                    <?=Html::dropDownList("spares", "", ArrayHelper::map(Spareparts::find()->where(["status" => 1])->all(), 'id', 'namewithPrice'), ["prompt" => "Select a Sparepart", 'class' => 'hide'])?>

                    <?=Html::dropDownList("accessories", "", ArrayHelper::map(Accessories::find()->where(["status" => 1])->all(), 'id', 'namewithPrice'), ["prompt" => "Select an Accessory", 'class' => 'hide'])?>                  

                    <?= $form->field($jobcardMaterial, 'unit_rate')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($jobcardMaterial, 'num_unit')->textInput(['maxlength' => true]) ?>                    

                    <?= $form->field($jobcardMaterial, 'rate')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($jobcardMaterial, 'rate')->hiddenInput(['id' => 'jobcardmaterial-hidden-rate'])->label(false);?>   

                    <?= $form->field($jobcardMaterial, 'discount')->radioList(['discount_percent' => 'Rate (%)','discount_amount' => 'Amount'], ['item' => function ($index, $label, $name, $checked, $value){ 
                            return "<label><input type='radio' name='$name' value='$value'> $label <input type='".(($value == "discount_percent")?"number":"text")."' class='hide' max='100' min='0' name='JobcardMaterial[$value]' value=''></label>";
                        }
                        ]) ?>              
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
        var tabId = $(".main-body:visible").attr("tab_id"); 
        $("[tab_id='"+tabId+"']").find("#jobcardmaterial-material_id").html($("[name='"+$("#jobcardmaterial-material_type").val()+"']").html());
        $("[tab_id='"+tabId+"']").find("#jobcardmaterial-material_id").val("<?php echo $jobcardMaterial->material_id;?>");
        $("[tab_id='"+tabId+"']").find("#jobcardmaterial-unit_rate").attr("disabled", "disabled");
        $("[tab_id='"+tabId+"']").find("#jobcardmaterial-rate").attr("disabled", "disabled");

        $("[tab_id='"+tabId+"']").find("[name='JobcardMaterial[discount_percent]']").val("<?=$jobcardMaterial->discount_percent?>");
        $("[tab_id='"+tabId+"']").find("[name='JobcardMaterial[discount_amount]']").val("<?=$jobcardMaterial->discount_amount?>");
        $("[tab_id='"+tabId+"']").find("[value='<?=$jobcardMaterial->discount?>']").prop('checked', true);
        showMatDiscount('<?=$jobcardMaterial->discount?>', tabId);
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
