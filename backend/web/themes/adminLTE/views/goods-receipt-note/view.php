<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Purchaseorder */

$this->title = (($model->prefix)?$model->prefix->prefix.' '.$model->grn_number:'');
$this->params['breadcrumbs'][] = ['label' => 'GRN', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="goods-receipt-note-view main-body" id="goods-receipt-note_view">
<div class="content-main-wrapper">
    <!-- Content Header (Page header) -->
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
                <div class="col-md-6"> 
                  <!--   <p>
                        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    </p> -->
                    <div class="row">
                        <div class="col-md-12"> 
                            <h5 class="heading"><span>Purchase Order Details</span> </h5>

                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    // 'id',
                                ['label'=>'GRN By',
                                'value'=>$model->user->firstname
                                ],
                                 ['label'=>'GRN Number',
                                'value'=>(($model->prefix)?$model->prefix->prefix.' '.$model->grn_number:''),
                                ],
                                ['label'=>'Supplier',
                                'value'=>$model->supplier->name
                                ],
                                'grn_created_date',
                                // 'po_expected_date',
                                ],
                                ]) ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">


                            <div class="col-md-12">
                               <h5 class="heading"><span>Items</span> </h5>

                               <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <?php if($model->po_id!=""): ?>
                                        <th>Requested Quantity</th>
                                        <?php endif; ?>
                                        <th>Quantity</th>
                                        <th>Unit</th>
                                       <!--  <th>Price</th>
                                        <th>VAT</th>
                                        <th>Total</th> -->
                                    </tr>
                                </thead>


                                <tbody class="item_table">

                                    <?php
                                    if($model->grnitems):
                                        foreach ($model->grnitems as $req) { ?>
                                    <tr class="item_row" rid="1">
                                        <td><?= $req->item->item_name?></td>
                                        <?php if($model->po_id): ?>
                                        <td><?=$req->po_quantity?></td>
                                         <?php endif; ?>
                                        <td><?=$req->quantity?></td>
                                        <td><?= $req->unit->name?></td>
                                       <!--  <td><?= $req->price?></td>
                                        <td><?= $req->tax?></td>
                                        <td><?= $req->total?></td> -->
                                    </tr>

                                    <?php } endif;?>



                                </tbody>


                            </table>


                            <div class="w50 pull-right">
                      <!--   <div class="mb-5 fl-w100"><label class="col-md-6">Sub Total</label><span class="col-md-6"><?=$model->subtotal ?></span></div>
                        <div class="mb-5 fl-w100"><label class="col-md-6">Total tax</label><span class="col-md-6"><?=$model->total_tax ?></span></div>
                        <div class="mb-5 fl-w100"><label class="col-md-6">Grand Total</label><span class="col-md-6"><?= $model->grand_total?></span></div>
                    -->
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                        // 'subtotal',
                        // 'total_tax',
                        // 'grand_total',
                        ],
                        ]) ?>

                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- /.box -->
</section>
</div>
</div>