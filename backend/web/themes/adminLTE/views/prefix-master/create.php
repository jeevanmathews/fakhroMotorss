<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model backend\models\PrefixMaster */

$this->title = 'Create Prefix';
$this->params['breadcrumbs'][] = ['label' => 'Prefix Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prefix-master-create main-body" id="prefix-master_create">
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
