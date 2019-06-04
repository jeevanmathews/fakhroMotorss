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

$this->registerJsFile($this->theme->getUrl('js/common.js'),['position' => \yii\web\View::POS_END]);
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
<body class="hold-transition skin-blue sidebar-mini">
<?php $this->beginBody() ?>

<div class="wrapper">

<header class="main-header">
    <!-- Logo -->
    <a href="<?=Yii::$app->homeUrl?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>TR</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Fakhro Motors</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <!--<li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>-->
                <!-- inner menu: contains the actual data -->
                <!--<ul class="menu">--><!-- start message -->
                  <!--<li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?=$this->theme->getUrl('images/avatar5.png');?>" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>-->
                  <!-- end message -->
                  <!--<li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?=$this->theme->getUrl('images/avatar5.png');?>" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        AdminLTE Design Team
                        <small><i class="fa fa-clock-o"></i> 2 hours</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>                 
                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li> -->
          <!-- Notifications: style can be found in dropdown.less -->         
              
                <!-- inner menu: contains the actual data -->            
             <?php //print_r(Yii::$app->user->identity->updates);exit;?> 
          <!-- Tasks:  -->
         
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?=$this->theme->getUrl('images/avatar5.png');?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?=Yii::$app->user->identity->username?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?=$this->theme->getUrl('images/avatar5.png');?>" class="img-circle" alt="User Image">

                <p>
                 Welcome <?=Yii::$app->user->identity->username?>                  
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">                 
                  <?= Html::a('Profile', ['admin/view', "id" => Yii::$app->user->identity->id], ['class' => 'btn btn-default btn-flat']) ?>    
                </div>
                <div class="pull-right">
                  <?php echo Html::beginForm(['/site/logout'], 'post');
                     echo Html::submitButton(
                        'Logout',['class' => 'btn btn-default btn-flat', 'name' => 'login-button']
                        );
                    echo Html::endForm();
                  ?>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
   <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?=$this->theme->getUrl('images/avatar5.png');?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?=Yii::$app->user->identity->username?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="active treeview">
          <a href="<?=Yii::$app->homeUrl?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>          
          </a>      
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-group"></i>
            <span>Manage Admin Users</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><?= Html::a('<i class="fa fa-circle-o"></i> Admin Users', ['/admin']) ?></li>
            <li><?= Html::a('<i class="fa fa-circle-o"></i> Add New', ['/admin/create']) ?> </li>
          </ul>
        </li>    

        <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i> <span>Manage Tourists</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><?= Html::a('<i class="fa fa-circle-o"></i> Tourists', ['/user', "user_type" => "tourist"]) ?></li>
            <li><?= Html::a('<i class="fa fa-circle-o"></i> Add New', ['user/create', "user_type" => "tourist"]) ?> </li>           
          </ul>
        </li>
       
        <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i> <span>Manage Hosts</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
           <li><?= Html::a('<i class="fa fa-circle-o"></i> Hosts', ['/user', "user_type" => "host"]) ?></li>
            <li><?= Html::a('<i class="fa fa-circle-o"></i> Add New', ['/user/create', "user_type" => "host"]) ?> </li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-shopping-cart"></i> <span>Manage Booking</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
           <li><?= Html::a('<i class="fa fa-circle-o"></i> Bookings', ['/booking']) ?></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-plus-circle"></i> <span>Manage Host Addons</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">         
             <li><?= Html::a('<i class="fa fa-circle-o"></i> Addons', ['/addon']) ?></li>
            <li><?= Html::a('<i class="fa fa-circle-o"></i> Add New', ['/addon/create']) ?> </li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-filter"></i> <span>Manage Tour Types</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">         
             <li><?= Html::a('<i class="fa fa-circle-o"></i> Tour Types', ['/tourtype']) ?></li>
            <li><?= Html::a('<i class="fa fa-circle-o"></i> Add New', ['/tourtype/create']) ?> </li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-map"></i> <span>Manage Countries</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">         
             <li><?= Html::a('<i class="fa fa-circle-o"></i> Countries', ['/country']) ?></li>
            <li><?= Html::a('<i class="fa fa-circle-o"></i> Add New', ['/country/create']) ?> </li>
          </ul>
        </li>  

         <li class="treeview">
          <a href="#">
            <i class="fa fa-location-arrow"></i> <span>Manage Locations</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">         
             <li><?= Html::a('<i class="fa fa-circle-o"></i> Locations', ['/location']) ?></li>
            <li><?= Html::a('<i class="fa fa-circle-o"></i> Add New', ['/location/create']) ?> </li>
          </ul>
        </li>        

         <li class="treeview">
          <a href="#">
            <i class="fa fa-language"></i> <span>Manage Languages</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">         
             <li><?= Html::a('<i class="fa fa-circle-o"></i> Languages', ['/language']) ?></li>
            <li><?= Html::a('<i class="fa fa-circle-o"></i> Add New', ['/language/create']) ?> </li>
          </ul>
        </li> 

        <li class="treeview">
          <a href="#">
            <i class="fa fa-folder-open"></i> <span>Manage Sections</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">         
             <li><?= Html::a('<i class="fa fa-circle-o"></i> Site Sections', ['/section']) ?></li>
            <li><?= Html::a('<i class="fa fa-circle-o"></i> Add New', ['/section/create']) ?> </li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-slideshare"></i> <span>Manage Site Gallery</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">         
             <li><?= Html::a('<i class="fa fa-circle-o"></i> Home Slide Show', ['/site/site-slides', 'section' => 1]) ?></li>
             <li><?= Html::a('<i class="fa fa-circle-o"></i> Tourist Signup - Slideshow', ['/site/site-slides', 'section' => 2]) ?></li>
             <li><?= Html::a('<i class="fa fa-circle-o"></i> Host Signup - Slideshow', ['/site/site-slides', 'section' => 3]) ?></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-wrench"></i> <span>Site Settings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">         
             <li><?= Html::a('<i class="fa fa-circle-o"></i> Settings', ['/settings']) ?></li>
          </ul>
        </li>


         <li class="treeview">
          <a href="#">
            <i class="fa fa-buysellads"></i> <span>Manage Coupon</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">         
             <li><?= Html::a('<i class="fa fa-circle-o"></i> Coupons', ['/coupon', "user_type" => "tourist"]) ?></li>
            <li><?= Html::a('<i class="fa fa-circle-o"></i> Add New', ['coupon/create']) ?> </li> 
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-buysellads"></i> <span>Manage Payment</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">         
             <li><?= Html::a('<i class="fa fa-circle-o"></i> Payment', ['/payment']) ?></li>
          </ul>
        </li>


        <li class="treeview">
          <a href="#">
            <i class="fa fa-sticky-note"></i> <span>CMS</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">         
             <li><?= Html::a('<i class="fa fa-circle-o"></i> CMS', ['/cms']) ?></li>
            <li><?= Html::a('<i class="fa fa-circle-o"></i> Add New', ['/cms/create']) ?> </li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-buysellads"></i> <span>Manage Advertisement</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">         
             <li><?= Html::a('<i class="fa fa-circle-o"></i> Ad Spaces', ['/admanager']) ?></li>
            <li><?= Html::a('<i class="fa fa-circle-o"></i> Add New Space', ['/admanager/create']) ?> </li>
            <li><?= Html::a('<i class="fa fa-circle-o"></i> Site Ads', ['/admanager/ads']) ?> </li>
            <li><?= Html::a('<i class="fa fa-circle-o"></i> Post New Ad', ['/admanager/post-ad']) ?> </li>
             <li><?= Html::a('<i class="fa fa-circle-o"></i> Ad Users', ['/aduser']) ?></li>
            <li><?= Html::a('<i class="fa fa-circle-o"></i> Ad Log', ['/admanager/adlog']) ?> </li>
          </ul>
        </li>


        <!--<li>
          <a href="#">
            <i class="fa fa-send"></i> <span>Interests</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-red">3</small>
              <small class="label pull-right bg-blue">17</small>
            </span>
          </a>
        </li>

         <li>
          <a href="#">
            <i class="fa fa-comments"></i> <span>Reviews</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-red">3</small>
              <small class="label pull-right bg-blue">17</small>
            </span>
          </a>
        </li>

        <li>
          <a href="#">
            <i class="fa fa-envelope"></i> <span>Mailbox</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-yellow">12</small>
              <small class="label pull-right bg-green">16</small>
              <small class="label pull-right bg-red">5</small>
            </span>
          </a>
        </li> 
        
       <!-- <li class="header">LABELS</li>
        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
        -->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    
    <!-- /.content -->
  </div>

   <footer class="main-footer">    
    <strong>Copyright &copy; 2014-2016 <a href="http://itvoyager.com">Voyager </a>.</strong> All rights
    reserved.
  </footer>
  <!-- /.content-wrapper -->
    <?php
   /* NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index'], 'options' => ["class" => 'treeview']],
        ['label' => 'Home', 'url' => ['/site/index'], 'options' => ["class" => 'treeview']],
    ];
     $menuItems[] = '<li>'
            . 
            .Nav::widget([
        'options' => ['class' => 'sidebar-menu'],
        'items' => $items,
    ])
            . '</li>';
    
    echo Nav::widget([
        'options' => ['class' => 'sidebar-menu'],
        'items' => $menuItems,
    ]);*/
   // NavBar::end();
    ?>



</div><!-- ./wrapper -->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
