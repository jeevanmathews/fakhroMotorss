<?php

use yii\helpers\Html;
use common\components\AutoForm;
use yii\helpers\ArrayHelper;
use backend\models\Supplier;
use backend\models\Purchaseorder;
use backend\models\Items;
use backend\models\Units;
use backend\models\PrefixMaster;
/* @var $this yii\web\View */
/* @var $model backend\models\Purchaseorder */
/* @var $form yii\widgets\ActiveForm */
$vat_format=Yii::$app->common->company->vat_format;
?>
<div class="goods-receipt-note-form">
<?php $form = AutoForm::begin(["id" => "goods-receipt-note-".time().(($model->isNewRecord)?"create":"update")."-form"]); ?>
<div class="box-body">
  <div class="row">
   <?php if($model->isNewRecord): ?>
   <div class="mb-20">

    <div class="col-md-6"> 
      <?= $form->field($model,'po_id', ['inputOptions' => ["class" => "select_po form-control select2"]])->dropDownList(ArrayHelper::map(Purchaseorder::find()->where(["status" => 1])->andWhere(['!=', 'process_status', 'completed'])->all(), 'id', 'po_number'), ["prompt" => "Select PO"]) ?>
    </div>
    <?php //if($model->isNewRecord): ?>
   <!--  <div class="col-md-6 "> 
      <?= Html::Button('Go', ['class' => 'btn btn-success btn_select_po pull-left']) ?>
    </div> -->
    <?php //endif; ?>
  </div>
<?php endif; ?>

 <?php $disabled=''; $disabletrue='';?>
<?php if(!$model->isNewRecord && $model->po_id!=""): 
   $disabled='disabled';

          $disabletrue= ',"disabled"=true';
?>
 <div class="col-md-6">
  <div class="form-group field-deliveryorder-do_number required has-error">
    <div class="input-group">
      <div class="input-group-addon">PO Number</div>
      <input type="text" id="" class="form-control" name="" disabled value="<?= $model->po->prefix->prefix.' '.$model->po->po_number?>">
    </div>
  </div> 
