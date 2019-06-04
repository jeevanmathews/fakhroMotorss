<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

   <section class="content-header">
      <h1>
        <?= Html::encode($this->title) ?>        
      </h1>
</section>

    <p>
        <?= Html::a('Create User', ['signup'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'username',
            [
            'label'=>'Role',
            'value'=>'roles.name'
            ],
             [
            'label'=>'Branch',
            'value'=>'branch.name'
            ],
            // 'auth_key',
            // 'password_hash',
            // 'password_reset_token',
            //'email:email',
            //'role_id',
            //'branch_id',
            //'status',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn','header'=>'Actions',],
            ['class' => 'yii\grid\ActionColumn',
            'header'=>'Set Roles',
            'template' => '{my_button}', 
            'buttons' => [
                'my_button' => function ($url, $model, $key) {
                   return Html::a('<span class="glyphicon glyphicon-check"></span>', Yii::$app->getUrlManager()->createUrl(['user/roles', 'id' =>$model->id,]), [
                    'title' => Yii::t('app', 'Add Role'),
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
