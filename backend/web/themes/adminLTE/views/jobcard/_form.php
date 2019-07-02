<?php

use yii\helpers\Html;
use common\components\AutoForm;
use yii\helpers\ArrayHelper;
use backend\models\Employees;
use backend\models\ExtendedWarrantyType;
use backend\models\AmcType;
use backend\models\JobcardStatus;
use backend\models\Branches;
use backend\models\ServiceType;
use backend\models\Manufacturer;
use backend\models\Make;
use backend\models\CarModel;
use backend\models\Vehicletype;

/* @var $this yii\web\View */
/* @var $model backend\models\Jobcard */
/* @var $form yii\widgets\ActiveForm */

$time = time();

?>
<?php $form = AutoForm::begin(["id" => "jobcard-".time().(($model->isNewRecord)?"create":"update")."-form"]); ?>
    <div class="box-body">

        <div class="row"> 
            <div class="col-md-12">
                <h5 class="heading"><span>Vehicle Details</span> <span class="pull-right"> <?php echo html::button("Search Vehicle", ["class" => "btn btn-link", 'id' => 'search_vehicle_'.$time])?></span></h5>
                <div class="col-md-6"> 
                    <?=$form->field($vehicle, 'make_id')->dropDownList(
                            ArrayHelper::map(Manufacturer::find()->all(), 'id', 'name'),
                             ['prompt' => 'Select Type','class' => 'form-control select2 type', 
                            
                        'onchange'=>'
                            $.get( "'.Yii::$app->getUrlManager()->createUrl('car-model/models').'&make_id="+$(this).val(), function( data ) {
                            $(document).find(".main-body:visible").find( "#jobcardvehicle-model_id" ).html(data);
                       });
                        ']);?>

                    <?php /*=$form->field($vehicle, 'make_id')->dropDownList(
                            (($vehicle->make)?ArrayHelper::map(Make::find()->where(['manufacturer_id' => $vehicle->manufacturer])->all(), 'id', 'make'):[]),
                             ['prompt' => 'Select Type','class' => 'form-control select2 type', 
                            
                        'onchange'=>'
                            $.get( "'.Yii::$app->getUrlManager()->createUrl('car-model/models').'&make_id="+$(this).val(), function( data ) {
                                $(document).find(".main-body:visible").find( "#jobcardvehicle-model_id" ).html(data);
                       });
                        ']);*/?>

                    <?= $form->field($vehicle, 'model_id')->dropDownList(($vehicle->model)?ArrayHelper::map(CarModel::find()->where(['make_id' => $vehicle->make_id])->all(), 'id', 'model'):[]) ?>

                    <?= $form->field($vehicle, 'vehicle_type')->dropDownList(ArrayHelper::map(Vehicletype::find()->where(['status' => 1])->all(), 'id', 'name')) ?>

                    <?= $form->field($vehicle, 'color')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'meter_reading')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'fuel_level', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(['low' => 'Low', 'medium' => 'Medium', 'High' => 'High'], ["prompt" => "Fuel Level"]) ?>

                    <?= $form->field($vehicle, 'reg_num')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($vehicle, 'chasis_num')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($vehicle, 'lpo_num')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6"> 
                    <?= $form->field($vehicle, 'vin')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($vehicle, 'wo_num')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($vehicle, 'amc_type', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(AmcType::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "AMC Type"]) ?>

                    <?= $form->field($vehicle, 'amc_expiry_date')->textInput(['maxlength' => true, 'class' => "form-control datepicker"]) ?>

                    <?= $form->field($vehicle, 'extended_warranty_type', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(ExtendedWarrantyType::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Extended Warranty Type"]) ?>

                    <?= $form->field($vehicle, 'ew_expiry_date')->textInput(['maxlength' => true, 'class' => "form-control datepicker"]) ?>

                    <?= $form->field($vehicle, 'ew_expiry_kms')->textInput(['maxlength' => true]) ?>

                     <?= $form->field($vehicle, 'service_schedule')->textInput(['maxlength' => true, 'class' => "form-control datepicker"]) ?>

                </div>                
            </div>
        </div>

        <div class="row"> 
            <div class="col-md-12">
                 <h5 class="heading"><span>Jobcard Details</span> </h5>
                <div class="col-md-6">  
                    <?= $form->field($model, 'branch_id', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(Branches::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Select Branch"]) ?>

                    <?= $form->field($model, 'service_advisor', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(Employees::find()->where(["status" => 1, "designation_id" => 2, "branch_id" => Yii::$app->user->identity->branch_id])->all(), 'id', 'fullname'), ["prompt" => "Service Advisor"]) ?>

                    <?= $form->field($model, 'service_manager', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(Employees::find()->where(["status" => 1, "designation_id" => 1, "branch_id" => Yii::$app->user->identity->branch_id])->all(), 'id', 'fullname'), ["prompt" => "Service Manager"]) ?>

                    <?= $form->field($model, 'tested_by', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(Employees::find()->where(["status" => 1, "designation_id" => 3, "branch_id" => Yii::$app->user->identity->branch_id])->all(), 'id', 'fullname'), ["prompt" => "Vehicle Tested By"]) ?> 

                    <?= $form->field($model, 'service_type', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(ServiceType::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Service Type"]) ?> 
                    
                    <?= $form->field($model, 'status', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(JobcardStatus::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Jobcard Status"]) ?>
                </div>

                <div class="col-md-6">

                    <?= $form->field($model, 'next_service_type', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(ServiceType::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Service Type"]) ?> 

                    <?= $form->field($model, 'promised_date')->textInput(['maxlength' => true, 'class' => "form-control"]) ?>

                    <?= $form->field($model, 'advance_paid')->textInput() ?>

                    <?= $form->field($model, 'receipt_num')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'comment')->textarea(['rows' => 4]) ?>
                </div>
            </div>
        </div>


            <div class="row"> 
            <div class="col-md-12">
                <h5 class="heading">
                <span>Customer Details</span> 
                <span class="pull-right"> <?php echo html::button("Search Customer", ["class" => "btn btn-link", 'id' => 'search_customer_'.$time])?></span></h5>
                <div class="col-md-6">

                   <?= $form->field($customer, 'name')->textInput() ?>

                    <?= $form->field($customer, 'contact_name')->textInput() ?>

                    <?= $form->field($customer, 'contact_number')->textInput() ?>
                </div>

                <div class="col-md-6">                    

                    <?= $form->field($customer, 'alt_phone')->textInput() ?>

                    <?= $form->field($customer, 'email')->textInput() ?>   

                    <?= $form->field($customer, 'address')->textarea(['rows' => 4]) ?>            

                </div>
            </div>
            </div>

        </div>
    <!-- /.box-body -->  
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
<?php AutoForm::end(); ?>

<div class="modal" id="search-info-<?php echo $time;?>">
 
</div>

<script type="text/javascript">
    $( function() {
    $( ".datepicker" ).datepicker({
      defaultDate: new Date(),
      dateFormat: "dd/mm/yy",
      changeMonth: true,
      changeYear: true,
      yearRange: "1930:2030",
    });
    });

    $(function() {
      $('#jobcard-promised_date').daterangepicker({
        singleDatePicker: true,
        timePicker: true,
        showDropdowns: true,
        minYear: 1901,
        maxYear: 2100,
        locale: {
          format: 'YYYY/MM/DD hh:mm A'
        }
      });
    });
</script>
