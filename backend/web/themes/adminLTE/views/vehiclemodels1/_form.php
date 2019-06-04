<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\AutoForm;
/* @var $this yii\web\View */
/* @var $model backend\models\Vehiclemodels */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vehiclemodels-form">
	<div class="box-body">
		<div class="row">           
			<div class="col-md-5 col-md-offset-3"> 
				<?php $form = AutoForm::begin(); ?>
				<?= $form->field($model, 'manufacturer_id')->dropDownList(
					$manufacturer, 
					['class' => 'form-control', 'prompt'=>'Select Manufacturer']);
					?>
					<?= $form->field($model, 'name')->textInput() ?>

				</div>
			</div>
		</div>
		<!-- /.box-body -->  
		<div class="box-footer">
			<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
			
		</div>
		<?php AutoForm::end(); ?>

	</div>
