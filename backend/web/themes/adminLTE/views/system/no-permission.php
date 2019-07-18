<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Company */

$this->title = "No Permission";
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="nopermission-view main-body" id="no-permission_view">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= Html::encode($this->title) ?>        
      </h1>
    </section>
    
    <section class="content">
    <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">   

        <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="error-page">
                    <div class="row">
                        <div class="col-md-6">
                            <h2>403</h2>
                            <h3>Access Denied/Forbidden</h3>
                            <h4>You don't have permission to view this page.</h4>
                        </div>
                        <div class="col-md-6">
                            <img src="themes/adminLTE/images/error-403.png" class="img-responsive" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
          <!-- /.box -->
    </section>
</div>