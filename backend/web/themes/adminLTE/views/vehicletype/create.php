<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
/* @var $this yii\web\View */
/* @var $model backend\models\Vehicletype */

$this->title = 'Create Vehicle Type';
$this->params['breadcrumbs'][] = ['label' => 'Vehicletypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehicletype-create main-body" id="vehicletype_create">
	<?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
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
					'model' => $model
					]) ?>
				</div>
			</section>
		</div>
	</div>