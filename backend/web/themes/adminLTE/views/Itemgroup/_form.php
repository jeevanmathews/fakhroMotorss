<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\AutoForm;
use yii\helpers\ArrayHelper;
use backend\models\Itemgroup;


/* @var $this yii\web\View */
/* @var $model backend\models\itemgroup */
/* @var $form yii\widgets\ActiveForm */
?>



 <?php $form = AutoForm::begin(); ?>

<div class="box-body">
   <div class="row">
    <div class="col-md-12">               
      <div class="row">
         <div class="col-md-6">  		
<?=
$form->field($model, 'type')->dropDownList(
				['accessories' => 'Accessories', 'spares' => 'Spares'],
				 ['prompt' => 'Select Type','class' => 'form-control select2 type',	
				
		    'onchange'=>'
                $.get( "'.Yii::$app->getUrlManager()->createUrl('itemgroup/lists').'&parent_id=0&type="+$(this).val(), function( data ) {
			    $( "div#itemlists" ).html(data);
           });
      ']);
    
     ?>

	<div id="itemlists">  
      <?=$form->field($model, 'parent_id')
           ->dropDownList(['choose_type' => 'Please choose type First' ],

                ['prompt' => 'Select ParentId','class' => 'form-control select2 type']
           );
		   ?>
    </div>

	
	<?= $form->field($model, 'status')->dropDownList([ '0' => 'Disable', '1' => 'Enable', ], ['prompt' => '','class'=>'form-control select2']) ?> 

	 </div>
           </div>
           </div>
    </div>
</div>
 <div class="box-footer">       
 <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

   <?php AutoForm::end(); ?>

</div>

