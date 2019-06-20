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
$cur_time = time();
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

                 <?php if($model->quotation) { ?> 
                <tr>               
                <td colspan="2"> 
                <span class="pull-left"><?= Html::button('View Quotation', ['onclick' => 'window.open("'.Yii::$app->getUrlManager()->createUrl(['jobcard/quotation', 'quotation_id' => $model->quotation->id]).'", "_blank");', 'class' => 'btn btn-success']) ?></span>
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

                <?php if($model->labourCost || $model->materialCost) { ?>
                <?php if(Yii::$app->common->company->vat_format == "exclusive"){ ?>
                    <tr>  
                      <td> 

                         <?= Html::a((($model->quotation)?'Regenerate Quotation':'Generate Quotation'), ['jobcard/generate-quotation', 'jobcard_id' => $model->id], ['class' => 'btn btn-success generate-quotation', 'target' => '_blank']) ?>
                    </td>
                     <td colspan="2">
                    <span class="pull-left">
                     <?= Html::button((($model->invoice)?'Regenerate Invoice':'Confirm Payment'), ['class' => 'btn btn-success', 'id' => 'confirm-payment-'.$cur_time]) ?>    
                    
                    </span>
                    <?=Html::hiddenInput("discount_jc_id", $model->id);?>                    
                    <?= Html::submitButton('Apply Discount', ['class' => 'btn btn-success', 'id' => 'apply-disount']) ?>
                    </td>

                    </tr>
                <?php } else{ ?>
                    <tr>  
                     <td> 

                         <?= Html::a((($model->quotation)?'Regenerate Quotation':'Generate Quotation'), ['jobcard/generate-quotation', 'jobcard_id' => $model->id], ['class' => 'btn btn-success generate-quotation', 'target' => '_blank']) ?>
                    </td>             
                    <td colspan="2">                   
                     <?= Html::button((($model->invoice)?'Regenerate Invoice':'Confirm Payment'), ['class' => 'btn btn-success', 'id' => 'confirm-payment-'.$cur_time]) ?>
                    </td>
                    </tr>
                <?php   } 
                } ?>
            </table>
            <div class="alert hide" role="alert">
              
            </div>
        </div> 
        </div>             
        </div>
        </div>
    </section>
</div>

<div class="modal confirm-payment-<?php echo $cur_time;?>" tabindex="-1" role="dialog"> 
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
                <?= Html::a('Generate Invoice', ['jobcard/generate-invoice', 'jobcard_id' => $model->id], ['class' => 'btn btn-success generate-invoice', 'target' => '_blank']) ?>
            </p>            
            </div>
        </div>
    </div>
    </section>
    </div>
    </div>  
</div>

<script type="text/javascript">

     
</script>
