<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PurchaserequestSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchase-request-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'pr_number') ?>

    <?= $form->field($model, 'requested_by') ?>

    <?= $form->field($model, 'supplier_id') ?>

    <?= $form->field($model, 'request_date') ?>

    <?php // echo $form->field($model, 'expected_date') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
