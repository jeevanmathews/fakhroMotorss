<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ExtendedWarrantyType */

$this->title = 'Update Extended Warranty Type: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Extended Warranty Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="main-body" id="extended-warranty-type_update">
<div class="content-main-wrapper">
	<section class="content-header">
      <h1>
        <?= Html::encode($this->title) ?>        
      </h1>
    <!--   <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Franchises</a></li>
        <li class="active">Create</li>
      </ol> -->
    </section>

    <section class="content">
  	<!-- SELECT2 EXAMPLE -->
	  	<div class="box box-default">
	        <div class="box-header with-border">
	          <!-- <h3 class="box-title">Create New</h3> -->
	        </div>   
			<!-- /.box-header -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
	      <!-- /.box -->
    </section>
</div>
</div>