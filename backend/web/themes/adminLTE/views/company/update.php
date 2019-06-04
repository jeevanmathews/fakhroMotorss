<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Company */

$this->title = 'Update Company: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
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