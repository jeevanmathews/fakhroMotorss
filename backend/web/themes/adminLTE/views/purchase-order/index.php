<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax; 
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PurchaseorderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Purchaseorders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-order-index main-body" id="purchase-order_index">
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
                        <?= Html::a('Create Purchase Order', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>
                     <?php Pjax::begin(['id'=>'purchase-order']); ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'id' => $page_id,
                        'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        // 'id',
                        // 'pr_id',
                        ['label'=>'PR',
                        'value'=>'pr.pr_number'],
                        [
                        'attribute' => 'po_number',
                        'value' =>function ($model){
                            return (($model->prefix)?$model->prefix->prefix.'-'.$model->po_number:'');
                        },

                        ],
                        'po_date',
                        'po_expected_date',
                          [
                          'attribute' => 'process_status',
                          'value' =>'process_status',
                          'filter' => Html::activeDropDownList($searchModel, 'process_status', ["pending"=>"pending", "processing" => "processing","completed" =>"completed"],['class'=>'form-control','prompt' => 'Search by Process Status']),
                          ],
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
                           return Html::a(Html::img($this->theme->getUrl("images/".$img),["width" =>  $width, "title" => (($model->status == 1)?"Disable":"Enable")]), ['change-status', 'id'=>$model->id],['class'=>'change_status']);
                       },
                       ]
                       ],
                       ['class' => 'yii\grid\ActionColumn',
                       'header'=>'Create GRN',
                       'template' => '{my_button}', 
                       'buttons' => [
                       'my_button' => function ($url, $model, $key) {
                        if($model->process_status!="completed"):
                           return Html::a('<span class="glyphicon glyphicon-check"></span>', Yii::$app->getUrlManager()->createUrl(['goods-receipt-note/creategrn', 'id' =>$model->id,]), [
                              'title' => Yii::t('app', 'Create GRN'),
                              ]);
                         endif;
                       },
                       ]
                       ],
                       ['class' => 'yii\grid\ActionColumn',
                       'header'=>'Create Invoice',
                       'template' => '{my_button}', 
                       'buttons' => [
                       'my_button' => function ($url, $model, $key) {
                         if($model->process_status!="completed"):
                           return Html::a('<span class="glyphicon glyphicon-check"></span>', Yii::$app->getUrlManager()->createUrl(['purchase-invoice/createpoinv', 'id' =>$model->id,]), [
                              'title' => Yii::t('app', 'Create Invoice'),
                              ]);
                         endif;
                       },
                       ]
                       ],
                       ],
                       'tableOptions' => [
                       'id' => 'theDatatable',
                       'class'=>'table table-striped table-bordered table-hover'
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
