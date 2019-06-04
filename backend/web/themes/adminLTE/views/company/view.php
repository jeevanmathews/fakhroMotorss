<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Company */

$this->title = $model->name;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
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

        <div class="box-body">
        <div class="row">
            <div class="col-md-6"> 
                <div class="row">
                    <div class="col-md-12"> 
                    <h5 class="heading"><span>Company Details</span> </h5>
                        <?= DetailView::widget([
                        'model' => $model,
                        'options' => ['class' => 'table table-striped table-bordered detail-view table-hover'],
                        'attributes' => [       
                            'name',    
                           'website',
                           'cr_number',
                           'cr_expiry',
                           'multi_branches',
                           'centrilized_warehouse',
                            [                      // the owner name of the model
                            'label' => 'Address',
                            'format' => 'ntext',
                            'value' => $model->address."\n".$model->state."\n".(isset($model->country->name)?$model->country->name:"")."\n zip: ".$model->zipcode,
                            ], 
                            'created_at',
                        ],
                    ]) ?>
                    </div>
                    <div class="col-md-12"> 
                    <h5 class="heading"><span>Contact Details</span> </h5>
                            <?= DetailView::widget([
                            'model' => $model,
                            'options' => ['class' => 'table table-striped table-bordered detail-view table-hover'],
                            'attributes' => [ 
                                'mailing_name',                            
                                'email:email',
                                'phone',
                                'fax',                                
                            ],
                        ]) ?>
                    </div>
                </div>             
        </div>

        <div class="col-md-6"> 
            <div class="row">
                <div class="col-md-12"> 
                    <h5 class="heading"><span>Account Details</span> </h5>
                    <?= DetailView::widget([
                        'model' => $model,
                        'options' => ['class' => 'table table-striped table-bordered detail-view table-hover'],
                        'attributes' => [                             
                            'vat_number',
                            'vat_expiry',                         
                            [
                            'label' => 'Vat Format',
                            'value' => (($model->vat_format =="inclusive")?"Inclusive (Apply VAT to each item cost)":"Exclusive (Apply VAT to final cost)")
                            ], 
                            'vat_rate', 
                            [
                            'label' => 'Financial Year',
                            'value' => $model->settings->financial_year
                            ], 
                            [
                            'label' => 'Books Beginning',
                            'value' => $model->settings->books_beginning
                            ],
                            [
                            'label' => 'Decimal Places',
                            'value' => $model->settings->decimal_places
                            ],
                            [
                            'label' => 'Enable Space',
                            'value' => $model->settings->enable_space
                            ],  
                            [
                            'label' => 'Date Format',
                            'value' => $model->settings->date_format
                            ], 
                            [
                            'label' => 'Suffix Symbol',
                            'value' => $model->settings->suffix_symbol
                            ],                   
                            [                      // the owner name of the model
                            'label' => 'Currency',
                            'format' => 'ntext',
                            'value' => (isset($model->settings->currency->symbol)?utf8_decode($model->settings->currency->symbol):""),
                            ],
							[                      // the owner name of the model
                            'label' => 'Logo',
                            'format' => 'html',
                            'value' => Html::img("../../backend/web/uploads/company/".$model->logo, ["class" => "img-responsive"])
                            ]
                        ],
                    ]) ?>
                    <p>
                    <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Edit Company Details', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>        
                    </p>
                </div>
            </div>
        </div>
        </div>
        </div>
        </div>
          <!-- /.box -->
    </section>
</div>