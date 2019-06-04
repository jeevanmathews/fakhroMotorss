<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box-body">
        <div class="row">
            <div class="col-md-6"> 
    <?= $form->field($model, 'username')->textInput() ?>
     <?= $form->field($model, 'branch_id')->dropDownList(
                    $branches, 
                    ['class' => 'form-control mb20', 'prompt'=>'Select Branch']);
                ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    </div>
    </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
