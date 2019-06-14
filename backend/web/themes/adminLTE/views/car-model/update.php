<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model backend\models\CarModel */

$this->title = 'Update Car Model: ' . $model->model;
$this->params['breadcrumbs'][] = ['label' => 'Car Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="main-body" id="car-model_update">
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

