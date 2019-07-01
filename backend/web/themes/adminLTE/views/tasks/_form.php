<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\AutoForm;
use yii\helpers\ArrayHelper;
use backend\models\TaskType;
use backend\models\Vehicletype;

/* @var $this yii\web\View */
/* @var $model backend\models\Tasks */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = AutoForm::begin(); ?>
<div class="box-body">
    <div class="row">
        <div class="col-md-12">
            <h5 class="heading"><span>Company Details</span> </h5>
            <div class="row">
                <div class="col-md-6"> 


                    <?= $form->field($model, 'task')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

                    <!--<?= $form->field($model, 'billable')->textInput() ?>
                    <?= $form->field($model, 'billable')->checkbox(['class'=>'styled-checkbox']) ?>-->
                    <div class="form-group field-variantfeatures-value">
                        <div class="input-group">
                            <!--<div class="input-group-addon"></div> -->
                           <label>&nbsp;&nbsp;&nbsp;
							 <?=
								$form->field($model, 'billable')
									->radioList(
										['yes' => 'Yes', 'no' => 'No'],
										[
											'item' => function($index, $label, $name, $checked, $value) {

												$return = '<label>';
												$return .= '<input type="radio" name="' . $name . '" value="' . $value . '" class="styled-radio" tabindex="3"'.(($checked==1)?"checked='checked'":"").'">';
												
												$return .= '<span>' . ucwords($label) . '</span>';
												$return .= '</label>';

												return $return;
											}
										]
									)
								->label('Billable');
                    ?>
							
                        </label>
                        </div>
                        <div class="help-block"></div>
                    </div>

                </div>
                <div class="col-md-6">
				<div class="form-group date-time-form-group">
				<div class="input-group">
				<div class="input-group-addon">Allowed Time</div>
				   <?php 
				   $min= $model->total_time;
					$d = floor ($min / 1440);
					$h = floor (($min - $d * 1440) / 60);
					$m = $min - ($d * 1440) - ($h * 60);
				   ?>
				   <?php if($model->total_time!=0) {?>
					<?= Html::dropDownList('days',$d,  $day, 
					 ['class' => 'form-control', 'id' => 'your_id', 'prompt' => '0'])?>  <span>Days</span>
					 <?= Html::dropDownList('hours',$h,  $hour, 
					 ['class' => 'form-control', 'id' => 'your_id', 'prompt' => '0'] )?>  <span>Hours</span>
					 <?= Html::dropDownList('minutes',$m,  $minutes, 
					 ['class' => 'form-control', 'id' => 'your_id', 'prompt' => '0'] )?>  <span>Minutes</span>
				   <?php }
				   else{ 
				   ?>
				   <?= Html::dropDownList('days','select',  $day, 
					 ['class' => 'form-control', 'id' => 'your_id', 'prompt' => '0'])?>  <span>Days</span>
					 <?= Html::dropDownList('hours','select',  $hour, 
					 ['class' => 'form-control', 'id' => 'your_id', 'prompt' => '0'] )?>  <span>Hours</span>
					 <?= Html::dropDownList('minutes','select',  $minutes, 
				   	 ['class' => 'form-control', 'id' => 'your_id', 'prompt' => '0'] )?>  <span>Minutes</span>
				   <?php
				   }
				   ?>
				</div>
				</div>			
				
					<?= $form->field($model, 'type', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(TaskType::find()->all(), 'id', 'task_type'), ["prompt" => "Select Task Type"]) ?>

					<?= $form->field($model, 'vehicle_type', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(Vehicletype::find()->where(['status' => 1])->all(), 'id', 'name'), ["prompt" => "Select Vehicle Type"]) ?>  
					<?php
					
					if($model->billable == ' ' || $model->billable == 'no')
					{
					?>
                    <div class="hidden-item" style="visibility:hidden">
                    <?= $form->field($model, 'actual_rate')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'billing_rate')->textInput(['maxlength' => true]) ?>
					 
					<?=
								$form->field($model, 'tax_enabled')
									->radioList(
										['yes' => 'Yes', 'no' => 'No'],
										[
											'item' => function($index, $label, $name, $checked, $value) {

												$return = '<label>';
												$return .= '<input type="radio" name="' . $name . '" value="' . $value . '" class="styled-radio" tabindex="3"'.(($checked==1)?"checked='checked'":"").'">';
												
												$return .= '<span>' . ucwords($label) . '</span>';
												$return .= '</label>';

												return $return;
											}
										]
									)
								->label('tax_enabled');
                    ?>
					<?php
					if($model->tax_enabled == 'no')
					{
					?>
					<span id="hide" style="visibility:hidden">
					<?= $form->field($model, 'tax_rate')->textInput(['maxlength' => true]) ?>
					</span>
					<?php
					}
					else
					{
					?>
					<span id="hide">
					<?= $form->field($model, 'tax_rate')->textInput(['maxlength' => true]) ?>
					</span>
					<?php
					}
					?>
					</div>
					<?php
					}
					else if($model->billable == 'yes')
					{
					?>
					<div class="hidden-item" style="">
                    <?= $form->field($model, 'actual_rate')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'billing_rate')->textInput(['maxlength' => true]) ?>
					 
					<?=
								$form->field($model, 'tax_enabled')
									->radioList(
										['yes' => 'Yes', 'no' => 'No'],
										[
											'item' => function($index, $label, $name, $checked, $value) {

												$return = '<label>';
												$return .= '<input type="radio" name="' . $name . '" value="' . $value . '" class="styled-radio" tabindex="3"'.(($checked==1)?"checked='checked'":"").'">';
												
												$return .= '<span>' . ucwords($label) . '</span>';
												$return .= '</label>';

												return $return;
											}
										]
									)
								->label('tax_enabled');
                    ?>
					<?php
					
					if($model->tax_enabled == '')
					{
					?>
					<span id="hide" style="visibility:hidden">
					<?= $form->field($model, 'tax_rate')->textInput(['maxlength' => true]) ?>
					</span>
					<?php
					}
					else
					{
					?>
					<span id="hide">
					<?= $form->field($model, 'tax_rate')->textInput(['maxlength' => true]) ?>
					</span>
					<?php
					}
					?>
					</div>
					<?php
					}
					else
					{
					?>
					  <div class="hidden-item" style="visibility:hidden">
                    <?= $form->field($model, 'actual_rate')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'billing_rate')->textInput(['maxlength' => true]) ?>
					 
					<?=
								$form->field($model, 'tax_enabled')
									->radioList(
										['yes' => 'Yes', 'no' => 'No'],
										[
											'item' => function($index, $label, $name, $checked, $value) {

												$return = '<label>';
												$return .= '<input type="radio" name="' . $name . '" value="' . $value . '" class="styled-radio" tabindex="3"'.(($checked==1)?"checked='checked'":"").'">';
												
												$return .= '<span>' . ucwords($label) . '</span>';
												$return .= '</label>';

												return $return;
											}
										]
									)
								->label('tax_enabled');
                    ?>
					
					<span id="hide" style="visibility:hidden">
					<?= $form->field($model, 'tax_rate')->textInput(['maxlength' => true]) ?>
					</span>
					
					</div>
					<?php
					}
					?>
					</div>
            </div>
        </div>
    </div>
</div>
<!-- /.box-body -->  
<div class="box-footer">
	<?php if(isset($jobcard_id)){ ?><?=Html::hiddenInput('jobcard_id', $jobcard_id)?><?php } ?>
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>
<!-- /.box-footer -->


<?php AutoForm::end(); ?>
<script>
  $(document).ready(function () {
    $("input[name='Tasks[billable]']").click(function () {
      var value = $(this).val();
	  if (value == 'yes') {
	   $(".hidden-item").css("visibility","visible");
	  }
	  else if (value == 'no') {
       	$(".hidden-item").css("visibility","hidden");

      }
	  $("input[name='Tasks[tax_enabled]']").click(function () {
      var value = $(this).val();
	  if (value == 'yes') {
	   $("#hide").css("visibility","visible");
	  }
	  else if (value == 'no') {
       	$("#hide").css("visibility","hidden");

      }
	  });
	 });
  });
	</script>
