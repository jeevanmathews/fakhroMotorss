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

<div class="itemgroup-form">

    <?php $form = AutoForm::begin(); ?>

		
<?=
$form->field($model, 'type')->dropDownList(
				['accessories' => 'Accessories', 'spares' => 'Spares'],
				 ['prompt' => 'Select Type','class' => 'form-control select2 type',	
				
		    'onchange'=>'
                $.get( "'.Yii::$app->getUrlManager()->createUrl('itemgroup/lists').'&type="+$(this).val(), function( data ) {
			  $( "select#itemgroup-parent_id" ).html(data);
           });
      ']);
    
      //$dataPost=ArrayHelper::map(Itemgroup::find()->asArray()->all(), 'id', 'category_name');?>
      <?=$form->field($model, 'parent_id')
           ->dropDownList(

                ['prompt' => 'Select ParentId']
           );
		   ?>
    <?= $form->field($model, 'category_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

   <?php AutoForm::end(); ?>

</div>
