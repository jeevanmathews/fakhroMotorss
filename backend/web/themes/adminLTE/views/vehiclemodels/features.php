<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\VehiclemodelsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Features  :'.$model->name;
$this->params['breadcrumbs'][] = $this->title;
?>
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
        <?= Html::a('Add Features', ['addfeatures','id'=>$model->id], ['class' => 'btn btn-success']) ?>
    </p>
<?php

// var_dump($model);die;
// $check=array();
?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // ['label'=>'Manufacturer',
            // 'value'=>'manufacturer.name',
            // ],
            ['label'=>'Type',
            'value'=>'feature.name',
            ],
             ['label'=>'Value',
            'value'=>'value',
            ],
        //     [
        //     'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
        //     'value' => function ($data,$check) {

        //         if(!in_array($data->feature->type, $check)){
        //             array_push($check,$data->feature->type);
        //             return $data->feature->type;
        //         }
        //         // return $data->feature->type; // $data['name'] for array data, e.g. using SqlDataProvider.
        //     },
        // ],
            // 'name',
            // 'created_date',
            // 'status',    
             // ['class' => 'yii\grid\ActionColumn'], 
               ['class' => 'yii\grid\ActionColumn',
                    'template' => '{update}{changeStatus}',
                    'buttons' => [
                            'changeStatus' => function ($url, $model, $key) {
                                 $img = ($model->status == 1)?"button_cross.png":"button_tick_alt.png";
                                 $width = ($model->status == 1)?"25":"20";
                                return Html::a(Html::img($this->theme->getUrl("images/".$img),["width" =>  $width, "title" => (($model->status == 1)?"Disable":"Enable")]), ['change-status', 'id'=>$model->id]);
                            },
                            'update' => function ($url, $model, $key) {
                                 $img = ($model->status == 1)?"button_cross.png":"button_tick_alt.png";
                                 $width = ($model->status == 1)?"25":"20";
                                return Html::a(Html::tag('span', '', ['class'=>'glyphicon glyphicon-pencil', 'data-id'=>'1', 'data-ds'=>'123']), ['editfeature', 'id'=>$model->id]);
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
