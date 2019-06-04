<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Itemtype;
use common\components\AutoForm;
/* @var $this yii\web\View */
/* @var $model backend\models\Itemtype */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="itemtype-form">

    <?php $form = AutoForm::begin(); ?>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="row"> 
                    <div class="col-md-6">  
                         <?= $form->field($model, 'group_id')->dropDownList(
                            $itemtypes=ArrayHelper::map(Itemtype::find()->all(), 'id', 'name'),
                            ['class' => 'form-control select2', 'prompt'=>'New type']);
                            ?>
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                       
                    </div>
                    <div class="col-md-6">  
                        <?= $form->field($model, 'quantity_added')->dropDownList([ 'yes' => 'Yes', 'no' => 'No', ], ['prompt' => '']) ?>

                        <?= $form->field($model, 'set_tax')->dropDownList([ 'yes' => 'Yes', 'no' => 'No', ], ['prompt' => '']) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="box-footer">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php AutoForm::end(); ?>

    </div>
