<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Tasks */

$this->title = 'Create Service Tasks';
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
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
		'day' => $day,
		'hour'=> $hour,
		'minutes'=>$minutes,
		'type'=>'create',
    ]) ?>
		</div>
        <!-- /.box -->
    </section>
</div>
