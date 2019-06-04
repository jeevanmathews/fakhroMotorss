<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\JobcardStatus */

$this->title = 'Create Jobcard Status';
$this->params['breadcrumbs'][] = ['label' => 'Jobcard Statuses', 'url' => ['index']];
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
    ]) ?>

</div>
        <!-- /.box -->
    </section>
</div>

