<?php

use yii\helpers\Html;
use common\components\AutoForm;
use yii\helpers\ArrayHelper;
use common\models\User;
use backend\models\ExtendedWarrantyType;
use backend\models\AmcType;
use backend\models\JobcardStatus;
use backend\models\Branches;
use backend\models\ServiceType;

/* @var $this yii\web\View */
/* @var $model backend\models\Jobcard */
/* @var $form yii\widgets\ActiveForm */
?>
<style type="text/css">
.autocomplete {
  /*the container must be positioned relative:*/
  position: relative;
  display: inline-block;
}
input {
  border: 1px solid transparent;
  background-color: #f1f1f1;
  padding: 10px; 
}
input[type=text] {
  background-color: #f1f1f1;
  width: 100%;
}
input[type=submit] {
  background-color: DodgerBlue;
  color: #fff;
}
.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}
.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}
.autocomplete-items div:hover {
  /*when hovering an item:*/
  background-color: #e9e9e9; 
}
.autocomplete-active {
  /*when navigating through the items using the arrow keys:*/
  background-color: DodgerBlue !important; 
  color: #ffffff; 
}
</style>
<?php $form = AutoForm::begin(); ?>
    <div class="box-body">

        <div class="row"> 
            <div class="col-md-12">
                <h5 class="heading"><span>Vehicle Details</span> </h5>
                <div class="col-md-6">
                    <?= $form->field($vehicle, 'make')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($vehicle, 'model')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($vehicle, 'color')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'meter_reading')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'fuel_level')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($vehicle, 'reg_num')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($vehicle, 'chasis_num')->textInput(['maxlength' => true]) ?>                                        
                </div>
             
            </div>
        </div>



        </div>
    <!-- /.box-body -->  
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
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
    });

    var countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla"];
    autocomplete(document.getElementById("jobcardvehicle-reg_num"), countries);
    
    document.addEventListener("click", function (e) {
       console.log($(this).prev("input").val())
    });

</script>

