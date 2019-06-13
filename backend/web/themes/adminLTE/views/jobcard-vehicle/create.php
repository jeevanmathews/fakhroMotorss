<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\JobcardVehicle */

$this->title = 'Create Jobcard Vehicle';
$this->params['breadcrumbs'][] = ['label' => 'Jobcard Vehicles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jobcard-vehicle-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
