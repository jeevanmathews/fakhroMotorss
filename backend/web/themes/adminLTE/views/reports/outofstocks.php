<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UnitsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Items below Stock level';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-main-wrapper main-body" id="reports_outofstocks">
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
                    <p>
                    <?php if(Yii::$app->common->checkPermission('PurchaseRequestController', 'create', 'true')){
                        echo Html::a('Create Purchase requisition', ['purchase-request/create'], ['class' => 'btn btn-success']);
                        } ?> 
                    </p>                 

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,                       
                        'id' => $page_id,
                        'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'item_name',
                        'current_stock',                        
                        ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box -->
    </section>
</div>

