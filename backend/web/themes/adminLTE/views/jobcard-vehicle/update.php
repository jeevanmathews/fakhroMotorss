<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\JobcardVehicle */

$this->title = 'Update Jobcard Vehicle: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Jobcard Vehicles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="main-body" id="jobcard-vehicle_update">
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

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
	</div>
        <!-- /.box -->
    </section>
</div>
</div>