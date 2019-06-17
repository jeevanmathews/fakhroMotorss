
<?php
use yii\grid\GridView;
use backend\assets\AppAsset;
use yii\helpers\Html;
AppAsset::register($this);
use backend\models\Branches;
use yii\widgets\DetailView;
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
 <link rel="apple-touch-icon" sizes="57x57" href="<?=$this->theme->getUrl('images/favicons/apple-icon-57x57.png')?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?=$this->theme->getUrl('images/favicons/apple-icon-60x60.png')?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?=$this->theme->getUrl('images/favicons/apple-icon-72x72.png')?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?=$this->theme->getUrl('images/favicons/apple-icon-76x76.png')?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?=$this->theme->getUrl('images/favicons/apple-icon-114x114.png')?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?=$this->theme->getUrl('images/favicons/apple-icon-120x120.png')?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?=$this->theme->getUrl('images/favicons/apple-icon-144x144.png')?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?=$this->theme->getUrl('images/favicons/apple-icon-152x152.png')?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=$this->theme->getUrl('images/favicons/apple-icon-180x180.png')?>">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?=$this->theme->getUrl('images/favicons/android-icon-192x192.png')?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=$this->theme->getUrl('images/favicons/favicon-32x32.png')?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?=$this->theme->getUrl('images/favicons/favicon-96x96.png')?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=$this->theme->getUrl('images/favicons/favicon-16x16.png')?>">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
</head>


