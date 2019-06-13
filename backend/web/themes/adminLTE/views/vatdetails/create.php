<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Vatdetails */

$this->title = 'Create VAT details';
$this->params['breadcrumbs'][] = ['label' => 'VAT details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-main-wrapper main-body" id="vatdetails_create">
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= Html::encode($this->title) ?>        
      </h1>
    </section>

     <section class="content">
    <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">  
	   <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
		</div>
        <!-- /.box -->
    </section>
</div>
