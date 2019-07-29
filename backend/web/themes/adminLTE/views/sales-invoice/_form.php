<?php

use yii\helpers\Html;
use common\components\AutoForm;
use yii\helpers\ArrayHelper;
use backend\models\Customer;
use backend\models\DeliveryOrder;
use backend\models\Items;
use backend\models\Units;
use backend\models\PrefixMaster;

/* @var $this yii\web\View */
/* @var $model backend\models\Purchaseorder */
/* @var $form yii\widgets\ActiveForm */
$vat_format=Yii::$app->common->company->vat_format;
?>
<div class="sales-invoice-form">
  <?php $form = AutoForm::begin(["id" => "sales-invoice-".time().(($model->isNewRecord)?"create":"update")."-form"]); ?>
  <div class="box-body">
    <div class="row">
     <?php 
     $disabled='';
     if(!$model->isNewRecord  && $model->do_id){ 
      $disabled='disabled';
    }
      ?>
      <?php if($model->isNewRecord): ?>
      <div class="mb-20">

        <div class="col-md-6"> 
          <?= $form->field($model,'do_id', ['inputOptions' => ["class" => "select_do form-control select2"]])->dropDownList(ArrayHelper::map(DeliveryOrder::find()->where(["status" => 1])->all(), 'id', 'do_number'), ["prompt" => "Select DO"]) ?>
        </div>
        <?php //if($model->isNewRecord): ?>
        <!-- <div class="col-md-6 "> 
            <?= Html::Button('Go', ['class' => 'btn btn-success btn_select_do pull-left']) ?>
          </div> -->
          <?php //endif; ?>
        </div>
      <?php endif; ?>
      <div class="col-md-12">

        <div class="row">

          <div class="col-md-6"> 
            <?php if($model->isNewRecord):
            $prefix=(isset(Yii::$app->common->prefix)?Yii::$app->common->prefix->id:'');
            else :
              $prefix=$model->prefix_id;
            endif;
            ?>
            <?= $form->field($model,'prefix_id', ['inputOptions' => ["class" => "form-control select2",'disabled'=>true]])->dropDownList(ArrayHelper::map(PrefixMaster::find()->where(["status" => 1])->all(), 'id', 'prefix'), ["prompt" => "Select Prefix",'value'=>$prefix]) ?>
            <?= $form->field($model, 'customer_id', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(Customer::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Select Customer"]) ?>  
            <?= $form->field($model, 'inv_created_by')->hiddenInput(['value' => \Yii::$app->user->identity->id])->label(false) ?>
            <?= $form->field($model, 'remarks')->textarea(['rows' => 6]) ?>
            <?= $form->field($model, 'branch_id')->hiddenInput(['value' => Yii::$app->user->identity->branch_id])->label(false) ?>
          </div>
          <div class="col-md-6"> 
           <?php if(!$model->isNewRecord):
           $number=$model->inv_number;
           else :
            $number=(isset($modellastnumber->inv_number)?$modellastnumber->inv_number+1:1);
          endif;?>
          <?= $form->field($model, 'inv_number')->textInput(['maxlength' => true,'value'=>$number,'class'=>'form-control disabled']) ?>
          <?= $form->field($model, 'inv_date')->textInput(['maxlength' => true,'class'=>'form-control datepicker']) ?>

        </div>
        <div class="col-md-12">
         <h5 class="heading"><span>Items</span> </h5>
         
         <table class="table table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th>Item</th>
              <?php if(!$model->isNewRecord && $model->do_id!=""): ?>
              <th>Order Quantity</th>
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
          <td><?= $form->field($model1,'unit_id[]', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(Units::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Select unit"])->label(false) ?></td>
          <td><?= $form->field($model1, 'price[]')->textInput(['class'=>'form-control price'])->label(false) ?>
           <?= Html::activeTextInput($model1,'total_price[]',['type'=>'hidden','class'=>'total_price form-control'])?>
         </td>
         <?php if($vat_format=="inclusive") :?>
         <td>
          <div id="" role="radiogroup" aria-invalid="true">
            <label>
              <input type="radio" checked="checked" class="discount_type" value="percentage" name="SalesInvoiceItems[dis_type][]"> Rate (%) 
            </label>
            <label>
              <input type="radio" class="discount_type"  value="amount" name="SalesInvoiceItems[dis_type][]"> Amount
            </label>
          </div>
          <?= $form->field($model1, 'discount_percentage[]')->textInput(['class'=>'form-control discount_percentage'])->label(false) ?>
          <?= Html::activeTextInput($model1,'discount_amount[]',['type'=>'hidden','class'=>'discount_amount form-control form-control'])?>
        </td>
        <td><?= $form->field($model1, 'net_amount[]')->textInput(['class'=>'form-control net_amount'])->label(false) ?></td>
        <td>
         <?= Html::activeTextInput($model1,'tax[]',['type'=>'hidden','class'=>'tax form-control form-control'])?>
         <?= $form->field($model1, 'vat_rate[]')->textInput(['class'=>'form-control vatrate'])->label(false) ?></td>
       <?php endif;?>
       <td><?= $form->field($model1, 'total[]')->textInput(['class'=>'form-control total'])->label(false) ?></td>
     </tr>
     <?php else :

     if($model->invoiceitems):
      foreach ($model->invoiceitems as $req) { ?>
    <tr class="item_row" rid="1">
      <?= $form->field($req, 'id[]')->hiddenInput(['value'=>$req->id])->label(false) ?>
      <td><?= Html::a('<span><i class="glyphicon glyphicon-trash"></i></span>', ['#'], ['class'=>'remove_row no-display']) ?></td>
      <td><?= $form->field($req,'item_id[]', ['inputOptions' => ["class" => "select_item_td form-control select2",'disabled' => ($model->pr_id) ? 'disabled' : false]])->dropDownList(ArrayHelper::map(Items::find()->where(["status" => 1])->all(), 'id', 'item_name'), ['options' => [$req->item_id => ['Selected'=>'selected']]],  ["prompt" => "Select Items"])->label(false) ?></td>
      <?php if(!$model->isNewRecord && $model->do_id!=""): ?>
      <td><?= $form->field($req, 'do_quantity[]')->textInput(['value'=>$req->do_quantity,'class'=>'form-control '.$disabled])->label(false) ?></td>
    <?php endif; ?>

    <td><?= $form->field($req, 'quantity[]')->textInput(['value'=>$req->quantity,'class'=>'form-control qty'])->label(false) ?></td>
    <td><?= $form->field($req,'unit_id[]', ['inputOptions' => ["class" => "form-control select2",'disabled' => ($model->pr_id) ? 'disabled' : false]])->dropDownList(ArrayHelper::map(Units::find()->where(["status" => 1])->all(), 'id', 'name'), ['options' => [$req->unit_id => ['Selected'=>'selected']]], ["prompt" => "Select unit"])->label(false) ?></td>
    <td><?= $form->field($req, 'price[]')->textInput(['value'=>$req->price,'class'=>'form-control price '.$disabled])->label(false) ?>
     <?= Html::activeTextInput($req,'total_price[]',['type'=>'hidden','class'=>'total_price form-control ','value'=>$req->total_price])?>
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
  <td><?= $form->field($req, 'net_amount[]')->textInput(['value'=>$req->net_amount,'class'=>'form-control net_amount'])->label(false) ?></td>
  <td>
    <?= Html::activeTextInput($req,'tax[]',['type'=>'hidden','class'=>'tax form-control form-control','value'=>$req->tax])?>
    <?= $form->field($req, 'vat_rate[]')->textInput(['value'=>$req->vat_rate,'class'=>'form-control vatrate'])->label(false) ?></td>
  <?php endif;?>
  <td><?= $form->field($req, 'total[]')->textInput(['value'=>$req->total,'class'=>'form-control total '.$disabled])->label(false) ?></td>

</tr>

<?php } endif;?>

<?php endif; ?>

</tbody>


</table>


<div class="w50 pull-right">
  <div class="mb-5 fl-w100"><?= $form->field($model, 'subtotal')->textInput(['class'=>'form-control subtotal '.$disabled]) ?></div>
  <?php if($vat_format=="exclusive") :?>
  <div class="input-group mb-5"><div class="input-group-addon">Discount Type</div>
  <div id="" role="radiogroup" aria-invalid="true">

    <label>
      <input type="radio" checked="checked" name="SalesInvoice[discount_type]"  class="common_discount_type" value="percentage"> Rate (%) 
    </label>
    <label>
      <input type="radio" name="SalesInvoice[discount_type]" class="common_discount_type"  value="amount"> Amount
    </label>
  </div>
</div>
<div class="mb-5 fl-w100"><?= $form->field($model, 'discount')->textInput(['class'=>'form-control discount']) ?></div>
<?= Html::activeTextInput($model,'discount_percent',['type'=>'hidden','class'=>'discount_percent form-control'])?>
<div class="mb-5 fl-w100">
  <div class="form-group field-salesinvoice-total_tax">
    <div class="input-group">
      <div class="input-group-addon">VAT %</div>
      <?= Html::activeTextInput($model,'vat_percent',['type'=>'hidden','class'=>'vatper form-control','value'=>(($vat_format=="exclusive")?Yii::$app->common->company->vat_rate:0)])?>
      <?= Html::textInput('vatt', (($vat_format=="exclusive")?Yii::$app->common->company->vat_rate:0), ['class' => 'form-control','disabled'=>'true']) ?>

    </div>
  </div>
</div>
<div class="mb-5 fl-w100"><?= $form->field($model, 'total_tax')->hiddenInput(['class'=>'form-control total_tax'])->label(false) ?></div>
<?php endif;?>
<div class="mb-5 fl-w100"><?= $form->field($model, 'grand_total')->textInput(['class'=>'form-control grandtotal '.$disabled]) //['readonly'=>true]?></div>
</div>

<?php if(!$model->isNewRecord  && $model->do_id){ ?>
<?= Html::Button('<span class="glyphicon glyphicon-plus"></span> Add Items', ['class' => 'btn btn-success btn_add_new pull-left','title'=>'Add Items']) ?>
<?php } ?>  
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

$('body').on('change','.select_do',function(){
  var pr_id=$(this).val();
  if(pr_id!='' && pr_id!='undefined'){

    $.ajaxSetup({async: false}); 
    $.ajax({
          url: '<?php echo Yii::$app->getUrlManager()->createUrl("sales-invoice/createinv")?>',//"'+po_id+'
          aSync: false,
          data:{'id':pr_id},
          dataType: "html",
          success: function(data) {
            $(".main-body").addClass("hide");
            $(".container-body").append($(data));
          }});
    $.ajaxSetup({async: true}); 
  }
});
</script>
</div>