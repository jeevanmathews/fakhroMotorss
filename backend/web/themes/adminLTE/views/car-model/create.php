<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CarModel */

$this->title = 'Create Car Model';
$this->params['breadcrumbs'][] = ['label' => 'Car Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="car-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
