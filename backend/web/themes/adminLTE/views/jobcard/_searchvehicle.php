<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\JobcardVehicleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jobcard Vehicles';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="content-main-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Vehicle Search
      </h1>
    </section>
    
    <section class="content">
    <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">   

        <div class="box-body">
        <div class="row">
            <div class="col-md-12"> 
                <div class="row">
                    <div class="col-md-12"> 
                        <p>                            
                            <?= Html::textInput("reg_num", "", ['placeholder' => 'Veh.Reg. Number', 'id' => 'reg_num'])?>

                            <?= Html::button('Search', ['class' => 'btn btn-success', 'id' => 'advanced_search_veh']) ?>
                        </p>
                  
                        <?php \yii\widgets\Pjax::begin(); ?>
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,                            
                            'columns' => [
                                //['class' => 'yii\grid\SerialColumn'],
                                'reg_num',                               
                                 [
                                    'attribute' => 'chasis_num',
                                    'format' => 'html',    
                                    'value' =>function ($model){
                                        return substr($model->chasis_num, 0, 3)."..."."<span class='hide'>".$model->chasis_num."</span>";
                                    }
                                ],
                                [
                                    'label' => 'Manufacturer',
                                    'format' => 'html',
                                    'value' =>function ($model){
                                        return utf8_decode($model->make->manufacturer->name)."<span class='hide'>".$model->make->manufacturer_id."</span>";
                                    }
                                ], 
                                [
                                    'label' => 'Make',
                                    'format' => 'html',
                                    'value' =>function ($model){
                                        return utf8_decode($model->make->make)."<span class='hide'>".$model->make_id."</span>";
                                    }
                                ],  
                                [
                                    'label' => 'Model',
                                    'format' => 'html',
                                    'value' =>function ($model){
                                        return utf8_decode($model->model->model)."<span class='hide'>".$model->model_id."</span>";
                                    }
                                ], 
                                'color',
                                ['class' => 'yii\grid\ActionColumn',
                                  'template' => '{select}',
                                  'buttons' => [
                                    'select' => function ($url, $model, $key) {
                                        return Html::button('select', ['class' => 'jobc-vehicle', 'onclick' => 'selectVehicle('.$model->id.');']);
                                    },        
                                    ]
                                ],
                            ],
                        ]); ?>
                        <?php \yii\widgets\Pjax::end(); ?>
                       
                    </div>
                </div>             
        </div>
        </div>
        </div>
        </div>
          <!-- /.box -->
    </section>
</div>


