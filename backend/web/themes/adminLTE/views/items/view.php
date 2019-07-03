<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use backend\models\Customfeatures;
/* @var $this yii\web\View */
/* @var $model backend\models\Items */

$this->title = $model->item_name;
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="items-view main-body" id="items_view">
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
                    <!-- <div class="col-md-12">  -->
                    <div class="col-md-6"> 

                       <!-- <div class="row"> -->
                       <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                // 'id',
                        'item_name',
                        'item_code',
                        
                        ['label'=>'Model',
                        'value' =>(isset($model->model) ? $model->model->name: '')
                        ],
                        ['label'=>'Variant',
                        'value' =>(isset($model->variant) ? $model->variant->name: '')
                        ],
                        'manufacturing_date',
                        ['label'=>'Supplier',
                        'value' =>$model->supplier->name
                        ],
                        ['label'=>'Purchase Price',
                        'value' =>$model->pricing->purchase_price
                        ],
                        ['label'=>'Selling Price',
                        'value' =>$model->pricing->selling_price
                        ],

                        [
                        'attribute' => 'Features',
                        'format' => 'html', 
                        'value' => function($model) {
                          $example = '';
                          foreach($model->featuresnValues() as $key => $value) {
                            //here your stuff
                            $example .= '<b>'.$value['name'].' </b>: '.implode(",",$value["values"]).'<br/>'; 
                        }
                      return $example;                // here's returned value
                  }
                  ],

                // 'variant_id',
                  ['label'=>'Opening stock',
                  'value' =>$model->opening_stock.' '.((isset($model->unit->name))?$model->unit->name:' ')
                  ],
                // 'opening_stock',
                  'created_date',
                // 'status',
                  ],
                  ]) ?>
            <!-- <div class="row">
            <div class="col-md-12">-->
                <?php

            // $count=0;

                ?>

              <!--   <div class="col-md-6">
        
                <div class="box box-widget widget-user-2 box-variant">

                <div class="widget-user-header variant">
                    
                    <h3 class="widget-user-username variant_name">Vehicle Features </h3>              
                </div>
                <div class="variant_features">                
                    <ul class="nav nav-stacked">
                        <?php foreach ($model->featuresnValues() as $features) {
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
             
            </div> 
        </div> -->
        <!-- </div>    -->
        <p>
         <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Edit ', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>       
           <!--  <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
                ]) ?> -->
            </p>
            <!-- </div> -->
        </div>
    </div>
</div>
</div>
</div>
<!-- /.box -->
</section>
</div>
</div>
