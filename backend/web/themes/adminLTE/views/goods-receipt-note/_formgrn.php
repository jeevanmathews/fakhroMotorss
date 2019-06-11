<?php

use yii\helpers\Html;
use common\components\AutoForm;
use yii\helpers\ArrayHelper;
use backend\models\Supplier;
use backend\models\Purchaseorder;
use backend\models\Items;
use backend\models\Units;
use backend\models\PrefixMaster;
$vat_format=Yii::$app->common->company->vat_format;
/* @var $this yii\web\View */
/* @var $model backend\models\Purchaseorder */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="goods-receipt-note-form">
<?php $form = AutoForm::begin(); ?>
<div class="col-md-6"> 
  <?= $form->field($model1,'po_id', ['inputOptions' => ["class" => "select_po form-control select2"]])->dropDownList(ArrayHelper::map(Purchaseorder::find()->where(["status" => 1])->andWhere(['!=', 'process_status', 'completed'])->all(), 'id', 'po_number'), ["prompt" => "Select PO"]) ?>
</div>

<!-- <div class="col-md-6 "> 
  <?= Html::Button('Go', ['class' => 'btn btn-success btn_select_po pull-left']) ?>
</div> -->
<?php AutoForm::end(); ?>
<?php $form = AutoForm::begin(["id" => "goods-receipt-note-".time().(($model->isNewRecord)?"create":"update")."-form"]); ?>
<div class="box-body">
  <div class="row">
   <div class="mb-20">

    <?= $form->field($model1,'po_id')->hiddenInput(['value'=>$model->id])->label(false)?>
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group field-deliveryorder-do_number required has-error">
            <div class="input-group">
              <div class="input-group-addon">PO Number</div>
              <input type="text" id="" class="form-control" name="" disabled value="<?= $model->prefix->prefix.' '.$model->po_number?>">
            </div>
          </div> 

          <?= $form->field($model1,'prefix_id', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(PrefixMaster::find()->where(["status" => 1])->all(), 'id', 'prefix'), ["prompt" => "Select Prefix",'value'=>Yii::$app->common->prefix->id]) ?>
          <?= $form->field($model1, 'supplier_id', ['inputOptions' => ["class" => "supplier_id form-control select2"]])->dropDownList(ArrayHelper::map(Supplier::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Select Supplier",'value'=>(isset($model->supplier_id)?$model->supplier_id:'')]) ?>                                     
          <span class="append_here">
           <?php if(Yii::$app->controller->action->id=='update'):
           echo Html::textarea('supplier_address',$model1->supplier->address,['class'=>'form-control','rows'=>6]);
           else:
             echo Html::textarea('supplier_address',$model->supplier->address,['class'=>'form-control','rows'=>6]); 
           endif;?>
         </span>
         <?= $form->field($model1, 'grn_created_by')->hiddenInput(['value' => \Yii::$app->user->identity->id])->label(false) ?>
         <?= $form->field($model, 'branch_id')->hiddenInput(['value' => Yii::$app->user->identity->branch_id])->label(false) ?>
       </div>
       <div class="col-md-6"> 
        <?= $form->field($model1, 'grn_date')->textInput(['maxlength' => true, 'class' => "form-control datepicker"]) ?>
        <?= $form->field($model1, 'grn_number')->textInput(['maxlength' => true,'value'=>$modellastnumber->grn_number+1]) ?>

      </div>
      <div class="col-md-12">
       <h5 class="heading"><span>Items</span> </h5>

       <table class="table table-bordered">
        <thead>
          <tr>

           <th>#</th>
           <th>Item</th>
           <th>Ordered Quantity</th>
           <th>Quantity</th>
           <th>Unit</th>
             <!-- <th>Price</th>
             <?php //if($vat_format=="inclusive") :?>
             <th>Discount</th>
             <th>Net</th>
             <th>VAT</th>
             <?php //endif;?>
             <th>Total</th> -->
           </tr>
         </thead>


         <tbody class="item_table">
          <?php if($type=='create'): ?>
          <tr class="item_row" rid="1">
            <td class=""><?= Html::a('<span><i class="glyphicon glyphicon-trash"></i></span>', ['#'], ['class'=>'remove_row no-display']) ?></td>
            <td><?= $form->field($modelpr,'item_id[]', ['inputOptions' => ["class" => "select_item_td form-control select2"]])->dropDownList(ArrayHelper::map(Items::find()->where(["status" => 1])->all(), 'id', 'item_name'), ["prompt" => "Select Items"])->label(false) ?></td>
            <td><?= $form->field($modelpr, 'quantity[]')->textInput()->label(false) ?></td>
            <td><?= $form->field($modelpr, 'quantity[]')->textInput(['class'=>'qty form-control'])->label(false) ?></td>
            <td><?= $form->field($modelpr,'unit_id[]', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(Units::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Select unit"])->label(false) ?>
              <?= Html::activeTextInput($model1,'price[]',['type'=>'hidden','class'=>'price'])?>
              <?php if($vat_format=="inclusive") :?>
              <?= Html::activeTextInput($model1,'vat_rate[]',['type'=>'hidden','class'=>'vatrate'])?>
              <?= Html::activeTextInput($model1,'tax[]',['type'=>'hidden','class'=>'tax'])?>
            <?php endif;?>
            <?= Html::activeTextInput($model1,'total[]',['type'=>'hidden','class'=>'total'])?>
            <?= Html::activeTextInput($model1,'total_price[]',['type'=>'hidden','class'=>'total_price'])?>

          </td>
            <!-- <td><?= $form->field($model1, 'price[]')->textInput(['class'=>'form-control price'])->label(false) ?>
              <input type="" class="total_price" name="GrnItems[total_price][]">
            </td>
            <?php //if($vat_format=="inclusive") :?>
            <td>
              <div id="" role="radiogroup" aria-invalid="true">
                <label>
                  <input type="radio" checked="checked" class="discount_type" value="percentage" name="GrnItems[dis_type][]"> Rate (%) 
                </label>
                <label>
                  <input type="radio" class="discount_type"  value="amount" name="GrnItems[dis_type][]"> Amount
                </label>
              </div>
              <?= $form->field($model1, 'discount_percentage[]')->textInput(['class'=>'form-control discount_percentage'])->label(false) ?>
              <input type="hidden" id="GrnItems-discount_amount" class="discount_amount" name="GrnItems[discount_amount][]">
            </td>
            <td><?= $form->field($model1, 'net_amount[]')->textInput(['class'=>'form-control net_amount'])->label(false) ?></td>
            <td>
             <input type="hidden" id="GrnItems-tax" class="tax" name="GrnItems[tax][]">
             <?= $form->field($model1, 'vat_rate[]')->textInput(['class'=>'form-control vatrate'])->label(false) ?></td>
             <?php //endif;?>
             <td><?= $form->field($model1, 'total[]')->textInput(['class'=>'form-control total'])->label(false) ?></td>
           -->
         </tr>
         <?php else :

         if($model->orderitems):
          $count=0;
        foreach ($model->orderitems as $req) { ?>
        <tr class="item_row" rid="1">
          <td>
           <?= $form->field($modelpr, 'id[]')->hiddenInput(['value'=>$req->id])->label(false) ?>
           <?= Html::a('<span><i class="glyphicon glyphicon-trash"></i></span>', ['#'], ['class'=>'remove_row no-display']) ?></td>
           <td><?= $form->field($modelpr,'item_id[]', ['inputOptions' => ["class" => "select_item_td form-control select2"]])->dropDownList(ArrayHelper::map(Items::find()->where(["status" => 1])->all(), 'id', 'item_name'), ['options' => [$req->item_id => ['Selected'=>'selected']]],['value'=>$req->item_id],  ["prompt" => "Select Items"])->label(false) ?></td>
           <td><?= $form->field($modelpr, 'po_quantity[]')->textInput(['value'=>(($req->remaining_quantity!=0)?$req->remaining_quantity:$req->quantity),'class'=>'form-control remaining_qty'])->label(false) ?></td>
           <td><?= $form->field($modelpr, 'quantity[]')->textInput(['class'=>'qty form-control'])->label(false) ?></td>
           <td><?= $form->field($modelpr,'unit_id[]', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(Units::find()->where(["status" => 1])->all(), 'id', 'name'), ['options' => [$req->unit_id => ['Selected'=>'selected']]],['value'=>$req->unit_id], ["prompt" => "Select unit"])->label(false) ?>
            <?= Html::activeTextInput($modelpr,'price[]',['type'=>'hidden','class'=>'price','value'=>$req->price])?>
            <?php if($vat_format=="inclusive") :?>
            <?= Html::activeTextInput($modelpr,'vat_rate[]',['type'=>'hidden','class'=>'vatrate','value'=>$req->vat_rate])?>
            <?= Html::activeTextInput($modelpr,'tax[]',['type'=>'hidden','class'=>'tax','value'=>$req->tax])?>
          <?php endif;?>
          <?= Html::activeTextInput($modelpr,'total[]',['type'=>'hidden','class'=>'total','value'=>$req->total])?>
          <?= Html::activeTextInput($modelpr,'total_price[]',['type'=>'hidden','class'=>'total_price','value'=>$req->total_price])?>

        </td>
             <!--              <td><?= $form->field($req, 'price[]')->textInput(['value'=>$req->price,'class'=>'form-control price'])->label(false) ?>
              <input type="" class="total_price" value="<?=$req->total_price?>" name="GrnItems[total_price][]">
            </td>
            <?php //if($vat_format=="inclusive") :?>
            <td>
              <div id="" role="radiogroup" aria-invalid="true">
                <label>
                  <input type="radio" <?php if($req->dis_type=="discount_type"){echo 'checked="checked"';}?> class="discount_type" value="percentage" name="GrnItems[dis_type][]"> Rate (%) 
                </label>
                <label>
                  <input type="radio" <?php if($req->dis_type=="discount_type"){echo 'checked="checked"';}?> class="discount_type"  value="amount" name="GrnItems[dis_type][]"> Amount
                </label>
              </div>
              <?= $form->field($req, 'discount_percentage[]')->textInput(['value'=>$req->discount_percentage,'class'=>'form-control discount_percentage'])->label(false) ?>
              <input type="hidden" id="GrnItems-discount_amount" value="<?=$req->discount_amount?>" class="discount_amount" name="GrnItems[discount_amount][]">
            </td>
            <td><?= $form->field($req, 'net_amount[]')->textInput(['value'=>$req->net_amount,'class'=>'form-control net_amount'])->label(false) ?></td>
            <td>
             <input type="hidden" id="GrnItems-tax" value="<?=$req->tax?>" class="tax" name="GrnItems[tax][]">
             <?= $form->field($req, 'vat_rate[]')->textInput(['value'=>$req->vat_rate,'class'=>'form-control vatrate'])->label(false) ?></td>
           <?php //endif;?>
           <td><?= $form->field($req, 'total[]')->textInput(['value'=>$req->total,'class'=>'form-control total'])->label(false) ?></td>
         -->
       </tr>

       <?php } endif;?>

     <?php endif; ?>

   </tbody>


 </table>


 <div class="w50 pull-right">
  <div class="mb-5 fl-w100"><?= $form->field($model1, 'subtotal')->hiddenInput(['value'=>$model->subtotal,'class'=>'subtotal form-control'])->label(false) ?></div>
  <?php //if($vat_format=="inclusive") :?>
  <div class="input-group mb-5">
    <!-- <div class="input-group-addon">Discount Type</div> -->
    <div id="" role="radiogroup" class="no-display" aria-invalid="true">

      <label>
        <input type="radio" checked="checked" name="GoodsReceiptNote[discount_type]"  class="common_discount_type" value="percentage"> Rate (%) 
      </label>
      <label>
        <input type="radio" name="GoodsReceiptNote[discount_type]" class="common_discount_type"  value="amount"> Amount
      </label>
    </div>
  </div>
  <div class="mb-5 fl-w100"><?= $form->field($model1, 'discount')->hiddenInput(['class'=>'form-control discount'])->label(false) ?></div>
  <input type="hidden" id="GrnItems-discount_percent" class="discount_percent" name="GoodsReceiptNote[discount_percent][]">
  <div class="mb-5 fl-w100">
    <div class="form-group field-GoodsReceiptNote-total_tax">
      <div class="input-group">
        <?= Html::activeTextInput($model,'vat_percent',['type'=>'hidden','class'=>'vatper','value'=>(($vat_format=="exclusive")?Yii::$app->common->company->vat_rate:0)])?>
      </div>
    </div>
  </div>
  <div class="mb-5 fl-w100"><?= $form->field($model1, 'total_tax')->hiddenInput(['class'=>'form-control total_tax'])->label(false) ?></div>
  <?php //endif;?>
  <div class="mb-5 fl-w100"><?= $form->field($model1, 'grand_total')->hiddenInput(['value'=>$model->grand_total,'class'=>'grandtotal form-control'])->label(false) //['readonly'=>true]?></div>
</div>

<?= Html::Button('<span class="glyphicon glyphicon-plus"></span> Add Items', ['class' => 'btn btn-success btn_add_new pull-left','title'=>'Add Items']) ?>
</div>
</div>
</div>
</div>
<!-- /.box-body -->  
<div class="box-footer">
  <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>
<?php AutoForm::end(); ?>
</div>


</script>
<script type="text/javascript">

  $('body').on('change','#goodsreceiptnote-po_id',function(){
    var po_id=$("#goodsreceiptnote-po_id").val();
if(po_id!='' && po_id!='undefined'){
    window.location.href='<?php echo Yii::$app->getUrlManager()->createUrl("goods-receipt-note/creategrn"). "&id="?>'+po_id;
  }
});

</script>
</div>