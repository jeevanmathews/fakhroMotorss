<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
/* @var $this yii\web\View */
/* @var $model backend\models\Vehiclemodels */

$this->title = 'Create Vehicles';
$this->params['breadcrumbs'][] = ['label' => 'Vehicles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehiclemodels-create main-body" id="vehiclemodels_create">
		<?= Breadcrumbs::widget([
		'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
		]) ?>
<!-- <div class="vehiclemodels-create"> -->
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

				<?= $this->render('_form', [
					'model' => $model,
            		'model2'=> $model2,
		            'model3'=> $model3,		        
            		'manufacturer'=>$manufacturer,            	
					]) ?>
				</div>
			</section>
		</div>
	</div>