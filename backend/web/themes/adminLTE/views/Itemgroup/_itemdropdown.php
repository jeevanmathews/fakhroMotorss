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
else
{

$Item = ArrayHelper::map(Itemgroup::find() ->where(['parent_id' =>$parent_id])->all(), 'id', 'category_name');

}

?>
<div class="form-group">
<div class="input-group">

<?=
(count($Item)>0)?

Html::dropDownList('parent_id[]','',
				['add_new' =>'Add New']+$Item ,
				 ['prompt' => 'Select Type','class' => 'form-control select2 type',	
				
		    'onchange'=>'if( $(this).val()== "add_new"){ $("[name=\'category_name\']").removeClass("hide");} else{
                $.get( "'.Yii::$app->getUrlManager()->createUrl('itemgroup/lists').'&parent_id="+$(this).val(), function( data ) {
			$("[name=\'category_name\']").remove();		
			$("div#itemlists").append(data);
			$("#hidden-field").css("visibility","hidden");
           });
			}
      '])
	  
:
	 Html::textInput('default_value','', ['class' => 'form-control']);
	 Html::hiddenInput('parent_id', $parent_id);
	  
?>
 </div>  
</div>
<div class="form-group">
<div class="input-group">

	<?= Html::textInput('category_name','', ['class' => 'form-control hide']) ; ?>

</div>
</div>

