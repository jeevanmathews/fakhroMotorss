<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CarModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Car Models';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-main-wrapper main-body" id="car-model_index">

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
        <div class="col-md-12"> 

    <p>
        <?= Html::a('Create Car Model', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',   
            [
                'attribute' => 'manufacturer',                
                'value' =>function ($model){
                    return ($model->make->manufacturer->name);
                }
            ],      
            [
                'attribute' => 'make_id',
                'label' => 'Make',
                'value' =>function ($model){
                    return ($model->make->make);
                }
            ],            
            'model',
            'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
        </div>
        </div>
        </div>
          <!-- /.box -->
    </section>
</div>
