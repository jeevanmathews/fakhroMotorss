<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\tasktypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Tasktypes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-main-wrapper main-body" id="tasktype_index">

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
                        <?= Html::a('Create Task Types', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => $page_id,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'task_type',
            'status',

            ['class' => 'yii\grid\ActionColumn'],
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
