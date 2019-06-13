<?php

use yii\helpers\Html;
use common\components\AutoForm;
use backend\models\Manufacturer;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Make */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="make-form">

	<?php $form = AutoForm::begin(["id" => "make-".time().(($model->isNewRecord)?"create":"update")."-form"]); ?>


    <?= $form->field($model, 'manufacturer_id')->dropDownList(ArrayHelper::map(Manufacturer::find()->all(), 'id', 'name'),['class' => 'form-control mb20','prompt'=>'Select Manufacturer']); ?>

    <?= $form->field($model, 'make')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'status')->dropDownList([ '0' => 'Disable', '1' => 'Enable', ], ['prompt' => '']) ?> 
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php AutoForm::end(); ?>

</div>
