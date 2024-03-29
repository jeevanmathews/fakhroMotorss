
<?php

use yii\helpers\Html;
use backend\models\Branches
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Fakhro Motors</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style type="text/css">
    body {
        color: #404E67;
        background: #F5F7FA;
        font-family: 'Open Sans', sans-serif;
    }
    .table-wrapper {
        width: 700px;
        margin: 30px auto;
        background: #fff;
        padding: 20px;  
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
    .table-title {
        padding-bottom: 10px;
        margin: 0 0 10px;
    }
    .table-title h2 {
        margin: 6px 0 0;
        font-size: 22px;
    }
    .table-title .add-new {
        float: right;
        height: 30px;
        font-weight: bold;
        font-size: 12px;
        text-shadow: none;
        min-width: 100px;
        border-radius: 50px;
        line-height: 13px;
    }
    .table-title .add-new i {
        margin-right: 4px;
    }
    table.table {
        table-layout: fixed;
    }
    table.table tr th, table.table tr td {
        border-color: #e9e9e9;
    }
    table.table th i {
        font-size: 13px;
        margin: 0 5px;
        cursor: pointer;
    }
    table.table th:last-child {
        width: 100px;
    }
    table.table td a {
        cursor: pointer;
        display: inline-block;
        margin: 0 5px;
        min-width: 24px;
    }    
    table.table td a.add {
        color: #27C46B;
    }
    table.table td a.edit {
        color: #FFC107;
    }
    table.table td a.delete {
        color: #E34724;
    }
    table.table td i {
        font-size: 19px;
    }
    table.table td a.add i {
        font-size: 24px;
        margin-right: -1px;
        position: relative;
        top: 3px;
    }    
    table.table .form-control {
        height: 32px;
        line-height: 32px;
        box-shadow: none;
        border-radius: 2px;
    }
    table.table .form-control.error {
        border-color: #f50000;
    }
    table.table td .add {
        display: none;
    }
</style>
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    var actions = $("table#task-table td:last-child").html();
    // Append table with add row form on add new button click
    $(".add-new").click(function(){
        $(this).attr("disabled", "disabled");
        var tableId = $(this).attr("table-id");
        var index = $("table#"+tableId+" tbody tr:last-child").index();
        if(tableId == "task-table"){
        var row = '<tr>' +
            '<td class="task_name"><input type="text" class="form-control" name="name" id="name"></td>' +
            '<td class="task_rate"><input type="text" class="form-control"></td>' +           
            '<td>' + actions + '</td>' +
        '</tr>';
        }else if(tableId == "material-table"){
            var row = '<tr>' +
            '<td class="material_type"><input type="text" class="form-control" name="material_type"></td>' +
            '<td class="material_name"><input type="text" class="form-control" name="material_name"></td>' +
            '<td class="no_unit"><input type="text" class="form-control"></td>' +
            '<td class="unit_rate"><input type="text" class="form-control"></td>' +
            '<td class="price"><input type="text" class="form-control"></td>' +
            '<td>' + actions + '</td>' +
            '</tr>';
        }
        $("table#"+tableId+"").append(row);     
        $("table#"+tableId+" tbody tr").eq(index + 1).find(".add, .edit").toggle();
        $('[data-toggle="tooltip"]').tooltip();
    });
    // Add row on add button click
    $(document).on("click", ".add", function(){
        var empty = false;
        var input = $(this).closest("tr").find('input[type="text"]');
        input.each(function(){
            if(!$(this).val()){
                $(this).addClass("error");
                empty = true;
            } else{
                $(this).removeClass("error");
            }
        });
        $(this).closest("tr").find(".error").first().focus();
        if(!empty){
            input.each(function(){
                $(this).parent("td").html($(this).val());
            });         
            $(this).closest("tr").find(".add, .edit").toggle();
            $(".add-new").removeAttr("disabled");
            updateTotals();
        }       
    });
    // Edit row on edit button click
    $(document).on("click", ".edit", function(){        
        $(this).closest("tr").find("td:not(:last-child)").each(function(){
            $(this).html('<input type="text" class="form-control" value="' + $(this).text() + '">');
        });     
        $(this).closest("tr").find(".add, .edit").toggle();
        $(".add-new").attr("disabled", "disabled");
    });
    // Delete row on delete button click
    $(document).on("click", ".delete", function(){
        $(this).closest("tr").remove();
        $(".add-new").removeAttr("disabled");
        updateTotals();
    });
    updateTotals();
});

