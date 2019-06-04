<?php

/* @var $this \yii\web\View */
/* @var $content string */
 
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition box-login-page">
<?php $this->beginBody() ?>
<?= Alert::widget() ?>
<div class="box_login">
  <div class="login-logo">
    <b>Motor Methods Admin</b>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
     <?= $content ?> 
  </div>
  <!-- /.login-box-body -->
  <footer class="box-login-footer navbar-fixed-bottom">
    <p>Copyright © 2019 Motor Methods, All rights reserved</p>
  </footer>
</div>
<!-- /.login-box -->
        <?php $this->endBody() ?>
        <script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
<?php $this->endPage() ?>
