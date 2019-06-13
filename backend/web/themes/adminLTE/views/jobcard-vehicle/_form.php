<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\JobcardVehicle */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jobcard-vehicle-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'reg_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'chasis_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'make')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tr_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amc_type')->textInput() ?>

    <?= $form->field($model, 'amc_expiry_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'extended_warranty_type')->textInput() ?>

    <?= $form->field($model, 'ew_expiry_kms')->textInput() ?>

    <?= $form->field($model, 'ew_expiry_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'service_schedule')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
