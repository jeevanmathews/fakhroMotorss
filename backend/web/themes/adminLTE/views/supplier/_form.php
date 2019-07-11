<?php

use yii\helpers\Html;
use common\components\AutoForm;
use backend\models\suppliergroup;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Supplier */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = AutoForm::begin(["id" => "supplier-".time().(($model->isNewRecord)?"create":"update")."-form"]); ?>
<div class="box-body">
    <div class="row">
    <div class="col-md-12"> 
    <div class="row">
        <div class="col-md-6"> 
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'vat_number')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'supplier_groupid')->dropDownList(ArrayHelper::map(SupplierGroup::find()->where(['status' => 1])->all(), 'id', 'name')) ?>
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


