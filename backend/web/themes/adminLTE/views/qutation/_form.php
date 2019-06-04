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
/* @var $model backend\models\Qutation */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = AutoForm::begin(); ?>
<div class="box-body">
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-6">  
          <?= $form->field($model,'prefix_id', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(PrefixMaster::find()->where(["status" => 1])->all(), 'id', 'prefix'), ["prompt" => "Select Prefix"]) ?>
          
          <?= $form->field($model, 'expected_date')->textInput(['maxlength' => true, 'class' => "form-control datepicker"]) ?>

          <?= $form->field($model, 'requested_by')->hiddenInput(['value' => \Yii::$app->user->identity->id])->label(false) ?>
        </div>
        <div class="col-md-6"> 
          <?= $form->field($model, 'qtn_number')->textInput(['maxlength' => true]) ?>
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
            <?php //if($vat_format=="inclusive") :?>
            <th>Discount</th>
            <th>Net</th>
            <th>VAT</th>
            <?php //endif;?>
            <th>Total</th>
          </tr>
        </thead>


        <tbody class="item_table">
          <?php if($type=='create'): ?>
          <tr class="item_row" rid="1">
            <td class=""><?= Html::a('<span><i class="glyphicon glyphicon-trash"></i></span>', ['#'], ['class'=>'remove_row no-display']) ?></td>
            <td><?= $form->field($model1,'item_id[]', ['inputOptions' => ["class" => "select_item_td form-control select2"]])->dropDownList(ArrayHelper::map(Items::find()->where(["status" => 1])->all(), 'id', 'item_name'), ["prompt" => "Select Items"])->label(false) ?></td>
            <td><?= $form->field($model1, 'quantity[]')->textInput(['class'=>'form-control qty'])->label(false) ?></td>
            <td><?= $form->field($model1,'unit_id[]', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(Units::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Select unit"])->label(false) ?>
              <!-- <input type="hidden" id="qutationitems-price" class="form-control price" name="QutationItems[price][]"> -->
              <!-- <input type="hidden" id="qutationitems-tax" class="form-control vatamount" name="QutationItems[tax][]"> -->
              <!-- <input type="hidden" id="qutationitems-total" class="form-control total" name="QutationItems[total][]"> -->
            </td>
            <td><?= $form->field($model1, 'price[]')->textInput(['class'=>'form-control price'])->label(false) ?>
              <input type="" class="total_price" name="QutationItems[total_price][]">
            </td>
            <?php //if($vat_format=="inclusive") :?>
            <td>
              <div id="" role="radiogroup" aria-invalid="true">
                <label>
                  <input type="radio" checked="checked" class="discount_type" value="percentage" name="QutationItems[dis_type][]"> Rate (%) 
                </label>
                <label>
                  <input type="radio" class="discount_type"  value="amount" name="QutationItems[dis_type][]"> Amount
                </label>
              </div>
              <?= $form->field($model1, 'discount_percentage[]')->textInput(['class'=>'form-control discount_percentage'])->label(false) ?>
              <input type="hidden" id="QutationItems-discount_amount" class="discount_amount" name="QutationItems[discount_amount][]">
            </td>
            <td><?= $form->field($model1, 'net_amount[]')->textInput(['class'=>'form-control net_amount'])->label(false) ?></td>
            <td>
             <input type="hidden" id="QutationItems-tax" class="tax" name="QutationItems[tax][]">
             <?= $form->field($model1, 'vat_rate[]')->textInput(['class'=>'form-control vatrate'])->label(false) ?></td>
             <?php //endif;?>
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
              <!-- <input type="hidden" id="qutationitems-price" class="form-control price" value="<?=$req->price?>" name="QutationItems[price][]"> -->
              <!-- <input type="hidden" id="qutationitems-tax" class="form-control vatamount" value="<?=$req->tax?>" name="QutationItems[tax][]"> -->
              <!-- <input type="hidden" id="qutationitems-total" class="form-control total" value="<?=$req->total?>" name="QutationItems[total][]"> -->
            </td>
            <td><?= $form->field($req, 'price[]')->textInput(['value'=>$req->price,'class'=>'form-control price'])->label(false) ?>
              <input type="" class="total_price" value="<?=$req->total_price?>" name="QutationItems[total_price][]">
            </td>
            <?php if($vat_format=="inclusive") :?>
            <td>
              <div id="" role="radiogroup" aria-invalid="true">
                <label>
                  <input type="radio" <?php if($req->dis_type=="discount_type"){echo 'checked="checked"';}?> class="discount_type" value="percentage" name="QutationItems[dis_type][]"> Rate (%) 
                </label>
                <label>
                  <input type="radio" <?php if($req->dis_type=="discount_type"){echo 'checked="checked"';}?> class="discount_type"  value="amount" name="QutationItems[dis_type][]"> Amount
                </label>
              </div>
              <?= $form->field($req, 'discount_percentage[]')->textInput(['value'=>$req->discount_percentage,'class'=>'form-control discount_percentage'])->label(false) ?>
              <input type="hidden" id="QutationItems-discount_amount" value="<?=$req->discount_amount?>" class="discount_amount" name="QutationItems[discount_amount][]">
            </td>
            <td><?= $form->field($req, 'net_amount[]')->textInput(['value'=>$req->net_amount,'class'=>'form-control net_amount'])->label(false) ?></td>
            <td>
             <input type="hidden" id="QutationItems-tax" value="<?=$req->tax?>" class="tax" name="QutationItems[tax][]">
             <?= $form->field($req, 'vat_rate[]')->textInput(['value'=>$req->vat_rate,'class'=>'form-control vatrate'])->label(false) ?></td>
           <?php endif;?>
           <td><?= $form->field($req, 'total[]')->textInput(['value'=>$req->total,'class'=>'form-control total'])->label(false) ?></td>
           
         </tr>

         <?php } endif;?>

       <?php endif; ?>

     </tbody>


   </table>
   
   
   <div class="w50 pull-right">
    <div class="mb-5 fl-w100"><?= $form->field($model, 'subtotal')->hiddenInput(['class'=>'form-control subtotal'])->label(false) ?></div>
    <?php //if($vat_format=="inclusive") :?>
    <div class="input-group mb-5"><div class="input-group-addon">Discount Type</div>
    <div id="" role="radiogroup" aria-invalid="true">

      <label>
        <input type="radio" checked="checked" name="Qutation[discount_type]"  class="common_discount_type" value="percentage"> Rate (%) 
      </label>
      <label>
        <input type="radio" name="Qutation[discount_type]" class="common_discount_type"  value="amount"> Amount
      </label>
    </div>
  </div>
  <div class="mb-5 fl-w100"><?= $form->field($model, 'discount')->textInput(['class'=>'form-control discount']) ?></div>
  <input type="hidden" id="QutationItems-discount_percent" class="discount_percent" name="Qutation[discount_percent][]">
  <div class="mb-5 fl-w100">
    <div class="form-group field-Qutation-total_tax">
      <div class="input-group">
        <div class="input-group-addon">VAT %</div>
        <input type="text" id="vatper" class="form-control vatper" name="Qutation[vat_percent]" value="<?=Yii::$app->common->company->vat_rate?>">
      </div>
    </div>
  </div>
  <div class="mb-5 fl-w100"><?= $form->field($model, 'total_tax')->textInput(['class'=>'form-control total_tax']) ?></div>
  <?php //endif;?>
  <div class="mb-5 fl-w100"><?= $form->field($model, 'grand_total')->hiddenInput(['class'=>'form-control grandtotal'])->label(false) //['readonly'=>true]?></div>
</div>
<input type="hidden" id="hiddenurl_itemprice" class="form-control hiddenurl_itemprice" name="" value="<?php echo Yii::$app->getUrlManager()->createUrl(['items/itemprice']);?>">
                   <!--  <div class="col-md-2"><input type="text"></div>
                    <div class="col-md-2"><input type="text"></div>
                    <div class="col-md-2"><input type="text"></div>
                    <div class="col-md-2"><input type="text"></div>
                    <div class="col-md-2"><input type="text"></div>
                    <div class="col-md-2"><input type="text"></div> -->
                    <?= Html::Button('<span class="glyphicon glyphicon-plus"></span> Add Items', ['class' => 'btn btn-success btn_add_new pull-left','title'=>'Add Items']) ?>
                  </div>
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
// $('body').on('click','.btn_add_new',function(e){
//     e.preventDefault();
//     var clone = $('.item_row:last').clone();
//     console.log(clone.find(".field-purchaserequestitems-item_id").children().children('span'));
//     clone.find('a.no-display').removeClass('no-display');
//     clone.find(".input-group").children('select').removeClass('select2');
//     clone.find(".input-group").children('span').remove();
//     clone.find("input").val('');
//     clone.find(".input-group").children('select').select2();
//          // clone.find(".field-purchaserequestitems-item_id")
//          //    .children('select')
//          //    // call destroy to revert the changes made by Select2
//          //    .select2("destroy")
//          //    .end()
//             // .append(
//             //     // clone the row and insert it in the DOM
//             //     $(".field-purchaserequestitems-item_id")
//             //     .children("select")
//             //     .first()
//             //     .clone()
//         // );
//         // clone.find('select').select2('destroy');
//         clone.find('select').select2();
//         $('.item_table').append(clone);
//     });
// $('body').on('click','.remove_row',function(e){
//    e.preventDefault();
//    $(this).closest('tr').remove();
// });


// $('body').on('change','.select_item_td',function(){
//     var item_id=$(this).val();
//     var thisrow=$(this).closest('tr');
//     var data={'item_id':item_id}
//     if(item_id!='' && item_id!='undefined'){
//         $.ajax({
//             'type':'post',
//             'url':"<?php echo Yii::$app->getUrlManager()->createUrl(['items/itemprice']);?>",
//             'data':data,
//             success:function(s){
//               console.log(s);
//                 var response = JSON.parse(s);
//                 $(thisrow).find('#qutationitems-price').val(response.selling_price);
//                 $(thisrow).find('#qutationitems-tax').val(response.vat);
//                 $(thisrow).find('#qutationitems-unit_id').val(response.unit_id);

//             }
//         });
//     }
// }); 
// // change the total with quantity and price 
// $('body').on('change','.qty,.price,.vatamount',function(){
//     var thisrow=$(this).closest('tr');
//     var total=0;
//     var qty=0;
//     var price=0;
//     var vat=0;
//     var vatamount=100;
//     if($(thisrow).find('.qty').val()!='' && $(thisrow).find('.qty').val()!='undefined'){
//         qty=$(thisrow).find('.qty').val();
//     }
//      if($(thisrow).find('.price').val()!='' && $(thisrow).find('.price').val()!='undefined'){
//         price=$(thisrow).find('.price').val();
//     }
//     if($(thisrow).find('.vatamount').val()!='' && $(thisrow).find('.vatamount').val()!='undefined'){
//         vatamount=$(thisrow).find('.vatamount').val();
//         vat=(parseFloat(qty)*parseFloat(price))*parseFloat(vatamount)/100;
//     }
//     total=(parseFloat(qty)*parseFloat(price))+ parseFloat(vat);
//     $(thisrow).find('.total').val(total);
//     $('.total').trigger('change');
// });
// // sum up totals to get subtotal
// $('body').on('change','.total',function(){
//     var subtotal=0;
//        $('.total').each(function () {
//           if($.isNumeric($(this).val())){
//             subtotal+=parseFloat($(this).val());
//           }
//        });
//    $('.subtotal').val(subtotal);
//    $('.subtotal').trigger('change');
// });
// $('body').on('change','.subtotal',function(){
//     var gtotal=0;
//    var subtotal= $('.subtotal').val();
//    var discount= $('.discount').val();
//    if($.isNumeric(discount)){
//         gtotal= parseFloat(subtotal)-parseFloat(discount); 
//    }else{
//         gtotal=subtotal;
//    }
//     $('.grandtotal').val(gtotal);
// });
// // reduce discount from total
// $('body').on('change','.discount',function(){
//     var discount=$(this).val();
//     var subtotal=$('.subtotal').val();
//     var grandtotal=parseFloat(subtotal)-parseFloat(discount); 
//     $('.grandtotal').val(grandtotal);
// });
// $( function() {
//     $( ".datepicker" ).datepicker({
//       defaultDate: new Date(),
//       dateFormat: "dd/mm/yy",
//       changeMonth: true,
//       changeYear: true,
//       yearRange: "1930:2030",
//   });
// });
</script>