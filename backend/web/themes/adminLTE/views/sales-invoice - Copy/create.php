<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SalesInvoice */

$this->title = 'Create Sales Invoice';
$this->params['breadcrumbs'][] = ['label' => 'Sales Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-invoice-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
