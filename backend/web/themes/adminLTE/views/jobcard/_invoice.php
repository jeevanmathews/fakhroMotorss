
<?php
use yii\grid\GridView;
use backend\assets\AppAsset;
use yii\helpers\Html;
AppAsset::register($this);
use backend\models\Branches
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>Fakhro Motors</title>
<?php $this->head() ?>
</head>


<body style="margin: 0; padding: 0;" class="invoice-wrapper">
    
    <table width="800" cellpadding="0" cellspacing="0" style=";margin:0 auto; font-family: 'Roboto Condensed', sans-serif;; border-collapse: collapse;">
        <tr>
            <td>
                <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                    <tr>
                        <td width="25%" valign="center">
                           <!-- <img src="images/logo.jpg" style="width: 150px; height: auto;" /> -->
							<?= Html::img("../../backend/web/uploads/company/".Yii::$app->common->company->logo, ["style"=>"width: 150px; height: auto;"]) ?>
                        </td>
                        <td width="50%" valign="center">
                            <h2 style="text-align: center; margin: 0 0 10px;"><?php echo Yii::$app->common->company->name;?></h2>
                            <p style="text-align: center; margin: 0;"><?php echo Yii::$app->common->company->address."\n".Yii::$app->common->company->state."\n".(isset(Yii::$app->common->company->country->name)?Yii::$app->common->company->country->name:"")."\n zip: ".Yii::$app->common->company->zipcode;?></p>
                        </td>
                        <td width="25%" valign="center">
                            <!-- <img src="images/byd-logo.jpg" style="width: 150px; height: auto;" /> -->
							<?= Html::img("../../backend/web/uploads/branches/".$invoice->jobcard->branch->logo, ["style"=>"width: 150px; height: auto;"]) ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="25%" style="padding: 10px;"></td>
                        <td width="50%" style="font-size: 20px; font-weight: bold; text-transform: uppercase; text-align: center; padding: 10px;"> Tax Invoice</td>
                        <td width="25%" style="padding: 10px;"></td>
                    </tr>
                </table>
                <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse; margin-bottom: 20px;">
                    <tr>
                        <td width="50%" style="border:1px solid #ddd; padding: 15px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                <tr>
                                    <td>
                                        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                            <tr>
                                                <td colspan="2" style="padding: 3px 0; font-size: 14px; font-weight: 700;">To,</td>
                                            </tr>
                                            <tr>
                                                <td width="40%" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Customer Name</td>
                                                <td width="60%" style="padding: 3px 0; font-size: 14px;">: <?php echo $invoice->customer->name;?></td>
                                            </tr>
                                            <tr>
                                                <td width="40%" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Reg No</td>
                                                <td width="60%" style="padding: 3px 0; font-size: 14px;">: <?php echo $invoice->vehicle->reg_num;?></td>
                                            </tr>
                                            <tr>
                                                <td width="40%" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Vehicle Manufacturer</td>
                                                <td width="60%" style="padding: 3px 0; font-size: 14px; text-transform: uppercase;">: <?php echo $invoice->vehicle->make->name;?></td>
                                            </tr>
                                            <tr>
                                                <td width="40%" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Vehicle Model</td>
                                                <td width="60%" style="padding: 3px 0; font-size: 14px; text-transform: uppercase;">: <?php echo $invoice->vehicle->model->model;?></td>
                                            </tr>
                                            <tr>
                                                <td width="40%" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Odometer</td>
                                                <td width="60%" style="padding: 3px 0; font-size: 14px;">: <?php echo $invoice->meter_reading;?> Kms</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="50%" style="border:1px solid #ddd; padding: 15px;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                         
                                            <tr>
                                                <td width="40%" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Invoice No.</td>
                                                <td width="60%" style="padding: 3px 0; font-size: 14px;">: <?php echo $invoice->id;?></td>
                                            </tr>
                                            <tr>
                                                <td width="40%" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Date</td>
                                                <td width="60%" style="padding: 3px 0; font-size: 14px;">: <?php echo date("d-m-Y");?></td>
                                            </tr>
                                            <tr>
                                                <td width="40%" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Repair Order No</td>
                                                <td width="60%" style="padding: 3px 0; font-size: 14px;">: </td>
                                            </tr>
                                            <tr>
                                                <td width="40%" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Ref No</td>
                                                <td width="60%" style="padding: 3px 0; font-size: 14px;">: </td>
                                            </tr>
                                            <tr>
                                                <td width="40%" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Job Card No</td>
                                                <td width="60%" style="padding: 3px 0; font-size: 14px;">: TA-SJCB <?php echo $invoice->jobcard_id;?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                
                <?= GridView::widget([
                        'dataProvider' => $taskdataProvider,     
                        'tableOptions' => ['class' => 'table'],
                        'summary' => "",             
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],  
                            [
                                'attribute' => 'task_id',
                                'label' => 'Task',
                                'value'=>function ($model, $key, $index, $widget){
                                    //$widget->footer = "<b>Labour Totals</b>";
                                    return $model->task->task ;
                                },  
                            ],
                            [                            
                                'attribute' => 'task_rate',
                                'value'=>function ($model, $key, $index, $widget) use (&$task_total) {
                                    //$task_total += $model->task_rate;
                                    //$widget->footer = "<b>".$task_total."</b>";
                                    return $model->task_rate;
                                },                          
                            ],
                            [
                                'attribute' => 'discount_amount',
                                'label' => 'Discount',
                                'visible' => ((Yii::$app->common->company->vat_format == "exclusive")?false:true),
                            ],
                            [
                                'label' => 'Net Price',
                                'value'=>function ($model, $key, $index, $widget) use (&$task_net_price_tot) {                                  
                                    $task_net_price = ((Yii::$app->common->company->vat_format == "exclusive")?$model->task_rate:($model->task_rate-$model->discount_amount));
                                    //$task_net_price_tot += $task_net_price;
                                    //$widget->footer = "<b>".$task_net_price_tot."</b>";
                                    return $task_net_price;                             
                                },
                                'visible' => ((Yii::$app->common->company->vat_format == "exclusive")?false:true),                          
                            ],
                            [                           
                                'attribute' => 'tax_rate',
                                'value'=>function ($model, $key, $index, $widget){
                                    if(Yii::$app->common->company->vat_format == "exclusive"){
                                        return "NA";
                                    }else{
                                        return (($model->tax_enabled == "yes")?$model->tax_rate:"NA");  
                                    }                                   
                                }, 
                                'visible' => ((Yii::$app->common->company->vat_format == "exclusive")?false:true),                            
                            ],
                            [
                                'attribute' => 'tax_amount',
                                'visible' => ((Yii::$app->common->company->vat_format == "exclusive")?false:true),
                            ],                                  
                            [                           
                                'attribute' => 'billing_rate',
                                'visible' => ((Yii::$app->common->company->vat_format == "exclusive")?false:true),
                                'value'=>function ($model, $key, $index, $widget) use (&$billing_rate) {
                                    if($model->billable == "yes"){
                                        //$billing_rate += $model->billing_rate;
                                    }
                                    //$widget->footer = "<b>".Yii::$app->common->company->settings->currency->code." ".$billing_rate."</b>";
                                    return ($model->billable == "yes")?(Yii::$app->common->company->settings->currency->code." ".$model->billing_rate) :"NA";
                                },                          
                            ],
                        ],
                        //'showFooter' => true,
                    ]); ?>      


                    <?= GridView::widget([
                        'dataProvider' => $materialdataProvider,  
                        'tableOptions' => ['class' => 'table'],
                        'summary' => "",              
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'material_type',
                            'material.item_name', 
                            'num_unit',
                            [
                                'attribute' => 'unit_rate',
                                'value'=>function ($model, $key, $index, $widget){
                                    //$widget->footer = "<b>Materials Totals</b>";
                                    return $model->unit_rate ;
                                },  
                            ],                       
                            [                            
                                'attribute' => 'total',
                                'label' => 'Price',
                                'value'=>function ($model, $key, $index, $widget) use (&$mat_total) {
                                    //$mat_total += $model->total;
                                    //$widget->footer = "<b>".$mat_total."</b>";
                                    return $model->total;
                                },                          
                            ],
                            [
                                'attribute' => 'discount_amount',
                                'label' => 'Discount',
                                'visible' => ((Yii::$app->common->company->vat_format == "exclusive")?false:true),
                            ],
                            [
                                'label' => 'Net Price',
                                'value'=>function ($model, $key, $index, $widget) use (&$net_price_tot) {                                   
                                    $net_price = ((Yii::$app->common->company->vat_format == "exclusive")?$model->total:($model->total-$model->discount_amount));
                                    //$net_price_tot += $net_price;
                                    //$widget->footer = "<b>".$net_price_tot."</b>";
                                    return $net_price;                              
                                },      
                                'visible' => ((Yii::$app->common->company->vat_format == "exclusive")?false:true),                  
                            ],
                            [                           
                                'attribute' => 'tax_rate',
                                'value'=>function ($model, $key, $index, $widget){
                                    if(Yii::$app->common->company->vat_format == "exclusive"){
                                        return "NA";
                                    }else{
                                        return (($model->tax_enabled == "yes")?$model->tax_rate:"NA");  
                                    }
                                    
                                },    
                                'visible' => ((Yii::$app->common->company->vat_format == "exclusive")?false:true),                        
                            ],
                            [
                                'attribute' => 'tax_amount',
                                'visible' => ((Yii::$app->common->company->vat_format == "exclusive")?false:true),
                            ],                          
                            [                      
                                'attribute' => 'rate',
                                'value'=>function ($model, $key, $index, $widget) use (&$rate) {
                                    //$rate += $model->rate;
                                    //$widget->footer = "<b>".Yii::$app->common->company->settings->currency->code." ".$rate."</b>";
                                    return Yii::$app->common->company->settings->currency->code." ".$model->rate ;
                                },  
                                'visible' => ((Yii::$app->common->company->vat_format == "exclusive")?false:true),                          
                            ], 
                        ],
                        //'showFooter' => true,
                    ]); ?>

                <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                    <tr>
                        <td width="100%">
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                <tr>
                                    <th width="50%" style="border:1px solid #ddd; border-bottom: none;"></th>
                                    <th width="37.5%" style="border:1px solid #ddd; border-bottom: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: left;"></th>
                                    <th width="12.5%" style="border:1px solid #ddd; border-bottom: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: right;"></th>
                                </tr>
                                <tr>
                                    <th width="50%" style="border:1px solid #ddd; border-bottom: none; border-top: none;"></th>
                                    <th width="37.5%" style="border:1px solid #ddd; border-bottom: none; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: left;"></th>
                                    <th width="12.5%" style="border:1px solid #ddd; border-bottom: none; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: right;"></th>
                                </tr>
                                <tr>
                                    <th width="50%" style="border:1px solid #ddd; border-bottom: none; border-top: none;"></th>
                                    <th width="37.5%" style="border:1px solid #ddd; border-bottom: none; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: left;">Gross</th>
                                    <th width="12.5%" style="border:1px solid #ddd; border-bottom: none; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: right;"><?php echo $invoice->gross_amount;?></th>
                                </tr>
                                <?php if(Yii::$app->common->company->vat_format == "exclusive" && $invoice->discount != 0){ ?>
                                <tr>
                                    <th width="50%" style="border:1px solid #ddd; border-bottom: none; border-top: none;"></th>
                                    <th width="37.5%" style="border:1px solid #ddd; border-bottom: none; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: left;">Discount</th>
                                    <th width="12.5%" style="border:1px solid #ddd; border-bottom: none; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: right;"><?php echo $invoice->discount;?></th>
                                </tr>
                                <?php } ?>

                                <tr>
                                    <th width="50%" style="border:1px solid #ddd; border-bottom: none; border-top: none;"></th>
                                    <th width="37.5%" style="border:1px solid #ddd; border-bottom: none; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: left;">Total <?php echo (Yii::$app->common->company->vat_format == "exclusive")?"Excluding":"Including";?> VAT</th>
                                    <th width="12.5%" style="border:1px solid #ddd; border-bottom: none; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: right;"><?php echo $invoice->total_charge;?></th>
                                </tr>
                                <?php if(Yii::$app->common->company->vat_format == "exclusive"){ ?>
                                <tr>
                                    <th width="50%" style="border:1px solid #ddd; border-bottom: none; border-top: none;"></th>
                                    <th width="37.5%" style="border:1px solid #ddd; border-bottom: none; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: left;">VAT <?php echo Yii::$app->common->company->vat_rate;?>%</th>
                                    <th width="12.5%" style="border:1px solid #ddd; border-bottom: none; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: right;"><?php echo $invoice->tax;?></th>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <th width="50%" style="border:1px solid #ddd; border-top: none;"></th>
                                    <th width="37.5%" style="border:1px solid #ddd; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: left;">Amount Due</th>
                                    <th width="12.5%" style="border:1px solid #ddd; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: right;"><?php echo $invoice->amount_due;?>      
                                    </th>
                                </tr>
                                
                            </table>
                        </td>
                    </tr>
                </table>
                <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                    <tr>
                        <td width="100%" style="border:1px solid #ddd; padding: 15px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                <tr>
                                    <td width="100%" height="100">         
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100%" style="text-align: center; font-style: italic;">Hope the above prices meet your approval and look forward to your confirmed order.</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                    <tr>
                        <td width="20%" style="padding: 5px; padding-left: 0;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                <tr>
                                    <td width="100%" height="40" style="border-bottom: 2px solid #ddd; padding: 10px;"></td>
                                </tr>
                                <tr>
                                    <td width="100%" style="text-align: center; padding: 5px;">Prepared by</td>
                                </tr>
                            </table>
                        </td>
                        <td width="20%" style="padding: 5px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                <tr>
                                    <td width="100%" height="40" style="border-bottom: 2px solid #ddd; padding: 10px;"></td>
                                </tr>
                                <tr>
                                    <td width="100%" style="text-align: center; padding: 5px;">Checked by</td>
                                </tr>
                            </table>
                        </td>
                        <td width="20%" style="padding: 5px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                <tr>
                                    <td width="100%" height="40" style="border-bottom: 2px solid #ddd; padding: 10px;"></td>
                                </tr>
                                <tr>
                                    <td width="100%" style="text-align: center; padding: 5px;">Reviewed by</td>
                                </tr>
                            </table>
                        </td>
                        <td width="20%" style="padding: 5px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                <tr>
                                    <td width="100%" height="40" style="border-bottom: 2px solid #ddd; padding: 10px;"></td>
                                </tr>
                                <tr>
                                    <td width="100%" style="text-align: center; padding: 5px;">Approved by</td>
                                </tr>
                            </table>
                        </td>
                        <td width="20%" style="padding: 5px; padding-right: 0;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                <tr>
                                    <td width="100%" height="40" style="border-bottom: 2px solid #ddd; padding: 10px;"></td>
                                </tr>
                                <tr>
                                    <td width="100%" style="text-align: center; padding: 5px;">Received by</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                    <tr>
                        <td width="33.33%" style="padding: 5px 10px; padding-left: 0;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border: 2px solid #ddd;">
                                <tr>
                                    <th width="100%" style="padding: 5px 5px 2px 5px; text-align: center;">Service Center - Tashan</th>
                                </tr>
                                <tr>
                                    <td width="100%" style="padding: 2px 5px; text-align: center; font-size: 12px;">C.R. No: 1256-9</td>
                                </tr>
                                <tr>
                                    <td width="100%" style="padding: 2px 5px; text-align: center; font-size: 12px;">Tel: +973 17402255, Fax: +973 17404183</td>
                                </tr>
                                <tr>
                                    <td width="100%" style="padding: 2px 5px; text-align: center; font-size: 12px;">E-mail: fakhromotors@fakhro.com</td>
                                </tr>
                                <tr>
                                    <td width="100%" style="padding: 2px 5px 5px 5px; text-align: center; font-size: 12px;">www.fakhro.com</td>
                                </tr>
                            </table>
                        </td>
                        <td width="33.33%" style="padding: 5px 10px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border: 2px solid #ddd;">
                                <tr>
                                    <th width="100%" style="padding: 5px 5px 2px 5px; text-align: center;">Body Workshop - Salmabad</th>
                                </tr>
                                <tr>
                                    <td width="100%" style="padding: 2px 5px; text-align: center; font-size: 12px;">C.R. No: 74484-2</td>
                                </tr>
                                <tr>
                                    <td width="100%" style="padding: 2px 5px; text-align: center; font-size: 12px;">Tel: +973 17784750, Fax: +973 17784758</td>
                                </tr>
                                <tr>
                                    <td width="100%" style="padding: 2px 5px; text-align: center; font-size: 12px;">E-mail: fmbodyshop@fakhro.com</td>
                                </tr>
                                <tr>
                                    <td width="100%" style="padding: 2px 5px 5px 5px; text-align: center; font-size: 12px;">www.fakhro.com</td>
                                </tr>
                            </table>
                        </td>
                        <td width="33.33%" style="padding: 5px 10px; padding-right: 0;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border: 2px solid #ddd;">
                                <tr>
                                    <th width="100%" style="padding: 5px 5px 2px 5px; text-align: center;">BYD Car Showroom - Arad</th>
                                </tr>
                                <tr>
                                    <td width="100%" style="padding: 2px 5px; text-align: center; font-size: 12px;">C.R. No: 74484-01</td>
                                </tr>
                                <tr>
                                    <td width="100%" style="padding: 2px 5px; text-align: center; font-size: 12px;">Tel: +973 17736700</td>
                                </tr>
                                <tr>
                                    <td width="100%" style="padding: 2px 5px; text-align: center; font-size: 12px;">E-mail: infobyd@fakhro.com</td>
                                </tr>
                                <tr>
                                    <td width="100%" style="padding: 2px 5px 5px 5px; text-align: center; font-size: 12px;">www.bydbahrain.com</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>   
</body>
</html>

<script>

window.print();
//window.close();
</script>
