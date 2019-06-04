<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\itemgroup */

$this->title = 'Update Itemgroup: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Itemgroups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="itemgroup-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
