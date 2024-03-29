<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SalesOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sales Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-order-index main-body" id="sales-order_index">
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
        <?= Html::a('Create Sales Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

   <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        // 'id',
                        // 'pr_id',
                        ['label'=>'QTN',
                        'value'=>'qtn.qtn_number'],
                        [
                        'attribute' => 'so_number',
                        'value' =>function ($model){
                            return (($model->prefix)?$model->prefix->prefix.'-'.$model->so_number:'');
                        },
                       
                        ],
                        'so_date',
                        'so_expected_date',
                            //'po_created_by',
                            //'subtotal',
                            //'total_tax',
                            //'grand_total',
                            //'status',

                        [
                        'attribute' => 'status',
                        'value' =>function ($model){
                            return ($model->status == 1)?"Enabled":"Disabled";
                        },
                        'filter' => Html::activeDropDownList($searchModel, 'status', ["1"=>"Enabled", "0" => "Disabled"],['class'=>'form-control','prompt' => 'Search by Status']),
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
