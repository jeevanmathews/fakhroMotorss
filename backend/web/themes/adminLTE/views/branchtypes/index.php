<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Branch Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-main-wrapper main-body" id="branchtype_index">

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
        <?= Html::a('Create Branch Type', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'type',
            // 'status',
            // 'created_date',

            ['class' => 'yii\grid\ActionColumn',         
            'template' => '{update}{changeStatus}',
            'buttons' => [
                    'changeStatus' => function ($url, $model, $key) {
                         $img = ($model->status == 1)?"button_cross.png":"button_tick_alt.png";
                         $width = ($model->status == 1)?"25":"20";
                        return Html::a(Html::img($this->theme->getUrl("images/".$img),["width" =>  $width, "title" => (($model->status == 1)?"Disable":"Enable")]), ['change-status', 'id'=>$model->id]);
                    },
                ]
            ],
        ],
        'tableOptions' => [
            'id' => 'theDatatable',
            'class'=>'table table-striped table-bordered table-hover'
            ],
    ]); ?>
 </div>
        </div>
        </div>
        </div>
          <!-- /.box -->
    </section>
</div>

