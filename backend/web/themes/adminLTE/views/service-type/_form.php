<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\AutoForm;
/* @var $this yii\web\View */
/* @var $model backend\models\ServiceType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-type-form">

   <?php $form = AutoForm::begin(); ?>
	<div class="box-body">
		<div class="row">           
			<div class="col-md-5 col-md-offset-3"> 

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    </div>
		</div>
	</div>
	<div class="box-footer">
		<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
	</div>

	<?php AutoForm::end(); ?>

</div>
