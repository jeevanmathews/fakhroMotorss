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
        <?= Html::a('Create Departments', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                // 'id',
                'name',
                // 'status',

                ['class' => 'yii\grid\ActionColumn'],
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
