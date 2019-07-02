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
       Customer Search
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
                            <?= Html::textInput("cus_name", "", ['placeholder' => 'Customer Name', 'id' => 'cus_name'])?>

                            <?= Html::button('Search', ['class' => 'btn btn-success', 'id' => 'advanced_search']) ?>
                        </p>
                  
                        <?php \yii\widgets\Pjax::begin(); ?>
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,                            
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                'name', 
                                'email',                            
                                ['class' => 'yii\grid\ActionColumn',
                                  'template' => '{select}',
                                  'buttons' => [                                    
                                    'select' => function ($url, $model, $key) {
                                        return Html::button('select', ['class' => 'jobc-vehicle', 'onclick' => 'selectCustomer('.$model->id.');']);
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

