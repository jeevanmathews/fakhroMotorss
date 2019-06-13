<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
/* @var $this yii\web\View */
/* @var $model backend\models\Accessories */

$this->title = 'Update Accessories: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Accessories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="accessories-update main-body" id="accessories_update">
	<?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
       ]) ?>
	<div class="accessoriestype-create">

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

		</div>
	</div>
