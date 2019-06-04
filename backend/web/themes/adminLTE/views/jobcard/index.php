<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\JobcardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jobcards';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-main-wrapper main-body" id="jobcard_index">

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
        <?= Html::a('Create Jobcard', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Jobcard Number',
                'attribute' => 'id',
                'value' => 'id',
            ],
       
            //'created_date',
            'promised_date',
            'advance_paid',
            'status',
            //'receipt_num',
            //'sales_manager',
            //'service_advisor',
            //'labour_cost',
            //'material_cost',
            //'tax',
            //'total_charge',
            //'customer_id',

            ['class' => 'yii\grid\ActionColumn',
            'template' => Yii::$app->common->listViewActions('jobcard'),
            'buttons' => [
            'mytasks' => function ($url, $model, $key) {
                return Html::a('My Tasks', ['mytasks'], ['style'=> 'color:#3c8dbc;    text-decoration: underline;']);
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
