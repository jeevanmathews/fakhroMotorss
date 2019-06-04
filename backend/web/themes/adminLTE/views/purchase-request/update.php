<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Purchaserequest */

$this->title = 'Update Purchase Requisition: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Purchase Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="content-header">
	<h1>
		<?= Html::encode($this->title) ?>        
	</h1>

</section>

<section class="content">
	<div class="box box-default">
		<div class="box-header with-border">  
		</div>   
		<?= $this->render('_form', [
			'model' => $model,
			'type'  =>'update',
			]) ?>
		</div>
	</section>
