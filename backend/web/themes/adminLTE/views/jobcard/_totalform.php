<?php

use yii\helpers\Html;
use common\components\AutoForm;
use yii\helpers\ArrayHelper;
use backend\models\Tasks;
use backend\models\Employees;

/* @var $this yii\web\View */
/* @var $model backend\models\Jobcard */
/* @var $form yii\widgets\ActiveForm */


if($model->discount){
    $discount = $model->discount;
}else{
    $discount = 0;
}
$gross =$model->labourCost + $model->materialCost;

$total_charge = $gross - $discount;

$vat = $total_charge*Yii::$app->common->company->vat_rate/100;
$amount_due = $total_charge + $vat;
?>

<div class="content-main-wrapper">
    <section class="content">
    <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">   

        <div class="box-body">
        <div class="row">
        <div class="col-md-6">
            <h5 class="heading">Total</h5>
            <table class="table table-striped table-bordered detail-view table-hover">
                
                <?php if($model->invoice) { ?> 
                <tr>               
                <td colspan="2"> 
                <span class="pull-left"><?= Html::button('View Invoice', ['onclick' => 'window.open("'.Yii::$app->getUrlManager()->createUrl(['jobcard/invoice', 'invoice_id' => $model->invoice->id]).'", "_blank");', 'class' => 'btn btn-success']) ?></span>
                </td>
                </tr>
                <?php } ?>                

                <tr>
                <td>Total Labour Cost: </td>
                <td><?php echo "<b>".Yii::$app->common->company->settings->currency->code." ".$model->labourCost."</b>";?></td>
                </tr>

                <tr>
                <td>Total Material Cost: </td>
                <td><?php echo "<b>".Yii::$app->common->company->settings->currency->code." ".$model->materialCost."</b>";?></td>
                </tr>

                <tr>
                <td>Gross: </td>
                <td id="gross-amount" gross-amount="<?php echo ($model->labourCost+$model->materialCost);?>"><?php echo "<b>".Yii::$app->common->company->settings->currency->code." ".($model->labourCost+$model->materialCost)."</b>";?></td>
                </tr>

                <?php if(Yii::$app->common->company->vat_format == "exclusive"){ ?>

                <tr>
                <td>Discount: </td>
                <td>
                    <div class="input-group">
                    <div role="radiogroup" aria-invalid="false">
                    <label><input type="radio"  name="ex_discount" value="discount_percent"> Rate (%) <input type="text" class="hide" id="discount_percent" max="100" min="0" value=""></label>
                    <label><input checked="checked" type="radio" name="ex_discount" value="discount_amount"> Amount <input type="text" id="discount_amount" class="" max="100" min="0" value="<?php echo $discount;?>"></label>
                    </div>
                    </div>
                </td>
                </tr>

                <tr>
                <td>Total Excluding VAT: </td>
                <td><?php echo "<b>".Yii::$app->common->company->settings->currency->code;?><span id="total_charge"><?php echo $total_charge;?></span></b></td>
                </tr>

                <tr>
                <td>VAT (%): <?php echo Yii::$app->common->company->vat_rate;?>%</td>
                <td id="vat">
                    <?php echo $vat?>
                </td>
                </tr>

                <?php } ?>

                <tr>
                <td>Amount Due: </td>
                <td><?php echo "<b>".Yii::$app->common->company->settings->currency->code." <span id='amount_due'>".$amount_due."</span></b>";?></td>
                </tr>
                <?php if(Yii::$app->common->company->vat_format == "exclusive"){ ?>
                    <tr>               
                    <td colspan="2">
                    <span class="pull-left">
                     <?= Html::button((($model->invoice)?'Regenerate Invoice':'Confirm Payment'), ['class' => 'btn btn-success', 'id' => 'confirm-payment']) ?>    
                    </span>                    
                    <?= Html::submitButton('Apply Discount', ['class' => 'btn btn-success', 'id' => 'apply-disount']) ?>
                    </td>
                    </tr>
                <?php } else{ ?>
                    <tr>               
                    <td colspan="2">                   
                     <?= Html::button((($model->invoice)?'Regenerate Invoice':'Confirm Payment'), ['class' => 'btn btn-success', 'id' => 'confirm-payment']) ?>  
                    </td>
                    </tr>
                <?php   } ?>
            </table>
            <div class="alert hide" role="alert">
              
            </div>
        </div> 
        </div>             
        </div>
        </div>
    </section>
</div>

<div class="modal confirmpay" tabindex="-1" role="dialog"> 
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
                <?= Html::a('Generate Invoice', ['jobcard/generate-invoice', 'jobcard_id' => $model->id], ['class' => 'btn btn-success', 'target' => '_blank']) ?>
            </p>            
            </div>
        </div>
    </div>
    </section>
    </div>
    </div>  
</div>

<script type="text/javascript">
    $("#confirm-payment").click(function(){
        $(".confirmpay").modal();
    });
    $('#discount_amount,#discount_percent').keyup(function(e){

      if (/\D/g.test(this.value))
      {
        // Filter non-digits from input value.
        this.value = this.value.replace(/\D/g, '');
      }else{
        var vat = "<?php echo Yii::$app->common->company->vat_rate;?>";
        if($(this).attr("id") =="discount_percent"){
            if(this.value >= 100)
                $(this).val("");
            else{
                var total_charge = $("#gross-amount").attr("gross-amount") - (($("#gross-amount").attr("gross-amount"))*$(this).val()/100);       
                $("#total_charge").html(total_charge);
            }            
        }else{ 
            if(this.value >= parseFloat($("#gross-amount").attr("gross-amount")))
                $(this).val("");
            else{
                var total_charge = $("#gross-amount").attr("gross-amount") - $(this).val();      
                $("#total_charge").html(total_charge);
            }
        }
        var vat_value =vat*total_charge/100;
        var amount_due = total_charge + vat_value;
        $("#vat").html(vat_value);
        $("#amount_due").html(amount_due);
      }
    });
    $("[name='ex_discount']").click(function(){        
        showtotDiscount($(this).val());
    });    
    function showtotDiscount(discount){
        if(discount == "discount_amount"){
            $("#discount_amount").removeClass("hide");
            $("#discount_percent").addClass("hide");
        }else{
            $("#discount_amount").addClass("hide");
            $("#discount_percent").removeClass("hide");
        }
    }

    $("#apply-disount").click(function(){
        var discount = $("#"+$("input:radio[name=ex_discount]:checked").val()).val();
        if(discount == ""){
            $(".alert").removeClass("alert-success").addClass("alert-error").removeClass("hide").html("Please input a discount rate or value.");
        }else{
            $(".alert").addClass("hide");
            if($("input:radio[name=ex_discount]:checked").val() == "discount_percent"){
            var data_obj = { jobcard_id: "<?php echo $model->id;?>", discount_percent: discount};
            }else{
                var data_obj = { jobcard_id: "<?php echo $model->id;?>", discount_amount: discount};
            } 
            $.post('<?=Yii::$app->getUrlManager()->createUrl(['jobcard/apply-discount'])?>', data_obj)
            .done(function( data ) {          
               $(".alert").addClass("alert-success").removeClass("alert-error").removeClass("hide").html(data);    
            });   
        } 
             
    });
</script>
