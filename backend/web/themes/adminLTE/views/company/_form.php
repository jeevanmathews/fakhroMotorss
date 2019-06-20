<?php

use yii\helpers\Html;
use common\components\AutoForm;
use yii\helpers\ArrayHelper;
use backend\models\Country;
use backend\models\Currency;

/* @var $this yii\web\View */
/* @var $model backend\models\Company */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = AutoForm::begin(["id" => "company-".time().(($model->isNewRecord)?"create":"update")."-form"]); ?>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
            <h5 class="heading"><span>Company Details</span> </h5>
            <div class="row">
                <div class="col-md-6">  

                      <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'template' => '']) ?>                      

                      <?= $form->field($model, 'cr_number')->textInput(['maxlength' => true]) ?>
                      <?= $form->field($model, 'cr_expiry')->textInput(['maxlength' => true, 'class' => "form-control datepicker"]) ?>

                      <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>  
                      <?= $form->field($model, 'multi_branches')->dropDownList([ 'yes' => 'Yes', 'no' => 'No', ], ['prompt' => '']) ?>

                      <?= $form->field($model, 'centrilized_warehouse')->dropDownList([ 'yes' => 'Yes', 'no' => 'No', ], ['prompt' => '']) ?>
                      
              </div>
              <div class="col-md-6">

                      <?= $form->field($model, 'country_id', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(Country::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Select Country"]) ?>                

                      <?= $form->field($model, 'state')->dropDownList(['' => 'Select','Manama' => 'Manama', 'Riffa' => 'Riffa', 'Muharraq' => 'Muharraq', 'Hamad Town' => 'Hamad Town', 'A\'ali' => 'A\'ali', 'Isa Town' => 'Isa Town', 'Sitra' => 'Sitra', 'Budaiya' => 'Budaiya', 'Jidhafs' => 'Jidhafs', 'Al-Malikiyah' => 'Al-Malikiyah']) ?> 
                      <?= $form->field($model, 'address')->textarea(['rows' => 4]) ?>

                      <?= $form->field($model, 'zipcode')->textInput(['maxlength' => true]) ?>  

              </div>
            </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
            <h5 class="heading"><span>Contact Details</span> </h5>
            <div class="row">
              <div class="col-md-6">  
                      <?= $form->field($model, 'mailing_name')->textInput(['maxlength' => true]) ?>
                      <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>                   
              </div>
              <div class="col-md-6"> 
                      <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                      <?= $form->field($model, 'fax')->textInput(['maxlength' => true]) ?>
              </div>
            </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
            <h5 class="heading"><span>Accounts Details</span> </h5>
            <div class="row">
              <div class="col-md-6">                        

                      <?= $form->field($model, 'vat_number')->textInput(['maxlength' => true]) ?>

                      <?= $form->field($model, 'vat_expiry')->textInput(['maxlength' => true, 'class' => "form-control datepicker"]) ?>

                      <?= $form->field($model, 'vat_format')->radioList(["inclusive" => 'Inclusive (Apply VAT to each item cost)', "exclusive" => 'Exclusive (Apply VAT to final cost)'])->label('Work Part Time'); ?> 

                      <?= $form->field($model, 'vat_rate')->textInput(['maxlength' => true]) ?> 

                      <?= $form->field($model->settings, 'financial_year')->textInput(['maxlength' => true, 'class' => "form-control datepicker"]) ?>
                     
                      <?= $form->field($model->settings, 'books_beginning')->textInput(['maxlength' => true, 'class' => "form-control datepicker"]) ?>

                      <?= $form->field($model->settings, 'suffix_symbol')->dropDownList([ 'yes' => 'Yes', 'no' => 'No']) ?>              
              </div>
              <div class="col-md-6"> 
                       <?= $form->field($model->settings, 'currency_id', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(Currency::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Select Currency"]) ?>                     

                      <?= $form->field($model->settings, 'decimal_places')->textInput(['maxlength' => true]) ?>

                      <?= $form->field($model->settings, 'enable_space')->dropDownList([ 'yes' => 'Yes', 'no' => 'No', ], ['prompt' => '']) ?>

                       <?= $form->field($model->settings, 'date_format')->dropDownList([ 'd/m/Y' => 'd/m/Y','d-m-Y' => 'd-m-Y', 'Y-m-d' => 'Y-m-d', 'm-d-Y' => 'm-d-Y'], ['prompt' => '']) ?>                     
					   <?= $form->field($model, 'imageFile')->fileInput(['accept' => 'image/*']) ?>

              </div>
            </div>
            </div>
        </div>
    </div>
<!-- /.box-body -->  
   <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
   </div>
              <!-- /.box-footer -->


    <?php AutoForm::end(); ?>

<script type="text/javascript">
     $( function() {
    $( ".datepicker" ).datepicker({
      defaultDate: new Date(),
      dateFormat: "dd/mm/yy",
      changeMonth: true,
      changeYear: true,
      yearRange: "1930:2030",
    });
  } );
</script>