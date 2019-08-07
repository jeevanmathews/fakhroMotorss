<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Departments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-main-wrapper main-body"  id="log_index">

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
        
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'id' => $page_id,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'controller',
                'action',
                'query_string',
                [
                    'attribute' => 'loggedin_user',
                    'value' => function($model){
                        return $model->loggedinuser->firstname;
                    }
                ],       
                'date',       
          
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
