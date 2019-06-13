<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\AutoForm;
use yii\helpers\ArrayHelper;
use backend\models\Itemtype;
use backend\models\Accessoriestype;
use backend\models\Itemgroup;
/* @var $this yii\web\View */
/* @var $model backend\models\Accessories */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="accessories-view main-body" id="accessories_view">
<div class="accessories-form">

    <?php $form = AutoForm::begin(["id" => "accessories-".time().(($model->isNewRecord)?"create":"update")."-form"]); ?>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6"> 
                    <?= $Item = ArrayHelper::map(Accessoriestype::find()->all(), 'id', 'name');?>
                    <?= $form->field($model,'itemgroup_id', ['inputOptions' => ["class" => "select_po form-control select2"]])->dropDownList(ArrayHelper::map(Purchaseorder::find()->where(["status" => 1])->andWhere(['!=', 'process_status', 'completed'])->all(), 'id', 'po_number'), ["prompt" => "Select PO"]) ?>
                    <?=Html::dropDownList('itemgroup_id[]','',
                        ['add_new' =>'Add New']. $Item ,
                        ['prompt' => 'Select Type','class' => 'form-control select2 type', 

                        'onchange'=>'if( $(this).val()== "add_new"){ $("[name=\'category_name\']").removeClass("hide");} else{
                        $.get( "'.Yii::$app->getUrlManager()->createUrl('itemgroup/lists').'&parent_id="+$(this).val(), function( data ) {
                        $("[name=\'category_name\']").remove();     
                        $("div#itemlists").append(data);
                        $("#hidden-field").css("visibility","hidden");
                        });
                        }
                        '])?>
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
  $(document).find('.select2').select2();
</script>
</div>