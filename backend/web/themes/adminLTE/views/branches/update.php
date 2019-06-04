<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Branches */

$this->title = 'Update Branch: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Branches', 'url' => ['index']];
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
	  	<div class="box box-default">	   
	    <?= $this->render('_form', [
	        'model' => $model,
	        'countries'=>$countries,
	        'company'=>$company,
            'branchtypes'=>$branchtypes
	    ]) ?>
      </div>
    </section>
</div>
