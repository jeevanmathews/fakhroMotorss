<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model backend\models\Make */

$this->title = 'Create Make';
$this->params['breadcrumbs'][] = ['label' => 'Makes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-main-wrapper main-body" id="make_create">
<?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
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
