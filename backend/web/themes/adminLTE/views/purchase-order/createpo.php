<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Purchaseorder */

$this->title = 'Create Purchase Order';
$this->params['breadcrumbs'][] = ['label' => 'Purchase Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-order-createpo main-body" id="purchase-order_createpo">
<section class="content-header">
	<h1>
		<?= Html::encode($this->title) ?>        
	</h1>

</section>

<section class="content">
	<div class="box box-default">
		<div class="box-header with-border">  
		</div>   


		<?= $this->render('_formpo', [
			'model' => $model,
			'modelpr' => $modelpr,
			'modellastnumber'=>$modellastnumber,
			'model1' => $model1,
			'type'  =>'update',
			]) ?>
		</div>
	</section>
</div>