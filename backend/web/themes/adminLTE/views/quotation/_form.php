<?php

use yii\helpers\Html;
use common\components\AutoForm;
use yii\helpers\ArrayHelper;
use backend\models\Customer;
use backend\models\Items;
use backend\models\Units;
use backend\models\PrefixMaster;
$vat_format=Yii::$app->common->company->vat_format;

/* @var $this yii\web\View */
/* @var $model backend\models\Quotation */
/* @var $form yii\widgets\ActiveForm */
?>
<div>
<?php $form = AutoForm::begin(["id" => "quotation-".time().(($model->isNewRecord)?"create":"update")."-form"]); ?>
<div class="box-body">
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-6">  
          <?= $form->field($model,'prefix_id', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(PrefixMaster::find()->where(["status" => 1])->all(), 'id', 'prefix'), ["prompt" => "Select Prefix",'value'=>(isset(Yii::$app->common->prefix)?Yii::$app->common->prefix->id:'')]) ?>
          
          <?= $form->field($model, 'expected_date')->textInput(['maxlength' => true, 'class' => "form-control datepicker"]) ?>

          <?= $form->field($model, 'remarks')->textarea(['rows' => 6]) ?>

          <?= $form->field($model, 'requested_by')->hiddenInput(['value' => \Yii::$app->user->identity->id])->label(false) ?>
          
          <?= $form->field($model, 'branch_id')->hiddenInput(['value' => Yii::$app->user->identity->branch_id])->label(false) ?>
        </div>
        <div class="col-md-6">
          <?php

          ?>
          <?php if(!$model->isNewRecord):
            $number=$model->qtn_number;
          else :
            $number=(isset($modellastnumber->qtn_number)?$modellastnumber->qtn_number+1:1);
          endif;?>
          <?= $form->field($model, 'qtn_number')->textInput(['maxlength' => true,'value'=>$number]) ?>
          <?= $form->field($model, 'customer_id', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(Customer::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Select Customer"]) ?>                                     
        </div> 
              <div class="col-md-12">
                 <h5 class="heading"><span>Items</span> </h5>
                 
                 <table class="table table-bordered">
                  <thead>
                   <tr>
                    <th>#</th>
                    <th>Item</th>
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
                   <?php if($vat_format=="inclusive") :?>
                   <?= Html::activeTextInput($model1,'vat_rate[]',['type'=>'hidden','class'=>'vatrate'])?>
                   <?= Html::activeTextInput($model1,'tax[]',['type'=>'hidden','class'=>'tax'])?>
                 <?php endif;?>
                 <?= Html::activeTextInput($model1,'total[]',['type'=>'hidden','class'=>'total'])?>
                 <?= Html::activeTextInput($model1,'total_price[]',['type'=>'hidden','class'=>'total_price'])?>
               </td>
               <td><?= $form->field($model1, 'price[]')->textInput(['class'=>'form-control price'])->label(false) ?>
               </td>
               <?php if($vat_format=="inclusive") :?>
               <td>
                <div id="" role="radiogroup" aria-invalid="true">
                  <label>
                    <input type="radio" checked="checked" class="discount_type" value="percentage" name="QuotationItems[dis_type][]"> Rate (%) 
                  </label>
                  <label>
                    <input type="radio" class="discount_type"  value="amount" name="QuotationItems[dis_type][]"> Amount
                  </label>
                </div>
                <?= $form->field($model1, 'discount_percentage[]')->textInput(['class'=>'form-control discount_percentage'])->label(false) ?>
                <input type="hidden" id="QuotationItems-discount_amount" class="discount_amount" name="QuotationItems[discount_amount][]">
              </td>
              <td><?= $form->field($model1, 'net_amount[]')->textInput(['class'=>'form-control net_amount'])->label(false) ?></td>
              <td>
               <input type="hidden" id="QuotationItems-tax" class="tax" name="QuotationItems[tax][]">
               <?= $form->field($model1, 'vat_rate[]')->textInput(['class'=>'form-control vatrate'])->label(false) ?></td>
             <?php endif;?>
             <td><?= $form->field($model1, 'total[]')->textInput(['class'=>'form-control total'])->label(false) ?></td>

            </tr>
            <?php else :

            if($model->requestitems):
            foreach ($model->requestitems as $req) { ?>
            <tr class="item_row" rid="1">
            <?= $form->field($req, 'id[]')->hiddenInput(['value'=>$req->id])->label(false) ?>
            <td><?= Html::a('<span><i class="glyphicon glyphicon-trash"></i></span>', ['#'], ['class'=>'remove_row no-display']) ?></td>
            <td><?= $form->field($req,'item_id[]', ['inputOptions' => ["class" => "select_item_td form-control select2"]])->dropDownList(ArrayHelper::map(Items::find()->where(["status" => 1])->all(), 'id', 'item_name'), ['options' => [$req->item_id => ['Selected'=>'selected']]],  ["prompt" => "Select Items"])->label(false) ?></td>
            <td><?= $form->field($req, 'quantity[]')->textInput(['value'=>$req->quantity,'class'=>'form-control qty'])->label(false) ?></td>
            <td><?= $form->field($req,'unit_id[]', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(Units::find()->where(["status" => 1])->all(), 'id', 'name'), ['options' => [$req->unit_id => ['Selected'=>'selected']]], ["prompt" => "Select unit"])->label(false) ?>
              <?php if($vat_format=="inclusive") :?>
              <?= Html::activeTextInput($req,'vat_rate[]',['type'=>'hidden','class'=>'vatrate','value'=>$req->vat_rate])?>
              <?= Html::activeTextInput($req,'tax[]',['type'=>'hidden','class'=>'tax','value'=>$req->tax])?>
            <?php endif;?>
            <?= Html::activeTextInput($req,'total[]',['type'=>'hidden','class'=>'total','value'=>$req->total])?>
            <?= Html::activeTextInput($req,'total_price[]',['type'=>'hidden','class'=>'total_price','value'=>$req->total_price])?>
            </td>
            <td><?= $form->field($req, 'price[]')->textInput(['value'=>$req->price,'class'=>'form-control price'])->label(false) ?>
            <!-- <input type="" class="total_price" value="<?=$req->total_price?>" name="QuotationItems[total_price][]"> -->
            </td>
            <?php if($vat_format=="inclusive") :?>
            <td>
            <div id="" role="radiogroup" aria-invalid="true">
              <label>
                <input type="radio" <?php if($req->dis_type=="percentage"){echo 'checked="checked"';}?> class="discount_type" value="percentage" name="QuotationItems[dis_type][]"> Rate (%) 
              </label>
              <label>
                <input type="radio" <?php if($req->dis_type=="amount"){echo 'checked="checked"';}?> class="discount_type"  value="amount" name="QuotationItems[dis_type][]"> Amount
              </label>
            </div>
            <?= $form->field($req, 'discount_percentage[]')->textInput(['value'=>$req->discount_percentage,'class'=>'form-control discount_percentage'])->label(false) ?>
            <input type="hidden" id="QuotationItems-discount_amount" value="<?=$req->discount_amount?>" class="discount_amount" name="QuotationItems[discount_amount][]">
            </td>
            <td><?= $form->field($req, 'net_amount[]')->textInput(['value'=>$req->net_amount,'class'=>'form-control net_amount'])->label(false) ?></td>
            <td>
            <input type="hidden" id="QuotationItems-tax" value="<?=$req->tax?>" class="tax" name="QuotationItems[tax][]">
            <?= $form->field($req, 'vat_rate[]')->textInput(['value'=>$req->vat_rate,'class'=>'form-control vatrate'])->label(false) ?></td>
            <?php endif;?>
            <td><?= $form->field($req, 'total[]')->textInput(['value'=>$req->total,'class'=>'form-control total'])->label(false) ?></td>

            </tr>

            <?php } endif;?>

            <?php endif; ?>

            </tbody>


            </table>


            <div class="w50 pull-right">
            <div class="mb-5 fl-w100"><?= $form->field($model, 'subtotal')->textInput(['class'=>'form-control subtotal']);//->label(false) ?></div>
            <?php //if($vat_format=="inclusive") :?>
            <div class="input-group mb-5"><div class="input-group-addon">Discount Type</div>
            <div id="" role="radiogroup" aria-invalid="true">

            <label>
              <input type="radio" checked="checked" name="Quotation[discount_type]"  class="common_discount_type" value="percentage"> Rate (%) 
            </label>
            <label>
              <input type="radio" name="Quotation[discount_type]" class="common_discount_type"  value="amount"> Amount
            </label>
            </div>
            </div>
            <div class="mb-5 fl-w100"><?= $form->field($model, 'discount')->textInput(['class'=>'form-control discount']) ?></div>
            <input type="hidden" id="QuotationItems-discount_percent" class="discount_percent" name="Quotation[discount_percent][]">
            <div class="mb-5 fl-w100">
            <div class="form-group field-Quotation-total_tax">
            <div class="input-group">
              <div class="input-group-addon">VAT %</div>
              <input type="text" id="vatper" class="form-control vatper" name="Quotation[vat_percent]" value="<?=Yii::$app->common->company->vat_rate?>">
            </div>
            </div>
            </div>
            <div class="mb-5 fl-w100"><?= $form->field($model, 'total_tax')->textInput(['class'=>'form-control total_tax']) ?></div>
            <?php //endif;?>
            <div class="mb-5 fl-w100"><?= $form->field($model, 'grand_total')->textInput(['class'=>'form-control grandtotal']);//->label(false) //['readonly'=>true]?></div>
            </div>
            <input type="hidden" id="hiddenurl_itemprice" class="form-control hiddenurl_itemprice" name="" value="<?php echo Yii::$app->getUrlManager()->createUrl(['items/itemprice']);?>">

            <?= Html::Button('<span class="glyphicon glyphicon-plus"></span> Add Items', ['class' => 'btn btn-success btn_add_new pull-left','title'=>'Add Items']) ?>
          </div>
      </div>
    </div>
  </div>
</div>

<!-- /.box-body -->  
<div class="box-footer">
  <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>
<?php AutoForm::end(); ?>
<script>
$( function() {
  $( ".datepicker" ).datepicker({
    defaultDate: new Date(),
    dateFormat: "dd/mm/yy",
    changeMonth: true,
    changeYear: true,
    yearRange: "1930:2030",
  });
});
$(".datepicker").datepicker("setDate", new Date());
$(document).find('select').select2();
</script>
</div>