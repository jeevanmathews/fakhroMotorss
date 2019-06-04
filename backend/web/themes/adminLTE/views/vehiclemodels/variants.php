<?php

use yii\helpers\Html;
use common\components\AutoForm;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\Customfeatures;

/* @var $this yii\web\View */
/* @var $model backend\models\Vehiclemodels */

$this->title = 'Create Variants: ' . $model->manufacturer->name.' '.$model->name;
$this->params['breadcrumbs'][] = ['label' => 'Vehicles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Variants';
?>
<div class="content-main-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?= Html::encode($this->title) ?>        
		</h1>
	</section>
	<section class="content">
		<div class="box box-default">	 
			<?php $form = AutoForm::begin(); ?>
			<div class="box-body">
				<div class="row">
					<div class="col-md-12"> 

						<?php 
						// var_dump($dataProvider);die;
						if($model->variants):
						?>
						 <?= GridView::widget([
					        'dataProvider' => $dataProvider,
					        'columns' => [
					            ['class' => 'yii\grid\SerialColumn'],

					            // 'id',
					            'name',
					          
					            ['class' => 'yii\grid\ActionColumn','header'=>'Actions',
								'header'=>'Features',
								'template' => '{my_button}',
								'buttons' => [
				                'my_button' => function ($url, $model, $key) {
				                   return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->getUrlManager()->createUrl(['vehiclemodels/update-variant', 'id' =>$model->id,]), [
				                    	'title' => Yii::t('app', 'Update Variant'),
						        		]);
						                },
				            		]
					            ],
					        ],
					         // ['class' => 'yii\grid\ActionColumn',
				          //   'header'=>'Features',
				          //   'template' => '{my_button}', 
				          //   'buttons' => [
				          //       'my_button' => function ($url, $model, $key) {
				          //          return Html::a('<span class="glyphicon glyphicon-check"></span>', Yii::$app->getUrlManager()->createUrl(['vehiclemodels/variantfeatures', 'id' =>$model->id,]), [
				          //           'title' => Yii::t('app', 'Add Role'),
				        		// ]);
				          //       },
				          //   ]
				          //   ],
					        'tableOptions' => [
					        'id' => 'theDatatable',
					        'class'=>'table table-striped table-bordered table-hover'
					        ],
					    ]); ?>
						<?php
						endif;
						?>
						<div class="maindiv">
							<div class="mainclone variantdiv">
								<h5 class="heading"><span>Variant Details</span> </h5>            
								<div class="row">
									<div class="col-md-12">  
										<?= $form->field($model2, 'name')->textInput() ?>
										<?= $form->field($model2, 'model_id')->hiddenInput(['value'=> $model->id])->label(false);?>
									</div>
									<div class="col-md-6">  
										
									</div>
								</div>
								<div class="box-footer">
									<?= Html::Button('<span class="glyphicon glyphicon-plus"></span>', ['class' => 'btn btn-success btn_add_features','title'=>'Add Features']) ?>
								</div>
							</div>
							<h5 class="heading"><span>Variant Features</span> </h5>            
							<div class="row featurediv ">
									<div class="featureclone divfeatures col-md-12" rid="1">
										<div class="col-md-3 ">  
											<div class="typeselect">  
											<?= $form->field($model3, 'name[]')->dropDownList(
												ArrayHelper::map(Customfeatures::find()->all(), 'id', 'name'), 
												['class' => 'form-control', 'prompt'=>'Select features']);
												?>
											</div>
											<div class=" no-display typetext">  
												<?= $form->field($model3, 'name[]')->textInput() ?>
											</div>
											<span class="newButtonSpan">Not in the list ?</span> <?= Html::a('Add new', '#', ['class'=>'new_feature_type']) ?>
										</div>
										<div class="col-md-3">  
											  Multiple Values
 											<label><input type='radio' class='styled-radio multipleselect' name="Customfeatures[multiple1]" value="yes" /><span>Yes</span></label>
											<label><input type='radio' class='styled-radio singleselect multipleselect'  name="Customfeatures[multiple1]" value="no" /><span>No</span></label>

										</div>
										<div class="col-md-6">
											<div class="col-md-11 value_div">  
												<?= $form->field($model4, 'value')->textInput(['class'=>'form-control valuetext textclone']) ?>
											</div>
											<div class="col-md-1 no-display valueclone">  
												<?= Html::a('<span class="glyphicon glyphicon-plus clonevalues"></span>', '#', ['class'=>'']) ?>
											</div>
											<div class="box-body col-md-1">
												<?= Html::a('<span class="glyphicon glyphicon-minus"></span>', '#', ['class'=>'pull-right remove_feature no-display']) ?>
											</div>
										</div>
									</div>
									<hr class="col-md-12"/>
								</div>
							</div>
							<div class="box-footer">
								<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
							</div>
						</div>
					</div>
				</div>
				<?php AutoForm::end(); ?>
			</div>
		</div>
	</div>
</section>
</div>

