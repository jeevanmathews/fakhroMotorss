<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\AutoForm;


/* @var $this yii\web\View */
/* @var $model backend\models\suppliergroup */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = AutoForm::begin(["id" => "suppliergroup-".time().(($model->isNewRecord)?"create":"update")."-form"]); ?>
 <div class="box-body">
    <div class="row">           
        <div class="col-md-5 col-md-offset-3"> 

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([ '0' => 'Disable', '1' => 'Enable', ], ['prompt' => '']) ?> 
   </div>
  </div>
</div>
    <div class="box-footer">

        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php AutoForm::end(); ?>


