<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model backend\models\AmcType */

$this->title = 'Create Amc Type';
$this->params['breadcrumbs'][] = ['label' => 'Amc Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-main-wrapper main-body" id="amc-type_create">
<?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
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