<script>
$(document).ready(function(){
	$('body').on('click','.trash-input',function(){
		$(this).parent(".col-md-1").parent(".row").remove();
	});
	$('.divfeatures:first').find('.valuetext').attr('name','Customfeatures[value1][]');
	$('.divfeatures:first').find('.multipleselect').attr('name','Customfeatures[multiple1]');
	$('body').on('click','.btn_add_features',function(){
		var last_row_type=$('.divfeatures:last').find('#customfeatures-name:not([disabled])').val();//.not('[disabled]'));//.val());
		console.log(last_row_type);
		if(last_row_type!='' &&  typeof(last_row_type)!=='undefined'){
			$('.divfeatures:first').find('.valuetext').attr('name','Customfeatures[value1][]');
			var clone=$('.featureclone').clone();
			clone.removeClass('featureclone');
			var rid = $('.divfeatures:last').attr('rid');
			var new_rid=parseInt(rid)+1;
			clone.attr('rid',new_rid);
			clone.find('.valuetext').attr('name','Customfeatures[value'+new_rid+'][]');
			clone.find('.multipleselect,.singleselect').attr('name','Customfeatures[multiple'+new_rid+']');

			clone.find(".field-customfeatures-value:not(first-child)").remove();
			
			clone.find('.singleselect').prop('checked', true);

			clone.find('.remove_feature').removeClass('no-display');
			clone.find('.valueclone').addClass('no-display');
			// clone.find('.value_div').addClass('col-md-6');
			// clone.find('.value_div').removeClass('col-md-4');
			clone.find(".trash-input").remove();
			clone.find('.field-variantfeatures-value').not(':first').remove();
			clone.find('input[type=text]').val('');
			$('.featurediv').append(clone);
			$('.featurediv').append('<hr class="col-md-12"/>');
		}
	});
	$('body').on('click','.new_feature_type',function(){
		if($(this).hasClass('select')){
			$(this).removeClass('select');
			$(this).closest('.divfeatures').find('.typeselect').removeClass('no-display');
			$(this).closest('.divfeatures').find('.typetext').addClass('no-display');
			$(this).closest('.divfeatures').find('.typetext input').attr('disabled',true);
			$(this).closest('.divfeatures').find('.typeselect select').attr('disabled',false);
			// $(this).removeClass('feature_select');
			// $(this).addClass('new_feature_type');
			$(this).parent().find('.newButtonSpan').html('Not in the list?');
			$(this).html('Add New');
		}else{
			$(this).closest('.divfeatures').find('.typeselect').addClass('no-display');
			$(this).closest('.divfeatures').find('.typeselect select').attr('disabled',true);
			$(this).closest('.divfeatures').find('.typetext input').attr('disabled',false);
			$(this).addClass('select');
			$(this).closest('.divfeatures').find('.typetext').removeClass('no-display');
			// $(this).removeClass('new_feature_type');
			// $(this).addClass('feature_select');
			$(this).parent().find('.newButtonSpan').html('Already in the list?');
			$(this).html('Select Type');
		}
	});
	$('body').on('click','.remove_feature',function(e){
		e.preventDefault();
		console.log($(this).closest('.divfeatures'));
		$(this).closest('.divfeatures').remove();
	});
	$('body').on('click','.multipleselect',function(){
		if($(this).is(':checked')){
			var multiple=$(this).val();
			if(multiple=='yes'){
				$(this).closest('.divfeatures').find('.valueclone').removeClass('no-display');
				// $(this).closest('.divfeatures').find('.value_div').removeClass('col-md-6');
				// $(this).closest('.divfeatures').find('.value_div').addClass('col-md-4');
			}else{
				$(this).closest('.divfeatures').find('.valueclone').addClass('no-display');
				$(this).closest('.divfeatures').find('.trash-input').addClass('no-display');
				// $(this).closest('.divfeatures').find('.value_div').addClass('col-md-6');
				// $(this).closest('.divfeatures').find('.value_div').removeClass('col-md-4');
				$(this).closest('.divfeatures').find('.field-variantfeatures-value').not(':first').remove();
			}
		}
	});
	$('body').on('click','.clonevalues',function(e){	
	e.preventDefault();	
		var rid = $(this).closest('.divfeatures').attr('rid');
		console.log($(this).closest('.divfeatures').focus());
		
		// valuetext textclone
		var clone='<div class="row"><div class="col-md-11"><div class="form-group field-variantfeatures-value"><div class="input-group"><div class="input-group-addon">Value</div><input type="text" id="customfeatures-value" class="form-control valuetext textclone" name="Customfeatures[value'+rid+'][]"></div><div class="help-block"></div></div></div><div class="col-md-1"><a href="#" class="trash-input"><i class="fa fa-fw fa-trash"></i></a></div></div>';
		// var remove='<a class="pull-right remove_feature" href="#"><span class="glyphicon glyphicon-minus"></span></a>';
		// clone.find('.valuetext').attr('name','Customfeatures[value'+rid+'][]');
		$(this).closest('.divfeatures').find('.value_div').append(clone);
		$(this).closest('.divfeatures').focus();
		// $(this).closest('.divfeatures').append(remove);
		// $(this).closest('.divfeatures').focus();
	});
});

</script>


<!-- DetailView::widget([
'model' => $model,
'options' => ['class' => 'table table-striped table-bordered detail-view table-hover'],
'attributes' => [
['label'=>'Manufacturer',
'value'=>$model->manufacturer->name,
],
'name',
],
]) -->
<!-- $form->field($model3, 'multiple')->dropDownList(['yes' => 'Yes', 'no' => 'No'],['prompt'=>'Select Option','class'=>'form-control multipleselect']); -->
<!-- $('body').on('change','.multipleselect',function(){
		var multiple=$(this).val();
		if(multiple=='yes'){
			$(this).closest('.divfeatures').find('.valueclone').removeClass('no-display');
			$(this).closest('.divfeatures').find('.value_div').removeClass('col-md-6');
			$(this).closest('.divfeatures').find('.value_div').addClass('col-md-4');
		}else{
			$(this).closest('.divfeatures').find('.valueclone').addClass('no-display');
			$(this).closest('.divfeatures').find('.value_div').addClass('col-md-6');
			$(this).closest('.divfeatures').find('.value_div').removeClass('col-md-4');
		}
	}); -->