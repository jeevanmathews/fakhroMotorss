<?php

use yii\helpers\Html;
use common\components\AutoForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Currency */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = AutoForm::begin(); ?>
<div class="box-body">
    <div class="row">           
        <div class="col-md-5 col-md-offset-3"> 
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'symbol')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'decimal_symbol')->textInput(['maxlength' => true]) ?>
     </div>
    </div>
</div>
<!-- /.box-body -->  
<div class="box-footer">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>
<?php AutoForm::end(); ?>
