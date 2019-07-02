<?php

use yii\helpers\Html;
use common\components\AutoForm;
use yii\helpers\ArrayHelper;
use backend\models\Supplier;
use backend\models\Items;
use backend\models\Units;
use backend\models\PrefixMaster;
/* @var $this yii\web\View */
/* @var $model backend\models\Branches */
/* @var $form yii\widgets\ActiveForm */
$vat_format=Yii::$app->common->company->vat_format;
?>
<div class="purchase-request-form">
<?php $form = AutoForm::begin(["id" => "purchse-request-".time().(($model->isNewRecord)?"create":"update")."-form"]); ?>
<div class="box-body">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">  
                    <?= $form->field($model,'prefix_id', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(PrefixMaster::find()->where(["status" => 1])->all(), 'id', 'prefix'), ["prompt" => "Select Prefix",'value'=>Yii::$app->common->prefix->id]) ?>
                    
                    <?= $form->field($model, 'expected_date')->textInput(['maxlength' => true, 'class' => "form-control datepicker"]) ?>

                    
                    <?= $form->field($model, 'remarks')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'requested_by')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>
                    
                    <?= $form->field($model, 'branch_id')->hiddenInput(['value' => Yii::$app->user->identity->branch_id])->label(false) ?>
                
                </div>
                <div class="col-md-6"> 
                    <?php if(!$model->isNewRecord):
                    $number=$model->pr_number;
                    else :
                    $number=(isset($modellastnumber->pr_number)?$modellastnumber->pr_number+1:1);
                    endif;?>
                    <?= $form->field($model, 'pr_number')->textInput(['maxlength' => true,'value'=>$number]) ?>
                    <?= $form->field($model, 'supplier_id', ['inputOptions' => ["class" => "supplier_id form-control select2"]])->dropDownList(ArrayHelper::map(Supplier::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Select Supplier"]) ?>                                     
                <span class="append_here"></span>
                </div> 
                <!-- <div class="row "> -->
                   
                <!-- </div> -->
                
                <div class="col-md-12">
                 <h5 class="heading"><span>Items</span> </h5>

                 <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                            <!-- <th>Price</th> -->
                            <?php //if($vat_format=="inclusive") :?>
                            <!-- <th>Discount</th> -->
                            <!-- <th>Net</th> -->
                            <!-- <th>VAT</th> -->
                            <?php //endif;?>
                            <!-- <th>Total</th> -->
                        </tr>
                    </thead>


                    <tbody class="item_table">
                        <?php if($model->isNewRecord): ?>
                        <tr class="item_row" rid="1">
                            <td class=""><?= Html::a('<span><i class="glyphicon glyphicon-trash"></i></span>', ['#'], ['class'=>'remove_row no-display']) ?></td>
                            <td><?= $form->field($model1,'item_id[]', ['inputOptions' => ["class" => "form-control select2 select_item_td"]])->dropDownList(ArrayHelper::map(Items::find()->where(["status" => 1])->all(), 'id', 'item_name'), ["prompt" => "Select Items"])->label(false) ?></td>
                            <td><?= $form->field($model1, 'quantity[]')->textInput(['class'=>'qty form-control'])->label(false) ?></td>
                            <td><?= $form->field($model1,'unit_id[]', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(Units::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Select unit"])->label(false) ?>
                            <!--     <input type="hidden" id="purchaserequestitems-price" class="form-control price" name="Purchaserequestitems[price][]">
                                <?php if($vat_format=="inclusive") :?>
                                <input type="hidden" id="purchaserequestitems-vatrate" class="form-control vatrate"  name="Purchaserequestitems[vatrate][]">
                                <input type="hidden" id="purchaserequestitems-tax" class="form-control tax"  name="Purchaserequestitems[tax][]">
                            <?php endif;?> -->
                            <?= Html::activeTextInput($model1,'price[]',['type'=>'hidden','class'=>'price'])?>
                            <?php if($vat_format=="inclusive") :?>
                            <?= Html::activeTextInput($model1,'vat_rate[]',['type'=>'hidden','class'=>'vatrate'])?>
                            <?= Html::activeTextInput($model1,'tax[]',['type'=>'hidden','class'=>'tax'])?>
                             <?php endif;?>
                            <?= Html::activeTextInput($model1,'total[]',['type'=>'hidden','class'=>'total'])?>
                            <?= Html::activeTextInput($model1,'total_price[]',['type'=>'hidden','class'=>'total_price'])?>
                            <!-- <input type="hidden" id="purchaserequestitems-total" class="form-control total"  name="Purchaserequestitems[total][]"> -->
                            <!-- <input type="hidden" id="purchaserequestitems-total_price" class="form-control total_price"  name="Purchaserequestitems[total_price][]"> -->


                        </td>
                           </tr>
                            <?php else :

                            if($model->requestitems):
                                foreach ($model->requestitems as $req) { ?>
                            <tr class="item_row" rid="1">
                                <?= $form->field($req, 'id[]')->hiddenInput(['value'=>$req->id])->label(false) ?>
                                <td><?= Html::a('<span><i class="glyphicon glyphicon-trash"></i></span>', ['#'], ['class'=>'remove_row no-display']) ?></td>
                                <td><?= $form->field($req,'item_id[]', ['inputOptions' => ["class" => "form-control select2 select_item_td"]])->dropDownList(ArrayHelper::map(Items::find()->where(["status" => 1])->all(), 'id', 'item_name'), ['options' => [$req->item_id => ['Selected'=>'selected']]],  ["prompt" => "Select Items"])->label(false) ?></td>
                                <td><?= $form->field($req, 'quantity[]')->textInput(['value'=>$req->quantity,'class'=>'qty form-control'])->label(false) ?></td>
                                <td><?= $form->field($req,'unit_id[]', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(Units::find()->where(["status" => 1])->all(), 'id', 'name'), ['options' => [$req->unit_id => ['Selected'=>'selected']]], ["prompt" => "Select unit"])->label(false) ?>
                                <?= Html::activeTextInput($req,'price[]',['type'=>'hidden','class'=>'price','value'=>$req->price])?>
                                <?php if($vat_format=="inclusive") :?>
                                <?= Html::activeTextInput($req,'vat_rate[]',['type'=>'hidden','class'=>'vatrate','value'=>$req->vat_rate])?>
                                <?= Html::activeTextInput($req,'tax[]',['type'=>'hidden','class'=>'tax','value'=>$req->tax])?>
                                 <?php endif;?>
                                <?= Html::activeTextInput($req,'total[]',['type'=>'hidden','class'=>'total','value'=>$req->total])?>
                                <?= Html::activeTextInput($req,'total_price[]',['type'=>'hidden','class'=>'total_price','value'=>$req->total_price])?>
                            

                            </td>
                              </tr>

                            <?php } endif;?>

                        <?php endif; ?>

                    </tbody>


                </table>
                
                  <?= Html::Button('<span class="glyphicon glyphicon-plus"></span> Add Items', ['class' => 'btn btn-success btn_add_new pull-left','title'=>'Add Items']) ?>
                <div class="w50 pull-right">
                    <div class="mb-5 fl-w100"><?= $form->field($model, 'subtotal')->hiddenInput(['class'=>'form-control subtotal'])->label(false) ?></div>
                    <?php //if($vat_format=="exclusive") :?>
                    <!-- <div class="input-group mb-5"><div class="input-group-addon">Discount Type</div> -->
                    
                    <!--<?=Html::ActiveRadioList($model,'discount_type',['percentage'=>'Rate %','amount'=>'Amount'],['class'=>'common_discount_type','type'=>'hidden'])?>-->
                    <div id="" role="radiogroup" class="no-display" aria-invalid="true">

                        <label>
                            <input type="radio" checked="checked" name="Purchaserequest[discount_type]"  class="common_discount_type" value="percentage"> Rate (%) 
                        </label>
                        <label>
                            <input type="radio" name="Purchaserequest[discount_type]" class="common_discount_type"  value="amount"> Amount
                        </label>
                    </div>
                </div>
                <div class="mb-5 fl-w100"><?= $form->field($model, 'discount')->hiddenInput(['class'=>'form-control discount'])->label(false) ?></div>
                <input type="hidden" id="Purchaserequestitems-discount_percent" class="discount_percent" name="Purchaserequest[discount_percent][]">
                <div class="mb-5 fl-w100">
                    <div class="form-group field-Purchaserequest-vat_percent">
                        <div class="input-group">
                            <!-- <div class="input-group-addon">VAT %</div> -->
                             <?= Html::activeTextInput($model,'vat_percent',['type'=>'hidden','class'=>'vatper','value'=>(($vat_format=="exclusive")?Yii::$app->common->company->vat_rate:0)])?>
                             </div>
                    </div>
                </div>
                <div class="mb-5 fl-w100"><?= $form->field($model, 'total_tax')->hiddenInput(['class'=>'form-control total_tax'])->label(false) ?></div>
                <?php// endif;?>
                <div class="mb-5 fl-w100"><?= $form->field($model, 'grand_total')->hiddenInput(['class'=>'form-control grandtotal'])->label(false) //['readonly'=>true]?></div>
            </div>
            </div>
            </div>
        </div>
    </div>

<!-- </div> -->
<!-- /.box-body -->  
<div class="box-footer">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>
<?php AutoForm::end(); ?>
<script>
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


</script>
</div>