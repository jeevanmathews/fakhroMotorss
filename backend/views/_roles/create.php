<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Roles */

$this->title = 'Create Roles';
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="roles-create">
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
        'model' => $model,
        'departments'=>$departments
    ]) ?>
		</div>
	      <!-- /.box -->
    </section>
</div>
