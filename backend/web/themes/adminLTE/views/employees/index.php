<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EmployeesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Staff';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-main-wrapper main-body"  id="employees_index">
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
                        <?= Html::a('Create Staff', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'id' => $page_id,
                        'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'fullname',                      
                        [
                          'attribute'=>'designation_id',
                          'value' => function($model, $key, $index){   
                            return ($model->designation)?$model->designation->name:"Not Set";
                          },
                        ],
                        'email:email',
                        'date_of_joining',
                        [
                        'attribute'=>'login',
                        'header'=>'Login',
                        'format'=>'raw',    
                        'value' => function($model, $key, $index)
                          {   
                              return (($model->login==1)?'Enabled':'No login');
                          },
                        ],
                        [
                        'attribute' => 'status',
                        'value' =>function ($model){
                            return ($model->status == 1)?"Enabled":"Disabled";
                        },
                        'filter' => Html::activeDropDownList($searchModel, 'status', ["1"=>"Enable", "0" => "Disable"],['class'=>'form-control','prompt' => 'Search by Status']),
                        ],
                        ['class' => 'yii\grid\ActionColumn',
                        'template' => '{view}{update}{changeStatus}{roles}',
                        'buttons' => [
                          'changeStatus' => function ($url, $model, $key) {
                             $img = ($model->status == 1)?"button_cross.png":"button_tick_alt.png";
                             $width = ($model->status == 1)?"25":"20";
                             return Html::a(Html::img($this->theme->getUrl("images/".$img),["width" =>  $width, "title" => (($model->status == 1)?"Disable":"Enable")]), ['change-status', 'id'=>$model->id],['class'=>'change_status']);
                          },
                          'roles' => function ($url, $model, $key) {                             
                             return Html::a('<span class="glyphicon glyphicon-user"></span>', ['roles', 'id'=>$model->id],['title'=>'Roles']);
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

