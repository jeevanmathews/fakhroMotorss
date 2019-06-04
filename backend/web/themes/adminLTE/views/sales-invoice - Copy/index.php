<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SalesInvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sales Invoices';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-invoice-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Sales Invoice', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'do_id',
            'inv_number',
            'inv_created_date',
            'inv_date',
            //'inv_created_by',
            //'customer_id',
            //'subtotal',
            //'discount',
            //'total_tax',
            //'grand_total',
            //'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
