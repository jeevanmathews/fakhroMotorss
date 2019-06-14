<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;
/* @var $this yii\web\View */
/* @var $model backend\models\Vehiclemodels */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Vehicles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="vehiclemodels-view main-body" id="vehiclemodels_view">
    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
<div class="content-main-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Vehicle Model: 
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
                     'options' => ['class' => 'table table-striped table-bordered detail-view table-hover'],
                    'attributes' => [
                         [  'label'=>'Manufacturer',
                            'value'=>$model->manufacturer->name,
                        ],
                        'name',
                        'created_date',                       
                        [
                            'attribute'=>'status',
                            'format' => 'html',
                            'value' =>   Html::img($this->theme->getUrl("images/".(($model->status == 1)?"button_tick_alt.png":"button_cross.png")), ["width" =>  '25', "title" => (($model->status == 1)?"Disable":"Enable")]),
                        ],
                    ],
                ]) ?>            
            </div>
        </div>

        <div class="row">
        <div class="col-md-12"><h5 class="heading"><span>Variants</span> </h5></div>
        <div class="col-md-12">
        <?php
        if(!$model->variants)
            echo "No Variants Found";
        $count=0;
         foreach($model->variants as $variant){ ?>
        
        
       <?php if($count%2==0){?> <div class="row"><?php } ?>
            <div class="col-md-6">
            <!-- <h5 class="heading"><span><?php echo $variant->name; ?></span> </h5> -->

            <div class="box box-widget widget-user-2 box-variant">

            <div class="widget-user-header variant">
                
                <h3 class="widget-user-username variant_name"><?php echo $variant->name; ?> </h3>              
            </div>
            <div class="variant_features">                
                <ul class="nav nav-stacked">
                    <?php foreach ($variant->variantfeaturesArray() as $features) {
                        ?>
                        <li>
                            <div class="row">
                                <div class="col-md-6"><?php echo $features['name'];?></div>
                                <div class="col-md-6">
                                    <?php echo implode(",", $features['values']); ?>
                                </div>
                            </div>
                        </li>
                    <?php }?>   
                </ul>
            </div>
            </div>
            </div>
           <?php if($count%2==1){?> </div><?php } $count++;?>
        
        <?php }?>
        </div> 
        </div>

        </div>
        </div>
    </section>
</div>
</div>
