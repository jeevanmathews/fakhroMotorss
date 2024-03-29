<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\Itemtype;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ItemtypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Itemtypes';
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
                        <?= Html::a('Create Item Type', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>
 <?php
                    // var_dump($dataProvider->getModels());die;
                    ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        // 'id',

                        'name',
                        [
                        'label'=>'Parent Type',
                        'value'=>'group.name',
                        'filter' => Html::activeDropDownList($searchModel, 'group_id', ArrayHelper::map(Itemtype::find()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Search by Parent']),
                        ],
                        'quantity_added',
                        'set_tax',
            //'created_at',
            //'status',

                        [
                        'attribute' => 'status',
                        'value' =>function ($model){
                            return ($model->status == 1)?"Enabled":"Disabled";
                        },
                        'filter' => Html::activeDropDownList($searchModel, 'status', ["1"=>"Enable", "0" => "Disable"],['class'=>'form-control','prompt' => 'Search by Status']),
                        ],

                        ['class' => 'yii\grid\ActionColumn',
                        'template' => '{update}{view}{changeStatus}',
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
