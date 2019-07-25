<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax; 
use yii\helpers\Arrayhelper;
use backend\models\Departments;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DesignationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Designations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-main-wrapper main-body"  id="designations_index">
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
				<?php if(Yii::$app->common->checkPermission('DesignationsController', 'create', 'true')){
					echo Html::a('Create Designation', ['create'], ['class' => 'btn btn-success']);
				} ?> 
                    </p>

                    <?php Pjax::begin(); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'id' => $page_id,
                        'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        // 'id',
                        'name',
                        /*[
                          'attribute' => 'department_id',
                          'label' => 'Deaprtment',
                          'value' =>function ($model){
                            return $model->department->name;
                            },
                        ],*/
                        [
                        'label' => 'Department',
                        'attribute' => 'department_id',
                        'filter' => Html::activeDropDownList($searchModel, 'department_id', ArrayHelper::map(Departments::find()->where(['status' => 1])->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Search by Deaprtment']),
                        'value' =>function ($model){
                            return utf8_decode($model->department->name);
                        }
                        ], 

                        [
                        'attribute' => 'status',
                        'value' =>function ($model){
                            return ($model->status == 1)?"Enabled":"Disabled";
                        },
                        'filter' => Html::activeDropDownList($searchModel, 'status', ["1"=>"Enable", "0" => "Disable"],['class'=>'form-control','prompt' => 'Search by Status']),
                        ],
                        ['class' => 'yii\grid\ActionColumn',
						'template' => ((Yii::$app->common->checkPermission('DesignationsController', 'update', 'true')?'{update}':'').(Yii::$app->common->checkPermission('DesignationsController', 'changestatus', 'true')?'{changeStatus}':'').(Yii::$app->common->checkPermission('DesignationsController', 'view', 'true')?'{view}':'')),

						
                        'buttons' => [
                        'changeStatus' => function ($url, $model, $key) {
                           $img = ($model->status == 1)?"button_cross.png":"button_tick_alt.png";
                           $width = ($model->status == 1)?"25":"20";
                           return Html::a(Html::img($this->theme->getUrl("images/".$img),["width" =>  $width, "title" => (($model->status == 1)?"Disable":"Enable")]), ['change-status', 'id'=>$model->id],['class'=>'change_status']);
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

