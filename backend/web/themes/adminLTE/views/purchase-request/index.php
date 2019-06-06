<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\Supplier;
use backend\models\Items;
use backend\models\Units;
use backend\models\User;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PurchaserequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Purchase Requisition';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-main-wrapper main-body" id="purchsae-request_index">

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
                        <?= Html::a('Create Purchase requisition', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

            // 'id',
                       [
                        'attribute' => 'pr_number',
                        'value' =>function ($model){
                            return (($model->prefix)?$model->prefix->prefix.'-'.$model->pr_number:'');
                        },
                       
                        ],
                        [
                        'attribute' => 'requested_by',
                        'label'=>'Requested By',
                        'value'=>'user.firstname',
                        'filter' => Html::activeDropDownList($searchModel, 'requested_by', ArrayHelper::map(User::find()->all(), 'id', 'firstname'),['class'=>'form-control','prompt' => 'Search by User']),
                        ],
                        [
                        'attribute' => 'supplier_id',
                        'label'=>'Supplier',
                        'value'=>'supplier.name',
                        'filter' => Html::activeDropDownList($searchModel, 'supplier_id', ArrayHelper::map(Supplier::find()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Search by Supplier']),
                        ], 
                        // 'request_date',
                        'expected_date',
            //'status',
                        'process_status',
                        [
                        'attribute' => 'status',
                        'value' =>function ($model){
                            return ($model->status == 1)?"Enabled":"Disabled";
                        },
                        'filter' => Html::activeDropDownList($searchModel, 'status', ["1"=>"Enabled", "0" => "Disabled"],['class'=>'form-control','prompt' => 'Search by Status']),
                        ],
                        //  [
                        // 'attribute' => 'process_status',
                        // 'value' =>function ($model){
                        //     return $model->process_status;
                        // },
                        // 'filter' => Html::activeDropDownList($searchModel, 'process_status', ["pending"=>"Pending", "processing" => "Processing",'completed'=>"Completed"],['class'=>'form-control','prompt' => 'Search by Status']),
                        // ],
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
                         ['class' => 'yii\grid\ActionColumn',
                         'header'=>'Create PO',
                          'template' => '{my_button}', 
                          'buttons' => [
                              'my_button' => function ($url, $model, $key) {
                                 return Html::a('<span class="glyphicon glyphicon-check"></span>', Yii::$app->getUrlManager()->createUrl(['purchase-order/createpo', 'id' =>$model->id,]), [
                                  'title' => Yii::t('app', 'Create PO'),
                      ]);
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


