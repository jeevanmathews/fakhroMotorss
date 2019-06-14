<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model backend\models\itemgroup */

$this->title = " Update" . $type ;
$this->params['breadcrumbs'][] = ['label' => $type, 'url' => ['index','type' => $type]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="main-body" id="itemgroup_update">
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
     <div class="box box-default">
    	<?= $this->render('_form', [
        'model' => $model,
        'type'=>$type
    	]) ?>
	</div>
    </section>
</div>
</div>
