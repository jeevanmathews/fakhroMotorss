<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TasksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Service Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-main-wrapper main-body" id="tasks_index">

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

						  <?php if(Yii::$app->common->checkPermission('TasksController', 'create', 'true')){
							echo Html::a('Create Tasks', ['create'], ['class' => 'btn btn-success']);
						} ?> 
						
                    </p>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'id' => $page_id,
                        'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        // 'id',
                        'task',
                        'description:ntext',
                        'type',
						'billable',
						
						[
							'attribute' => 'billing_rate',
							'value' =>function ($model){
                              return ($model->billable =='yes')?$model->billing_rate:"NA";
                                },
							'format' => 'raw'
						],
                        // 'created_date',
            //'status',

                        ['class' => 'yii\grid\ActionColumn',
					'template' => ((Yii::$app->common->checkPermission('TasksController', 'update', 'true')?'{update}':'').(Yii::$app->common->checkPermission('TasksController', 'delete', 'true')?'{delete}':'').(Yii::$app->common->checkPermission('TasksController', 'view', 'true')?'{view}':'')),

                        ]
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
