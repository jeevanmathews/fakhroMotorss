<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Items */

$this->title = 'Create Items';
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
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
        'modelprice'=>$modelprice,
        'type'=>'create'
    ]) ?>
		</div>
        <!-- /.box -->
    </section>
</div>
