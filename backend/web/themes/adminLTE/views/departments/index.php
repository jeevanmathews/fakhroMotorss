<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Departments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-main-wrapper main-body"  id="departments_index">

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
        <?php if(Yii::$app->common->checkPermission('DepartmentsController', 'create', 'true')){
            echo Html::a('Create Departments', ['create'], ['class' => 'btn btn-success']);
        } ?>        

        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
            'id' => $page_id,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'name',
                // ['class' => 'yii\grid\ActionColumn',
                // 'template' => ((Yii::$app->common->checkPermission('DepartmentsController', 'update', 'true')?'{update}':'').(Yii::$app->common->checkPermission('DepartmentsController', 'delete', 'true')?'{delete}':'')),
                // ],
                ['class' => 'yii\grid\ActionColumn',
                                'template' => ((Yii::$app->common->checkPermission('DepartmentsController', 'update', 'true')?'{update}':'').(Yii::$app->common->checkPermission('DepartmentsController', 'changestatus', 'true')?'{changeStatus}':'')),
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
