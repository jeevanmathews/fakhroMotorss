<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ExtendedWarrantyType */

$this->title = 'Create Extended Warranty Type';
$this->params['breadcrumbs'][] = ['label' => 'Extended Warranty Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-main-wrapper main-body" id="extended-warranty-type_create">
<!-- Content Header (Page header) -->
    <section class="content-header">

    <h1><?= Html::encode($this->title) ?></h1>
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
