<?php

use yii\helpers\Html;
use common\components\AutoForm;
use yii\helpers\Arrayhelper;
use backend\models\Departments;
use backend\models\Designations;
use backend\models\Roles;
use backend\models\Branches;
/* @var $this yii\web\View */
/* @var $model backend\models\Branches */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = AutoForm::begin(["id" => "employees-".time().(($model->isNewRecord)?"create":"update")."-form"]); ?>
<div class="box-body">
    <div class="row">
        <div class="col-md-12">
            <div class="row outer_div">
                <div class="col-md-6">  

                    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'date_of_joining')->textInput(['maxlength' => true, 'class' => "form-control datepicker"]) ?>

                    <?= $form->field($model, 'date_of_birth')->textInput(['maxlength' => true, 'class' => "form-control datepicker"]) ?>


                </div>
                <div class="col-md-6">  


                  
                    
                    <!--<?= $form->field($model, 'login')->textInput() ?>-->
                    <?php if($type=='create'){ ?> 
                    <?= $form->field($model, 'login')->dropDownList([0 => 'No',1 => 'Yes' ],['class'=>'form-control login_enabled']) ?>                  
                    <?php } ?>
                     <?php if($type=='update' && $model->login==1){ ?>
                        <div class="">
                            <?= $form->field($model->user, 'role_id', ['inputOptions' => ["class" => "form-control roleselect select2"]])->dropDownList(ArrayHelper::map(Roles::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Select Role"]) ?>

                            <?= $form->field($model->user, 'branch_id', ['inputOptions' => ["class" => "form-control branchselect select2"]])->dropDownList(ArrayHelper::map(Branches::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Select Branch"]) ?>                        
                            <?= $form->field($model, 'designation_id', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(Designations::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Select Designation"]) ?>
                            <span style="display:none;color:red" id="passwordcheck">Passwords do not match</span>
                        </div>
                     <?php } else{?>

                        <div class="login_div">
                            
                            <?= $form->field($model1, 'role_id', ['inputOptions' => ["class" => "form-control roleselect select2"]])->dropDownList(ArrayHelper::map(Roles::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Select Role"]) ?>
                            <?= $form->field($model1, 'branch_id', ['inputOptions' => ["class" => "form-control branchselect select2"]])->dropDownList(ArrayHelper::map(Branches::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Select Branch"]) ?>

                            <?= $form->field($model, 'designation_id', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(Designations::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Select Designation"]) ?>

                            <?= $form->field($model1, 'username')->textInput(['autofocus' => true]) ?>
                            <?= $form->field($model1, 'password')->passwordInput() ?>
                            <?= $form->field($model1, 'confirmPassword')->passwordInput() ?>
                            <span style="display:none;color:red" id="passwordcheck">Passwords do not match</span>
                        </div>
                        <?php } ?>
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
    $('body').on('click','.login_enabled',function(){
        var login=$(this).val();
        if(login==1){
            $('.login_div').removeClass('no-display');
            $('.roleselect').parent().find('.select2-container').css('width','100%');
            $('.branchselect').parent().find('.select2-container').css('width','100%');
        }else{
            $('.login_div').addClass('no-display');
        }
    });
    $('#signupform-email').on('focusout',function(){
    var email=$('#signupform-email').val();
    if(email!=''){
        $.ajax({
            type:'post',
            data:{email:email},
            url:'<?=Yii::$app->getUrlManager()->createUrl(['user/uniqueemail'])?>',
            success:function(data){
                if(data==1){
                    $('#emailUniqueerror').show();
                }else{
                    $('#emailUniqueerror').hide();
                }
            }
        });
    }
});
$('#signupform-confirmpassword , #signupform-confirmpassword').on('focusout',function(){
    var password=$('#signupform-password').val();
    var confirmpassword=$('#signupform-confirmpassword').val();
    if(password!='' && confirmpassword!='' ){
       if(password==confirmpassword){
            $('#passwordcheck').hide();
       }else{
             $('#passwordcheck').show();
       }
    }
});
    </script>