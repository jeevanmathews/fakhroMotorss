<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax; 

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

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'll'.time(),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],           
            'reg_num', 
            [
                'label' => 'Manufacturer',
                'value' =>function ($model){
                    return utf8_decode($model->make->manufacturer->name);
                }
            ],         
            'make.make',
            'model.model',
            'color',      
            [
                'attribute' => 'customer_id',
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
    <?php Pjax::end(); ?> 
</div>
        </div>
        </div>
        </div>
          <!-- /.box -->
    </section>
</div>

<script type="text/javascript">
    $(document).on('pjax:beforeReplace', function() {
        
        })

</script>