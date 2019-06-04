<?php

use yii\helpers\Html;
use common\components\AutoForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Currency */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = AutoForm::begin(); ?>
<div class="box-body">
	<div class="row">           
		<div class="col-md-5 col-md-offset-3"> 

			<?= $form->field($model, 'process')->dropDownList([ 'purchase-request' => 'Purchase request', 'purchase-order' => 'Purchase order', 'goods-receipt-note' => 'GRN', 'purchase-invoice' => 'Purchase invoice', 'purchase-return' => 'Purchase return', 'quotation' => 'Quotation', 'sales-order' => 'Sales order', 'delivery-order' => 'Delivery order', 'sales-invoice' => 'Sales invoice', 'jobcard-invoice' => 'Jobcard invoice', ], ['prompt' => '','class'=>'form-control select2']) ?>

			<?= $form->field($model, 'prefix')->textInput(['maxlength' => true]) ?>

			<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

		</div>
	</div>
</div>
<!-- /.box-body -->  
<div class="box-footer">
	<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>
<?php AutoForm::end(); ?>
