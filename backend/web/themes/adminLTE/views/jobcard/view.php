<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;
/* @var $this yii\web\View */
/* @var $model backend\models\Jobcard */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Jobcards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="content-main-wrapper main-body"  id="jobcard_view">
 <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
           Jobcard Number   
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
                    <h5 class="heading"><span>Vehicle Details</span> </h5>
                        <?= DetailView::widget([
                        'model' => $model,
                        'options' => ['class' => 'table table-striped table-bordered detail-view table-hover'],
                        'attributes' => [ 
                            [
                            'label'=>'Make',
                            'value' => (isset($model->vehicle)?$model->vehicle->make->name:''),
                            ],
                            [
                            'label'=>'Model',
                            'value' => (isset($model->vehicle)?$model->vehicle->model->model:''),
                            ],
                            [
                            'label'=>'Color',
                            'value' => (isset($model->vehicle)?$model->vehicle->color:''),
                            ],
                            [
                            'label'=>'Meter Reading',
                            'value' => $model->meter_reading,
                            ],
                            [
                            'label'=>'Fuel level',
                            'value' => $model->fuel_level,
                            ],
                            [
                            'label'=>'Registration Number',
                            'value' => (isset($model->vehicle->reg_num)?$model->vehicle->reg_num:''),
                            ],
                            [
                            'label'=>'Chaisis Number',
                            'value' => (isset($model->vehicle->chasis_num)?$model->vehicle->chasis_num:''),
                            ],
                            [
                            'label'=>'Amc Type',
                            'value' => (($model->vehicle->amc_type)?$model->vehicle->amcType->name:"NA"),
                            ],
                            [
                            'label'=>'Amc Expiry Date',
                            'value' => $model->vehicle->amc_expiry_date,
                            ],
                            [
                            'label'=>'Extended Warranty Type',
                            'value' => (($model->vehicle->extended_warranty_type)?$model->vehicle->extendedWarrantyType->name:"NA"),
                            ],
                            [
                            'label'=>'Ew Expiry Date',
                            'value' => $model->vehicle->ew_expiry_date,
                            ],
                            [
                            'label'=>'Ew Expiry Kms',
                            'value' => $model->vehicle->ew_expiry_kms,
                            ],
                            [
                            'label'=>'Service Schedule',
                            'value' => $model->vehicle->service_schedule,
                            ],
                            
                            
                          
                        ],
                    ]) ?>
                    </div>
                    <div class="col-md-12"> 
                    <h5 class="heading"><span>Customer Details</span> </h5>
                    <?= DetailView::widget([
                            'model' => $model,
                            'options' => ['class' => 'table table-striped table-bordered detail-view table-hover'],
                            'attributes' => [ 
                            [
                            'label'=>'Name',
                            'value' => (isset($model->customer)?$model->customer->name:'Nil'),
                            ],
                            [
                            'label'=>'Contact Name',
                            'value' => (isset($model->customer)?$model->customer->contact_name:'Nil'),
                            ],
                            [
                            'label'=>'Contact Number',
                            'value' => (isset($model->customer)?$model->customer->contact_number:'Nil'),
                            ],
                            [
                            'label'=>'Alternate Contact Number',
                            'value' => (isset($model->customer)?$model->customer->alt_phone:'Nil'),
                            ],
                            [
                            'label'=>'Email',
                            'value' => (isset($model->customer)?$model->customer->email:'Nil'),
                            ],
                            [
                            'label' => 'Address',
                            'format' => 'ntext',
                            'value' =>(isset($model->address)?$model->address:'Nil'),
                            ],
                            ],
                        ]) ?>   
                     
                    </div>
                </div>             
        </div>
                <div class="col-md-6"> 
            <div class="row">
                <div class="col-md-12"> 
                    <h5 class="heading"><span>Jobcard Details</span> </h5>
                       <?= DetailView::widget([
                            'model' => $model,
                            'options' => ['class' => 'table table-striped table-bordered detail-view table-hover'],
                            'attributes' => [ 
                            [
                            'label'=>'Branch',
                            'value' => $model->branch->name,
                            ], 
                            [
                            'label'=>'Service Advisor',
                            'value' => (isset($model->invoice->advisor) ? $model->invoice->advisor->first_name."\t".$model->invoice->advisor->last_name:'Nil'),
                            ],
                            [
                            'label'=>'Service Manager',
                            'value' => (isset($model->invoice->manager) ? $model->invoice->manager->first_name."\t".$model->invoice->manager->last_name:'Nil'),
                            ],
                            [
                            'label'=>'Vehicle Tested By',
                            'value' => (isset($model->invoice->testedby) ? $model->invoice->testedby->first_name."\t".$model->invoice->testedby->last_name:'Nil'),
                            ],
                            [
                            'label'=>'Service Type',
                            'value' => (isset($model->invoice->serviceType) ? $model->invoice->serviceType->name:'Nil'),
                            ],
                            [
                            'label'=>'Next Service Type',
                            'value' => (isset($model->invoice->NextServiceType) ? $model->invoice->NextServiceType->name:'Nil'),
                            ], 
                            [
                            'label'=>'Jobcard Status',
                            'value' => (isset($model->invoice->jobcardStatus) ? $model->invoice->jobcardStatus->name:'Nil'),
                            ],
                            [
                            'label'=>'Promised Date',
                            'value' =>(isset($model->invoice->promised_date)?date('d/m/Y h:iA', strtotime($model->invoice->promised_date)):''),
                            ],
							[
                            'label'=>'Issued Date',
                            'value' =>(isset($model->invoice->created_date)?date('d/m/Y h:iA', strtotime($model->invoice->created_date)):''),
                            ],
							
                            [
                            'label'=>'Advance Paid',
                            'value' =>(isset($model->invoice->advance_paid)?$model->invoice->advance_paid:''),
                            ],
                            [
                            'label'=>'Receipt No',
                            'value' =>(isset($model->invoice->receipt_num)?$model->invoice->receipt_num:''),
                            ],
                            [
                            'label' => 'Comment',
                            'format' => 'ntext',
                            'value' =>(isset($model->invoice->comment)?$model->invoice->comment:'Nil'),
                            ],
                            ],
                        ]) ?>     
                    <p>
                    <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Edit Jobcard', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>        
                    </p>
                </div>
            </div>
        </div>
        </div>
        
        </div>
        </div>
        </section>
</div>      
            