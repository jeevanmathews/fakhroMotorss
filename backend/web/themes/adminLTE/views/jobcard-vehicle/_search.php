<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\JobcardVehicleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jobcard-vehicle-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'reg_num') ?>

    <?= $form->field($model, 'chasis_num') ?>

    <?= $form->field($model, 'make') ?>

    <?= $form->field($model, 'model') ?>

    <?php // echo $form->field($model, 'color') ?>

    <?php // echo $form->field($model, 'tr_number') ?>

    <?php // echo $form->field($model, 'amc_type') ?>

    <?php // echo $form->field($model, 'amc_expiry_date') ?>

    <?php // echo $form->field($model, 'extended_warranty_type') ?>

    <?php // echo $form->field($model, 'ew_expiry_kms') ?>

    <?php // echo $form->field($model, 'ew_expiry_date') ?>

    <?php // echo $form->field($model, 'service_schedule') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
