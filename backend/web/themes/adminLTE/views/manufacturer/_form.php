<?php

use yii\helpers\Html;
use common\components\AutoForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Manufacturer */
/* @var $form yii\widgets\ActiveForm */
?>

    <?php $form = AutoForm::begin(["id" => "manufacturer-".time().(($model->isNewRecord)?"create":"update")."-form"]); ?>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">               
                <div class="row">
                    <div class="col-md-6">  

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>

                    </div>
                    <div class="col-md-6">   

                    <?= $form->field($model, 'imageFile')->fileInput(['accept' => 'image/*']) ?>

                    <?= $form->field($model, 'status')->dropDownList([ '0' => 'Disable', '1' => 'Enable', ], ['prompt' => '']) ?>                        
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