<body style="margin: 0; padding: 0;" class="return-wrapper">
    
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
							<?= Html::img("../../backend/web/uploads/branches/", ["style"=>"width: 150px; height: auto;"]) ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="25%" style="padding: 10px;"></td>
                        <td width="50%" style="font-size: 20px; font-weight: bold; text-transform: uppercase; text-align: center; padding: 10px;">Purchase Return</td>
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
                                                <td width="40%" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Supplier Name</td>
                                                <td width="60%" style="padding: 3px 0; font-size: 14px;">: <?php echo $return->supplier->name;?></td>
                                            </tr>
                                            <tr>
                                                <td width="40%" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Supplier Address</td>
                                                <td width="60%" style="padding: 3px 0; font-size: 14px;">: <?php echo $return->supplier->address;?></td>
                                            </tr>
                                           <!--  <tr>
                                                <td width="40%" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Vehicle Make</td>
                                                <td width="60%" style="padding: 3px 0; font-size: 14px; text-transform: uppercase;">: <?php echo '';//$return->vehicle->make;?></td>
                                            </tr>
                                            <tr>
                                                <td width="40%" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Odometer</td>
                                                <td width="60%" style="padding: 3px 0; font-size: 14px;">: <?php echo '';//$return->meter_reading;?> Kms</td>
                                            </tr> -->
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
                                                <td width="40%" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Return No</td>
                                                <td width="60%" style="padding: 3px 0; font-size: 14px;">: <?=$return->prefix->prefix.' '.$return->prtn_number;?></td>
                                            </tr>
                                            <tr>
                                                <td width="40%" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Return Date</td>
                                                <td width="60%" style="padding: 3px 0; font-size: 14px;">: <?php echo $return->prtn_created_date?></td>
                                            </tr>
                                            <tr>
                                                <td width="40%" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Return By</td>
                                                <td width="60%" style="padding: 3px 0; font-size: 14px;">: <?php echo $return->user->firstname?></td>
                                            </tr>
                                           <?php if(isset($return->po)) :?> <tr>
                                                <td width="40%" style="padding: 3px 0; font-size: 14px; font-weight: 700;">PO No</td>
                                                <td width="60%" style="padding: 3px 0; font-size: 14px;">: <?php if(isset($return->po)){echo $return->po->prefix->prefix.' '.$return->po->po_number;}else if(isset($model->grn)){echo $model->grn->prefix->prefix.'-'.$model->grn->grn_number;};?>
                                                 
                                                 </td>
                                            </tr>
                                        <?php endif; ?>
                                           
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
              <!-- grid comes here -->

                    <?= GridView::widget([
                        'dataProvider' => $itemsdataProvider,     
                        'tableOptions' => ['class' => 'table'],
                        'summary' => "",             
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                               'label'=>'Item',
                               'value'=>'item.item_name'
                            ], 
                            'price',  
                            'quantity', 
                            [
                               'label'=>'Unit',
                               'value'=>'unit.name'
                            ],  
                            'tax',
                            'total',
                             
                        ],
                          'tableOptions' => [
                     'id' => 'theDatatable',
                     'class'=>'table  table-bordered table-hover'
                     ],
                        'showFooter' => true,
                    ]); ?>    
                       <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                    <tr>
                        <td width="100%">
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                <tr>
                                    <th width="50%" style="border:1px solid #ddd; border-bottom: none;"></th>
                                    <th width="37.5%" style="border:1px solid #ddd; border-bottom: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: left;">Sub Total</th>
                                    <th width="12.5%" style="border:1px solid #ddd; border-bottom: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: right;"><?php echo Yii::$app->common->number_format($return->subtotal);?></th>
                                </tr>
                                <tr>
                                    <th width="50%" style="border:1px solid #ddd; border-bottom: none; border-top: none;"></th>
                                    <th width="37.5%" style="border:1px solid #ddd; border-bottom: none; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: left;">Discount</th>
                                    <th width="12.5%" style="border:1px solid #ddd; border-bottom: none; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: right;"><?php echo Yii::$app->common->number_format($return->discount);?></th>
                                </tr>
                                <tr>
                                    <th width="50%" style="border:1px solid #ddd; border-bottom: none; border-top: none;"></th>
                                    <!-- <th width="37.5%" style="border:1px solid #ddd; border-bottom: none; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: left;">Net Amount</th> -->
                                    <!-- <th width="12.5%" style="border:1px solid #ddd; border-bottom: none; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: right;"><?php //echo $return->net_amount;?></th> -->
                                </tr>
                                <?php if(Yii::$app->common->company->vat_format == "exclusive" && $return->discount != 0){ ?>
                                <tr>
                                    <th width="50%" style="border:1px solid #ddd; border-bottom: none; border-top: none;"></th>
                                    <th width="37.5%" style="border:1px solid #ddd; border-bottom: none; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: left;">Discount</th>
                                    <th width="12.5%" style="border:1px solid #ddd; border-bottom: none; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: right;"><?php echo $return->discount;?></th>
                                </tr>
                                <?php } ?>

                                <tr>
                                    <th width="50%" style="border:1px solid #ddd; border-bottom: none; border-top: none;"></th>
                                    <th width="37.5%" style="border:1px solid #ddd; border-bottom: none; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: left;">Total <?php echo (Yii::$app->common->company->vat_format == "exclusive")?"Excluding":"Including";?> VAT</th>
                                    <th width="12.5%" style="border:1px solid #ddd; border-bottom: none; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: right;"><?php echo $return->grand_total;?></th>
                                </tr>
                                <?php if(Yii::$app->common->company->vat_format == "exclusive"){ ?>
                                <tr>
                                    <th width="50%" style="border:1px solid #ddd; border-bottom: none; border-top: none;"></th>
                                    <th width="37.5%" style="border:1px solid #ddd; border-bottom: none; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: left;">VAT <?php echo Yii::$app->common->company->vat_rate;?>%</th>
                                    <th width="12.5%" style="border:1px solid #ddd; border-bottom: none; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: right;"><?php echo $return->tax;?></th>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <th width="50%" style="border:1px solid #ddd; border-top: none;"></th>
                                    <!-- <th width="37.5%" style="border:1px solid #ddd; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: left;">Amount Due</th> -->
                                    <!-- <th width="12.5%" style="border:1px solid #ddd; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: right;"><?php //echo $return->amount_due;?>       -->
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

//window.print();
//window.close();
</script>





