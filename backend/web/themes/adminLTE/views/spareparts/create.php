<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
/* @var $this yii\web\View */
/* @var $model backend\models\Spareparts */

$this->title = 'Create Spareparts';
$this->params['breadcrumbs'][] = ['label' => 'Spareparts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spareparts-create main-body" id="spareparts_create">
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
					<!-- /.box-header -->
					<?= $this->render('_form', [
						'model' => $model,
						]) ?>
					</div>
					<!-- /.box -->
				</section>
			</div>

		</div>

