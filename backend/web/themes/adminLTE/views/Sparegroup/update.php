<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\itemgroup */

$this->title = 'Update Sparegroup: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Itemgroups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="main-body" id="sparegroup_update">
<div class="content-main-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= Html::encode($this->title) ?>        
      </h1>
    </section>
     <section class="content">
     <div class="box box-default">
    	<?= $this->render('_form', [
        'model' => $model,
    	]) ?>
	</div>
    </section>
</div>
</div>
