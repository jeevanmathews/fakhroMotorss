<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
/* @var $this yii\web\View */
/* @var $model backend\models\Purchaseorder */

$this->title = 'Create Delivery Order';
$this->params['breadcrumbs'][] = ['label' => 'Delivery Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-order-createdo main-body" id="delivery-order_createdo">
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


		<?= $this->render('_formdo', [
			'model' => $model,
			'modelpr' => $modelpr,
			'model1' => $model1,
			'modellastnumber'=>$modellastnumber,
			]) ?>
		</div>
	</section>
</div>