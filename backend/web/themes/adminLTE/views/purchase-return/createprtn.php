<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
/* @var $this yii\web\View */
/* @var $model backend\models\Purchaseorder */

$this->title = 'Create Purchase Return';
$this->params['breadcrumbs'][] = ['label' => 'Purchase Return', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-return-createprtn main-body" id="purchase-return_createprtn">
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


		<?= $this->render('_formprtn', [
			'model' => $model,
			'modelpr' => $modelpr,
			'model1' => $model1,
			'type'  =>'update',
			]) ?>
		</div>
	</section>
</div>