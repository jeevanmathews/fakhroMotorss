<?php

use yii\helpers\Html;
use common\components\AutoForm;
use backend\models\Manufacturer;
use backend\models\Make;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\CarModel */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = AutoForm::begin(["id" => "model-".time().(($model->isNewRecord)?"create":"update")."-form"]); ?>
    <div class="box-body">
        <div class="row"> 
            <div class="col-md-6">
            <?php if($model->make_id) $model->manufacturer = $model->make->manufacturer->id;?>
            <?=$form->field($model, 'manufacturer')->dropDownList(
				ArrayHelper::map(Manufacturer::find()->all(), 'id', 'name'),
				 ['prompt' => 'Select Type','class' => 'form-control select2 type',	
				
		    'onchange'=>'
                $.get( "'.Yii::$app->getUrlManager()->createUrl('car-model/makes').'&manufacturer_id="+$(this).val(), function( data ) {
			    $( "#carmodel-make_id" ).html(data);
           });
            ']);?>

            <?= $form->field($model, 'make_id')->dropDownList(($model->make_id)?ArrayHelper::map(Make::find()->where(['manufacturer_id' => $model->manufacturer])->all(), 'id', 'make'):[]) ?>

            <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'status')->dropDownList([ '0' => 'Disable', '1' => 'Enable', ], ['prompt' => '']) ?> 
            </div>
        </div>
    </div>
    <!-- /.box-body -->  
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php AutoForm::end(); ?>
