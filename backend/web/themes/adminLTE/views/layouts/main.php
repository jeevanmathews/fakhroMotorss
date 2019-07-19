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
$nopermissionUrl = Yii::$app->getUrlManager()->createUrl(['common/no-permission']);
$jc_vehicle_info_url = Yii::$app->getUrlManager()->createUrl(['jobcard/vehicle-info']);
$jc_vehicle_search_url = Yii::$app->getUrlManager()->createUrl(['jobcard/search-vehicle']);
$jc_customer_search_url = Yii::$app->getUrlManager()->createUrl(['jobcard/search-customer']);
$jc_create_task_url = Yii::$app->getUrlManager()->createUrl(['tasks/create']);
$jc_apply_discount_url = Yii::$app->getUrlManager()->createUrl(['jobcard/apply-discount']);
$jc_customer_info_url = Yii::$app->getUrlManager()->createUrl(['jobcard/customer-info']);
$jc_item_search_url = Yii::$app->getUrlManager()->createUrl(['jobcard/search-item']);
$jc_approval_url = Yii::$app->getUrlManager()->createUrl(['jobcard/approval']);
$vat_rate = Yii::$app->common->company->vat_rate;
$decimal_places = Yii::$app->common->company->settings->decimal_places;
$js = <<< JS
var jsUrl = '$jsUrl' ;
var nopermissionUrl = '$nopermissionUrl' ;
var jc_vehicle_info_url = '$jc_vehicle_info_url';
var jc_vehicle_search_url = '$jc_vehicle_search_url';
var jc_customer_search_url = '$jc_customer_search_url';
var jc_create_task_url = '$jc_create_task_url';
var jc_apply_discount_url = '$jc_apply_discount_url';
var jc_customer_info_url = '$jc_customer_info_url';
var jc_item_search_url = '$jc_item_search_url';
var jc_approval_url = '$jc_approval_url';
var vat_rate = '$vat_rate';
var decimal_places = '$decimal_places';
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
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>                        
          </button>
          <a class="navbar-brand" href="<?=Yii::$app->getUrlManager()->createUrl(['site/dashboard'])?>"><img src="themes/adminLTE/images/logo.png" class="img-responsive" /></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav">
            <li class="dropdown">            
             <?= Html::a('Branches', ['/branches/index'], ['class'=>'']) ?>
           </li>
           <?php  Yii::$app->common->getMenu();?>
           <!--<li class="dropdown">
            <a href="#">Masters</a>
            <ul class="dropdown-menu">             
                    
                      <li>
                        <?= Html::a('Currency', ['/currency/index'], ['class'=>'']) ?>
                      </li>
                      <li>
                        <?= Html::a('Units', ['/units/index'], ['class'=>'']) ?>
                      </li> 
                      <li>
                        <?= Html::a('Supplier', ['/supplier/index'], ['class'=>'']) ?>
                      </li>
                       <li>
                        <?= Html::a('Supplier Groups', ['/suppliergroup/index'], ['class'=>'']) ?>
                      </li>    
                      <li>
                        <?= Html::a('Branch Types', ['/branchtypes/index'], ['class'=>'']) ?>
                      </li> 
                     
                      <li>
                        <?= Html::a('Amc Types', ['/amc-type/index'], ['class'=>'']) ?>
                      </li>
                      <li>
                        <?= Html::a('Extended Warranty Types', ['/extended-warranty-type/index'], ['class'=>'']) ?>
                      </li>
                     
                      <li>
                        <?= Html::a('Service Type', ['/service-type/index'], ['class'=>'']) ?>
                      </li>
                      <li>
                        <?= Html::a('Prefix', ['/prefix-master/index'], ['class'=>'']) ?>
                      </li>
                    </ul>
                  </li>

                   <li class="dropdown"> 
                    <a href="#">Administration</a> 
                     <ul class="dropdown-menu"> 
                      <li>
                        <?= Html::a('Departments', ['/departments/index'], ['class'=>'']) ?>
                      </li>
                      <li>
                        <?= Html::a('Designations', ['/designations/index'], ['class'=>'']) ?>
                      </li>   
                      <li>
                        <?= Html::a('Roles', ['/roles/index'], ['class'=>'']) ?>
                      </li>                    
                      <li>
                        <?= Html::a('Staff', ['/employees/index'], ['class'=>'']) ?>
                      </li>
                     </ul> 
                   </li> 

                  <li class="dropdown">
                    <a href="#">Inventory</a>
                    <ul class="dropdown-menu">                       
                      <li>
                        <h4>Products</h4>
                      </li>
                      <li>
                        <?= Html::a('Vehicle Type', ['/vehicletype/index'], ['class'=>'']) ?>
                      </li>
                         
                     
                      <li>
                        <?= Html::a('Vehicle', ['/vehiclemodels/index'], ['class'=>'']) ?>
                      </li> 
                      <li>
                        <?= Html::a('Items', ['/items/index'], ['class'=>'']) ?>
                      </li> 
                      <li>
                        <?= Html::a('Accessories', ['/itemgroup/index'], ['class'=>'']) ?>
                      </li>
                      <li>
                        <?= Html::a('Spare Parts', ['/itemgroup/index','type' => 'spares'] ,['class'=>'']) ?>
                      </li>
                      <li>
                        <h4>Services</h4>
                      </li>
                      <li>
                        <?= Html::a('Service Tasks', ['/tasks/index'], ['class'=>'']) ?>
                      </li>
                        <li>
                        <?= Html::a('Task Types', ['/tasktype/index'], ['class'=>'']) ?>
                      </li>
					  
                     
                      
                    </ul>
                  </li>
                  <li class="dropdown">
                    <a href="#">Purchase</a>
                    <ul class="dropdown-menu">  
                      <li>
                        <?= Html::a('Purchase Requisition', ['/purchase-request/index'], ['class'=>'']) ?>
                      </li>
                      <li>
                        <?= Html::a('Purchase Order', ['/purchase-order/index'], ['class'=>'']) ?>
                      </li>
                      <li>
                        <?= Html::a('GRN', ['/goods-receipt-note/index'], ['class'=>'']) ?>
                      </li>
                       <li>
                        <?= Html::a('Purchase Invoice', ['/purchase-invoice/index'], ['class'=>'']) ?>
                      </li>
                       <li>
                        <?= Html::a('Purchase return', ['/purchase-return/index'], ['class'=>'']) ?>
                      </li>
                    </ul>
                  </li> 

                  <li class="dropdown">
                    <?= Html::a('Jobcard', ['/jobcard/index'], ['class'=>'']) ?>
                    <ul class="dropdown-menu">  
                      <li>
                        <?= Html::a('Jobcard', ['/jobcard/index'], ['class'=>'']) ?>
                      </li>  
                      <li>
                        <?= Html::a('Jobcard Vehicle', ['/jobcard-vehicle'], ['class'=>'']) ?>
                      </li> 
                     
                      <li>
                        <?= Html::a('Manufacturer', ['/manufacturer/index'], ['class'=>'']) ?>
                      </li>

                      <li>
                        <?= Html::a('Model', ['/car-model'], ['class'=>'']) ?>
                      </li> 
                      <li>
                        <?= Html::a('Customer', ['/customer/index'], ['class'=>'']) ?>
                      </li> 
                      <li>
                        <?= Html::a('Jobcard Approval', ['/jobcard/approval'], ['class'=>'']) ?>
                      </li>                    
                    </ul>
                  </li> 
                  <li class="dropdown">
                    <a href="#">Sales</a>
                    <ul class="dropdown-menu">  
                      <li>
                        <?= Html::a('Quotation', ['/quotation/index'], ['class'=>'']) ?>
                      </li>
                      <li>
                        <?= Html::a('Sales Order', ['/sales-order/index'], ['class'=>'']) ?>
                      </li>
                      <li>
                        <?= Html::a('Delivery Order', ['/delivery-order/index'], ['class'=>'']) ?>
                      </li>
                      <li>
                        <?= Html::a('Sales Invoice', ['/sales-invoice/index'], ['class'=>'']) ?>
                      </li>
                    </ul>
                  </li>  -->           
                
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li class="messages-menu">                  
                  
                </li>

                <!-- <li><a href="index.php?r=site%2Flogout">Logout</a></li> -->
                

                <li class="dropdown">
                  <a href="#"><i class="fa fa-gears"></i>  Settings</a>
                  <ul class="dropdown-menu">  
                    <li>
                     <?= Html::a('<i class="fa fa-home"></i> Manage Company', ['/company/view', "id" => 1], ['title'=>'Manage Company']) ?>
                   </ul>
                 </li>

                 <li class="dropdown user user-menu">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="themes/adminLTE/images/user2-160x160.jpg" class="user-image" alt="User Image">
                    <span class="hidden-xs"> <?= Yii::$app->user->identity->username?></span>
                  </a>
                  <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                      <img src="themes/adminLTE/images/user2-160x160.jpg" class="img-circle" alt="User Image">

                      <p>
                       <?= Yii::$app->user->identity->username?>
                       <small>Designation</small>
                     </p>
                   </li>
                   <!-- Menu Body -->
                     
                      <!-- Menu Footer-->
                      <li class="user-footer">
                        <div class="pull-left">
                          <a href="#" class="btn btn-default btn-flat">Profile</a>
                        </div>
                        <div class="pull-right">
                          <?=Html::beginForm(['/site/logout'], 'post')
                          . Html::submitButton(
                            'Sign out (' . Yii::$app->user->identity->username . ')',
                            ['class' => 'btn btn-default btn-flat']
                            )
                            . Html::endForm() ?>                   
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      </header>      

    <div class="container container-body">
      
      <ul class="nav nav-tabs closeable-tab" id="myTab" role="tablist">
        <!--Tabs -->
      </ul>

        <?= Alert::widget() ?>
        <?= $content ?>
        
        <!-- /.content -->
      </div>
      <footer class="copyright-wrapper">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <p class="text-center">Copyright © 2019 Motor Methods. All rights reserved.</p>
            </div>
          </div>
        </div>
      </footer>
      
      <script type="text/javascript">

      var supplier='<?php echo Yii::$app->getUrlManager()->createUrl(['supplier/single']);?>';
      var hiddenurl_itemprice= '<?php echo Yii::$app->getUrlManager()->createUrl(['items/itemprice'])?>';   

      var decimalPlaces=<?= Yii::$app->common->decimalplaces?>;
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
