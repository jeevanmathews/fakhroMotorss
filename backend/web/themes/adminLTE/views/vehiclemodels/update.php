<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Vehiclemodels */

$this->title = 'Update Vehicles: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Vehiclemodels', 'url' => ['index']];
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
		<div class="box box-default">	 
			<?= $this->render('_form', [
				'model' => $model,
            'manufacturer'=>$manufacturer,
            'types'=>$types,
				]) ?>
			</div>
		</section>
	</div>

