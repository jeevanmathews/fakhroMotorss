<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\customer */

$this->title = 'Create Customer';
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
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
