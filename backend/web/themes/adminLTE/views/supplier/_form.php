<?php

use yii\helpers\Html;
use common\components\AutoForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Supplier */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = AutoForm::begin(); ?>
<div class="box-body">
    <div class="row">
    <div class="col-md-12"> 
    <div class="row">
        <div class="col-md-6"> 
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'vat_number')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6"> 
            <?= $form->field($model, 'address')->textarea(['rows' => 7]) ?>
         </div>
    </div>
   </div>
   </div>
</div>
<!-- /.box-body -->  
<div class="box-footer">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>
<?php AutoForm::end(); ?>


