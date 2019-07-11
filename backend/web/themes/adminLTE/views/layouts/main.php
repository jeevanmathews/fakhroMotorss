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
$jc_vehicle_info_url = Yii::$app->getUrlManager()->createUrl(['jobcard/vehicle-info']);
$jc_vehicle_search_url = Yii::$app->getUrlManager()->createUrl(['jobcard/search-vehicle']);
$jc_customer_search_url = Yii::$app->getUrlManager()->createUrl(['jobcard/search-customer']);
$jc_create_task_url = Yii::$app->getUrlManager()->createUrl(['tasks/create']);
$jc_apply_discount_url = Yii::$app->getUrlManager()->createUrl(['jobcard/apply-discount']);
$jc_customer_info_url = Yii::$app->getUrlManager()->createUrl(['jobcard/customer-info']);
$jc_item_search_url = Yii::$app->getUrlManager()->createUrl(['jobcard/search-item']);
$js = <<< JS
var jsUrl = '$jsUrl' ;
var jc_vehicle_info_url = '$jc_vehicle_info_url';
var jc_vehicle_search_url = '$jc_vehicle_search_url';
var jc_customer_search_url = '$jc_customer_search_url';
var jc_create_task_url = '$jc_create_task_url';
var jc_apply_discount_url = '$jc_apply_discount_url';
var jc_customer_info_url = '$jc_customer_info_url';
var jc_item_search_url = '$jc_item_search_url';
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
           <li class="dropdown active">
            <a href="#">Masters</a>
            <ul class="dropdown-menu">
             
                      <!-- <li>
                        <?= Html::a('Permission Master', ['/permissionmaster/index'], ['class'=>'']) ?>
                      </li> -->                      
                    <!--   <li>
                        <?= Html::a('Country', ['/country/index'], ['class'=>'']) ?>
                      </li> -->
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
                        <?= Html::a('VAT', ['/vatdetails/index'], ['class'=>'']) ?>
                      </li> 
                      <li>
                        <?= Html::a('Amc Types', ['/amc-type/index'], ['class'=>'']) ?>
                      </li>
                      <li>
                        <?= Html::a('Extended Warranty Types', ['/extended-warranty-type/index'], ['class'=>'']) ?>
                      </li>
                      <!--<li>
                        <?= Html::a('Jobcard Status', ['/jobcard-status/index'], ['class'=>'']) ?>
                      </li>-->
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
                      <!--<li>
                        <?= Html::a('Accessory Types', ['/accessoriestype/index'], ['class'=>'']) ?>
                      </li> -->
                      <!--<li>
                        <?= Html::a('Spare Types', ['/sparetypes/index'], ['class'=>'']) ?>
                      </li>-->                       
                     <!--  <li>
                        <?= Html::a('Spare Parts', ['/spareparts/index'], ['class'=>'']) ?>
                      </li> 
                      <li>
                        <?= Html::a('Accessories', ['/accessories/index'], ['class'=>'']) ?>
                      </li> 
                       -->                     
                     
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
					  
                     <!--  <li>
                        <?= Html::a('Item Types', ['/itemtype/index'], ['class'=>'']) ?>
                      </li> -->
                      
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
                      <!--<li>
                        <?= Html::a('Make', ['/make'], ['class'=>'']) ?>
                      </li>-->
                      <li>
                        <?= Html::a('Manufacturer', ['/manufacturer/index'], ['class'=>'']) ?>
                      </li>

                      <li>
                        <?= Html::a('Model', ['/car-model'], ['class'=>'']) ?>
                      </li> 
                        <li>
                        <?= Html::a('Customer', ['/customer/index'], ['class'=>'']) ?>
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
                  </li> 
                <!--<li class="dropdown">
                  <a href="#">Stock</a>
                    <ul class="dropdown-menu">                       
                      <li>
                        <?= Html::a('Supplier', ['/supplier/index'], ['class'=>'']) ?>
                      </li>
                    </ul>
                  </li>-->
                <!-- <li>
                    <?= Html::a('User', ['/user/index'], ['class'=>'']) ?>
                  </li> -->
               <!--  <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">Transactions <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Page 1-1</a></li>
                <li><a href="#">Page 1-2</a></li>
                <li>
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Transactions level2 <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Page 1-1</a></li>
                  <li><a href="#">Page 1-2</a></li>
                  <li>
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Transactions level3 <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="#">Page 1-1</a></li>
                    <li><a href="#">Page 1-2</a></li>
                    <li><a href="#">Page 1-3</a></li>
                  </ul>
                </li>
                  <li><a href="#">Page 1-3</a></li>
                </ul>
              </li>
                <li><a href="#">Page 1-3</a></li>
              </ul>
            </li> -->
             <!--    <li><a href="#">Accounts</a></li>
                <li><a href="#">Online Banking</a></li>              
                <li><a href="#">Final Reports</a></li>
                <li><a href="#">Stocks</a></li>             
                <li><a href="#">Reports</a></li>
                <li><a href="#">Hot Keys</a></li>
                <li><a href="#">Downloads</a></li>
                <li><a href="#">Helps</a></li> -->
                <!-- <li class="dropdown messages-menu"> -->
                <!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown"> -->
                <!-- <i class="fa fa-cubes"></i> Branches -->
                <!-- <span class="label label-success">4</span> -->
                <!-- </a> -->
                <!-- <ul class="dropdown-menu">                  -->
                <!-- <li> -->
                <!-- inner menu: contains the actual data -->
                <!-- <ul class="menu"> -->
                <!-- <li>start message -->
                          <!-- <a href="#">
                            <div class="pull-left">
                              <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                            </div>
                            <h4>
                              Support Team
                              <small><i class="fa fa-clock-o"></i> 5 mins</small>
                            </h4>
                            <p>Why not buy a new awesome theme?</p>
                          </a>
                        </li> -->
                        <!-- end message -->                 
                        
                    <!--     <li>
                          <a href="#">
                            <div class="pull-left">
                              <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                            </div>
                            <h4>
                              Reviewers
                              <small><i class="fa fa-clock-o"></i> 2 days</small>
                            </h4>
                            <p>Why not buy a new awesome theme?</p>
                          </a>
                        </li>
                      </ul>
                    </li>                    
                  </ul>
                </li> -->
                
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
                      <!-- <li class="user-body">
                        <div class="row">
                          <div class="col-xs-4 text-center">
                            <a href="#">Followers</a>
                          </div>
                          <div class="col-xs-4 text-center">
                            <a href="#">Sales</a>
                          </div>
                          <div class="col-xs-4 text-center">
                            <a href="#">Friends</a>
                          </div>
                        </div>
                      </li> -->
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
                          <!--  <div class="pull-right">
                          <a href="#" class="btn btn-default btn-flat">Sign out</a>
                        </div> -->
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      </header>
      
   <!--  <section class="dashboard">
      <div class="container-fluid">
        <div class="dashboard-inner">
          <div class="row table-row">
            <div class="col-sm-3">
              <div class="dashboard-left-menu">
                <div class="dashboard-left-menu-inner">
                  <h4 class="">Most Viewed Reports</h4>
                  <a href="#" class="btn-block">New Ledger</a>
                  <a href="#" class="btn-block">Retail: Bill</a>
                  <a href="#" class="btn-block">Change Company</a>
                  <a href="#" class="btn-block">Current Stock</a>
                  <a href="#" class="btn-block">GST Register & Returns</a>
                </div>
                <div class="dashboard-left-menu-inner">
                  <h4 class="">Recently Viewed Reports</h4>
                  <a href="#" class="btn-block">Search</a>
                  <a href="#" class="btn-block">Change Company</a>
                  <a href="#" class="btn-block">New Company</a>
                  <a href="#" class="btn-block">Current Stock</a>
                  <a href="#" class="btn-block">GST Register & Returns</a>
                </div>
              </div>
            </div>
            <div class="col-sm-6"></div>
            <div class="col-sm-3">
              <div class="dashboard-right-menu">
                <a href="#" class="btn btn-block">Bill-Wholesale</a>
                <a href="#" class="btn btn-block">Bill-Retail</a>
                <a href="#" class="btn btn-block">S/R Expiry</a>
                <a href="#" class="btn btn-block">P/R Expiry</a>
                <a href="#" class="btn btn-block">Receipt</a>
              </div>
            </div>
          </div>
          <div class="row table-row">
            <div class="col-sm-12">
              <div class="dashboard-bottom-area">
                <div class="row">
                  <div class="col-sm-3">
                    <h4>DEMO COMPANY-DECO</h4>
                    <h5>Ernakulam</h5>
                    <h6>Financial Period: Apr., 2018 - Mar., 2019</h6>
                  </div>
                  <div class="col-sm-6"></div>
                  <div class="col-sm-3">
                    <h4><span>Date</span>: 7 Mar., 2019</h4>
                    <h4><span>Day</span>: Thursday</h4>
                    <h4><span>Time</span>: 14:51:17</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section> -->
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


      $(document).on('click', "[class='close-tab']", function(){
        //Next or Previous tab to be shown
        var tab_type = "id";
        var prev_tab_id = $(this).closest("li").prev("li").attr("id");  
        if(prev_tab_id == undefined){
            var prev_tab_id = $(this).closest("li").next("li").attr("id");
          if(prev_tab_id == undefined){
            var prev_tab_id = "navbar-header";
            tab_type = "class";
          }
        } 
        var close_tabId = $(this).closest("li").attr("id");
        for(var i=0;i<5;i++){
          $('div[tab_id="'+close_tabId+'"]').next("script").remove();
        }
        $(this).closest("li").remove(); 
        $('div[tab_id="'+close_tabId+'"]').remove();
        (tab_type == "id")?($("#"+prev_tab_id).find("a").trigger("click")):($("."+prev_tab_id).find("a").trigger("click"));
      })
      
      $(document).on('click', "a", function(){
        var pagination = false;
        if($(this).hasClass("page_tab")){
          var tab_id = $(this).closest("li").attr("id");           
          $("#myTab .nav-item").addClass("active");  
          $(this).closest("li").removeClass("active");
          $(".main-body").addClass("hide");
          $(document).find('div[tab_id="'+tab_id+'"]').removeClass("hide");         
          return;
        } else if($(this).hasClass("jc-tabs")){ //Check for other clicks
          return true;
        } else if($(this).hasClass("close-modal")){
          return true;
        }else if($(this).hasClass("generate-invoice")){
          $("[class*='confirm-payment']").modal().hide();
          return true;
        }
        else if($(this).hasClass("change_status")){ //Check for other clicks
          return true;
        }
        else if($(this).hasClass("search-jcitem")){ //Check for other clicks
          return true;
        }
        else if($(this).hasClass("generate-quotation")){ //Check for other clicks
          return true;
        }
        else if($(this).hasClass("nav-link")){ //Check for other clicks
          return true;
        }else if($(this).hasClass("navbar-brand")){       
          $(".main-body").addClass("hide");
          $("#site_dashboard").removeClass("hide");
          return false;
        }else if($(this).hasClass("folder-tree")){
          return false;
        }else if($(this).attr("data-page")){
          pagination = true;
        }
        event.preventDefault();        

        //Find requested page id
        //
        var page_id = $(this).attr("href").split("=")[1].replace("%2F","_"); 
        //Extract request action only without arguments
        if(page_id.indexOf("&") != -1){         
          page_id = page_id.replace(page_id.substr(page_id.indexOf("&")),"");
        }

        //Generate Tab        
        if($(this).closest("div").attr("id") == "myNavbar"){
          $("#myTab .nav-item").addClass("active");          
          var tabId = "tab_id_"+($(".page_tab").length+1);
          $( '<li id="'+tabId+'" class="nav-item"><a class="nav-link page_tab" data-toggle="tab" role="tab" aria-controls="task" aria-selected="false"><span>'+page_id.replace("_","/")+'</span></a><b class="close-tab"><i class="fa fa-times-circle" aria-hidden="true"></i></b></li>' ).appendTo( $( "#myTab" ) );
        }

        if(tabId == undefined){
         var tabId = $(this).closest(".main-body").attr("tab_id");         
        }
          
         if($('div[tab_id="'+tabId+'"]').length){
            for(var i=0;i<5;i++){
              $('div[tab_id="'+tabId+'"]').next("script").remove();
            }
          }
          $.ajaxSetup({async: false}); 
          $.ajax({
          url: $(this).attr("href"),
          aSync: false,
          dataType: "html",
          success: function(data) {
            if(pagination && $(".modal").is(":visible")){              
              $(".modal:visible").find(".grid-view").html($(data).find('.grid-view').html())
            }else{
              $(".main-body").addClass("hide");
              $('div[tab_id="'+tabId+'"]').remove();
              $(".container-body").append($(data));
              $(document).find(".main-body:visible").attr("tab_id", tabId);
              $("#"+tabId).find("span").html($(document).find(".main-body:visible").find(".content-header h1").html());
              //$("#"+tabId).find("span").html(page_id.replace("_","/"));
              addMandatoryStar();
            }
            
          }});
          $.ajaxSetup({async: true}); 
       
      });

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
      function addMandatoryStar(){
        $("[aria-required='true']").each(function(){
          var new_text = "* "+$(this).prev(".input-group-addon").text();
          if($(this).prev(".input-group-addon").text().indexOf("*") == -1){
            $(this).prev(".input-group-addon").text(new_text);
          }
        });
      }
      </script>
      
    </body>
    <?php $this->endBody() ?>
    </html>
    <?php $this->endPage() ?>
