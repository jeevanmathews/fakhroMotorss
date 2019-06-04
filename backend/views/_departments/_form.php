<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Departments */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="departments-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6"> 
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    </div>
    </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
