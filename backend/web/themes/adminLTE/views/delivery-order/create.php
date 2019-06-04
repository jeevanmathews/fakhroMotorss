<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Purchaseorder */

$this->title = 'Create Delivery Order';
$this->params['breadcrumbs'][] = ['label' => 'Delivery Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
			'model1' => $model1,
			'type'  =>'create',
			]) ?>
		</div>
	</section>
