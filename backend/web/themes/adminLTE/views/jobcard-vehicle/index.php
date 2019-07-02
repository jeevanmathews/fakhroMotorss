<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Manufacturer;
use yii\helpers\Arrayhelper;
//use yii\widgets\Pjax; 

/* @var $this yii\web\View */
/* @var $searchModel backend\models\JobcardVehicleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jobcard Vehicles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-main-wrapper main-body" id="jobcard-vehicle_index">

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
            <?= Html::a('Create Jobcard Vehicle', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,             
                'id' => $page_id,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],           
                    'reg_num', 
                    [
                        'label' => 'Manufacturer',
                        'attribute' => 'make_id',
                        'filter' => Html::activeDropDownList($searchModel, 'make_id', ArrayHelper::map(Manufacturer::find()->where(['status' => 1])->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Search by Manufacturer']),
                        'value' =>function ($model){
                            return utf8_decode($model->make->name);
                        }
                    ],
                    'vehicletype.name', 
                   /* [
                       
                        'attribute' => 'make_id',
                        'filter' => Html::activeTextInput($searchModel, 'make_id',['class'=>'form-control','prompt' => 'Search by Make']),
                        'value' =>function ($model){
                            return utf8_decode($model->make->make);
                        }
                    ],*/
                    [
                       
                        'attribute' => 'model_id',
                        'filter' => Html::activeTextInput($searchModel, 'model_id',['class'=>'form-control','prompt' => 'Search by Model']),
                        'value' =>function ($model){
                            return utf8_decode($model->model->model);
                        }
                    ],  
                    'color',      
                    [
                        'attribute' => 'customer_id',
                        'filter' => Html::activeTextInput($searchModel, 'customer_id',['class'=>'form-control','prompt' => 'Search by Customer']),
                        'value' => function($model){
                            return ($model->customer)?$model->customer->name:"";
                        }
                    ],
                    //'tr_number',
                    //'amc_type',
                    //'amc_expiry_date',
                    //'extended_warranty_type',
                    //'ew_expiry_kms',
                    //'ew_expiry_date',
                    //'service_schedule',

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
