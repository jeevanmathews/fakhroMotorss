
<?php

if(isset($_POST['connect'])){	

	ini_set('max_execution_time', 18000);   
	$servername = $_POST['host_name'];
	$username = $_POST['user_name'];
	$password = $_POST['database_password'];
	$database = $_POST['db_name'];

	// Create connection
	$conn = mysqli_connect($servername, $username, $password);
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	// Create database
	$sql = "CREATE DATABASE if not exists ".$database;
	if (mysqli_query($conn, $sql)) {
	    mysqli_select_db($conn, $database);

	    $contents = file_get_contents("demodata/autoerp.sql");

	    // Remove C style and inline comments
	    $comment_patterns = array('/\/\*.*(\n)*.*(\*\/)?/', //C comments
	                              '/\s*--.*\n/', //inline comments start with --
	                              '/\s*#.*\n/', //inline comments start with #
	                              );
	    $contents = preg_replace($comment_patterns, "\n", $contents);

	    //Retrieve sql statements
	    $statements = explode(";\n", $contents);
	    $statements = preg_replace("/\s/", ' ', $statements);

	    foreach ($statements as $query) {
	        if (trim($query) != '') {
	        	mysqli_query($conn, $query);
	        }
	    }

	    $fname = "common/config/main-local.php";
        $fhandle = fopen($fname,"r");
        $content = fread($fhandle,filesize($fname));

        $content = str_replace("dbname=demo", "dbname=".$database, $content);

        $fhandle = fopen($fname,"w");
        fwrite($fhandle,$content);
        fclose($fhandle);

        header("Location:backend/web/");
	}
}

?>


<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-param" content="_csrf-backend">
    <meta name="csrf-token" content="ybM-3s2aJBRkg3unz_fjyo5OAhI-JfJY_BOMQFPU4eyui3etuP4cJBS1Ofepuqun2xRRZVNuiD25Z_sMGYfRvA==">
    <title>Login</title>
    <link href="backend/web/assets/7c4c0941/css/bootstrap.css" rel="stylesheet">
<link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700%7CRoboto+Slab:100,300,400,700%7CRoboto:100,300,400,500,700,900" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
<link href="backend/web/themes/adminLTE/plugins/select2/select2.min.css" rel="stylesheet">
<link href="backend/web/themes/adminLTE/css/AdminLTE.min.css" rel="stylesheet">
<link href="backend/web/themes/adminLTE/css/_all-skins.min.css" rel="stylesheet">
<link href="backend/web/themes/adminLTE/css/tooltipster.bundle.min.css" rel="stylesheet">
<link href="backend/web/themes/adminLTE/css/pignose.calendar.css" rel="stylesheet">
<link href="backend/web/themes/adminLTE/css/style.css" rel="stylesheet">
<link href="backend/web/themes/adminLTE/css/owl.carousel.min.css" rel="stylesheet">
<script src="backend/web/assets/9d08adae/jquery.js"></script>
<script src="backend/web/assets/c3ba5d83/yii.js"></script>
<script src="backend/web/assets/7c4c0941/js/bootstrap.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="backend/web/themes/adminLTE/plugins/select2/select2.full.min.js"></script>
<script src="backend/web/themes/adminLTE/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="backend/web/themes/adminLTE/plugins/fastclick/fastclick.js"></script>
<script src="backend/web/themes/adminLTE/js/app.min.js"></script>
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<script src="backend/web/themes/adminLTE/js/tooltipster.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="backend/web/themes/adminLTE/js/pignose.calendar.js"></script>
<script>var jsUrl = 'backend/web/index.php?r=common%2Fvalidate-entry' ;</script>    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <link rel="apple-touch-icon" sizes="57x57" href="backend/web/themes/adminLTE/images/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="backend/web/themes/adminLTE/images/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="backend/web/themes/adminLTE/images/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="backend/web/themes/adminLTE/images/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="backend/web/themes/adminLTE/images/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="backend/web/themes/adminLTE/images/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="backend/web/themes/adminLTE/images/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="backend/web/themes/adminLTE/images/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="backend/web/themes/adminLTE/images/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="backend/web/themes/adminLTE/images/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="backend/web/themes/adminLTE/images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="backend/web/themes/adminLTE/images/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="backend/web/themes/adminLTE/images/favicons/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
</head>

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
              <a class="navbar-brand" href="backend/web/index.php?r=site%2Fdashboard"><img src="backend/web/themes/adminLTE/images/logo.png" class="img-responsive" /></a>
            </div>
     
          </div>
        </nav>
    </header>
  <div class="launch-screen">
 <div class="container container-body">
