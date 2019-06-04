<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Roles */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="roles-form">

    <?php $form = ActiveForm::begin(); ?>
<div class="box-body">
        <div class="row">
            <div class="col-md-6"> 
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'department_id')->dropDownList(
	                $departments, 
	                ['class' => 'form-control mb20', 'prompt'=>'Select Department']);
	?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    </div>
    </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
