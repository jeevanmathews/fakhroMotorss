<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\Vehiclemodels;
use backend\models\Variants;
use yii\widgets\Pjax;

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
                            <?= Html::a('Create Items', ['create'], ['class' => 'btn btn-success']) ?>
                        </p>
                         <?php Pjax::begin(['id'=>'items']); ?>
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
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
                            // 'opening_stock',
                            // ['label'=>'Unit',
                            //  'value' =>'unit.name'
                            // ],
                            // 'created_date',
                //'status',

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
</div>
