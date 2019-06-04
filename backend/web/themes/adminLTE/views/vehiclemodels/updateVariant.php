<?php

use yii\helpers\Html;
use common\components\AutoForm;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\Customfeatures;

/* @var $this yii\web\View */
/* @var $model backend\models\Vehiclemodels */

$this->title = 'Update Variant: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Vehicles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->model->name, 'url' => ['view', 'id' => $model->model_id]];
$this->params['breadcrumbs'][] = ['label' => $model->name];
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
						<div class="maindiv">
							<div class="mainclone variantdiv">
								<h5 class="heading"><span>Variant Details</span> </h5>            
								<div class="row">
									<div class="col-md-12">  
										<?= $form->field($model, 'name')->textInput() ?>
									</div>
									<div class="col-md-6">  
										
									</div>
								</div>
								<div class="box-footer">
									<?= Html::Button('<span class="glyphicon glyphicon-plus"></span>', ['class' => 'btn btn-success btn_add_features','title'=>'Add Features']) ?>
								</div>
							</div>
							<h5 class="heading"><span>Variant Features</span> </h5>            
							<div class="row featurediv ">
							<?php  $fcount = 1;
							if(!$features){ ?>
							<div class="featureclone divfeatures clearfix" rid="1">
									<div class="col-md-3 "> 
										<div class="typeselect">
										<?= $form->field($custumFeature, 'name[]')->dropDownList(
											ArrayHelper::map(Customfeatures::find()->all(), 'id', 'name'), 
											['class' => 'form-control', 'prompt'=>'Select features']);
											?>
										</div>
										<div class="no-display typetext">  
										<?= $form->field($custumFeature, 'name[]')->textInput() ?>
										</div>
										<span>Not in the list ?</span> <?= Html::a('Add new', '#', ['class'=>'btn btn-xs new_feature_type']) ?>
									</div>
									
									<div class="col-md-3">  
										  Multiple Values
										  <label><input type='radio' class='styled-radio multipleselect' name="Customfeatures[multiple1]" value="yes" /><span>Yes</span></label>
											<label><input type='radio' class='styled-radio singleselect'  name="Customfeatures[multiple1]" value="no" /><span>No</span></label>

										  <!-- <input class="multipleselect" type="radio" name="Customfeatures[multiple1]" value="yes">Yes -->
										  <!-- <input type="radio" class="singleselect" name="Customfeatures[multiple1]" checked value="no">No -->
									</div>
									<div class="col-md-6 outer_value_div">  
										<div class="col-md-8 value_div"> 

											<?= $form->field($variantFeature, 'value')->textInput(['class'=>'form-control valuetext textclone', 'name' => 'Variantfeatures[value1][]']) ?>
										</div>
										<div class="col-md-4 no-display valueclone">  
											<?= Html::a('<span class="glyphicon glyphicon-plus clonevalues"></span>', '#', ['class'=>'']) ?>
										</div>
										<div class="box-body col-md-4">
										
										<?= Html::a('<span class="glyphicon glyphicon-minus"></span>', '#', ['class'=>'pull-right remove_feature no-display']) ?>
										</div>
									</div>
									
								</div>							
							<?php }
							foreach ($features as $featureId => $feature) {							
								?>

									<div class="<?php echo (($fcount == 1)?'featureclone ':'');?> divfeatures clearfix" rid="<?php echo $fcount?>">
										<div class="col-md-3 "> 
										<div class="typeselect">
										<?= $form->field($custumFeature, 'name[]')->dropDownList(
											ArrayHelper::map(Customfeatures::find()->all(), 'id', 'name'), 
											['class' => 'form-control', 'prompt'=>'Select features', 'value' => $featureId 	]);
											?>
										</div>
										<div class="no-display typetext">  
										<?= $form->field($custumFeature, 'name[]')->textInput() ?>
										</div>
										<span class="newButtonSpan">Not in the list ?</span> <?= Html::a('Add new', '#', ['class'=>' new_feature_type']) ?>
									</div>
										<div class="col-md-3">  
											  Multiple Values
										  	<!-- <input class="multipleselect" type="radio" name="Customfeatures[multiple<?php echo $fcount;?>]" value="yes" <?php echo (count($feature['values'])>1)?"checked":""; ?>>Yes -->
										  	<!-- <input type="radio" <?php echo (count($feature['values'])==1)?"checked":""; ?> class="singleselect" name="Customfeatures[multiple<?php echo $fcount;?>]" value="no">No -->
											<label><input type='radio' class='styled-radio multipleselect' name="Customfeatures[multiple<?php echo $fcount;?>]" value="yes" <?php echo (count($feature['values'])>1)?"checked":""; ?>/><span>Yes</span></label>
											<label><input type='radio' class='styled-radio singleselect multipleselect' <?php echo (count($feature['values'])==1)?"checked":""; ?>  name="Customfeatures[multiple<?php echo $fcount;?>]" value="no" /><span>No</span></label>

										</div>
										<div class="<?php echo (count($feature['values'])>1)?"col-md-4":"col-md-4"; ?> value_div">  
										<?php 
										$valueloop = 0;
										foreach($feature['values'] as $value) {
												$valueloop++; 
												$variantFeature->value = $value;?>
												<div class="row">
												<div class="col-md-11">
											<?= $form->field($variantFeature, 'value')->textInput(['class'=>'form-control valuetext textclone', 'name' => 'Variantfeatures[value'.$fcount.'][]']) ?>
												</div>
											<?php if(count($feature['values'])>1 && $valueloop > 1) {

												echo '<div class="col-md-1"><a href="#" class="trash-input"><i class="fa fa-fw fa-trash"></i></a></div>';
												} ?>
												</div>
										<?php  } ?>	
										</div>
										<div class="col-md-2 <?php echo (count($feature['values'])>1)?"":"no-display"; ?> valueclone">  
											<?= Html::a('<span class="glyphicon glyphicon-plus clonevalues"></span>', '#', ['class'=>'']) ?>
										</div>
										<div class="box-body col-md-1">
											
											<?= Html::a('<span class="glyphicon glyphicon-minus"></span>', '#', ['class'=>'remove_feature '.(($fcount == 1)?'no-display':'')]) ?>
										</div>
									</div>	
									<hr/>							
							<?php 
							$fcount++;
							} ?>
							</div>								
							</div>
							<div class="box-footer">
								<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
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

	$('body').on('click','.trash-input',function(){
		$(this).parent(".col-md-1").parent(".row").remove();
		//$(this).remove();
	});

	$('body').on('click','.btn_add_features',function(){
		var last_row_type=$('.divfeatures:last').find('#customfeatures-type:not([disabled])').val();
		// console.log(last_row_type);
		if(last_row_type!=''){
			$('.divfeatures:first').find('.valuetext').attr('name','Variantfeatures[value1][]');
			var clone=$('.featureclone').clone();
			clone.removeClass('featureclone');
			var rid = $('.divfeatures:last').attr('rid');
			var new_rid=parseInt(rid)+1;
			clone.attr('rid',new_rid);
			clone.find('.valuetext').attr('name','Variantfeatures[value'+new_rid+'][]');
			clone.find('.multipleselect,.singleselect').attr('name','Variantfeatures[multiple'+new_rid+']');

			if($('.divfeatures:first').find(".field-variantfeatures-value").length > 1){
				//$('.divfeatures:first').find(".field-variantfeatures-value:first").remove();						
			}clone.find("#customfeatures-name").val("");
			clone.find('.singleselect').prop('checked', true);
			clone.find('.remove_feature').removeClass('no-display');
			clone.find('.valueclone').addClass('no-display');
			// clone.find('.value_div').addClass('col-md-6').removeClass('col-md-4');	
			clone.find('.field-variantfeatures-value').not(':first').remove();
			clone.find(".trash-input").remove();
			clone.find('input[type=text]').val('');
			$('.featurediv').append(clone);
			$('.featurediv').append('<hr/>');
		}
	});
	$('body').on('click','.new_feature_type',function(){
		if($(this).hasClass('select')){
			$(this).removeClass('select');
			$(this).closest('.divfeatures').find('.typeselect').removeClass('no-display');
			$(this).closest('.divfeatures').find('.typetext').addClass('no-display');
			$(this).closest('.divfeatures').find('.typetext input').attr('disabled',true);
			$(this).closest('.divfeatures').find('.typeselect select').attr('disabled',false);
			// $(this).removeClass('feature_select');
			// $(this).addClass('new_feature_type');
			// console.log($(this).closest('.newButtonSpan'));
			$(this).parent().find('.newButtonSpan').html('Not in the list?');
			$(this).html('Add New');
		}else{
			$(this).closest('.divfeatures').find('.typeselect').addClass('no-display');
			$(this).closest('.divfeatures').find('.typeselect select').attr('disabled',true);
			$(this).closest('.divfeatures').find('.typetext input').attr('disabled',false);
			$(this).addClass('select');
			$(this).closest('.divfeatures').find('.typetext').removeClass('no-display');
			// $(this).removeClass('new_feature_type');
			// $(this).addClass('feature_select');
			$(this).parent().find('.newButtonSpan').html('Already in the list?');
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
				// $(this).closest('.divfeatures').find('.value_div').removeClass('col-md-6');				
				// $(this).closest('.divfeatures').find('.value_div').addClass('col-md-4');
			}else{
				$(this).closest('.divfeatures').find('.valueclone').addClass('no-display');
				$(this).closest('.divfeatures').find('.trash-input').addClass('no-display');
				// $(this).closest('.divfeatures').find('.value_div').addClass('col-md-6');
				// $(this).closest('.divfeatures').find('.value_div').removeClass('col-md-4');
				$(this).closest('.divfeatures').find('.field-variantfeatures-value').not(':first').remove();
			}
		}
	});
	$('body').on('click','.clonevalues',function(){		
		var rid = $(this).closest('.divfeatures').attr('rid');
		// valuetext textclone
		var clone='<div class="row"><div class="col-md-11"><div class="form-group field-variantfeatures-value"><div class="input-group"><div class="input-group-addon">Value</div><input type="text" id="variantfeatures-value" class="form-control valuetext textclone" name="Variantfeatures[value'+rid+'][]"></div><div class="help-block"></div></div></div><div class="col-md-1"><a href="#" class="trash-input"><i class="fa fa-fw fa-trash"></i></a></div></div>';
		// var remove='<a class="pull-right remove_feature" href="#"><span class="glyphicon glyphicon-minus"></span></a>';
		// clone.find('.valuetext').attr('name','Customfeatures[value'+rid+'][]');
		$(this).closest('.divfeatures').find('.value_div').append(clone);
		// $(this).closest('.divfeatures').append(remove);
		// $(this).closest('.divfeatures').focus();
	});
});

</script>

