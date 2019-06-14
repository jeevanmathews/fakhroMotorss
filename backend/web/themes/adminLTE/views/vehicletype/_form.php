<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\AutoForm;
/* @var $this yii\web\View */
/* @var $model backend\models\Vehicletype */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vehicletype-form">

	<?php $form = AutoForm::begin(["id" => "vehicletype-".time().(($model->isNewRecord)?"create":"update")."-form"]); ?>
	<div class="box-body">
		<div class="row">           
			<div class="col-md-5 col-md-offset-3"> 
				<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

			</div>
		</div>
	</div>
	<!-- /.box-body -->  
	<div class="box-footer">
		<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
	</div>

	<?php AutoForm::end(); ?>

</div>
