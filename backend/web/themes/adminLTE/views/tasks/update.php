<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
/* @var $this yii\web\View */
/* @var $model backend\models\Tasks */

$this->title = 'Update Service Tasks: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="main-body" id="tasks_update">
<?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
<div class="content-main-wrapper">
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
		'day'=>$day,
		'model' => $model,
		'day' => $day,
		'hour'=> $hour,
		'minutes'=>$minutes,
		'type'=>'update',
    ]) ?>
		</div>
        <!-- /.box -->
    </section>
</div>
</div>