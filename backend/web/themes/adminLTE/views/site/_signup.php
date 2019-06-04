<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;


$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-offset-2 col-md-8">
          <?= $form->field($user, 'username')->textInput(['maxlength' => true]) ?>
           <?= $form->field($user, 'email')->textInput(['maxlength' => true]) ?>
           <?= $form->field($user, 'password')->passwordInput() ?>
           <?= $form->field($user, 'confirmPassword')->passwordInput() ?>
           <?= Html::submitButton('Submit', ['class' => 'btn btn-primary pull-right', 'name' => 'signup']) ?> 
       </div>