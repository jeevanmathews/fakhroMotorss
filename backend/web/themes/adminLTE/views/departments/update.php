<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Departments */

$this->title = 'Update Departments: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Departments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="departments-update main-body" id="departments_update">

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
