<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\AutoForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Sparetypes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sparetypes-form">

	<?php $form = AutoForm::begin(); ?>
	<div class="box-body">
		<div class="row">           
			<div class="col-md-5 col-md-offset-3">

				<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
			</div>
		</div>
	</div>
	<div class="box-footer">
		<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
	</div>

	<?php AutoForm::end(); ?>

</div>