<div class="tab">
  <button class="tablinks active">STEP 1 : SET UP</button>
  <button class="tablinks">STEP 2 : CONFIGURE COMPANY</button>
  <button class="tablinks signup">STEP 3 : CREATE COMPANY ADMIN</button>
 
</div>
 <form id="login-form" action="" method="post">
<input type="hidden" name="_csrf-backend" value="ybM-3s2aJBRkg3unz_fjyo5OAhI-JfJY_BOMQFPU4eyui3etuP4cJBS1Ofepuqun2xRRZVNuiD25Z_sMGYfRvA=="><div id="conf" class="tabcontent first_tab">
  <h2 class="heading text-center">Configure Connection</h2>
  <div class="row">
       <div class="col-md-offset-2 col-md-8">
          <div class="form-group field-database-name required">
<label class="control-label" for="database-name">Database Name</label>
<input type="text" id="database-name" class="form-control" name="db_name" maxlength="300" aria-required="true" value="autoerp">

<p class="help-block help-block-error"></p>
</div>           <div class="form-group field-host-name required">
<label class="control-label" for="host-name">Host Name</label>
<input type="text" id="host-name" class="form-control" name="host_name" maxlength="300" aria-required="true"  value="localhost">

<p class="help-block help-block-error"></p>
</div>           <div class="form-group field-database-user-name">
<label class="control-label" for="database-user-name">User Name</label>
<input type="text" id="database-user-name" class="form-control" name="user_name" value="root">

<p class="help-block help-block-error"></p>
</div>           <div class="form-group field-database-password required">
<label class="control-label" for="database-password">Password</label>
<input type="text" id="database-password" class="form-control" name="database_password" aria-required="true" value="">

<p class="help-block help-block-error"></p>
</div>           <button type="submit" class="btn btn-primary pull-right" name="connect">Next</button> 
       </div>                                    
  </div>
</div>

<div id="signup" class="tabcontent signup">
  <h2 class="heading text-center"></h2>
  <div class="row">
                                       
  </div>
</div>
</div>
</div>
</form><script type="text/javascript">
$(".tabcontent").css("display", "none");
var screen = "";
if(screen == "")
    $(".first_tab").css("display", "block");
else{
    $(".tablinks").removeClass("active");
    $("."+screen).addClass("active");
    $("#"+screen).css("display", "block");
}
</script>
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
<script src="backend/web/themes/adminLTE/js/common.js"></script>
<script src="backend/web/assets/c3ba5d83/yii.validation.js"></script>
<script src="backend/web/assets/c3ba5d83/yii.activeForm.js"></script>
<script>jQuery(function ($) {
jQuery('#login-form').yiiActiveForm([{"id":"company-name","name":"name","container":".field-company-name","input":"#company-name","error":".help-block.help-block-error","validate":function (attribute, value, messages, deferred, $form) {yii.validation.required(value, messages, {"message":"Company Name cannot be blank."});yii.validation.string(value, messages, {"message":"Company Name must be a string.","max":300,"tooLong":"Company Name should contain at most 300 characters.","skipOnEmpty":1});}},{"id":"company-email","name":"email","container":".field-company-email","input":"#company-email","error":".help-block.help-block-error","validate":function (attribute, value, messages, deferred, $form) {yii.validation.required(value, messages, {"message":"Company Email cannot be blank."});yii.validation.email(value, messages, {"pattern":/^[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/,"fullPattern":/^[^@]*<[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?>$/,"allowName":false,"message":"Company Email is not a valid email address.","enableIDN":false,"skipOnEmpty":1});yii.validation.string(value, messages, {"message":"Company Email must be a string.","max":300,"tooLong":"Company Email should contain at most 300 characters.","skipOnEmpty":1});}},{"id":"company-phone","name":"phone","container":".field-company-phone","input":"#company-phone","error":".help-block.help-block-error","validate":function (attribute, value, messages, deferred, $form) {yii.validation.number(value, messages, {"pattern":/^\s*[+-]?\d+\s*$/,"message":"Phone must be an integer.","skipOnEmpty":1});}},{"id":"company-address","name":"address","container":".field-company-address","input":"#company-address","error":".help-block.help-block-error","validate":function (attribute, value, messages, deferred, $form) {yii.validation.required(value, messages, {"message":"Address cannot be blank."});yii.validation.string(value, messages, {"message":"Address must be a string.","skipOnEmpty":1});}}], []);
});</script></html>
