<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
/* @var $this yii\web\View */
/* @var $model backend\models\tasktype */


$this->title = 'Create Tasktype';
$this->params['breadcrumbs'][] = ['label' => 'Tasktypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-main-wrapper main-body" id="tasks_create">
<!-- Content Header (Page header) -->
<?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
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
