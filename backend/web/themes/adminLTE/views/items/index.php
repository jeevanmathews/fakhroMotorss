<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\Vehiclemodels;
use backend\models\Variants;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ItemsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-main-wrapper main-body"  id="items_index">
    <div class="content-main-wrapper">

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
					<?php if(Yii::$app->common->checkPermission('ItemsController', 'create', 'true')){
					echo Html::a('Create Items', ['create'], ['class' => 'btn btn-success']);
				} ?> 
							
                        </p>
                   
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'id' => $page_id,
                            'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                          

                            // 'id',
                            // ['label'=>'Model',
                            // 'value' =>'model.name'
                            // ],
                            // ['label'=>'Variant',
                            // 'value' =>'variant.name'
                            // ],
                            'item_name',
                            'item_code',
                              [
                                'attribute' => 'model_id',
                                'label'=>'Model',
                                'value'=>'model.name',
                                'filter' => Html::activeDropDownList($searchModel, 'model_id', ArrayHelper::map(Vehiclemodels::find()->all(), 'id', 'name'),['class'=>'form-control select2','prompt' => 'Search by Model']),
                            ],
                            [
                                'attribute' => 'variant_id',
                                'label'=>'Variant',
                                'value'=>'variant.name',
                                'filter' => Html::activeDropDownList($searchModel, 'variant_id', ArrayHelper::map(Variants::find()->all(), 'id', 'name'),['class'=>'form-control select2','prompt' => 'Search by Variant']),
                            ],
                            [
                            'attribute' => 'Current Stock',
                            'value' =>function ($model){
                                return (($model->currentStock($model->id))?$model->currentStock($model->id).' '.$model->unit->code:'');
                            },
                           
                            ],
                            // 'opening_stock',
                            // ['label'=>'Unit',
                            //  'value' =>'unit.name'
                            // ],
                            // 'created_date',
                //'status',

       //                      ['class' => 'yii\grid\ActionColumn',
							// 'template' => ((Yii::$app->common->checkPermission('ItemsController', 'update', 'true')?'{update}':'').(Yii::$app->common->checkPermission('ItemsController', 'delete', 'true')?'{delete}':'').(Yii::$app->common->checkPermission('ItemsController', 'view', 'true')?'{view}':'')),

							// ],
                             ['class' => 'yii\grid\ActionColumn',
                                'template' => ((Yii::$app->common->checkPermission('ItemsController', 'update', 'true')?'{update}':'').(Yii::$app->common->checkPermission('ItemsController', 'changestatus', 'true')?'{changeStatus}':'').(Yii::$app->common->checkPermission('ItemsController', 'view', 'true')?'{view}':'')),
                                'buttons' => [
                                        'changeStatus' => function ($url, $model, $key) {
                                             $img = ($model->status == 1)?"button_cross.png":"button_tick_alt.png";
                                             $width = ($model->status == 1)?"25":"20";
                                            return Html::a(Html::img($this->theme->getUrl("images/".$img),["width" =>  $width, "title" => (($model->status == 1)?"Disable":"Enable")]), ['change-status', 'id'=>$model->id]);
                                        },
                                    ]
                                ],
                            ],


                            ]); ?>
                    
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </section>
    </div>
</div>
