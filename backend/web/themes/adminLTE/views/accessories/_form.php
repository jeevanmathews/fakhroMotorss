<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\AutoForm;
use yii\helpers\ArrayHelper;
use backend\models\Itemtype;
use backend\models\Accessoriestype;
/* @var $this yii\web\View */
/* @var $model backend\models\Accessories */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="accessories-form">

    <?php $form = AutoForm::begin(); ?>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">  
                        <?= $form->field($model, 'accessories_type_id')->dropDownList(
                            $itemtypes=ArrayHelper::map(Accessoriestype::find()->all(), 'id', 'name'),
                            ['class' => 'form-control select2', 'prompt'=>'Select type']);
                        ?>
                       <!--  <?= $form->field($model, 'item_type_id')->dropDownList(
                            $itemtypes=ArrayHelper::map(Itemtype::find()->all(), 'id', 'name'),
                            ['class' => 'form-control select2', 'prompt'=>'Select type']);
                        ?> -->
                           <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>                   
                    </div>
                    <div class="col-md-6">  
                        
                        <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
						<?= $form->field($model, 'rate')->textInput(['maxlength' => true]) ?>

                    </div>
                    <div class="col-md-12">  
                        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
                    </div>
					<div class="col-md-6">
					<?php if($model->tax_enabled == 'yes'){ ?>
					 <?= $form->field($model, 'tax_enabled')->checkbox(['class'=>'tax_enabled','checked' => 'checked']); ?>
					 
                         <span class="rate"><?= $form->field($model, 'tax_rate')->textInput(); ?></span>
					<?php 
					}
					else{
						?>
						 <?= $form->field($model, 'tax_enabled')->checkbox(['class'=>'tax_enabled']); ?>
					 
                         <span class="rate no-display"><?= $form->field($model, 'tax_rate')->textInput(); ?></span>
					<?php
					}
					?>
					</div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php AutoForm::end(); ?>

</div>
<script>
  $('body').on('click','.tax_enabled',function(){
        if($(this).is(':checked')){
            $('.rate').removeClass('no-display');
        } else{
            $('.rate').addClass('no-display');
        }
    });
</script>