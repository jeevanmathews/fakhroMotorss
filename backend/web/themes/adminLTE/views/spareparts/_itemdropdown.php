<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\AutoForm;
use yii\helpers\ArrayHelper;
use backend\models\Itemgroup;

/* @var $this yii\web\View */
/* @var $model backend\models\itemgroup */
/* @var $form yii\widgets\ActiveForm */
if($type!="")
{
	$Item = ArrayHelper::map(Itemgroup::find() ->where(['parent_id' =>$parent_id,'type'=>$type])->all(), 'id', 'category_name');
}
?>

<?=
(count($Item)>0)?
'<div class="form-group parent_id">
<div class="input-group">
<div class="input-group-addon">Sub Group</div>'.
Html::dropDownList('parent_id[]','',
	$Item ,
	['prompt' => 'Select Type','class' => 'form-control select2 type',	

	'onchange'=>'$(this).parent().parent().nextAll(".parent_id").remove(); if( $(this).val()== "add_new"){ $("[name=\'category_name\']").removeClass("hide");} else{
		$.get( "'.Yii::$app->getUrlManager()->createUrl('spareparts/lists').'&parent_id="+$(this).val(), function( data ) {
			$("[name=\'category_name\']").remove();		
			$("div#itemlists").append(data);
			$("#hidden-field").css("visibility","hidden");
		});
}
'])
.'</div>  
</div>'
:
	 //Html::textInput('default_value','', ['class' => 'form-control']);
Html::hiddenInput('parent_id[]', $parent_id);

?>

<div class="form-group">
	<div class="input-group">


	</div>
</div>

<script>
  $(document).find('select').select2();
</script>