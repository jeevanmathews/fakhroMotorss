<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\AutoForm;
/* @var $this yii\web\View */
/* @var $model backend\models\tasktype */
/* @var $form yii\widgets\ActiveForm */
?>

   <?php $form = AutoForm::begin(["id" => "tasktype-".time().(($model->isNewRecord)?"create":"update")."-form"]); ?>
 <div class="box-body">
    <div class="row">           
        <div class="col-md-5 col-md-offset-3"> 
    <?= $form->field($model, 'task_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    </div>
  </div>
</div>
    <div class="box-footer">

        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php AutoForm::end(); ?>
    


