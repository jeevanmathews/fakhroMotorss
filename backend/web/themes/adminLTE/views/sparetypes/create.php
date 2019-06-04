<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Sparetypes */

$this->title = 'Create Spare Types';
$this->params['breadcrumbs'][] = ['label' => 'Sparetypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-main-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= Html::encode($this->title) ?>        
      </h1>
    </section>

     <section class="content">
    <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">    
      <!-- /.box-header -->
	   <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
		  </div>
        <!-- /.box -->
    </section>
</div>
