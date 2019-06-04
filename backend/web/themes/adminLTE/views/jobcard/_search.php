<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\JobcardSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jobcard-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'jobcard_number') ?>

    <?= $form->field($model, 'created_date') ?>

    <?= $form->field($model, 'promised_date') ?>

    <?= $form->field($model, 'advance_paid') ?>

    <?php // echo $form->field($model, 'receipt_num') ?>

    <?php // echo $form->field($model, 'sales_manager') ?>

    <?php // echo $form->field($model, 'service_advisor') ?>

    <?php // echo $form->field($model, 'labour_cost') ?>

    <?php // echo $form->field($model, 'material_cost') ?>

    <?php // echo $form->field($model, 'tax') ?>

    <?php // echo $form->field($model, 'total_charge') ?>

    <?php // echo $form->field($model, 'customer_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
