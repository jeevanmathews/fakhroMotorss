<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\JobcardVehicle */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Jobcard Vehicles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="jobcard-vehicle-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'reg_num',
            'chasis_num',
            'make',
            'model',
            'color',
            'tr_number',
            'amc_type',
            'amc_expiry_date',
            'extended_warranty_type',
            'ew_expiry_kms',
            'ew_expiry_date',
            'service_schedule',
        ],
    ]) ?>

</div>
