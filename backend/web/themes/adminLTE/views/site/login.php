<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
   

    <div class="row">
        <div class="col-md-8 col-sm-8 col-xs-12">
            <figure>
                <img class="img-responsive" src="themes/adminLTE/images/left-banner.jpg" alt="">
            </figure>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
             <h2><?= Html::encode($this->title) ?></h2>

             <p>Please fill out the following fields to login:</p>

            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox(['class'=>'styled-checkbox','template' => "<label>{input}<span>{labelTitle}</span>{hint}{error}</label>"]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>


