<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ServiceType */

$this->title = 'Update Service Type: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Service Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
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
    ]) ?>

</div>
        <!-- /.box -->
    </section>
</div>
