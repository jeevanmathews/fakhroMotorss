<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\AutoForm;
use yii\helpers\ArrayHelper;
use backend\models\Vehiclemodels;
use backend\models\Variants;
use backend\models\Units;
use backend\models\Supplier;
/* @var $this yii\web\View */
/* @var $model backend\models\Items */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="items-form">

    <?php $form = AutoForm::begin(["id" => "items-".time().(($model->isNewRecord)?"create":"update")."-form"]); ?>
    <div class="box-body">
        <div class="row">           
            <div class="">
                <?php //if($model->isNewRecord):?>
                <div class="col-md-12">
                    <h5 class="heading"><span>Item</span> </h5>
					<div class="row">
					<div class="col-md-6 "> 
					<?=
				     $form->field($model, 'type')->dropDownList(
								['accessories' => 'Accessories', 'spares' => 'Spares'],
								 ['prompt' => 'Select Type','class' => 'form-control select2 type']	
								
						); ?>

						</div>
						<div class="type-dpdn">
                         
                        </div>
					</div>

                    <div class="row">
					
                        <div class="col-md-6 "> 
                            <!--<?= $form->field($model, 'model_id')->textInput() ?>-->
                            <?= $form->field($model, 'model_id')->dropDownList(
                                $itemtypes=ArrayHelper::map(Vehiclemodels::find()->all(), 'id', 'name'),
                                ['class' => 'form-control select2 vehicle_model', 'prompt'=>'Select Vehicle']);
                                ?>
                          
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'variant_id')->dropDownList(
                         $itemtypes=ArrayHelper::map(Variants::find()->where(['model_id'=>$model->model_id])->all(), 'id', 'name'),
                         ['class' => 'form-control select2 variant_id','prompt'=>'Select Variant']);
                         ?>
                        </div>
                    </div>
                </div>
                 <div class="col-md-12 outer_div">
                   
                     <?php if($type=="update" && $model->itemfeature): 
                      echo'<h5 class="heading"><span>Item Features</span> </h5>';
                      echo'<div class="row">';
                      $ftr_id=array();
                        if($feature= $model->itemfeature){
                            foreach ($feature as $ftr) {
                              $ftr_id[]=$ftr->value_id;
                          }
                      }
                     ?>
                      <?php foreach ($types as $key => $type) {
                            echo'<div class="col-md-6">'; 
                            echo'<div class="form-group field-items-variant_id required has-success">';
                            echo'<div class="input-group">';
                            echo'<div class="input-group-addon">'.$type['type'].'</div>';
                            echo'<input type="hidden" id="items-opening_stock" class="form-control" name="Itemfeature[feature_id][]" value="'.$key.'" aria-invalid="false">';

                            if(sizeof($type['values']) > 1){
                                echo'<select id="items-variant_id" class="form-control select2 select2-new " name="Itemfeature[value_id][]" >';
                                echo'<option value="">Select '.$type['type'].'</option>';
                                foreach ($type['values'] as $key => $values){
                                    echo'<option '.((in_array($values['value_id'],$ftr_id))?'selected="selected"':"").' value="'.$values['value_id'].'">'.$values['value'].'</option>';
                                }
                                echo'</select>';

                            }else{  
                                echo'<input type="text" id="items-opening_stock" class="form-control" disabled name="Items[opening_stock]" value="'.$type['values'][0]['value'].'" aria-invalid="false">';
                                echo'<input type="hidden" id="items-opening_stock" class="form-control" name="Itemfeature[value_id][]" value="'.$type['values'][0]['value_id'].'" aria-invalid="false">';
                            }
                            echo'</div>';
                            echo'</div>';
                            echo'</div>';
                        }
                        ?>
                      <?php endif; ?>
                    </div>
                 </div>
                <div class="col-md-12">
                    <h5 class="heading"><span>Item Details</span> </h5>
                    <div class="row">
                        <div class="col-md-6 "> 
                           <?= $form->field($model, 'item_name')->textInput() ?>
                            <!--<?= $form->field($model, 'variant_id')->textInput() ?>-->
                            <?= $form->field($model, 'item_code')->textInput() ?>
                            <?= $form->field($model, 'description')->textarea(['rows' => 4])  ?>
                        </div>
                        <div class="col-md-6">
                             <?= $form->field($model, 'supplier_id', ['inputOptions' => ["class" => "form-control select2"]])->dropDownList(ArrayHelper::map(Supplier::find()->where(["status" => 1])->all(), 'id', 'name'), ["prompt" => "Select Supplier"]) ?>                                     
                              
                        </div>
                    </div>
                </div>
<?php
// var_dump($model->pricing);die;
?>
                    <!--<?= $form->field($model, 'created_date')->textInput() ?>

                    <?= $form->field($model, 'status')->textInput() ?>-->
                <?php //else: ?>
                          
            <div class="col-md-12">
                <h5 class="heading"><span>Pricing And Stock Details</span> </h5>
                <div class="row">
                    <div class="col-md-6 "> 
                        
                         <?= $form->field($modelprice, 'selling_price')->textInput(['value'=>(isset($model->pricing->selling_price)?$model->pricing->selling_price:0)]) ?>
                         <?= $form->field($model, 'tax_enabled')->checkbox(['class'=>'tax_enabled']); ?>
                         <span class="vat no-display"><?= $form->field($model, 'vat')->textInput(); ?></span>
                   </div>
                   <div class="col-md-6 ">
                      <?php if($model->isNewRecord  || (!$model->isNewRecord && $model->opening_stock==0)): ?>
                        <?= $form->field($model, 'opening_stock')->textInput() ?>
                      <?php endif ;?>
                            <?= $form->field($model, 'unit_id')->dropDownList(
                                $itemtypes=ArrayHelper::map(Units::find()->all(), 'id', 'name'),
                                ['class' => 'form-control select2 ', 'prompt'=>'Select Unit']);
                        ?>
                    </div>
                </div>
            </div>     
        </div>
    </div>
