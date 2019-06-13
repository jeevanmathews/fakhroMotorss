<?php

use yii\helpers\Html;
use common\components\AutoForm;
use yii\helpers\ArrayHelper;
use backend\models\Supplier;
use backend\models\GoodsReceiptNote;
use backend\models\Items;
use backend\models\Units;
use backend\models\PrefixMaster;
/* @var $this yii\web\View */
/* @var $model backend\models\GoodsReceiptNote */
/* @var $form yii\widgets\ActiveForm */

$vat_format=Yii::$app->common->company->vat_format;
?>
<div class="purchase-invoice-form">
<?php $form = AutoForm::begin(["id" => "purchase-invoice-".time().(($model->isNewRecord)?"create":"update")."-form"]); ?>
    <div class="col-md-6"> 
        <?= $form->field($model1,'grn_id', ['inputOptions' => ["class" => "select_grn form-control select2"]])->dropDownList(ArrayHelper::map(GoodsReceiptNote::find()->where(["status" => 1])->andWhere(['!=', 'process_status', 'completed'])->all(), 'id', 'grn_number'), ["prompt" => "Select GRN"]) ?>
    </div>
    
   <!--  <div class="col-md-6 "> 
        <?= Html::Button('Go', ['class' => 'btn btn-success btn_select_grn pull-left']) ?>
    </div> -->
