<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css',
        '//fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700%7CRoboto+Slab:100,300,400,700%7CRoboto:100,300,400,500,700,900',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css',        
        'themes/adminLTE/plugins/select2/select2.min.css',
        'themes/adminLTE/css/AdminLTE.min.css',
        'themes/adminLTE/css/_all-skins.min.css',    
        'themes/adminLTE/css/tooltipster.bundle.min.css',          
        'themes/adminLTE/css/pignose.calendar.css',
        'themes/adminLTE/css/owl.carousel.min.css',
        'themes/adminLTE/css/pignose.calendar.css',
        'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css',
        'themes/adminLTE/css/jquery.toast.css',
        'themes/adminLTE/css/style.css'
        //'themes/adminLTE/plugins/datepicker/datepicker3.css',
       // 'themes/adminLTE/plugins/daterangepicker/daterangepicker.css',


    ];
    public $js = [   
    'https://code.jquery.com/ui/1.12.1/jquery-ui.js',  
    'themes/adminLTE/plugins/select2/select2.full.min.js',

    //'themes/adminLTE/plugins/daterangepicker/daterangepicker.js',
    //'themes/adminLTE/plugins/datepicker/bootstrap-datepicker.js',
    'themes/adminLTE/plugins/slimScroll/jquery.slimscroll.min.js',
    'themes/adminLTE/plugins/fastclick/fastclick.js',
    'themes/adminLTE/js/app.min.js',
    'https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js',
    'themes/adminLTE/js/tooltipster.bundle.min.js',
    'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js',   
    'themes/adminLTE/js/pignose.calendar.js',
    'themes/adminLTE/js/calculation.js',
    'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js',
    'themes/adminLTE/js/jquery.toast.js',
    'themes/adminLTE/js/autocomplete.js',
    ];
    public $jsOptions = array(
    'position' => \yii\web\View::POS_HEAD
    );
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

}
