<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PrefixMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Prefix Masters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prefix-master-index main-body" id="prefix-master_index">
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
				  <?php if(Yii::$app->common->checkPermission('PrefixMasterController', 'create', 'true')){
            echo Html::a('Create Prefix Master', ['create'], ['class' => 'btn btn-success']);
        } ?> 
              </p>

              <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'id' => $page_id,
                'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                        // 'id',
                'prefix',
                ['attribute'=>'process',
                'value'=>function ($model){
                  return ucwords(str_replace('-', ' ', $model->process));
                },
                ],
                'description:ntext',
                        // 'created_date',
                        // 'status',

                        // ['class' => 'yii\grid\ActionColumn'],
                [
                'attribute' => 'status',
                'value' =>function ($model){
                  return ($model->status == 1)?"Enabled":"Disabled";
                },
                'filter' => Html::activeDropDownList($searchModel, 'status', ["1"=>"Enabled", "0" => "Disabled"],['class'=>'form-control','prompt' => 'Search by Status']),
                ],
                ['class' => 'yii\grid\ActionColumn',
                'template' => '{update}{changeStatus}',
				'template' => ((Yii::$app->common->checkPermission('PrefixMasterController', 'update', 'true')?'{update}':'').(Yii::$app->common->checkPermission('PrefixMasterController', 'changestatus', 'true')?'{changeStatus}':'')),

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
             </div>
           </div>
         </div>
       </div>
       <!-- /.box -->
     </section>
   </div>
 </div>

