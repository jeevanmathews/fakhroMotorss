<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Roles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-main-wrapper main-body">

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
                        <?= Html::a('Create Roles', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],     
                            'name',            
                            ['class' => 'yii\grid\ActionColumn',
                            'template' => '{my_button}', 
                            'buttons' => [
                                'my_button' => function ($url, $model, $key) {
                                   return Html::a('<span class="glyphicon glyphicon-lock"></span>', Yii::$app->getUrlManager()->createUrl(['permissionmaster/permissions', 'id' =>$model->id,]), [
                                    'title' => Yii::t('app', 'Set Permission'),
                                    ]);
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