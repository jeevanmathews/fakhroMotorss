<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SalesInvoiceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sales-invoice-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'do_id') ?>

    <?= $form->field($model, 'inv_number') ?>

    <?= $form->field($model, 'inv_created_date') ?>

    <?= $form->field($model, 'inv_date') ?>

    <?php // echo $form->field($model, 'inv_created_by') ?>

    <?php // echo $form->field($model, 'customer_id') ?>

    <?php // echo $form->field($model, 'subtotal') ?>

    <?php // echo $form->field($model, 'discount') ?>

    <?php // echo $form->field($model, 'total_tax') ?>

    <?php // echo $form->field($model, 'grand_total') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
