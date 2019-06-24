<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model backend\models\suppliergroup */

$this->title = 'Update Suppliergroup: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Suppliergroups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="main-body" id="suppliergroup_update">
<?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
<div class="content-main-wrapper">

	<section class="content-header">

    <h1><?= Html::encode($this->title) ?></h1>
</section>
<section class="content">
  	<!-- SELECT2 EXAMPLE -->
	  	<div class="box box-default">
	        <div class="box-header with-border">
	          <!-- <h3 class="box-title">Create New</h3> -->
	        </div>   
			<!-- /.box-header -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
	      <!-- /.box -->
    </section>
</div>
</div>

