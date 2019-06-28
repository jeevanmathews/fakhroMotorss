
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

<body style="margin: 0; padding: 0;">
    
    <table width="800" cellpadding="0" cellspacing="0" style=";margin:0 auto; font-family: 'Roboto Condensed', sans-serif;; border-collapse: collapse;">
        <tr>
            <td>
                <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                    <tr>
                        <td width="25%" valign="center">
                           <?= Html::img("../../backend/web/uploads/company/".Yii::$app->common->company->logo, ["style"=>"width: 150px; height: auto;"]) ?>
                        </td>
                        <td width="50%" style="font-size: 20px; font-weight: bold; text-transform: uppercase; text-align: center; padding: 10px;">Job Card</td>
                        <td width="25%" valign="center">
                            <?= Html::img("../../backend/web/uploads/branches/".$jobcard->branch->logo, ["style"=>"width: 150px; height: auto;"]) ?>
                        </td>
                    </tr>
                </table>
                <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                    <tr>
                        <td width="33.33%" style="border:1px solid #ddd; padding: 15px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                <tr>
                                    <td>
                                        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                            <tr>
                                                <td width="40%" valign="top" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Job Card No</td>
                                                <td width="60%" valign="top" style="padding: 3px 0; font-size: 14px;">: TA-SJCB <?php echo $jobcard->id;?></td>
                                            </tr>
                                            <tr>
                                                <td width="40%" valign="top" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Customer Name</td>
                                                <td width="60%" valign="top" style="padding: 3px 0; font-size: 14px; text-transform: uppercase;">: <?php echo $jobcard->customer->name;?></td>
                                            </tr>
                                            <tr>
                                                <td width="40%" valign="top" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Mobile</td>
                                                <td width="60%" valign="top" style="padding: 3px 0; font-size: 14px;">: <?php echo $jobcard->customer->contact_number;?>/42</td>
                                            </tr>
                                            <tr>
                                                <td width="40%" valign="top" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Email</td>
                                                <td width="60%" valign="top" style="padding: 3px 0; font-size: 14px; text-transform: uppercase;">: <?php echo $jobcard->customer->email;?></td>
                                            </tr>
                                            <tr>
                                                <td width="40%" valign="top" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Contact Person</td>
                                                <td width="60%" valign="top" style="padding: 3px 0; font-size: 14px;">: <?php echo ($jobcard->customer->contact_name)?$jobcard->customer->contact_name:$jobcard->customer->name;?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="33.33%" style="border:1px solid #ddd; padding: 15px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                <tr>
                                    <td>
                                        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                            <tr>
                                                <td width="40%" valign="top" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Reg No</td>
                                                <td width="60%" valign="top" style="padding: 3px 0; font-size: 14px;">:  <?php echo $jobcard->vehicle->reg_num;?></td>
                                            </tr>
                                            <tr>
                                                <td width="40%" valign="top" style="padding: 3px 0; font-size: 14px; font-weight: 700;">VIN</td>
                                                <td width="60%" valign="top" style="padding: 3px 0; font-size: 14px;">: <?php echo $jobcard->vehicle->vin;?></td>
                                            </tr>
                                            <tr>
                                                <td width="40%" valign="top" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Model</td>
                                                <td width="60%" valign="top" style="padding: 3px 0; font-size: 14px; text-transform: uppercase;">: <?php echo $jobcard->vehicle->model->model;?></td>
                                            </tr>
                                            <tr>
                                                <td width="40%" valign="top" style="padding: 3px 0; font-size: 14px; font-weight: 700;">LPO No:</td>
                                                <td width="60%" valign="top" style="padding: 3px 0; font-size: 14px;">: <?php echo $jobcard->vehicle->lpo_num;?></td>
                                            </tr>
                                            <tr>
                                                <td width="40%" valign="top" style="padding: 3px 0; font-size: 14px; font-weight: 700;">W/O No:</td>
                                                <td width="60%" valign="top" style="padding: 3px 0; font-size: 14px;">: <?php echo $jobcard->vehicle->wo_num;?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="33.33%" style="border:1px solid #ddd; padding: 15px;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                            <tr>
                                                <td width="40%" valign="top" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Date In</td>
                                                <td width="60%" valign="top" style="padding: 3px 0; font-size: 14px;">: <?php echo date("d-m-Y", strtotime($jobcard->created_date));?></td>
                                            </tr>
                                            <tr>
                                                <td width="40%" valign="top" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Time In</td>
                                                <td width="60%" valign="top" style="padding: 3px 0; font-size: 14px;">: <?php echo date("h:i:s", strtotime($jobcard->created_date));?></td>
                                            </tr>
                                            <tr>
                                                <td width="40%" valign="top" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Kms In</td>
                                                <td width="60%" valign="top" style="padding: 3px 0; font-size: 14px;">: <?php echo $jobcard->meter_reading;?></td>
                                            </tr>
                                            <tr>
                                                <td width="40%" valign="top" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Date of Delivery</td>
                                                <td width="60%" valign="top" style="padding: 3px 0; font-size: 14px;">: <?php echo $jobcard->promised_date;?></td>
                                            </tr>
                                            <!--<tr>
                                                <td width="40%" valign="top" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Delivery Time</td>
                                                <td width="60%" valign="top" style="padding: 3px 0; font-size: 14px;">: </td>
                                            </tr>-->
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                    <tr>
                        <td width="100%">
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                <tr>
                                    <th colspan="2" style="border-left:1px solid #ddd; border-right:1px solid #ddd; border-bottom:1px solid #ddd;"">
                                        <h3 style="text-transform: uppercase;">Customer Order Description</h3>
                                    </th>
                                </tr>
                              
                                <tr>
                                    <td width="1%" style="border-left:1px solid #ddd; border-bottom:1px solid #ddd; padding: 8px 10px; font-size: 14px; text-align: center;"></td>
                                    <td width="99%" style="border-right:1px solid #ddd; border-bottom:1px solid #ddd; padding: 8px 10px; font-size: 14px; text-transform: uppercase;"><?php echo $jobcard->comment;?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                    <tr>
                        <td width="100%">
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                <tr>
                                    <td width="60%" valign="bottom" style="border:1px solid #ddd; border-bottom: none; border-top: none; padding: 5px 10px; font-size: 14px;">
                                        <h3 style="text-align: center; font-weight: 700; margin: 5px 0 10px;"><span style="border-bottom: 1px solid #333; padding: 0 0 3px; display: inline-block;">Declaration</span></h3>
                                        <p style="margin: 0 0 5px;">The above vehicle has been delivered in the condition described I am fully satisfied with the carried out job and service.</p>
                                        <p style="margin: 0;">Thanking You,</p>
                                        <p style="margin: 20px 0 0; text-align: center;"><span style="border-top: 1px solid #333; padding: 3px 0 0;">Customer Name & Signature</span></p>
                                    </td>
                                    <td width="40%" valign="bottom" style="border:1px solid #ddd; border-bottom: none; border-top: none; padding: 5px 10px; font-size: 14px;">
                                        <h3 style="text-align: center; font-weight: 700; margin: 0;"><span style="border-bottom: 1px solid #333; padding: 0 0 3px; display: inline-block;">Service Advisor Name and Signature</span></h3>
                                        <p style="margin: 0; text-align: center; font-size: 12px; padding: 3px 0 0;">Terms strictly cash unless otherwise arranged</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                    <tr>
                        <td width="100%" style="border:1px solid #ddd; padding: 10px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                <tr>
                                    <td width="100%">
                                        <p style="margin: 0;"><span style="font-weight: 700;">Remarks: </span>Vehicle will be released only upon submitting the customer copy service request.</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                    <tr>
                        <td width="100%" style="border:1px solid #ddd; border-top: none; padding: 10px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                <tr>
                                    <td width="60%" valign="bottom" style="font-size: 14px;">
                                        <p style="margin: 0;">Workshop Copy</p>
                                    </td>
                                    <td width="40%" valign="bottom" style="font-size: 14px; text-align: center;">
                                        <p style="margin: 0; display: inline-block;">Customer Waiting:</p>
                                        <label style="display: inline-block;"><input type="radio" name="gender" value="Yes"> Yes</label>
                                        <label style="display: inline-block;"><input type="radio" name="gender" value="No"> No</label>
                                    </td>
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

    <!-- <script src="js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/owl.carousel.min.js" type="text/javascript"></script> -->

</body>
</html>


<script>

//window.print();
//window.close();
</script>
