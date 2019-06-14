<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\AutoForm;
use yii\helpers\ArrayHelper;
use backend\models\Itemtype;
use backend\models\Sparetypes;
use backend\models\Itemgroup;
use backend\models\Sparegroup;
/* @var $this yii\web\View */
/* @var $model backend\models\Spareparts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="spareparts-form">

    <?php $form = AutoForm::begin(["id" => "spareparts-".time().(($model->isNewRecord)?"create":"update")."-form"]); ?>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6" id="itemlists"> 
                    <?php $Item = ArrayHelper::map(Itemgroup::find()->where(['parent_id' =>0,'type'=>'spares'])->all(), 'id', 'category_name');?>
                    <div class="form-group mb-20 parent_id">
                      <div class="input-group">
                            <div class="input-group-addon">Group</div>
                            <?=Html::dropDownList('parent_id[]','',
                             $Item ,
                            ['prompt' => 'Select Type','class' => 'form-control select2 type', 

                            'onchange'=>'$(this).parent().parent().nextAll(".parent_id").remove(); if( $(this).val()== "add_new"){ $("[name=\'category_name\']").removeClass("hide");} else{
                            $.get( "'.Yii::$app->getUrlManager()->createUrl('spareparts/lists').'&parent_id="+$(this).val(), function( data ) {
                            $("[name=\'category_name\']").remove();     
                            $("[id=\'spareparts-itemgroup_id\']").parent().remove();     
                            $("div#itemlists").append(data);
                            $("#hidden-field").css("visibility","hidden");
                            });
                            }
                            '])?>
                        </div>
                    </div>

                    <?php if(!$model->isNewRecord && $model->itemgroup_id!=''): ?>
                        <?= $form->field($model, 'itemgroup_id')->dropDownList(
                            $itemtypes=ArrayHelper::map(Sparegroup::find()->where(['type'=>'spares'])->all(), 'id', 'category_name'),
                            ['class' => 'form-control select2', 'prompt'=>'Select type','disabled'=>true]);
                        ?>
                     <?php endif;?>   

                      <!--   <?= $form->field($model, 'spare_type_id')->dropDownList(
                            $itemtypes=ArrayHelper::map(Sparetypes::find()->all(), 'id', 'name'),
                            ['class' => 'form-control select2', 'prompt'=>'Select type']);
                        ?>
                        <?= $form->field($model, 'item_type_id')->dropDownList(
                            $itemtypes=ArrayHelper::map(Itemtype::find()->all(), 'id', 'name'),
                            ['class' => 'form-control select2', 'prompt'=>'Select type']);
                        ?> -->
                                        
                    </div>
                    <div class="col-md-6">  
                       <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>       
                        <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
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
