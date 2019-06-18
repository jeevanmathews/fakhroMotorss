<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
/* @var $this yii\web\View */
/* @var $model backend\models\Items */

$this->title = 'Update Item: ' .$model->item_name;
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->item_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="items-update main-body" id="items_update">
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
          'types'=>$types,
          'type'=>'update',
          'modelprice'=>$modelprice,
      ]) ?>
  		</div>
          <!-- /.box -->
      </section>
  </div>
</div>
