<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Arrayhelper;
use backend\models\Branches;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UnitsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Service Report';
$this->params['breadcrumbs'][] = $this->title;
$amount_due = 0;
?>
<div class="content-main-wrapper main-body" id="reports_services">
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
                    <div class="row">
                        <div class="col-md-5">
                        </div>
                        <div class="col-md-2">
                        <?= Html::dropDownList("report_branch_id", [], ArrayHelper::map(Branches::find()->where(['status' => 1])->all(), 'id', 'name'), ['prompt' => 'Select Branch'])?>
                        </div>
                        <div class="col-md-2">
                        <?= Html::textInput("date_from", "", ['placeholder' => 'Date From'])?>
                        To
                        </div>
                        <div class="col-md-2">
                        <?= Html::textInput("date_to", "", ['placeholder' => 'Date To'])?>
                        </div>
                        <div class="col-md-1">                        
                        <?= Html::button('Search', ['class' => 'btn btn-success search_jc_report']) ?>
                        </div>

                    </div>                    
                </div>
                <div class="col-md-12">

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,                       
                        'id' => $page_id,
                        'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],                      
                            [
                                'attribute' => 'discount',
                                'value'=>function ($model, $key, $index, $widget) use (&$discount) {
                                    $discount += $model['discount'];
                                    $widget->footer = "<b>".$discount."</b>";
                                    return number_format($model['discount'], Yii::$app->common->company->settings->decimal_places);
                                },   
                            ],                        
                            [
                                'attribute' => 'tax',
                                'value'=>function ($model, $key, $index, $widget) use (&$tax) {
                                    $tax += $model['tax'];
                                    $widget->footer = "<b>".$tax."</b>";
                                    return number_format($model['tax'], Yii::$app->common->company->settings->decimal_places);
                                },   
                            ],
                            [
                                'attribute' => 'amount_due',
                                'value'=>function ($model, $key, $index, $widget) use (&$amount_due) {
                                    $amount_due += $model['amount_due'];
                                    $widget->footer = "<b>".$amount_due."</b>";
                                    return number_format($model['amount_due'], Yii::$app->common->company->settings->decimal_places);
                                },      
                            ]                       
                        ],
                        'showFooter' => true,
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box -->
    </section>
</div>

