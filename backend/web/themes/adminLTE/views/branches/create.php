<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
/* @var $this yii\web\View */
/* @var $model backend\models\Branches */

$this->title = 'Create Branch';
$this->params['breadcrumbs'][] = ['label' => 'Branches', 'url' => ['index']];
$this->params['breadcrumbs'][] =  'Create Branch' ;
?>
<div class="branches-create main-body" id="branches_create">
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
  	        'countries'=>$countries,
  	        'company'=>$company,
              'branchtypes'=>$branchtypes
  	    ]) ?>
  </div>
  </section>
  </div>
</div>
