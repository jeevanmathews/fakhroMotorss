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
				 ['prompt' => 'Select Type','class' => 'form-control select2 type']	
				
		); ?>
		
  <?= $form->field($model, 'parent_id')->dropDownList(
                         $itemtypes=ArrayHelper::map(Itemgroup::find()->where(['parent_id'=>0])->all(), 'id', 'category_name'),
                         ['class' => 'form-control select2 parent_id','prompt'=>'Select Parent']);
                         ?>

    <?= $form->field($model, 'category_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

   <?php AutoForm::end(); ?>

</div>
<script>
$('body').on('change','.type',function(){
	 var types=$(this).val();
	 data={'type':types};
	if(types == 'spares'){
        typedisplay="Spares";
		var Url ="<?php echo Yii::$app->getUrlManager()->createUrl(['itemgroup/spares']);?>";
	}
	else if(types == 'accessories')
	{
         typedisplay="Accessories";
		var Url ="<?php echo Yii::$app->getUrlManager()->createUrl(['itemgroup/accessory']);?>";

	}
	else{
		
	}
	    $.ajax({
        'type':'post',
        'url':Url,
        'data':data,
        success:function(s){
			console.log(s);
		}
        
        });
});
</script>