function updateTotals(){
    var gross = 0;
    $(".task_rate").each(function(){
       gross = gross+parseFloat($(this).text());
    });
    $(".price").each(function(){
       gross = gross+parseFloat($(this).text());
    });
    $(".gross").html(gross);
    var vat = gross*parseFloat($("#vat").html())/100;
    $("#vat_amount").html(vat);
    $("#amount_due").html(gross + vat);
}
$(document).on('keyup', ".unit_rate", function(){
    $(this).closest("tr").find(".price").text(parseFloat($(this).closest("tr").find("td.no_unit>input").val()) * parseFloat($(this).find("input").val()));
});
function printQuotation(){  
    var $content = $("html");
    $content.find("#task-table th:last-child, #task-table td:last-child, #material-table th:last-child, #material-table td:last-child").addClass("hide");
    $content.find("#print").addClass("hide");
    $content.find(".add-btn").addClass("hide"); 
    $content.find("#saveqtn").addClass("hide"); 
    var printWindow = window.open('', '', 'height=400,width=800');
    printWindow.document.write('<html><head><title>DIV Contents</title>');
    printWindow.document.write('</head><body >');
    printWindow.document.write($content.html());
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print(); 
    
    $content.find("#task-table th:last-child, #task-table td:last-child, #material-table th:last-child, #material-table td:last-child").removeClass("hide");
    $content.find("#print").removeClass("hide");
    $content.find(".add-btn").removeClass("hide"); 
    $content.find("#saveqtn").removeClass("hide"); 
}
function saveQuotation(){
    tasks = []; 
    materials = [];
    $("#task-table tr:gt(0)").each(function(){  
        var task = {}; 
        task.name = $(this).find("td.task_name").text();
        task.rate = $(this).find("td.task_rate").text(); 
        tasks.push(task);
    });
    $("#material-table tr:gt(0)").each(function(){  
        var material = {}; 
        material.name = $(this).find("td.material_name").text();
        material.type = $(this).find("td.material_type").text(); 
        material.no_unit = $(this).find("td.no_unit").text();
        material.unit_rate = $(this).find("td.unit_rate").text();
        material.price = $(this).find("td.price").text();
        materials.push(material);
    });
    $.ajaxSetup({async: false}); 
    $.post("<?php echo Yii::$app->getUrlManager()->createUrl(['jobcard/temp-quotation']+['jobcard_id' => $jobcard->id])?>", {_csrf_backend: '<?php echo  \yii::$app->request->csrfToken;?>' ,tasks: JSON.stringify(tasks), materials: JSON.stringify(materials)})
    .done(function( data ) {
        alert('Quotation saved!');            
    });
    $.ajaxSetup({async: true});
}
</script>
</head>
<body style="margin: 0; padding: 0;" class="invoice-wrapper">
    <button id="print" onclick="printQuotation();">Print</button>
    <button id="saveqtn" onclick="saveQuotation();">Save</button>
    <table width="800" cellpadding="0" cellspacing="0" style=";margin:0 auto; font-family: 'Roboto Condensed', sans-serif; border-collapse: collapse;">
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
              <?= Html::img("../../backend/web/uploads/branches/".$jobcard->branch->logo, ["style"=>"width: 150px; height: auto;"]) ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="25%" style="padding: 10px;"></td>
                        <td width="50%" style="font-size: 20px; font-weight: bold; text-transform: uppercase; text-align: center; padding: 10px;"> Quotation</td>
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
                                                <td width="60%" style="padding: 3px 0; font-size: 14px;">: <?php echo $jobcard->customer->name;?></td>
                                            </tr>
                                            <tr>
                                                <td width="40%" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Reg No</td>
                                                <td width="60%" style="padding: 3px 0; font-size: 14px;">: <?php echo $jobcard->vehicle->reg_num;?></td>
                                            </tr>                                            
                                            <tr>
                                                <td width="40%" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Vehicle Manufacturer</td>
                                                <td width="60%" style="padding: 3px 0; font-size: 14px; text-transform: uppercase;">: <?php echo $jobcard->vehicle->make->name;?></td>
                                            </tr>
                                            <tr>
                                                <td width="40%" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Vehicle Model</td>
                                                <td width="60%" style="padding: 3px 0; font-size: 14px; text-transform: uppercase;">: <?php echo $jobcard->vehicle->model->model;?></td>
                                            </tr>
                                            <tr>
                                                <td width="40%" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Odometer</td>
                                                <td width="60%" style="padding: 3px 0; font-size: 14px;">: <?php echo $jobcard->meter_reading;?> Kms</td>
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
                                                <td width="40%" style="padding: 3px 0; font-size: 14px; font-weight: 700;">Quotation No.</td>
                                                <td width="60%" style="padding: 3px 0; font-size: 14px;">: <?php echo $jobcard->id;?></td>
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
                                                <td width="60%" style="padding: 3px 0; font-size: 14px;">: TA-SJCB <?php echo $jobcard->id;?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
 
           
                <div class="row add-btn">                  
                    <div class="col-sm-12">
                        <button table-id="task-table" type="button" class="btn btn-info add-new pull-right"><i class="fa fa-plus"></i> Add New</button>
                    </div>
                </div>
            

                <table id="task-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Task Rate</th>                      
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($tasks) { foreach ($tasks as $task) {
                        if($task) {?>
                        <tr>
                        <?php 
                        echo '<td class="task_name">'.$task->name.'</td>';
                        echo '<td class="task_rate">'.$task->rate.'</td>';
                        ?>
                        <td>
                            <a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
                            <a class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                            <a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                        </td>
                        </tr>     
                    <?php } } } else { ?>

                    <tr>
                        <td class="task_name">Task Name</td>
                        <td class="task_rate">100</td>                     
                        <td>
                            <a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
                            <a class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                            <a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                        </td>
                    </tr>
                    <?php } ?>                         
                </tbody>
            </table>

            <div class="row add-btn">                  
                    <div class="col-sm-12">
                        <button table-id="material-table" type="button" class="btn btn-info add-new pull-right"><i class="fa fa-plus"></i> Add New</button>
                    </div>
                </div>
            

                <table id="material-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Material Type</th>
                        <th>Material Name</th>                        
                        <th>Num.Unit</th>
                        <th>Unit Rate</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if($materials) { foreach ($materials as $material) {
                        if($material) {?>
                        <tr>
                        <?php 
                        echo '<td class="material_type">'.$material->type.'</td>';
                        echo '<td class="material_name">'.$material->name.'</td>';
                        echo '<td class="no_unit">'.$material->no_unit.'</td>';
                        echo '<td class="unit_rate">'.$material->unit_rate.'</td>';
                        echo '<td class="price">'.$material->price.'</td>';                        
                        ?>
                        <td>
                            <a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
                            <a class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                            <a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                        </td>
                        </tr> 

                  <?php } } } else { ?>
                    <tr>
                        <td class="material_type">Spare</td>
                        <td class="material_name">Rear Mirror</td>
                        <td class="no_unit">100</td>
                        <td class="unit_rate">5</td>
                        <td class="price">500</td>
                        <td>
                            <a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
                            <a class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                            <a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                        </td>
                    </tr>  
                 <?php } ?>                                   
                </tbody>
            </table>

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
                                    <th width="12.5%" style="border:1px solid #ddd; border-bottom: none; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: right;" class="gross">00</th>
                                </tr>
                                
                                <tr>
                                    <th width="50%" style="border:1px solid #ddd; border-bottom: none; border-top: none;"></th>
                                    <th width="37.5%" style="border:1px solid #ddd; border-bottom: none; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: left;">Total <?php echo (Yii::$app->common->company->vat_format == "exclusive")?"Excluding":"Including";?> VAT</th>
                                    <th width="12.5%" style="border:1px solid #ddd; border-bottom: none; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: right;" class="gross">55</th>
                                </tr>
                                <?php if(Yii::$app->common->company->vat_format == "exclusive"){ ?>
                                <tr>
                                    <th width="50%" style="border:1px solid #ddd; border-bottom: none; border-top: none;"></th>
                                    <th width="37.5%" style="border:1px solid #ddd; border-bottom: none; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: left;">VAT <div id="vat"><?php echo Yii::$app->common->company->vat_rate;?></div>%</th>
                                    <th width="12.5%" style="border:1px solid #ddd; border-bottom: none; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: right;" id="vat_amount">66</th>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <th width="50%" style="border:1px solid #ddd; border-top: none;"></th>
                                    <th width="37.5%" style="border:1px solid #ddd; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: left;">Amount Due</th>
                                    <th width="12.5%" style="border:1px solid #ddd; border-top: none; padding: 5px 10px; font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: right;" id="amount_due">676     
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
