<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;
/* @var $this yii\web\View */
/* @var $model backend\models\Purchaseorder */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'GRN', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$cur_time = time();
?>
<div class="delivery-order-view main-body" id="delivery-order_view">
<?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
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
                    <p>
                        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    </p>
                    <div class="row">
                        <div class="col-md-12"> 
                            <h5 class="heading"><span>Delivery Order Details</span> </h5>

                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    // 'id',
                                ['label'=>'DO By',
                                'value'=>$model->user->firstname
                                ],
                                 ['label'=>'DO Number',
                                'value'=>(($model->prefix)?$model->prefix->prefix.'-'.$model->do_number:''),
                                ],
                                ['label'=>'customer',
                                'value'=>$model->customer->name
                                ],
                                'do_created_date',
                                // 'po_expected_date',
                                ],
                                ]) ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if($model->payment_confirmation==1): ?>
                 <span class="pull-left">
                         <?= Html::button('View Invoice', ['onclick' => 'window.open("'.Yii::$app->getUrlManager()->createUrl(['sales-invoice/invoice', 'id' => $model->invoice->id]).'", "_blank");', 'class' => 'btn btn-success']) ?>
                </span>
            <?php else : ?>
                 <span class="pull-left">
                         <?= Html::button('Confirm Payment', ['class' => 'btn btn-success', 'id' => 'confirm-payment-'.$cur_time]) ?>    
                </span>
             <?php endif; ?>
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
                                        <?php if($model->so_id): ?>
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
                                    if($model->orderitems):
                                        foreach ($model->orderitems as $req) { ?>
                                    <tr class="item_row" rid="1">
                                        <td><?= $req->item->item_name?></td>
                                        <?php if($model->so_id): ?>
                                        <td><?=$req->so_quantity?></td>
                                         <?php endif; ?>
                                        <td><?=$req->quantity?></td>
                                        <td><?= $req->unit->name?></td>
                                        <!-- <td><?= $req->price?></td>
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
                        // 'disacount',
                        // 'grand_total',
                        ],
                        ]) ?>

                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
</div>
<div class="modal confirm-payment-<?php echo $cur_time;?>" tabindex="-1" role="dialog"> 
    <div class="modal-content">
    <div class="content-main-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      Click "Generate Invoice" button to update stocks and confirm this payment. 
    </section>    
    <section class="content">
        <div class="box box-default">  
        <div class="row">
            <div class="col-md-12"> 
            <p>
                <?= Html::a('Generate Invoice', ['delivery-order/generate-invoice', 'do_id' => $model->id], ['class' => 'btn btn-success generate-invoice-sales','target'=>'_blank']) ?>
            </p>            
            </div>
        </div>
    </div>
    </section>
    </div>
    </div>  
</div>
<!-- /.box -->
</section>
</div>