<!-- </div> -->
<!-- </div> -->

<!-- /.box-body -->  
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
</div>

<?php AutoForm::end(); ?>

</div>
<script>
    // $(document).ready(function(){
    //     $('.select2-new').select2();
    // });
$('body').on('change','.vehicle_model',function(){
    var model=$(this).val();
    data={'model_id':model}
    $.ajax({
        'type':'post',
        'url':"<?php echo Yii::$app->getUrlManager()->createUrl(['items/variantsbymodel']);?>",
        'data':data,
        success:function(s){
            var response = JSON.parse(s);
            var myDropDownList = document.getElementById("items-variant_id");
            $.each(response, function(index, value) {
                var option = document.createElement("option");
                option.text = value.name;
                option.value = value.id;

                try {
                    myDropDownList.options.add(option);

                }
                catch (e) {
                    alert(e);
                }
            });
                // myDropDownList.className += " select2";
            }
        });
});
$('body').on('change','.variant_id',function(){
    var display='';
    var variant=$(this).val();
    data={'variant_id':variant};
    $.ajax({
        'type':'post',
        'url':"<?php echo Yii::$app->getUrlManager()->createUrl(['items/featuresbyvariant']);?>",
        'data':data,
        success:function(s){
			
            var response = JSON.parse(s);
            display+='<h5 class="heading"><span>Item Features</span> </h5>';
            display+='<div class="row">';
            $.each(response, function( key, value ) {
                // console.log(key);
                
               
                display+='<div class="col-md-6 "> ';
                display+='<div class="form-group field-items-variant_id required has-success">';
                display+='<div class="input-group">';
                display+='<div class="input-group-addon">'+value.type+'</div>';
                display+='<input type="hidden" id="items-opening_stock" class="form-control" name="Itemfeature[feature_id][]" value="'+key+'" aria-invalid="false">';
                    // console.log(value.values);
                    // console.log(value.values.length);
                    if(value.values.length > 1){
                        // console.log(value.values);
                        display+='<select id="items-variant_id" class="form-control select2-new " name="Itemfeature[value_id][]" >';
                        display+='<option value="">Select '+value.type+'</option>';
                        $.each(value.values, function( key1, value1 ) {
                            // console.log( key1 + ": " + value1 );
                            display+='<option value="'+value1.value_id+'">'+value1.value+'</option>';
                        });
                        display+='</select>';
                        
                    }else{  
                        // console.log(value.values[0]);
                        display+='<input type="text" id="items-opening_stock" class="form-control" disabled name="Items[opening_stock]" value="'+value.values[0].value+'" aria-invalid="false">';
                        display+='<input type="hidden" id="items-opening_stock" class="form-control" name="Itemfeature[value_id][]" value="'+value.values[0].value_id+'" aria-invalid="false">';
                    }
                    display+='</div>';
                    display+='</div>';
                    display+='</div>';
                    // console.log( key + ": " + value );
                }); 

                    display+='</div>';
                $('.outer_div').append(display);
                $('.select2-new').select2();  
                }
            });
        });
	//Type change dropDownList
	$('body').on('change','.type',function(){

    var display='';
    var typedisplay='';
    var types=$(this).val();
    data={'type':types};
	if(types == 'spares'){
        typedisplay="Spares";
		var Url ="<?php echo Yii::$app->getUrlManager()->createUrl(['items/typebyspares']);?>";
	}
	else if(types == 'accessories')
	{
         typedisplay="Accessories";
		var Url ="<?php echo Yii::$app->getUrlManager()->createUrl(['items/typebyaccessory']);?>";

	}
	else
	{

	}
	// console.log(data);
	//;
    $.ajax({
        'type':'post',
        'url':Url,
        'data':data,
        success:function(s){
			console.log(s);
            var response = JSON.parse(s);
                //display+='<div class="row">';
                //display+='<div class="col-md-12 "> ';
                display+='<div class="col-md-6 "> ';
                display+='<div class="form-group field-items-variant_id required has-success">';
                display+='<div class="input-group">';
				
                display+='<div class="input-group-addon">'+typedisplay+'</div>';
                //display+='<input type="hidden" id="items-opening_stock" class="form-control" name="Itemfeature[feature_id][]" value="'+key+'" aria-invalid="false">';
                    // console.log(value.values);
                    // console.log(value.values.length);
                   
                        // console.log(value.values);
                        display+='<select id="items-type" class="form-control select2-new " name="Items[product_id]" >';
                        display+='<option value="">Select '+typedisplay+'</option>';
                        $.each(response, function( key1, value1 ) {
                             console.log( key1 + ": " + value1 );
                            display+='<option value="'+value1.id+'">'+value1.name+'</option>';
                        });
                        display+='</select>';
                        
                    
                    display+='</div>';
                    display+='</div>';
                    display+='</div>';
                    // console.log( key + ": " + value );
                

                    display+='</div>';
               // $('.outer_div').append(display);
			   	   $('.type-dpdn').html(display);

                $('.select2-new').select2();  
                }
            });
        });
/*End*/	

    $( function() {
        $( ".datepicker" ).datepicker({
          defaultDate: new Date(),
          dateFormat: "dd/mm/yy",
          changeMonth: true,
          changeYear: true,
          yearRange: "1930:2030",
      });
    });
    $('body').on('click','.tax_enabled',function(){
        if($(this).is(':checked')){
            $('.vat').removeClass('no-display');
        } else{
            $('.vat').addClass('no-display');
        }
    });
</script>