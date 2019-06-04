<?php
use yii\grid\GridView;
?>
<!DOCTYPE html>
<!-- saved from url=(0073)http://10.1.1.18/restaurantPOS/dashboard/stores/1/nexo/orders/receipt/182 -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>Order ID : KK569E - Nexo Shop Receipt</title>
<?php
\yii\bootstrap\BootstrapAsset::register($this);
?>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="well col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row order-details">
                <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                    <h2 class="text-center" style="font-size:24px;"><?php echo Yii::$app->common->company->name;?></h2>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    BRANCH : <?php echo $jobcard->branch->name;?> 
                    <br/>
                    CODE : <?php echo $jobcard->branch->code;?>            
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                    Job No :  <?php echo $jobcard->id;?>                
                </div>
            </div>
             <p style="font-size: 15px; text-align: center;">Tel : <?php echo $jobcard->branch->phone;?> | e-mail <?php echo $jobcard->branch->email;?></p>
            <div class="row">
                <div class="text-center">
                    <h3 style="font-size:20px;"> Job Card</h3>
                </div>

                <?= GridView::widget([
                        'dataProvider' => $taskdataProvider,   
                        'summary' => "",             
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],  
                            [
                                'attribute' => 'task_id',
                                'label' => 'Task',
                                'value'=>function ($model, $key, $index, $widget){
                                    $widget->footer = "<b>Labour Totals</b>";
                                    return $model->task->task ;
                                },  
                            ],
                            [                            
                                'attribute' => 'task_rate',
                                'value'=>function ($model, $key, $index, $widget) use (&$task_total) {
                                    $task_total += $model->task_rate;
                                    $widget->footer = "<b>".$task_total."</b>";
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
                                    $task_net_price_tot += $task_net_price;
                                    $widget->footer = "<b>".$task_net_price_tot."</b>";
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
                                        $billing_rate += $model->billing_rate;
                                    }
                                    $widget->footer = "<b>".Yii::$app->common->company->settings->currency->code." ".$billing_rate."</b>";
                                    return ($model->billable == "yes")?(Yii::$app->common->company->settings->currency->code." ".$model->billing_rate) :"NA";
                                },                          
                            ], 
                        ],
                        'showFooter' => true,
                    ]); ?>      


                    <?= GridView::widget([
                        'dataProvider' => $materialdataProvider,  
                        'summary' => "",              
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'material_type',
                            'material.name', 
                            'num_unit',
                            [
                                'attribute' => 'unit_rate',
                                'value'=>function ($model, $key, $index, $widget){
                                    $widget->footer = "<b>Materials Totals</b>";
                                    return $model->unit_rate ;
                                },  
                            ],                             
                            [                            
                                'attribute' => 'total',
                                'label' => 'Price',
                                'value'=>function ($model, $key, $index, $widget) use (&$mat_total) {
                                    $mat_total += $model->total;
                                    $widget->footer = "<b>".$mat_total."</b>";
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
                                    $net_price_tot += $net_price;
                                    $widget->footer = "<b>".$net_price_tot."</b>";
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
                            ],
                            [
                                'attribute' => 'tax_amount',
                                'visible' => ((Yii::$app->common->company->vat_format == "exclusive")?false:true),
                            ],                          
                            [                      
                                'attribute' => 'rate',
                                'value'=>function ($model, $key, $index, $widget) use (&$rate) {
                                    $rate += $model->rate;
                                    $widget->footer = "<b>".Yii::$app->common->company->settings->currency->code." ".$rate."</b>";
                                    return Yii::$app->common->company->settings->currency->code." ".$model->rate ;
                                },  
                                'visible' => ((Yii::$app->common->company->vat_format == "exclusive")?false:true),                          
                            ], 
                        ],
                        'showFooter' => true,
                    ]); ?>
                <table class="table table-hover">                  
                    <tbody>
                        <tr>
                            <td>
                                Total Labour   </td>     
                                <td></td>        <td></td>              
                            <td class="text-right"><?php echo $jobcard->labour_cost;?> </td>
                        </tr> 
                        <tr>
                            <td>
                                Total Materials   </td>      
                                <td></td>  <td></td>                   
                            <td class="text-right"><?php echo $jobcard->material_cost;?> </td>
                        </tr>                           
                                                        
                        <tr>
                            <td class=""><strong>Gross </strong></td>  
                            <td></td> <td></td>                         
                            <td class="text-right"> <?php echo $jobcard->gross_amount;?></td>
                        </tr>

                        <?php if(Yii::$app->common->company->vat_format == "exclusive" && $jobcard->discount != 0){ ?>
                        <tr>
                            <td class=""><strong>Discount </strong></td>
                            <td></td> <td></td>                         
                            <td class="text-right"><?php echo $jobcard->discount;?></td>
                        </tr>
                        <?php } ?>           
                        <tr>
                            <td class="">Total Excluding VAT</td>
                            <td></td><td></td>
                              <td class="text-right"> <?php echo $jobcard->total_charge;?>  </td>
                        </tr>
                        <tr>
                            <td class=""> VAT(%) </td>
                            <td></td><td><?php echo Yii::$app->common->company->vat_rate;?>%</td>
                              <td class="text-right"> <?php echo $jobcard->tax;?>  </td>
                        </tr>

                       <tr>
                            <td class=""> TOTAL RECEIVED AMOUNT</td>
                            <td></td><td></td>
                              <td class="text-right">  <?php echo $jobcard->amount_due;?> </td>
                        </tr>
                      
                       
                        <!--<tr>
                            <td class="text-right" colspan="3"><h4 style="font-size:16px;"><strong> CHANGE:</strong></h4></td>
                            <td class="text-right text-danger">
                            <h4 style="font-size:16px;">
                            <strong> 0.000  </strong>
                            </h4></td>
                        </tr>-->
                  </tbody>
                </table>
    <div class="text-center">
    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAC1JREFUKJFj+MzDbMN/5oO9zR+DD38OfzjPw29gY2Dwwd74AMOo1KjUqBRMCgA10myid9Uo3gAAAABJRU5ErkJggg==">    <br>
    <h3 style="margin:5px 0">KK569E</h3>
    </div>
      <p class="text-center"></p>
     <p style="font-size: 16px; text-align: center;">Thank you for visiting us...</p>
                 
    <div class="container-fluid hideOnPrint">
        <div class="row hideOnPrint">
            <div class="col-lg-12">
            <a href="http://10.1.1.18/restaurantPOS/dashboard/stores/1/nexo/orders" class="btn btn-success btn-lg btn-block">Return to the Orders list</a>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
</div>
<style>
* {
    font-family: 'fake_receiptregular';
    text-transform: uppercase;
}
.well{
      max-width: 75%;
    margin: auto;
}
.table th{
    font-size: 16px;
}
.table td{
    font-size: 15px;
}
.table th:nth-child(1){
    width:60%;
}
@media print {
    * {
        font-family: 'fake_receiptregular';
        text-transform: uppercase;
    }
    .hideOnPrint {
        display:none !important;
    }
    td, th {font-size: 2.8vw;}
    .order-details, p {
        font-size: 2.5vw;
    }
    .order-details h2 {
        font-size: 5.5vw;
    }
    h3 {
        font-size: 2.8vw;
    }
    h4 {
        font-size: 2.8vw;
    }
}
</style>
<script>
window.print();
window.close();
</script>



</body></html>