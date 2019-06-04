<?php

use yii\helpers\Html;
use common\components\AutoForm;
use backend\models\Country;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Branches */
/* @var $form yii\widgets\ActiveForm */
?>

    <?php $form = AutoForm::begin(); ?>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <h5 class="heading"><span>Branch Details</span> </h5>
                <div class="row">
                    <div class="col-md-6">  

                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'mailing_name')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>
                    </div>
                    <div class="col-md-6">     
                       <?= $form->field($model, 'country_id')->dropDownList(
                         ArrayHelper::map(Country::find()->all(), 'id', 'name'), 
                        ['class' => 'form-control mb20','prompt'=>'Select Country']);
                        ?>
						

                        <?= $form->field($model, 'state')->dropDownList(['' => 'Select','Manama' => 'Manama', 'Riffa' => 'Riffa', 'Muharraq' => 'Muharraq', 'Hamad Town' => 'Hamad Town', 'A\'ali' => 'A\'ali', 'Isa Town' => 'Isa Town', 'Sitra' => 'Sitra', 'Budaiya' => 'Budaiya', 'Jidhafs' => 'Jidhafs', 'Al-Malikiyah' => 'Al-Malikiyah']) ?> 

                        <?= $form->field($model, 'zipcode')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

                        

                        <?= $form->field($model, 'fax')->textInput(['maxlength' => true]) ?>


                    </div>
					<div class="col-md-6">
					<?= $form->field($model, 'imageFile')->fileInput(['accept' => 'image/*']) ?>
					</div>
                    <div class="col-md-6">
                    <h5 class="heading"><span>Branch Type</span> </h5>
                        <?php
                            if(!$model->isNewRecord) {
                            $checkedList = explode(',',$model->branchtype_id); //get selected value from db if value exist
                            $model->branchtype_id = $checkedList;
                            }
                        ?>
                       <?= $form->field($model, 'branchtype_id')->checkboxList($branchtypes,
                            [
                            'item'  =>  function ($index, $label, $name, $checked, $value)
                                { 
                                return "<label><input type='checkbox' class='styled-checkbox' name= $name value='$value' ".(($checked)? "checked='$checked'":'')." /><span>$label</span></label>";
                                }
                            ])->label(false)?>
                       <?= $form->field($model, 'company_id')->hiddenInput(['value'=>$company])->label(false) ?>
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

