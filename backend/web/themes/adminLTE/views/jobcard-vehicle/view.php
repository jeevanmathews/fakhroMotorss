<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;
/* @var $this yii\web\View */
/* @var $model backend\models\JobcardVehicle */


$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Jobcard Vehicles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="content-main-wrapper main-body"  id="jobcard-vehicle_view">
<?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Jobcard Vehicle       
      </h1>
    </section>
    
    <section class="content">
    <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">   

        <div class="box-body">
        <div class="row">
        <div class="col-md-6"> 
    <div class="row">
    <div class="col-md-12"> 
    <h5 class="heading"><span>Jobcard Vehicle</span> </h5>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'reg_num',
            'chasis_num',
            'make_id',
            'model_id',
            'color',
            'tr_number',
            'amc_type',
            'amc_expiry_date',
            'extended_warranty_type',
            'ew_expiry_kms',
            'ew_expiry_date',
            'service_schedule',
        ],
    ]) ?>

</div>
                </div>
            </div>
        </div>
        </div>
        </div>
          <!-- /.box -->
    </section>
</div>
