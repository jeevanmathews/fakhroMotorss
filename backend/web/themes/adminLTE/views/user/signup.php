<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
   <section class="content-header">
      <h1>
        <?= Html::encode($this->title) ?>        
      </h1>
</section>

    <p>Please fill out the following fields to signup:</p>

   <div class="box-body">
        <div class="row">
            <div class="col-md-6"> 
            <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'branch_id')->dropDownList(
                    $branches, 
                    ['class' => 'form-control mb20', 'prompt'=>'Select Branch']);
                ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>
                <span style="display:none;color:red" id="emailUniqueerror">This email is already used</span>

                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'confirmPassword')->passwordInput() ?>
                 <span style="display:none;color:red" id="passwordcheck">Passwords do not match</span>
                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    </div>
</div>
<script>
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