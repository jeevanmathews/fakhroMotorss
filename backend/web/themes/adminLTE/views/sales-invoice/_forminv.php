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
/* @var $model backend\models\SalesOrder */
/* @var $form yii\widgets\ActiveForm */

$vat_format=Yii::$app->common->company->vat_format;
?>
<div class="sales-invoice-form">
<?php $form = AutoForm::begin(["id" => "sales-invoice-".time().(($model->isNewRecord)?"createinv":"update")."-form"]); ?>
    <div class="col-md-6"> 
        <?= $form->field($model1,'do_id', ['inputOptions' => ["class" => "select_do form-control select2"]])->dropDownList(ArrayHelper::map(DeliveryOrder::find()->where(["status" => 1])->all(), 'id', 'do_number'), ["prompt" => "Select DO"]) ?>
    </div>
    
  <!--   <div class="col-md-6 "> 
        <?= Html::Button('Go', ['class' => 'btn btn-success btn_select_do pull-left']) ?>
    </div> 
<?php AutoForm::end(); ?>
<?php $form = AutoForm::begin(["id" => "sales-invoice-".time().(($model->isNewRecord)?"createinv":"update")."-form"]); ?>
--><div class="box-body">
    <div class="row">
         <div class="mb-20">

                 <?= $form->field($model1, 'do_id')->hiddenInput(['value' => $model->id])->label(false) ?>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6"> 
                    <div class="form-group field-deliveryorder-inv_number required has-error">
                      <div class="input-group">
                        <div class="input-group-addon">DO Number</div>
                        <?= Html::textInput('donum', $model->prefix->prefix.' '.$model->do_number, ['class'=>'form-control','disabled'=>true]); ?>
                      </div>
                    </div>
                     <?php if($model->isNewRecord):
                        $prefix=(isset(Yii::$app->common->prefix)?Yii::$app->common->prefix->id:'');
                        else :
                          $prefix=$model1->prefix_id;
                        endif;
                        ?>
                      <?= $form->field($model1,'prefix_id', ['inputOptions' => ["class" => "form-control select2",'disabled'=>true]])->dropDownList(ArrayHelper::map(PrefixMaster::find()->where(["status" => 1])->all(), 'id', 'prefix'), ["prompt" => "Select Prefix",'value'=>$prefix]) ?>
                   <?= $form->field($model1, 'customer_id', ['inputOptions' => ["class" => "form-control select2",'disabled'=>true]])->dropDownList(ArrayHelper::map(Customer::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Select Customer"]) ?>                                     
                    <?= $form->field($model1, 'inv_created_by')->hiddenInput(['value' => \Yii::$app->user->identity->id])->label(false) ?>
                     <?= $form->field($model1, 'remarks')->textarea(['rows' => 6]) ?>
                      <?= $form->field($model1, 'branch_id')->hiddenInput(['value' => Yii::$app->user->identity->branch_id])->label(false) ?>
                </div>
                <div class="col-md-6"> 
                      <?php if(!$model1->isNewRecord):
                           $number=$model1->inv_number;
                           else :
                            $number=(isset($modellastnumber->inv_number)?$modellastnumber->inv_number+1:1);
                           endif;?>
                    <?= $form->field($model1, 'inv_date')->textInput(['maxlength' => true, 'class' => "form-control datepicker"]) ?>
                     <?= $form->field($model1, 'inv_number')->textInput(['maxlength' => true,'value'=>$number,'class'=>'form-control disabled']) ?>
                    
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
                                <td><?= $form->field($modelpr, 'quantity[]')->textInput(['class'=>'form-control qty'])->label(false) ?></td>
                                <td><?= $form->field($modelpr,'unit_id[]', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(Units::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Select unit"])->label(false) ?></td>
                                <td><?= $form->field($modelpr, 'price[]')->textInput(['class'=>'form-control price'])->label(false) ?>
                                    <?= Html::activeTextInput($model1,'total_price[]',['type'=>'hidden','class'=>'total_price form-control'])?>
                                </td>
                               <?php if($vat_format=="inclusive") :?>
                                <td>
                                <div id="" role="radiogroup" aria-invalid="true">
                                    <label>
                                    <input type="radio" checked="checked" class="discount_type" value="discount_percent" name="SalesInvoiceItems[dis_type][]"> Rate (%) 
                                    </label>
                                    <label>
                                    <input type="radio" class="discount_type"  value="discount_amount" name="SalesInvoiceItems[dis_type][]"> Amount
                                   </label>
                                </div>
                                <?= $form->field($modelpr, 'discount_percentage[]')->textInput(['class'=>'form-control discount_percentage'])->label(false) ?>
                                  <?= Html::activeTextInput($model1,'discount_amount[]',['type'=>'hidden','class'=>'discount_amount form-control form-control'])?>
                                </td>
                                <td><?= $form->field($modelpr, 'net_amount[]')->textInput(['class'=>'form-control net_amount'])->label(false) ?></td>
                                <td>
                                      <?= Html::activeTextInput($model1,'tax[]',['type'=>'hidden','class'=>'tax form-control form-control'])?>
                                    <?= $form->field($modelpr, 'vat_rate[]')->textInput(['class'=>'form-control vatrate'])->label(false) ?></td>
                                  <?php endif;?>

                               <td><?= $form->field($modelpr, 'total[]')->textInput(['class'=>'form-control total'])->label(false) ?></td>
                                
                            </tr>
                            <?php else :

                            if($model->orderitems):
                                $count=0;
                                foreach ($model->orderitems as $req) { ?>
                            <tr class="item_row" rid="1">
                                <td>
                                <?= $form->field($modelpr, 'id[]')->hiddenInput(['value'=>$req->id])->label(false) ?>
                                <?= Html::a('<span><i class="glyphicon glyphicon-trash"></i></span>', ['#'], ['class'=>'remove_row no-display']) ?></td>
                                <td><?= $form->field($modelpr,'item_id[]', ['inputOptions' => ["class" => "select_item_td form-control select2",'disabled'=>true]])->dropDownList(ArrayHelper::map(Items::find()->where(["status" => 1])->all(), 'id', 'item_name'), ['options' => [$req->item_id => ['Selected'=>'selected']]],['value'=>$req->item_id],  ["prompt" => "Select Items"])->label(false) ?></td>
                                <td><?= $form->field($req, 'quantity[]')->textInput(['value'=>(($req->remaining_quantity!=0)?$req->remaining_quantity:$req->quantity),'class'=>'form-control disabled'])->label(false) ?></td>
                                 <td><?= $form->field($modelpr, 'quantity[]')->textInput(['class'=>'form-control qty','value'=>(($req->remaining_quantity!=0)?$req->remaining_quantity:$req->quantity)])->label(false) ?></td>
                                <td><?= $form->field($modelpr,'unit_id[]', ['inputOptions' => ["class" => "form-control select2",'disabled'=>true]])->dropDownList(ArrayHelper::map(Units::find()->where(["status" => 1])->all(), 'id', 'name'), ['options' => [$req->unit_id => ['Selected'=>'selected']]],['value'=>$req->unit_id], ["prompt" => "Select unit"])->label(false) ?></td>
                                
                                <td><?= $form->field($modelpr, 'price[]')->textInput(['value'=>$req->price,'class'=>'form-control price disabled'])->label(false) ?>
                                     <?= Html::activeTextInput($modelpr,'total_price[]',['type'=>'hidden','class'=>'total_price form-control form-control','value'=>$req->total_price])?>
                                </td>
                               <?php if($vat_format=="inclusive") :?>
                                <td>
                                <div id="" role="radiogroup" aria-invalid="true">
                                    <label>
                                    <input type="radio" <?php if($req->dis_type=="discount_type"){echo 'checked="checked"';}?> class="discount_type" value="discount_percent" name="SalesInvoiceItems[dis_type][]"> Rate (%) 
                                    </label>
                                    <label>
                                    <input type="radio" <?php if($req->dis_type=="discount_type"){echo 'checked="checked"';}?> class="discount_type"  value="discount_amount" name="SalesInvoiceItems[dis_type][]"> Amount
                                   </label>
                                </div>
                                <?= $form->field($modelpr, 'discount_percentage[]')->textInput(['value'=>$req->discount_percentage,'class'=>'form-control discount_percentage'])->label(false) ?>
                                 <?= Html::activeTextInput($modelpr,'discount_amount[]',['type'=>'hidden','class'=>'discount_amount form-control form-control','value'=>$req->discount_amount])?>
                                </td>
                                <td><?= $form->field($modelpr, 'net_amount[]')->textInput(['value'=>$req->net_amount,'class'=>'form-control net_amount disabled'])->label(false) ?></td>
                                <td>
                                     <?= Html::activeTextInput($modelpr,'tax[]',['type'=>'hidden','class'=>'tax form-control form-control','value'=>$req->tax])?>
                                    <?= $form->field($modelpr, 'vat_rate[]')->textInput(['value'=>$req->vat_rate,'class'=>'form-control vatrate'])->label(false) ?></td>
                                  <?php endif;?>
                                <td><?= $form->field($modelpr, 'total[]')->textInput(['value'=>$req->total,'class'=>'form-control total disabled'])->label(false) ?></td>
                                
                               </tr>

                            <?php } endif;?>

                        <?php endif; ?>

                    </tbody>


                </table>
                
                
                <div class="w50 pull-right">
                    <div class="mb-5 fl-w100"><?= $form->field($model1, 'subtotal')->textInput(['value'=>$model->subtotal,'class'=>'form-control subtotal disabled']) ?></div>
                   <?php if($vat_format=="exclusive") :?>
                     <div class="input-group mb-5"><div class="input-group-addon">Discount Type</div>
                        <div id="" role="radiogroup" aria-invalid="true">

                            <label>
                            <input type="radio" checked="checked" name="SalesInvoice[discount_type]"  class="common_discount_type" value="discount_percent"> Rate (%) 
                            </label>
                            <label>
                            <input type="radio" name="SalesInvoice[discount_type]" class="common_discount_type"  value="discount_amount"> Amount
                            </label>
                        </div>
                    </div>
                    <div class="mb-5 fl-w100"><?= $form->field($model1, 'discount')->textInput(['class'=>'form-control discount']) ?></div>
                  <?= Html::activeTextInput($model1,'discount_percent',['type'=>'hidden','class'=>'discount_percent form-control'])?>
                      <div class="mb-5 fl-w100"><?= $form->field($model, 'net')->textInput(['class'=>'form-control net disabled']);///->label(false)  ?></div>
                    <div class="mb-5 fl-w100">
                        <div class="form-group field-salesinvoice-total_tax">
                        <div class="input-group">
                            <div class="input-group-addon">VAT %</div>
                           <?= Html::activeTextInput($model1,'vat_percent',['type'=>'hidden','class'=>'vatper form-control','value'=>(($vat_format=="exclusive")?Yii::$app->common->company->vat_rate:0)])?>
                            <?= Html::textInput('vatt', (($vat_format=="exclusive")?Yii::$app->common->company->vat_rate:0), ['class' => 'form-control','disabled'=>'true']) ?>
            
                        </div>
                        </div>
                    </div>
                    <div class="mb-5 fl-w100"><?= $form->field($model1, 'total_tax')->hiddenInput(['class'=>'form-control total_tax'])->label(false) ?></div>
                     <?php endif;?>
                    <div class="mb-5 fl-w100"><?= $form->field($model1, 'grand_total')->textInput(['value'=>$model->grand_total,'class'=>'form-control grandtotal disabled']) //['readonly'=>true]?></div>
                </div>
                <!--   <?= Html::Button('<span class="glyphicon glyphicon-plus"></span> Add Items', ['class' => 'btn btn-success btn_add_new pull-left','title'=>'Add Items']) ?> -->
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

addMandatoryStar();
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