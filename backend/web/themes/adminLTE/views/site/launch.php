<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\widgets\Alert;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="launch-screen">
 <div class="container container-body">
<div class="tab">
  <button class="tablinks">STEP 1 : SET UP</button>
  <button class="tablinks active">STEP 2 : CONFIGURE COMPANY</button>
  <button class="tablinks signup">STEP 3 : CREATE COMPANY ADMIN</button> 
</div>
 <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
<div id="conf" class="tabcontent first_tab">
  <h2 class="heading text-center">Configure Company</h2>
  <div class="row">
       <div class="col-md-offset-2 col-md-8">
          <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
           <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
           <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
           <?= $form->field($model, 'address')->textArea(['maxlength' => true]) ?>
           <?= Html::submitButton('Next', ['class' => 'btn btn-primary pull-right', 'name' => 'createCompany']) ?> 
       </div>                                    
  </div>
</div>

<div id="signup" class="tabcontent signup">
<?= Alert::widget() ?>
  <h2 class="heading text-center">CREATE COMPANY ADMIN</h2>
  <div class="row">
   <?php
    if($screen == "signup"){
        echo $this->render('_signup', [
            'user' => $user,
            'form' => $form 
        ]);
    }
   ?>                                    
  </div>
</div>
</div>
</div>
<?php ActiveForm::end(); ?>
<script type="text/javascript">
$(".tabcontent").css("display", "none");
var screen = "<?php echo $screen?>";
if(screen == "")
    $(".first_tab").css("display", "block");
else{
    $(".tablinks").removeClass("active");
    $("."+screen).addClass("active");
    $("#"+screen).css("display", "block");
}
</script>
