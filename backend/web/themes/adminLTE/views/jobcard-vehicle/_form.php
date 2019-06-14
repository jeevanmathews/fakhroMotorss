<?php

use yii\helpers\Html;
use common\components\AutoForm;
use backend\models\Manufacturer;
use backend\models\Make;
use backend\models\Customer;
use backend\models\CarModel;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\JobcardVehicle */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = AutoForm::begin(["id" => "jobcard-vehicle-".time().(($model->isNewRecord)?"create":"update")."-form"]); ?>

<div class="box-body">
    <div class="row"> 
        <div class="col-md-6">
        <?= $form->field($model, 'reg_num')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'chasis_num')->textInput(['maxlength' => true]) ?>

        <?php if($model->make) $model->manufacturer = $model->make->manufacturer->id;?>

        <?=$form->field($model, 'manufacturer')->dropDownList(
                ArrayHelper::map(Manufacturer::find()->all(), 'id', 'name'),
                 ['prompt' => 'Select Type','class' => 'form-control select2 type', 
                
            'onchange'=>'
                $.get( "'.Yii::$app->getUrlManager()->createUrl('car-model/makes').'&manufacturer_id="+$(this).val(), function( data ) {
                $( "#jobcardvehicle-make_id" ).html(data);
           });
            ']);?>

        <?=$form->field($model, 'make_id')->dropDownList(
                (($model->make)?ArrayHelper::map(Make::find()->where(['manufacturer_id' => $model->manufacturer])->all(), 'id', 'make'):[]),
                 ['prompt' => 'Select Type','class' => 'form-control select2 type', 
                
            'onchange'=>'
                $.get( "'.Yii::$app->getUrlManager()->createUrl('car-model/models').'&make_id="+$(this).val(), function( data ) {
                $( "#jobcardvehicle-model_id" ).html(data);
           });
            ']);?>

        <?= $form->field($model, 'model_id')->dropDownList(($model->model)?ArrayHelper::map(CarModel::find()->where(['make_id' => $model->make_id])->all(), 'id', 'model'):[]) ?>


        <?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'customer_id')->dropDownList(ArrayHelper::map(Customer::find()->where(['status' => 1])->all(), 'id', 'name'), ['prompt' => 'Select Type']) ?>

        <?= $form->field($model, 'tr_number')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'amc_type')->textInput() ?>

        <?= $form->field($model, 'amc_expiry_date')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'extended_warranty_type')->textInput() ?>

        <?= $form->field($model, 'ew_expiry_kms')->textInput() ?>

        <?= $form->field($model, 'ew_expiry_date')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'service_schedule')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
</div>
<!-- /.box-body -->  
<div class="box-footer">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php AutoForm::end(); ?>
