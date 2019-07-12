<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AmcTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Amc Types';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="content-main-wrapper main-body" id="amc-type_index">

    <section class="content-header">

    <h1><?= Html::encode($this->title) ?></h1>
   </section>
	<section class="content">
    <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">   

        <div class="box-body">
        <div class="row">
        <div class="col-md-12"> 
    <p>
        <?= Html::a('Create Amc Type', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => $page_id,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
       [	'attribute' => 'status',
			'value' =>function ($model){
				return ($model->status == 1)?"Enabled":"Disabled";
			},
			'filter' => Html::activeDropDownList($searchModel, 'status', ["1"=>"Enable", "0" => "Disable"],['class'=>'form-control','prompt' => 'Search by Status']),

                ],
                ['class' => 'yii\grid\ActionColumn',
                'template' => '{update}{changeStatus}',
                'buttons' => [
                        'changeStatus' => function ($url, $model, $key) {
                           $img = ($model->status == 1)?"button_cross.png":"button_tick_alt.png";
                           $width = ($model->status == 1)?"25":"20";
                           return Html::a(Html::img($this->theme->getUrl("images/".$img),["width" =>  $width, "title" => (($model->status == 1)?"Disable":"Enable")]), ['change-status', 'id'=>$model->id],['class'=>'change_status']);
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
