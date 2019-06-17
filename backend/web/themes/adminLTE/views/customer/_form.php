<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\AutoForm;

/* @var $this yii\web\View */
/* @var $model backend\models\customer */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = AutoForm::begin(["id" => "customer-".time().(($model->isNewRecord)?"create":"update")."-form"]); ?>
  <div class="box-body">
     <div class="row">
         <div class="col-md-12">
           <div class="row">
             <div class="col-md-6"> 

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
	

    <?= $form->field($model, 'alt_phone')->textInput(['maxlength' => true]) ?>
	</div>
    <div class="col-md-12">  
    
	<?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>
</div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

     <?php AutoForm::end(); ?>


