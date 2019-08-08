<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Manufacturer;
use backend\models\Vehicletype;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\VehiclemodelsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vehicles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-main-wrapper main-body"  id="vehiclemodels_index">
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
        
			<?php if(Yii::$app->common->checkPermission('VehiclemodelsController', 'create', 'true')){
					echo Html::a('Create Vehicles', ['create'], ['class' => 'btn btn-success']);
				} ?> 
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => $page_id,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],            
            [
                'attribute' => 'manufacturer_id',
                'label'=>'Manufacturer',
                'value'=>'manufacturer.name',
                'filter' => Html::activeDropDownList($searchModel, 'manufacturer_id', ArrayHelper::map(Manufacturer::find()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Search by Manufacturer']),
            ],
            [
                'attribute' => 'type_id',
                'label'=>'Type',
                'value'=>'type.name',
                'filter' => Html::activeDropDownList($searchModel, 'type_id', ArrayHelper::map(Vehicletype::find()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Search by Vehicle']),
            ], 
            'name',      
            [
                'attribute' => 'created_date',
                'value' => function($model){
                    return Yii::$app->common->displayDate($model->created_date); 
                },
                'filter' => ''
            ],  
            [   'class' => 'yii\grid\ActionColumn',
				'template' => ((Yii::$app->common->checkPermission('VehiclemodelsController', 'update', 'true')?'{update}':'')
				.(Yii::$app->common->checkPermission('VehiclemodelsController', 'changestatus', 'true')?'{changeStatus}':'').(Yii::$app->common->checkPermission('DesignationsController', 'view', 'true')?'{view}':'')),
                'header'=>'Actions',
                'buttons' => [
                        'changeStatus' => function ($url, $model, $key) {
                           $img = ($model->status == 1)?"button_cross.png":"button_tick_alt.png";
                           $width = ($model->status == 1)?"25":"20";
                           return Html::a(Html::img($this->theme->getUrl("images/".$img),["width" =>  $width, "title" => (($model->status == 1)?"Disable":"Enable")]), ['change-status', 'id'=>$model->id],['class'=>'change_status']);
                       },
                       ]
            ],
            ['class' => 'yii\grid\ActionColumn',
            'header'=>'Variants',
            'template' => '{add_variant} {view_variant}', 
            'buttons' => [
                'add_variant' => function ($url, $model, $key) {
                   return Html::a('Add Variant <span class="glyphicon glyphicon-plus"></span>', Yii::$app->getUrlManager()->createUrl(['vehiclemodels/variant', 'id' =>$model->id,]), [
                    'class' => 'btn btn-add-variant',
                    'title' => Yii::t('app', 'Add Variants'),
                    ]);
                },
                'view_variant' => function ($url, $model, $key) {                  
                   return '<div class="btn-group variant-dropdown">
          
                  <button type="button" class="btn btn-info btn-flat dropdown-toggle" data-toggle="dropdown">
                    Variants<span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    '.(($model->variantList())?$model->variantList():"<li>No variants</li>").'
                  </ul>
                </div>';
                },
            ]
            ],
        ],
          'tableOptions' => [
                'id' => 'theDatatable',
                'class'=>'table table-striped table-bordered table-hover'
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
