<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\itemgroup */

$this->title = 'Create Itemgroup';
$this->params['breadcrumbs'][] = ['label' => 'Itemgroups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="itemgroup-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
