<?php

use yii\helpers\Html;
use common\components\AutoForm;
use yii\helpers\ArrayHelper;
use backend\models\Supplier;
use backend\models\Purchaserequest;
use backend\models\Items;
use backend\models\Units;
use backend\models\PrefixMaster;
// var_dump($model);die;
/* @var $this yii\web\View */
/* @var $model backend\models\Purchaseorder */
/* @var $form yii\widgets\ActiveForm */
$vat_format=Yii::$app->common->company->vat_format;
?>
<?php $form = AutoForm::begin(); ?>
<div class="col-md-6"> 
  <?= $form->field($model1,'pr_id', ['inputOptions' => ["class" => "select_pr form-control select2"]])->dropDownList(ArrayHelper::map(Purchaserequest::find()->where(["status" => 1])->andWhere(['!=', 'process_status', 'completed'])->all(), 'id', 'pr_number'), ["prompt" => "Select PR"]) ?>
</div>

<!-- <div class="col-md-6 "> 
  <?= Html::Button('Go', ['class' => 'btn btn-success btn_select_pr pull-left']) ?>
</div> -->
<?php AutoForm::end(); ?>

<?php $form = AutoForm::begin(["id" => "purchase-order-".time().(($model->isNewRecord)?"createpo":"update")."-form"]); ?>
<div class="box-body">
  <div class="row">
    <div class="col-md-12">
     <?= $form->field($model1,'pr_id')->hiddenInput(['value'=>$model->id])->label(false) ?>
     <div class="row">
      <div class="col-md-6"> 

       <div class="form-group field-deliveryorder-do_number required has-error">
        <div class="input-group">
          <div class="input-group-addon">PR Number</div>
          <input type="text" id="" class="form-control" name="" disabled value="<?= $model->prefix->prefix.' '.$model->pr_number?>">
        </div>
      </div>
      <?= $form->field($model1,'prefix_id', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(PrefixMaster::find()->where(["status" => 1])->all(), 'id', 'prefix'), ["prompt" => "Select Prefix",'value'=>(isset(Yii::$app->common->prefix->id)?Yii::$app->common->prefix->id:'')]) ?>
      <?= $form->field($model1, 'supplier_id', ['inputOptions' => ["class" => "supplier_id form-control select2"]])->dropDownList(ArrayHelper::map(Supplier::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Select Supplier",'value'=>(isset($model->supplier_id)?$model->supplier_id:'')]) ?>                                     
      <span class="append_here">
         <?php if(Yii::$app->controller->action->id=='update'):
              echo Html::textarea('supplier_address',$model1->supplier->address,['class'=>'form-control','rows'=>6]);
              else:
               echo Html::textarea('supplier_address',$model->supplier->address,['class'=>'form-control','rows'=>6]); 
              endif;?>
      </span>
      <?= $form->field($model1, 'po_created_by')->hiddenInput(['value' => \Yii::$app->user->identity->id])->label(false) ?>
      <?= $form->field($model, 'branch_id')->hiddenInput(['value' => Yii::$app->user->identity->branch_id])->label(false) ?>
    </div>
    <div class="col-md-6"> 
       <?php if(Yii::$app->controller->action->id=='update'):
                    $number=$model->po_number;
                    else :
                    $number=(isset($modellastnumber->po_number)?$modellastnumber->po_number+1:1);
                    endif;?>
      <?= $form->field($model1, 'po_expected_date')->textInput(['maxlength' => true, 'class' => "form-control datepicker"]) ?>
      <?= $form->field($model1, 'po_number')->textInput(['maxlength' => true,'value'=>$number]) ?>
      <?= $form->field($model, 'remarks')->textarea(['rows' => 6]) ?>
    </div>
    <div class="col-md-12">
     <h5 class="heading"><span>Items</span> </h5>

     <table class="table table-bordered">
      <thead>
        <tr>


         <th>#</th>
         <th>Item</th>
         <th>Requested Quantity</th>
         <th>Quantity</th>
         <th>Unit</th>
         <th>Price</th>
         <th>Total</th>
       <!--   
         <?php //if($vat_format=="inclusive") :?>
         <th>Discount</th>
         <th>Net</th>
         <th>VAT</th>
         <?php //endif;?>
          -->
       </tr>
     </thead>


     <tbody class="item_table">
      <?php if($model->isNewRecord): ?>
      <tr class="item_row" rid="1">
        <td class=""><?= Html::a('<span><i class="glyphicon glyphicon-trash"></i></span>', ['#'], ['class'=>'remove_row no-display']) ?></td>
        <td><?= $form->field($model1,'item_id[]', ['inputOptions' => ["class" => "select_item_td form-control select2"]])->dropDownList(ArrayHelper::map(Items::find()->where(["status" => 1])->all(), 'id', 'item_name'), ["prompt" => "Select Items"])->label(false) ?></td>
        <td><?= $form->field($model1, 'quantity[]')->textInput()->label(false) ?></td>
        <td><?= $form->field($model, 'quantity[]')->textInput(['class'=>'qty form-control'])->label(false) ?></td>
        <td><?= $form->field($model1,'unit_id[]', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(Units::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Select unit"])->label(false) ?> 
         
          <?php if($vat_format=="inclusive") :?>
          <?= Html::activeTextInput($model1,'vat_rate[]',['type'=>'hidden','class'=>'vatrate'])?>
          <?= Html::activeTextInput($model1,'tax[]',['type'=>'hidden','class'=>'tax'])?>
        <?php endif;?>
        
        <?= Html::activeTextInput($model1,'total_price[]',['type'=>'hidden','class'=>'total_price'])?>
      </td>
      <td>
         <?= Html::activeTextInput($model1,'price[]',['type'=>'text','class'=>'price form-control'])?>
      </td>
      <td><?= Html::activeTextInput($model1,'total[]',['type'=>'text','class'=>'total form-control'])?></td>
    </tr>
    <?php else :

    if($model->requestitems):
      foreach ($model->requestitems as $req) { ?>
    <tr class="item_row" rid="1">
      <?= $form->field($modelpr, 'id[]')->hiddenInput(['value'=>$req->id])->label(false) ?>
      <td><?= Html::a('<span><i class="glyphicon glyphicon-trash"></i></span>', ['#'], ['class'=>'remove_row no-display']) ?></td>
      <td><?= $form->field($modelpr,'item_id[]', ['inputOptions' => ["class" => "select_item_td form-control select2"]])->dropDownList(ArrayHelper::map(Items::find()->where(["status" => 1])->all(), 'id', 'item_name'), ['options' => [$req->item_id => ['Selected'=>'selected']]],['value'=>$req->item_id],  ["prompt" => "Select Items"])->label(false) ?></td>
      <td><?= $form->field($modelpr, 'pr_quantity[]')->textInput(['value'=>(($req->remaining_quantity!=0)?$req->remaining_quantity:$req->quantity),'class'=>'form-control remaining_qty'])->label(false) ?></td>
      <td><?= $form->field($modelpr, 'quantity[]')->textInput(['class'=>'qty form-control'])->label(false) ?></td>
      <td><?= $form->field($modelpr,'unit_id[]', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(Units::find()->where(["status" => 1])->all(), 'id', 'name'), ['options' => [$req->unit_id => ['Selected'=>'selected']]],['value'=>$req->unit_id], ["prompt" => "Select unit"])->label(false) ?>
      
        <?php if($vat_format=="inclusive") :?>
        <?= Html::activeTextInput($req,'vat_rate[]',['type'=>'hidden','class'=>'vatrate','value'=>$req->vat_rate])?>
        <?= Html::activeTextInput($req,'tax[]',['type'=>'hidden','class'=>'tax','value'=>$req->tax])?>
      <?php endif;?>
      
      <?= Html::activeTextInput($req,'total_price[]',['type'=>'hidden','class'=>'total_price','value'=>$req->total_price])?>

    </td>
    <td>  <?= Html::activeTextInput($req,'price[]',['type'=>'text','class'=>'price form-control','value'=>$req->price])?></td>
  <td><?= Html::activeTextInput($req,'total[]',['type'=>'text','class'=>'total form-control','value'=>$req->total])?> </td>
  </tr>

  <?php } endif;?>

<?php endif; ?>

</tbody>


</table>


<div class="w50 pull-right">
  <div class="mb-5 fl-w100"><?= $form->field($model1, 'subtotal')->textInput(['value'=>$model->subtotal,'class'=>'subtotal form-control']);//->label(false)  ?></div>
  <?php if($vat_format=="exclusive") :?>
  <div class="input-group mb-5">
    <div class="input-group-addon">Discount Type</div>
    <div id="" role="radiogroup" class="" aria-invalid="true">

      <label>
        <input type="radio" checked="checked" name="Purchaseorder[discount_type]"  class="common_discount_type" value="percentage"> Rate (%) 
      </label>
      <label>
        <input type="radio" name="Purchaseorder[discount_type]" class="common_discount_type"  value="amount"> Amount
      </label>
    </div>
  </div>
  <div class="mb-5 fl-w100"><?= $form->field($model1, 'discount')->textInput(['class'=>'form-control discount']);//->label(false)  ?></div>
  <input type="hidden" id="Purchaseorderitems-discount_percent" class="discount_percent" name="Purchaseorder[discount_percent]">
  <div class="mb-5 fl-w100">
    <div class="form-group field-Purchaseorder-vat_percent">
      <div class="input-group">
        <div class="input-group-addon">VAT %</div>
        <?= Html::activeTextInput($model,'vat_percent',['type'=>'hidden','class'=>'vatper','value'=>(($vat_format=="exclusive")?Yii::$app->common->company->vat_rate:0)])?>
        <?= Html::textInput('vatt', (($vat_format=="exclusive")?Yii::$app->common->company->vat_rate:0), ['class' => 'form-control','disabled'=>'true']) ?>
      </div>
    </div>
  </div>
  <div class="mb-5 fl-w100"><?= $form->field($model1, 'total_tax')->hiddenInput(['class'=>'form-control total_tax'])->label(false)  ?></div>
  <?php endif;?>
  <div class="mb-5 fl-w100"><?= $form->field($model1, 'grand_total')->textInput(['value'=>$model->grand_total,'class'=>'grandtotal form-control']);//->label(false)  //['readonly'=>true]?></div>
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

  $('body').on('change','.select_pr',function(){
    var pr_id=$(this).val();
    if(pr_id!='' && pr_id!='undefined'){
      // window.location.href='<?php echo Yii::$app->getUrlManager()->createUrl("purchase-order/createpo"). "&id="?>'+pr_id;
     $.ajaxSetup({async: false}); 
          $.ajax({
          url: '<?php echo Yii::$app->getUrlManager()->createUrl("purchase-order/createpo")?>',//"'+po_id+'
          aSync: false,
          data:{'id':pr_id},
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