<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Departments */

$this->title = 'Create Departments';
$this->params['breadcrumbs'][] = ['label' => 'Departments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="departments-create main-body" id="departments_create">

 <section class="content-header">
      <h1>
        <?= Html::encode($this->title) ?>        
      </h1>
</section>

     <section class="content">
  	<!-- SELECT2 EXAMPLE -->
	  	<div class="box box-default">
	        <div class="box-header with-border">
	          <!-- <h3 class="box-title">Create New</h3> -->
	        </div>   
			<!-- /.box-header -->

	    <?= $this->render('_form', [
	        'model' => $model
	    ]) ?>
		</div>
	      <!-- /.box -->
    </section>
</div>
