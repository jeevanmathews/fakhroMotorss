<?php

use yii\helpers\Html;
use common\components\AutoForm;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Vehiclemodels */

$this->title = 'Update Variant features ';
$this->params['breadcrumbs'][] = ['label' => 'Vehicles', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Variants';
?>
<div class="content-main-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?= Html::encode($this->title) ?>        
		</h1>
	</section>
	<section class="content">
		<div class="box box-default">	 
			<?php $form = AutoForm::begin(); ?>
			<div class="box-body">
				<div class="row">
					<div class="col-md-12"> 		
								
						<div class="">
							
							<h5 class="heading"><span>Variant Features</span> </h5>            
							<div class="row  featurediv">
								<div class=" divfeatures" rid="1">
										<div class="col-md-3  no-display typeselect"> 
											<?php
											// var_dump($model->varient);die;
											// $model->feature->type=$model->type;
											?>
											<?= $form->field($model->feature, 'type')->dropDownList(
											$features, 
											['class' => 'form-control', 'prompt'=>'Select features','disabled'=>true,'value'=>$model->feature->id]);
											?>
										</div>
										<div class="col-md-3  typetext">  
											<?= $form->field($model->feature, 'type')->textInput(['value' => $model->feature->type]) ?>
											
										</div>
										<div class="col-md-3">  
										
											  <?= $form->field($model->feature, 'multiple')->radioList(['yes' => 'Yes', 'no' => 'No'],
					                            [
					                            'item'  =>  function ($index, $label, $name, $checked, $value)
					                                { 
					                                return "<label><input type='radio' class='styled-checkbox multipleselect' name= $name value='$value' ".(($checked)? "checked='$checked'":'')." /><span>$label</span></label>";
					                                }
					                            ,'class'=>'pull-right','value'=>$model->feature->multiple])->label()?>
										</div>
										<div class="col-md-6 value_div">  
											<?= $form->field($model->feature, 'value')->textInput(['class'=>'form-control valuetext textclone','value'=>$model->feature->value]) ?>
										<?= $form->field($model->feature, 'id')->hiddenInput(['value' => $model->feature->id])->label(false) ?>
										</div>
										<div class="col-md-2 no-display valueclone">  
											<?= Html::a('<span class="glyphicon glyphicon-plus clonevalues"></span>', '#', ['class'=>'']) ?>
										</div>
										<div class="box-body col-md-12">
											<?= Html::a('Add new', '#', ['class'=>'new_feature_type']) ?>
											<?= Html::a('<span class="glyphicon glyphicon-minus"></span>', '#', ['class'=>'pull-right remove_feature no-display']) ?>
										</div>
									</div>
								</div>
							</div>
							<div class="box-footer">
								<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
							</div>
								
							
							
							
						</div>
						</div>
					
					</div>
				</div>
				<?php AutoForm::end(); ?>
			</div>
		</div>
	</div>
</section>
</div>

<script>
$(document).ready(function(){
	// $('.divfeatures:first').find('.valuetext').attr('name','Customfeatures[value1][]');
	// $('.divfeatures:first').find('.multipleselect').attr('name','Customfeatures[multiple1]');
	$('body').on('click','.btn_add_features',function(){
		var last_row_type=$('.divfeatures:last').find('#customfeatures-type:not([disabled])').val();//.not('[disabled]'));//.val());
		console.log(last_row_type);
		if(last_row_type!=''){
			$('.divfeatures:first').find('.valuetext').attr('name','Customfeatures[value1][]');
			var clone=$('.featureclone').clone();
			clone.removeClass('featureclone');
			var rid = $('.divfeatures:last').attr('rid');
			var new_rid=parseInt(rid)+1;
			clone.attr('rid',new_rid);
			clone.find('.valuetext').attr('name','Customfeatures[value'+new_rid+'][]');
			clone.find('.multipleselect').attr('name','Customfeatures[multiple'+new_rid+']');
			clone.find('.remove_feature').removeClass('no-display');
			clone.find('.valueclone').addClass('no-display');
			clone.find('.value_div').addClass('col-md-6');
			clone.find('.value_div').removeClass('col-md-4');
			clone.find('.field-customfeatures-value').not(':first').remove();
			clone.find('input').val('');
			$('.featurediv').append(clone);
		}
	});
	$('body').on('click','.new_feature_type',function(){
		if($(this).hasClass('select')){
			$(this).removeClass('select');
			$(this).closest('.divfeatures').find('.typeselect').removeClass('no-display');
			$(this).closest('.divfeatures').find('.typetext').addClass('no-display');
			$(this).closest('.divfeatures').find('input').attr('disabled',true);
			$(this).closest('.divfeatures').find('select').attr('disabled',false);
			// $(this).removeClass('feature_select');
			// $(this).addClass('new_feature_type');
			$(this).html('Add New');
		}else{
			$(this).closest('.divfeatures').find('.typeselect').addClass('no-display');
			$(this).closest('.divfeatures').find('select').attr('disabled',true);
			$(this).closest('.divfeatures').find('input').attr('disabled',false);
			$(this).addClass('select');
			$(this).closest('.divfeatures').find('.typetext').removeClass('no-display');
			// $(this).removeClass('new_feature_type');
			// $(this).addClass('feature_select');
			$(this).html('Select Type');
		}
	});
	$('body').on('click','.remove_feature',function(){
		console.log($(this).closest('.divfeatures'));
		$(this).closest('.divfeatures').remove();
	});
	$('body').on('click','.multipleselect',function(){
		if($(this).is(':checked')){
			var multiple=$(this).val();
			if(multiple=='yes'){
				$(this).closest('.divfeatures').find('.valueclone').removeClass('no-display');
				$(this).closest('.divfeatures').find('.value_div').removeClass('col-md-6');
				$(this).closest('.divfeatures').find('.value_div').addClass('col-md-4');
			}else{
				$(this).closest('.divfeatures').find('.valueclone').addClass('no-display');
				$(this).closest('.divfeatures').find('.value_div').addClass('col-md-6');
				$(this).closest('.divfeatures').find('.value_div').removeClass('col-md-4');
				$(this).closest('.divfeatures').find('.field-customfeatures-value').not(':first').remove();
			}
		}
	});
	$('body').on('click','.clonevalues',function(){
		var rid =$(this).parents().find('.divfeatures').attr('rid');
		// valuetext textclone
		var clone='<div class="form-group field-customfeatures-value"><div class="input-group"><div class="input-group-addon">Value</div><input type="text" id="customfeatures-value" class="form-control valuetext textclone" name="Customfeatures[value'+rid+'][]"></div><div class="help-block"></div></div>';
		// var remove='<a class="pull-right remove_feature" href="#"><span class="glyphicon glyphicon-minus"></span></a>';
		// clone.find('.valuetext').attr('name','Customfeatures[value'+rid+'][]');
		$(this).closest('.divfeatures').find('.value_div').append(clone);
		// $(this).closest('.divfeatures').append(remove);
		// $(this).closest('.divfeatures').focus();
	});
	$('body').on('click','.btn_add_new',function(){

		if($(this).hasClass('clicked')){
			
		}else{
			$(this).addClass('clicked');
			$('.maindiv').removeClass('no-display');
			$('.maindiv').addClass('btn_add_features');
		}
	});
});

</script>


<!-- DetailView::widget([
'model' => $model,
'options' => ['class' => 'table table-striped table-bordered detail-view table-hover'],
'attributes' => [
['label'=>'Manufacturer',
'value'=>$model->manufacturer->name,
],
'name',
],
]) -->
<!-- $form->field($model, 'multiple')->dropDownList(['yes' => 'Yes', 'no' => 'No'],['prompt'=>'Select Option','class'=>'form-control multipleselect']); -->
<!-- $('body').on('change','.multipleselect',function(){
		var multiple=$(this).val();
		if(multiple=='yes'){
			$(this).closest('.divfeatures').find('.valueclone').removeClass('no-display');
			$(this).closest('.divfeatures').find('.value_div').removeClass('col-md-6');
			$(this).closest('.divfeatures').find('.value_div').addClass('col-md-4');
		}else{
			$(this).closest('.divfeatures').find('.valueclone').addClass('no-display');
			$(this).closest('.divfeatures').find('.value_div').addClass('col-md-6');
			$(this).closest('.divfeatures').find('.value_div').removeClass('col-md-4');
		}
	}); -->




<!-- 
	<div class="maindiv no-display">
							<h5 class="heading"><span>Variant Features</span> </h5>            
							<div class="row featurediv ">
								<div class="featureclone divfeatures" rid="1">
										<div class="col-md-3 no-display typeselect">  
											<?php
											// var_dump($model->varient);die;
											// $model->feature->type=$model->type;
											?>
											<?= $form->field($model->feature, 'type[]')->dropDownList(
											$features, 
											['class' => 'form-control', 'prompt'=>'Select features','disabled'=>true]);
											?>
										</div>
										<div class="col-md-3  typetext">  
											<?= $form->field($model->feature, 'type[]')->textInput(['value' => $model->feature->type]) ?>
											
										</div>
										<div class="col-md-3">  
										
											  <?= $form->field($model->feature, 'multiple[]')->radioList(['yes' => 'Yes', 'no' => 'No'],
					                            [
					                            'item'  =>  function ($index, $label, $name, $checked, $value)
					                                { 
					                                return "<label><input type='radio' class='styled-checkbox multipleselect' name= $name value='$value' ".(($checked)? "checked='$checked'":'')." /><span>$label</span></label>";
					                                }
					                            ,'class'=>'pull-right'])->label()?>
										</div>
										<div class="col-md-6 value_div">  
											<?= $form->field($model->feature, 'value[]')->textInput(['class'=>'form-control valuetext textclone','value'=>$model->feature->value]) ?>
										<?= $form->field($model, 'model_id')->hiddenInput(['value' => $model->varient[0]->model_id])->label(false) ?>
										</div>
										<div class="col-md-2 no-display valueclone">  
											<?= Html::a('<span class="glyphicon glyphicon-plus clonevalues"></span>', '#', ['class'=>'']) ?>
										</div>
										<div class="box-body col-md-12">
											<?= Html::a('Add new', '#', ['class'=>'new_feature_type']) ?>
											<?= Html::a('<span class="glyphicon glyphicon-minus"></span>', '#', ['class'=>'pull-right remove_feature no-display']) ?>
										</div>
									</div>
								</div>
								<div class="box-footer">
								<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
							</div>
							</div> -->