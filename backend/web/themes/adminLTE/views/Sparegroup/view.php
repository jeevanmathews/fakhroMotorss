<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\itemgroup */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Itemgroups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="content-main-wrapper main-body"  id="sparegroup_view">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= Html::encode($this->title) ?>        
      </h1>
    </section>
    
    <section class="content">
    <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">   

        <div class="box-body">
        <div class="row">
        <div class="col-md-6"> 

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
            'label'=>'Parent',
            'value' => $model->parent->category_name,
            ],
            'category_name',
             [                     
			'label' =>  'Status',
			'format' => 'ntext',
			'value' => ($model->status == '0'? "Disable":"Enable"),
			],
        ],
    ]) ?>

<p>
<?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Edit Details', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>       
 </p>
            </div>

        </div>             
        </div>
        </div>
    </section>
</div>