</div> 
<?php endif; ?>
<div class="col-md-12">

  <div class="row">
    
    <div class="col-md-6"> 
      <?= $form->field($model,'prefix_id', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(PrefixMaster::find()->where(["status" => 1])->all(), 'id', 'prefix'), ["prompt" => "Select Prefix",'value'=>(isset(Yii::$app->common->prefix->id)?Yii::$app->common->prefix->id:''),'disabled'=>true]) ?>
      <?= $form->field($model, 'grn_date')->textInput(['maxlength' => true,'class'=>'form-control datepicker']) ?>
      <?= $form->field($model, 'remarks')->textarea(['rows' => 6]) ?>
      <?= $form->field($model, 'grn_created_by')->hiddenInput(['value' => \Yii::$app->user->identity->id])->label(false) ?>
      <?= $form->field($model, 'branch_id')->hiddenInput(['value' => Yii::$app->user->identity->branch_id])->label(false) ?>
    </div>
    <div class="col-md-6"> 
      <?php if(!$model->isNewRecord):
      $number=$model->grn_number;
      else :
        $number=(isset($modellastnumber->grn_number)?$modellastnumber->grn_number+1:1);
      endif;?>
      <?= $form->field($model, 'grn_number')->textInput(['maxlength' => true,'value'=>$number,'disabled'=>true]) ?>
      <?= $form->field($model, 'supplier_id', ['inputOptions' => ["class" => "supplier_id form-control select2"]])->dropDownList(ArrayHelper::map(Supplier::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Select Supplier",'disabled' => ($model->po_id) ? 'disabled' : false]) ?>  
      <span class="append_here">
        <?php if(!$model->isNewRecord):
        echo Html::textarea('supplier_address',$model->supplier->address,['class'=>'form-control','rows'=>6]);
        endif;?>

      </span>
    </div>
    <div class="col-md-12">
     <h5 class="heading"><span>Items</span> </h5>

     <table class="table table-bordered">
      <thead>
        <tr>
         <th>#</th>
         <th>Item</th>
         <?php if(!$model->isNewRecord && $model->po_id!=""): ?>
         <th>Ordered Quantity</th>
       <?php endif; ?>
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
        <td><?= $form->field($model1,'item_id[]', ['inputOptions' => ["class" => "select_item_td form-control select2"]])->dropDownList(ArrayHelper::map(Items::find()->where(["status" => 1])->all(), 'id', 'item_name'), ["prompt" => "Select Items"])->label(false) ?></td>
        
        <td><?= $form->field($model1, 'quantity[]')->textInput(['class'=>'form-control qty'])->label(false) ?></td>
        <td><?= $form->field($model1,'unit_id[]', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(Units::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Select unit"])->label(false) ?>
          <?= Html::activeTextInput($model1,'total_price[]',['type'=>'hidden','class'=>'total_price'])?>
          </td>
          
         <?php if($vat_format=="inclusive") :?>
          <td>
            <div id="" role="radiogroup" aria-invalid="true">
              <label>
                <input type="radio" <?php if($model1->dis_type=="discount_type"){echo 'checked="checked"';}?> class="discount_type" value="percentage" name="GrnItems[dis_type][]"> Rate (%) 
              </label>
              <label>
                <input type="radio" <?php if($model1->dis_type=="discount_type"){echo 'checked="checked"';}?> class="discount_type"  value="amount" name="GrnItems[dis_type][]"> Amount
              </label>
            </div>
            <?= $form->field($model1, 'discount_percentage[]')->textInput(['class'=>'form-control discount_percentage'])->label(false) ?>
            <?= Html::activeTextInput($model1,'discount_amount[]',['type'=>'hidden','class'=>'discount_amount form-control form-control'])?>
          </td>
          <td><?= $form->field($model1, 'net_amount[]')->textInput(['class'=>'form-control net_amount'])->label(false) ?></td>
          <td>
           <?= Html::activeTextInput($model1,'tax[]',['type'=>'text','class'=>'tax form-control form-control'])?>
           <?= $form->field($model1, 'vat_rate[]')->textInput(['class'=>'form-control vatrate'])->label(false) ?></td>
         <?php endif;?>
     
        
      
        <td><?= Html::activeTextInput($model1,'price[]',['type'=>'text','class'=>'price form-control'])?></td>
            <td> <?= Html::activeTextInput($model1,'total[]',['type'=>'text','class'=>'total form-control'])?></td>
      
     </tr>
     <?php else :

     if($model->grnitems):
      foreach ($model->grnitems as $req) { ?>
    <tr class="item_row" rid="1">
      <?= $form->field($req, 'id[]')->hiddenInput(['value'=>$req->id])->label(false) ?>
      <td><?= Html::a('<span><i class="glyphicon glyphicon-trash"></i></span>', ['#'], ['class'=>'remove_row no-display']) ?></td>
      <td><?= $form->field($req,'item_id[]', ['inputOptions' => ["class" => "select_item_td form-control select2",'disabled' => ($model->po_id) ? 'disabled' : false]])->dropDownList(ArrayHelper::map(Items::find()->where(["status" => 1])->all(), 'id', 'item_name'), ['options' => [$req->item_id => ['Selected'=>'selected']]],  ["prompt" => "Select Items"])->label(false) ?></td>
      <?php if($model->po_id){ ?>
      <td><?= $form->field($req, 'po_quantity[]')->textInput(['value'=>(($req->remaining_quantity!=0)?$req->remaining_quantity:$req->quantity),'class'=>'form-control remaining_qty '.$disabled])->label(false) ?></td>
      <?php } ?>
      <td><?= $form->field($req, 'quantity[]')->textInput(['value'=>$req->quantity,'class'=>'form-control qty'])->label(false) ?></td>
      <td><?= $form->field($req,'unit_id[]', ['inputOptions' => ["class" => "form-control select2",'disabled' => ($model->po_id) ? 'disabled' : false]])->dropDownList(ArrayHelper::map(Units::find()->where(["status" => 1])->all(), 'id', 'name'), ['options' => [$req->unit_id => ['Selected'=>'selected']]], ["prompt" => "Select unit"])->label(false) ?>
        <?= Html::activeTextInput($req,'total_price[]',['type'=>'hidden','class'=>'total_price','value'=>$req->total_price])?>
       </td>
      
      <?php if($vat_format=="inclusive") :?>
          <td>
            <div id="" role="radiogroup" aria-invalid="true">
              <label>
                <input type="radio" <?php if($req->dis_type=="discount_type"){echo 'checked="checked"';}?> class="discount_type" value="percentage" name="SalesInvoiceItems[dis_type][]"> Rate (%) 
              </label>
              <label>
                <input type="radio" <?php if($req->dis_type=="discount_type"){echo 'checked="checked"';}?> class="discount_type"  value="amount" name="SalesInvoiceItems[dis_type][]"> Amount
              </label>
            </div>
            <?= $form->field($req, 'discount_percentage[]')->textInput(['value'=>$req->discount_percentage,'class'=>'form-control discount_percentage'])->label(false) ?>
            <?= Html::activeTextInput($req,'discount_amount[]',['type'=>'hidden','class'=>'discount_amount form-control form-control','value'=>$req->discount_amount])?>
          </td>
          <td><?= $form->field($req, 'net_amount[]')->textInput(['value'=>$req->net_amount,'class'=>'form-control net_amount '.$disabled])->label(false) ?></td>
          <td>
           <?= Html::activeTextInput($req,'tax[]',['type'=>'text','class'=>'tax form-control form-control','value'=>$req->tax])?>
           <?= $form->field($req, 'vat_rate[]')->textInput(['value'=>$req->vat_rate,'class'=>'form-control vatrate'])->label(false) ?></td>
         <?php endif;?>
   
    <td> <?= Html::activeTextInput($modelpr,'price[]',['type'=>'text','class'=>'price form-control '.$disabled,'value'=>$req->price])?> </td>
            <td><?= Html::activeTextInput($modelpr,'total[]',['type'=>'text','class'=>'total form-control '.$disabled,'value'=>$req->total])?></td>
     
    </tr>

    <?php } endif;?>

  <?php endif; ?>

</tbody>


</table>


<div class="w50 pull-right">
  <div class="mb-5 fl-w100"><?= $form->field($model, 'subtotal')->textInput(['class'=>'form-control subtotal '.$disabled]);//->label(false) ?></div>
  <?php if($vat_format=="exclusive") :?>
  <div class="input-group mb-5">
    <div class="input-group-addon">Discount Type</div>
    <div id="" role="radiogroup" class="" aria-invalid="true">

      <label>
        <input type="radio" checked="checked" name="GoodsReceiptNote[discount_type]"  class="common_discount_type" value="percentage"> Rate (%) 
      </label>
      <label>
        <input type="radio" name="GoodsReceiptNote[discount_type]" class="common_discount_type"  value="amount"> Amount
      </label>
    </div>
  </div>
  <div class="mb-5 fl-w100"><?= $form->field($model, 'discount')->textInput(['class'=>'form-control discount']);//->label(false) ?></div>
  <?= Html::activeTextInput($model,'discount_percent',['type'=>'hidden','class'=>'discount_percent form-control'])?>
     <div class="mb-5 fl-w100"><?= $form->field($model, 'net')->textInput(['value'=>$model->net,'class'=>'form-control net disabled']);///->label(false)  ?></div>
  <div class="mb-5 fl-w100">
    <div class="form-group field-GoodsReceiptNote-total_tax">
      <div class="input-group">
        <div class="input-group-addon">VAT %</div>
        <?= Html::activeTextInput($model,'vat_percent',['type'=>'hidden','class'=>'vatper','value'=>(($vat_format=="exclusive")?Yii::$app->common->company->vat_rate:0)])?>
       <?= Html::textInput('vatt', (($vat_format=="exclusive")?Yii::$app->common->company->vat_rate:0), ['class' => 'form-control','disabled'=>'true']) ?>
      </div>
    </div>
  </div>
  <div class="mb-5 fl-w100"><?= $form->field($model, 'total_tax')->hiddenInput(['class'=>'form-control total_tax'])->label(false) ?></div>
  <?php endif;?>  <div class="mb-5 fl-w100"><?= $form->field($model, 'grand_total')->textInput(['class'=>'form-control grandtotal '.$disabled]);//->label(false) //['readonly'=>true]?></div>
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
  $('body').on('change','#goodsreceiptnote-po_id',function(){
    var po_id=$("#goodsreceiptnote-po_id").val();
    if(po_id!='' && po_id!='undefined'){
      //  window.location.href='<?php echo Yii::$app->getUrlManager()->createUrl("goods-receipt-note/creategrn"). "&id="?>'+po_id;
      
        $.ajaxSetup({async: false}); 
          $.ajax({
          url: '<?php echo Yii::$app->getUrlManager()->createUrl("goods-receipt-note/creategrn")?>',//"'+po_id+'
          aSync: false,
          data:{'id':po_id},
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
  jQuery('form').bind('submit', function() {
        jQuery(this).find(':disabled').removeAttr('disabled');
    });

</script>
</div>