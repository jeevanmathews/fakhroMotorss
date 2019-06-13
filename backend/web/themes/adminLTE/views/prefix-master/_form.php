<?php

use yii\helpers\Html;
use common\components\AutoForm;
use backend\models\Branches;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\Currency */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="prefix-master-form">
	<?php $form = AutoForm::begin(["id" => "prefix-master-".time().(($model->isNewRecord)?"create":"update")."-form"]); ?>
	<div class="box-body">
		<div class="row">           
			<div class="col-md-5 col-md-offset-3"> 

				<?= $form->field($model, 'process')->dropDownList([ 'purchase-request' => 'Purchase request', 'purchase-order' => 'Purchase order', 'goods-receipt-note' => 'GRN', 'purchase-invoice' => 'Purchase invoice', 'purchase-return' => 'Purchase return', 'quotation' => 'Quotation', 'sales-order' => 'Sales order', 'delivery-order' => 'Delivery order', 'sales-invoice' => 'Sales invoice', 'jobcard-invoice' => 'Jobcard invoice', ], ['prompt' => '','class'=>'form-control select2']) ?>

				<?= $form->field($model, 'prefix')->textInput(['maxlength' => true,'class'=>'form-control prefix']) ?>
				
				 <?= $form->field($model,'branch_id', ['inputOptions' => ["class" => "branch_change form-control select2"]])->dropDownList(ArrayHelper::map(Branches::find()->where(["status" => 1])->all(), 'id', 'name','code'), ["prompt" => "Select Branch"]) ?>

				<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

				<?= Html::textInput('actual_prefix','',['type'=>'hidden','class'=>'form-control actual_prefix','disabled'=>true])?>
				<?= Html::textInput('code','',['type'=>'hidden','class'=>'form-control code','disabled'=>true])?>

			</div>
		</div>
	</div>
	<!-- /.box-body -->  
	<div class="box-footer">
		<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
	</div>
	<?php AutoForm::end(); ?>
	<script>
  		$(document).find('select').select2();
  		$('.branch_change,.prefix').on('change',function(){
  			var branch='';
  			var prefix='';
  			var code='';
  			
  				branch= $('.branch_change').val();
			if($('.prefix').val()!='' && $('.prefix').val()!='undefined'){
  				 prefix= $('.prefix').val();
  			}
  			if($('.branch_change option:selected').parent().attr('label')!='' && typeof $('.branch_change option:selected').parent().attr('label')!=='undefined'){
  				 code = $('.branch_change option:selected').parent().attr('label');
  			}
  			var actual_prefix = 'TA-S'+prefix+code;
  			$('.actual_prefix').val(prefix);
  			$('.actual_prefix').val(actual_prefix);
  			$('.code').val(code);
  		});
	</script>
</div>
