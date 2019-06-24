<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\Supplier;
use backend\models\Items;
use backend\models\Units;
use backend\models\User;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PurchaseorderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Purchase Invoice';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-main-wrapper main-body"  id="purchase-invoice_index">
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
                        <?= Html::a('Create Purchase Invoice', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>
                     <?php Pjax::begin(['id'=>'purchase-invoice']); ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'id' => $page_id,
                        'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        // 'id',
                        // 'pr_id',
                        // ['label'=>'GRN',
                        // 'value'=>'grn.grn_number'],
                        // ['label'=>'PO',
                        // 'value'=>'po.po_number'],
                         [
                        'attribute' => 'po_number',
                        'value' =>function ($model){
                            return (isset($model->po)?$model->po->prefix->prefix.'-'.$model->po->po_number:'(Not Set)');
                        },
                       
                        ],
                         [
                        'attribute' => 'grn_number',
                        'value' =>function ($model){
                            return (isset($model->grn)?$model->grn->prefix->prefix.'-'.$model->grn->grn_number:'(Not Set)');
                        },
                       
                        ],
                        [
                        'attribute' => 'inv_number',
                        'value' =>function ($model){
                            return (($model->prefix)?$model->prefix->prefix.'-'.$model->inv_number:'');
                        },
                       
                        ],
                        'inv_date',
                         [
                        'attribute' => 'inv_created_by',
                        'label'=>'Purchase Invoice By',
                        'value'=>'user.firstname',
                        'filter' => Html::activeDropDownList($searchModel, 'inv_created_by', ArrayHelper::map(User::find()->all(), 'id', 'firstname'),['class'=>'form-control','prompt' => 'Search by User']),
                        ],
                        [
                        'attribute' => 'supplier_id',
                        'label'=>'Supplier',
                        'value'=>'supplier.name',
                        'filter' => Html::activeDropDownList($searchModel, 'supplier_id', ArrayHelper::map(Supplier::find()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Search by Supplier']),
                        ], 
                        // 'po_expected_date',
                            // 'grn_created_by',
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
                        'template' => '{view}{changeStatus}',
                        'buttons' => [
                        'changeStatus' => function ($url, $model, $key) {
                         $img = ($model->status == 1)?"button_cross.png":"button_tick_alt.png";
                         $width = ($model->status == 1)?"25":"20";
                         return Html::a(Html::img($this->theme->getUrl("images/".$img),["width" =>  $width, "title" => (($model->status == 1)?"Disable":"Enable")]), ['change-status', 'id'=>$model->id],['class'=>'change_status']);
                     },
                     ]
                     ],
                      ['class' => 'yii\grid\ActionColumn',
                       'header'=>'Purchase Return',
                       'template' => '{my_button}', 
                       'buttons' => [
                       'my_button' => function ($url, $model, $key) {
                         if($model->process_status!="completed"):
                           return Html::a('<span class="glyphicon glyphicon-check"></span>', Yii::$app->getUrlManager()->createUrl(['purchase-return/createprtninv', 'id' =>$model->id,]), [
                              'title' => Yii::t('app', 'Purchase Return'),
                              ]);
                         endif;
                       },
                       ]
                       ],

                       ['class' => 'yii\grid\ActionColumn',
                       'header'=>'Invoice Print View',
                       'template' => '{my_button}', 
                       'buttons' => [
                       'my_button' => function ($url, $model, $key) {
                         if($model->process_status!="completed"):
                           return Html::a('<span class="glyphicon glyphicon-check"></span>', Yii::$app->getUrlManager()->createUrl(['purchase-invoice/invoice', 'id' =>$model->id,]), [
                              'title' => Yii::t('app', 'Invoice Print View'),
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

