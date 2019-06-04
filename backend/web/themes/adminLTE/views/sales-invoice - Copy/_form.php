<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SalesInvoice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sales-invoice-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'do_id')->textInput() ?>

    <?= $form->field($model, 'inv_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'inv_created_date')->textInput() ?>

    <?= $form->field($model, 'inv_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'inv_created_by')->textInput() ?>

    <?= $form->field($model, 'customer_id')->textInput() ?>

    <?= $form->field($model, 'subtotal')->textInput() ?>

    <?= $form->field($model, 'discount')->textInput() ?>

    <?= $form->field($model, 'total_tax')->textInput() ?>

    <?= $form->field($model, 'grand_total')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
