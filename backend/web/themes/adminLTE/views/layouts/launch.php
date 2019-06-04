<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);

$this->registerJsFile($this->theme->getUrl('/js/common.js'),['position' => \yii\web\View::POS_END]);
$jsUrl = Yii::$app->getUrlManager()->createUrl(['common/validate-entry']);
$js = <<< JS
var jsUrl = '$jsUrl' ;
JS;
$this->registerJs($js, \yii\web\View::POS_HEAD);

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
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <link rel="apple-touch-icon" sizes="57x57" href="<?=$this->theme->getUrl('images/favicons/apple-icon-57x57.png')?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?=$this->theme->getUrl('images/favicons/apple-icon-60x60.png')?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?=$this->theme->getUrl('images/favicons/apple-icon-72x72.png')?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?=$this->theme->getUrl('images/favicons/apple-icon-76x76.png')?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?=$this->theme->getUrl('images/favicons/apple-icon-114x114.png')?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?=$this->theme->getUrl('images/favicons/apple-icon-120x120.png')?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?=$this->theme->getUrl('images/favicons/apple-icon-144x144.png')?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?=$this->theme->getUrl('images/favicons/apple-icon-152x152.png')?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=$this->theme->getUrl('images/favicons/apple-icon-180x180.png')?>">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?=$this->theme->getUrl('images/favicons/android-icon-192x192.png')?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=$this->theme->getUrl('images/favicons/favicon-32x32.png')?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?=$this->theme->getUrl('images/favicons/favicon-96x96.png')?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=$this->theme->getUrl('images/favicons/favicon-16x16.png')?>">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
</head>
<?php $this->beginBody() ?>

<body>
  <header class="">
      <nav class="navbar navbar-inverse">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                        
              </button>
              <a class="navbar-brand" href="<?=Yii::$app->getUrlManager()->createUrl(['site/dashboard'])?>"><img src="themes/adminLTE/images/logo.png" class="img-responsive" /></a>
            </div>
     
          </div>
        </nav>
    </header>
  <?= $content ?>
  <footer class="copyright-wrapper">
      <div class="container-fluid">
          <div class="row">
              <div class="col-sm-12">
                  <p class="text-center">Copyright © 2019 Dragon Auto. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    
    <script type="text/javascript">
      $(document).ready(function(){
       $('meta[name="viewport"]').prop('content', 'width=2000');
    });

    $(document).ready(function(){
      $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
        event.preventDefault(); 
        event.stopPropagation(); 
        $(this).parent().siblings().removeClass('open');
        $(this).parent().toggleClass('open');
      });
    });
  </script>
    
</body>
<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>
