<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\Customer;
use backend\models\Items;
use backend\models\Units;
use backend\models\User;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PurchaseorderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Delivery Order';
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
                        <?= Html::a('Create DO', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        // 'id',
                        // 'pr_id',
                        ['label'=>'SO',
                        'value'=>'so.so_number'],
                        [
                        'attribute' => 'do_number',
                        'value' =>function ($model){
                            return (($model->prefix)?$model->prefix->prefix.'-'.$model->do_number:'');
                        },
                       
                        ],
                        'do_date',
                         [
                        'attribute' => 'do_created_by',
                        'label'=>'DO By',
                        'value'=>'user.firstname',
                        'filter' => Html::activeDropDownList($searchModel, 'do_created_by', ArrayHelper::map(User::find()->all(), 'id', 'firstname'),['class'=>'form-control','prompt' => 'Search by User']),
                        ],
                        [
                        'attribute' => 'customer_id',
                        'label'=>'Customer_id',
                        'value'=>'customer.name',
                        'filter' => Html::activeDropDownList($searchModel, 'customer_id', ArrayHelper::map(Customer::find()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Search by Customer']),
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


