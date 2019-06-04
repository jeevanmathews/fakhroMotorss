<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\AutoForm;
use backend\models\Vehicletype;
use backend\models\Variants;
use yii\helpers\ArrayHelper;

// use backend\models\Currency;
/* @var $this yii\web\View */
/* @var $model backend\models\Vehiclemodels */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vehiclemodels-form">
	<?php $form = AutoForm::begin(); ?>
	<div class="box-body">
		<div class="row">
			<div class="col-md-12">   
				<h5 class="heading"><span>Vehicle Details</span> </h5>            
				<div class="row">
						<div class="col-md-6">  
						<?= $form->field($model, 'manufacturer_id')->dropDownList(
							$manufacturer, 
							['class' => 'form-control', 'prompt'=>'Select Manufacturer']);
							?>
						</div>
							<div class="col-md-6">  
						<?= $form->field($model, 'type_id')->dropDownList(
							ArrayHelper::map(Vehicletype::find()->all(), 'id', 'name'), 
							['class' => 'form-control', 'prompt'=>'Select Type']);
							?>
						</div>
						<div class="col-md-6">  
							<?= $form->field($model, 'name')->textInput() ?>
						</div>
					</div>
					
				</div>
				<!-- /.box-body -->  
				<div class="box-footer">
					<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
				</div>
				

			</div>
			<?php AutoForm::end(); ?>
</div>
<script>
	$('.btn_add_variant').on('click',function(){
		var clone=$('.mainclone').clone();
		clone.removeClass('mainclone');
		console.log(clone.find('.featurediv'));
		clone.find('.divfeatures').not(':first').remove();
		$('.maindiv').append(clone);
	});
	$('body').on('click','.btn_add_features',function(){
		var clone=$(this).closest('.variantdiv').find('.featureclone').clone();
		console.log(clone);
		clone.removeClass('featureclone');
		$(this).closest('.variantdiv').find('.featurediv').append(clone);
	});
	$('.new_feature_type').on('click',function(){
		if($(this).hasClass('select')){
			$(this).removeClass('select');
			$('.typeselect').removeClass('no-display');
			$('.typetext').addClass('no-display');
			$(this).removeClass('feature_select');
			$(this).addClass('new_feature_type');
			$(this).html('Add New');
		}else{
			$('.typeselect').addClass('no-display');
			$(this).addClass('select');
			$('.typetext').removeClass('no-display');
			$(this).removeClass('new_feature_type');
			$(this).addClass('feature_select');
			$(this).html('Select Type');
		}
	});
	// $('.feature_select').on('click',function(){
	// 	alert();
	// 	$('.typeselect').removeClass('no-display');
	// 	$('.typetext').addClass('no-display');
	// 	$(this).removeClass('feature_select');
	// 	$(this).addClass('new_feature_type');
	// 	$(this).html('Add New');
	// });
</script>