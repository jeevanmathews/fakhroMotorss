<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
/* @var $this yii\web\View */
/* @var $model backend\models\Purchaseorder */

$this->title = 'Create Purchase Invoice';
$this->params['breadcrumbs'][] = ['label' => 'Purchase Invoice', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-invoice-createinv main-body" id="purchase-invoice_createinv">
		<?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
       ]) ?>
<section class="content-header">
	<h1>
		<?= Html::encode($this->title) ?>        
	</h1>

</section>

<section class="content">
	<div class="box box-default">
		<div class="box-header with-border">  
		</div>   


		<?= $this->render('_forminv', [
			'model' => $model,
			'modelpr' => $modelpr,
			'modellastnumber'=>$modellastnumber,
			'model1' => $model1,
			'type'  =>'update',
			]) ?>
		</div>
	</section>
	</div>