<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Role Permissions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-permission-index">

    <section class="content-header">
      <h1>
        <?= Html::encode($this->title) ?>        
      </h1>
</section>

    <p>
        <?= Html::a('Create Role Permission', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'role_id',
            'permission_id',
            'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