<?php AutoForm::end(); ?>
<?php $form = AutoForm::begin(); ?>
<div class="box-body">
    <div class="row">
         <div class="mb-20">

                <?= $form->field($model1,'grn_id')->hiddenInput(['value'=>$model->id])->label(false) ?>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6"> 
                  <div class="form-group field-deliveryorder-do_number required has-error">
                      <div class="input-group">
                        <div class="input-group-addon">GRN Number</div>
                        <input type="text" id="" class="form-control" name="" disabled value="<?= $model->prefix->prefix.' '.$model->grn_number?>">
                      </div>
                    </div>
                
                  
                     <?= $form->field($model1,'prefix_id', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(PrefixMaster::find()->where(["status" => 1])->all(), 'id', 'prefix'), ["prompt" => "Select Prefix",'value'=>Yii::$app->common->prefix->id]) ?>
                    <?= $form->field($model1, 'supplier_id', ['inputOptions' => ["class" => "supplier_id form-control select2"]])->dropDownList(ArrayHelper::map(Supplier::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Select Supplier",'value'=>(isset($model->supplier_id)?$model->supplier_id:'')]) ?>                                     
                    <?= $form->field($model1, 'inv_created_by')->hiddenInput(['value' => \Yii::$app->user->identity->id])->label(false) ?>
                      <?= $form->field($model, 'branch_id')->hiddenInput(['value' => Yii::$app->user->identity->branch_id])->label(false) ?>
                </div>
                <div class="col-md-6 "> 
                    <?= $form->field($model1, 'inv_date')->textInput(['maxlength' => true, 'class' => "form-control datepicker"]) ?>
                     <?php if(Yii::$app->controller->action->id=='update'):
                      $number=$model->inv_number;
                      else :
                        $number=(isset($modellastnumber->inv_number)?$modellastnumber->inv_number+1:1);
                      endif;?>
                      <?= $form->field($model, 'inv_number')->textInput(['maxlength' => true,'value'=>$number]) ?>
                   <span class="append_here"></span> 
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
                                <th>Price</th>
                                  <?php if($vat_format=="inclusive") :?>
                                <th>Discount</th>
                                <th>Net</th>
                                <th>VAT</th>
                                <?php endif;?>
                                <th>Total</th>
                            </tr>
                        </thead>


                        <tbody class="item_table">
                            <?php if($model->isNewRecord): ?>
                            <tr class="item_row" rid="1">
                                <td class=""><?= Html::a('<span><i class="glyphicon glyphicon-trash"></i></span>', ['#'], ['class'=>'remove_row no-display']) ?></td>
                                <td><?= $form->field($modelpr,'item_id[]', ['inputOptions' => ["class" => "select_item_td form-control select2"]])->dropDownList(ArrayHelper::map(Items::find()->where(["status" => 1])->all(), 'id', 'item_name'), ["prompt" => "Select Items"])->label(false) ?></td>
                                <td><?= $form->field($modelpr, 'quantity[]')->textInput()->label(false) ?></td>
                                <td><?= $form->field($modelpr, 'quantity[]')->textInput(['class'=>'qty form-control'])->label(false) ?></td>
                                <td><?= $form->field($modelpr,'unit_id[]', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(Units::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Select unit"])->label(false) ?></td>
                                <td><?= $form->field($model1, 'price[]')->textInput(['class'=>'form-control price'])->label(false) ?>
                                    <input type="hidden" class="total_price" name="PurchaseInvoiceItems[total_price][]">
                                </td>
                               <?php if($vat_format=="inclusive") :?>
                                <td>
                                <div id="" role="radiogroup" aria-invalid="true">
                                    <label>
                                    <input type="radio" checked="checked" class="discount_type" value="percentage" name="PurchaseInvoiceItems[dis_type][]"> Rate (%) 
                                    </label>
                                    <label>
                                    <input type="radio" class="discount_type"  value="amount" name="PurchaseInvoiceItems[dis_type][]"> Amount
                                   </label>
                                </div>
                                <?= $form->field($model1, 'discount_percentage[]')->textInput(['class'=>'form-control discount_percentage'])->label(false) ?>
                                  <input type="hidden" id="PurchaseInvoiceItems-discount_amount" class="discount_amount" name="PurchaseInvoiceItems[discount_amount][]">
                                </td>
                                <td><?= $form->field($model1, 'net_amount[]')->textInput(['class'=>'form-control net_amount'])->label(false) ?></td>
                                <td>
                                       <input type="hidden" id="PurchaseInvoiceItems-tax" class="tax" name="PurchaseInvoiceItems[tax][]">
                                    <?= $form->field($model1, 'vat_rate[]')->textInput(['class'=>'form-control vatrate'])->label(false) ?></td>
                                  <?php endif;?>
                                <td><?= $form->field($model1, 'total[]')->textInput(['class'=>'form-control total'])->label(false) ?></td>
                             
                               </tr>
                            <?php else :

                            if($model->grnitems):
                                $count=0;
                                foreach ($model->grnitems as $req) { ?>
                            <tr class="item_row" rid="1">
                                <td>
                                     <?= $form->field($modelpr, 'id[]')->hiddenInput(['value'=>$req->id])->label(false) ?>
                                    <?= Html::a('<span><i class="glyphicon glyphicon-trash"></i></span>', ['#'], ['class'=>'remove_row no-display']) ?></td>
                                <td><?= $form->field($modelpr,'item_id[]', ['inputOptions' => ["class" => "select_item_td form-control select2"]])->dropDownList(ArrayHelper::map(Items::find()->where(["status" => 1])->all(), 'id', 'item_name'), ['options' => [$req->item_id => ['Selected'=>'selected']]],['value'=>$req->item_id],  ["prompt" => "Select Items"])->label(false) ?></td>
                                <td><?= $form->field($modelpr, 'grn_quantity[]')->textInput(['value'=>(($req->remaining_quantity!=0)?$req->remaining_quantity:$req->quantity),'class'=>'form-control remaining_qty'])->label(false) ?></td>
                                 <td><?= $form->field($modelpr, 'quantity[]')->textInput(['class'=>'qty form-control'])->label(false) ?></td>
                                <td><?= $form->field($modelpr,'unit_id[]', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(Units::find()->where(["status" => 1])->all(), 'id', 'name'), ['options' => [$req->unit_id => ['Selected'=>'selected']]],['value'=>$req->unit_id], ["prompt" => "Select unit"])->label(false) ?></td>
                                <td><?= $form->field($modelpr, 'price[]')->textInput(['value'=>$req->price,'class'=>'form-control price'])->label(false) ?>
                                    <input type="hidden" class="total_price" value="<?=$req->total_price?>" name="PurchaseInvoiceItems[total_price][]">
                                </td>
                               <?php if($vat_format=="inclusive") :?>
                                <td>
                                <div id="" role="radiogroup" aria-invalid="true">
                                    <label>
                                    <input type="radio" <?php if($req->dis_type=="discount_type"){echo 'checked="checked"';}?> class="discount_type" value="percentage" name="PurchaseInvoiceItems[dis_type][]"> Rate (%) 
                                    </label>
                                    <label>
                                    <input type="radio" <?php if($req->dis_type=="discount_type"){echo 'checked="checked"';}?> class="discount_type"  value="amount" name="PurchaseInvoiceItems[dis_type][]"> Amount
                                   </label>
                                </div>
                                <?= $form->field($modelpr, 'discount_percentage[]')->textInput(['value'=>$req->discount_percentage,'class'=>'form-control discount_percentage'])->label(false) ?>
                                  <input type="hidden" id="PurchaseInvoiceItems-discount_amount" value="<?=$req->discount_amount?>" class="discount_amount" name="PurchaseInvoiceItems[discount_amount]">
                                </td>
                                <td><?= $form->field($req, 'net_amount[]')->textInput(['value'=>$req->net_amount,'class'=>'form-control net_amount'])->label(false) ?></td>
                                <td>
                                       <input type="hidden" id="PurchaseInvoiceItems-tax" value="<?=$req->tax?>" class="tax" name="PurchaseInvoiceItems[tax][]">
                                    <?= $form->field($req, 'vat_rate[]')->textInput(['value'=>$req->vat_rate,'class'=>'form-control vatrate'])->label(false) ?></td>
                                  <?php endif;?>
                               <td><?= $form->field($modelpr, 'total[]')->textInput(['value'=>$req->total,'class'=>'form-control total'])->label(false) ?></td>    
        
                                </tr>

                            <?php } endif;?>

                        <?php endif; ?>

                    </tbody>


                </table>
                
                
                <div class="w50 pull-right">
                    <div class="mb-5 fl-w100"><?= $form->field($model1, 'subtotal')->textInput(['value'=>$model->subtotal,'class'=>'subtotal form-control']) ?></div>
                    <?php if($vat_format=="exclusive") :?>
                     <div class="input-group mb-15"><div class="input-group-addon">Discount Type</div>
                        <div id="" role="radiogroup" aria-invalid="true">

                            <label>
                            <input type="radio" checked="checked" name="PurchaseInvoice[discount_type]"  class="common_discount_type" value="percentage"> Rate (%) 
                            </label>
                            <label>
                            <input type="radio" name="PurchaseInvoice[discount_type]" class="common_discount_type"  value="amount"> Amount
                            </label>
                        </div>
                    </div>
                    <div class="mb-5 fl-w100"><?= $form->field($model1, 'discount')->textInput(['class'=>'form-control discount']) ?></div>
                    <input type="hidden" id="PurchaseInvoiceItems-discount_percent" class="discount_percent" name="PurchaseInvoice[discount_percent][]">
                    <div class="mb-5 fl-w100">
                        <div class="form-group field-PurchaseInvoice-total_tax">
                        <div class="input-group">
                            <div class="input-group-addon">VAT %</div>
                            <?= Html::activeTextInput($model,'vat_percent',['type'=>'hidden','class'=>'vatper','value'=>(($vat_format=="exclusive")?Yii::$app->common->company->vat_rate:0)])?>
                        </div>
                        </div>
                    </div>
                    <div class="mb-5 fl-w100"><?= $form->field($model1, 'total_tax')->textInput(['class'=>'form-control total_tax']) ?></div>
                     <?php endif;?>
                    <div class="mb-5 fl-w100"><?= $form->field($model1, 'grand_total')->textInput(['value'=>$model->grand_total,'class'=>'grandtotal form-control']) //['readonly'=>true]?></div>
                </div>
                 <input type="hidden" id="hiddenurl_itemprice" class="form-control hiddenurl_itemprice" name="" value="<?php echo Yii::$app->getUrlManager()->createUrl(['items/itemprice']);?>">
                  
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
$(".datepicker").datepicker({
    defaultDate: new Date(),
    dateFormat: "dd/mm/yy",
    changeMonth: true,
    changeYear: true,
    setDate: new Date(),
    yearRange: "1930:2030",
  });
  $(".datepicker").datepicker("setDate", new Date());
  $(document).find('select').select2();


$('body').on('change','#purchaseinvoice-grn_id',function(){
  var grn_id=$("#purchaseinvoice-grn_id").val();
if(grn_id!='' && grn_id!='undefined'){
    // window.location.href='<?php echo Yii::$app->getUrlManager()->createUrl("purchase-invoice/createinv"). "&id="?>'+grn_id;
  
      $.ajaxSetup({async: false}); 
          $.ajax({
          url: '<?php echo Yii::$app->getUrlManager()->createUrl("purchase-invoice/createinv")?>',//"'+po_id+'
          aSync: false,
          data:{'id':grn_id},
          dataType: "html",
          success: function(data) {
            console.log(data);
            $(".main-body").addClass("hide");
            // $('div[tab_id="'+tabId+'"]').remove();
            $(".container-body").append($(data));
            // $(document).find(".main-body:visible").attr("tab_id", tabId);

            // $("#"+tabId).find("span").html(page_id.replace("_","/"));
          }});
          $.ajaxSetup({async: true}); 
  }
});
</script>
</div>