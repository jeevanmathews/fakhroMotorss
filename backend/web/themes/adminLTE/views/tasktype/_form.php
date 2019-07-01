<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\tasktype */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tasktype-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'task_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
