<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model backend\models\Jobcard */

$this->title = 'Jobcard Booking - Jobcard: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Jobcards', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$total_time = 0;
$billing_rate = 0;
$rate = 0;
$task_total = 0;
$mat_total = 0;
$task_net_price_tot = 0;
$net_price_tot = 0;
$cur_time = time();
?>
<div class="main-body" id="jobcard_update_<?php echo $cur_time;?>">
<?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
<div class="content-main-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= Html::encode($this->title) ?>        
      </h1>
    </section>

     <section class="content">
      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">  

		<ul class="nav nav-tabs" id="" role="tablist">
		  	<li class="nav-item <?php if($activeTab == "job-card"){echo 'active';}?>">
		    <a class="nav-link jc-tabs <?php if($activeTab == "job-card"){echo 'active';}?>" id="job-card-tab-<?php echo $cur_time;?>" data-toggle="tab" href="#job-card_<?php echo $cur_time;?>" role="tab" aria-controls="jobcard" aria-selected="true">
		    <span>Job Card</span></a>
		  	</li>
		  	<li class="nav-item <?php if($activeTab == "task"){echo 'active';}?>">
		    <a class="nav-link jc-tabs <?php if($activeTab == "task"){echo 'active';}?>" id="task-tab-<?php echo $cur_time;?>" data-toggle="tab" href="#task_<?php echo $cur_time;?>" role="tab" aria-controls="task" aria-selected="false"><span>Jobcard Tasks</span></a>
		  	</li>
		  	<li class="nav-item <?php if($activeTab == "material"){echo 'active';}?>">
		    <a class="nav-link jc-tabs <?php if($activeTab == "material"){echo 'active';}?>" id="material-tab-<?php echo $cur_time;?>" data-toggle="tab" href="#material_<?php echo $cur_time;?>" role="tab" aria-controls="material" aria-selected="false"><span>Materials</span></a>
		  	</li>
		  	<li class="nav-item <?php if($activeTab == "total"){echo 'active';}?>">
		    <a class="nav-link jc-tabs <?php if($activeTab == "total"){echo 'active';}?>" id="total-tab-<?php echo $cur_time;?>" data-toggle="tab" href="#total_<?php echo $cur_time;?>" role="tab" aria-controls="total" aria-selected="false"><span>Total Charges</span></a>
		  	</li>
		</ul>
		<div class="tab-content" id="">
		  	<div class="tab-pane <?php if($activeTab == "job-card"){echo 'active';}?>" id="job-card_<?php echo $cur_time;?>" role="tabpanel" aria-labelledby="home-tab">
			    <?= $this->render('_form', [
			        'model' => $model,
			        'vehicle' => $vehicle,
			        'customer' => $customer
			    ]) ?>
			</div>
		  	<div class="tab-pane <?php if($activeTab == "task"){echo 'active';}?>" id="task_<?php echo $cur_time;?>" role="tabpanel" aria-labelledby="task-tab">
		  		<div class="box-body">
        		<div class="row"> 
            	<div class="col-md-12">        			
        			<?php if(!$jobcardTask->isNewRecord){?>
	    				<p>
	                        <?= Html::a('Add New Task', ['update', 'id' => $model->id, 'tab' => 'task'], ['class' => 'btn btn-success']) ?>
	                    </p>
                    <?php } ?>
			  		<?= GridView::widget([
				        'dataProvider' => $taskdataProvider,			    
				        'columns' => [
				            ['class' => 'yii\grid\SerialColumn'],	
				            'task.task',				          
				            [
				            	'label' => 'Mechanic',
				            	'value' => 'mechanic.fullname'
				            ],			            		      
				            'start_date_time',				          
				            [
			            	 	'attribute' => 'end_date_time',
			            	 	'value'=>function ($model, $key, $index, $widget){
						       		$widget->footer = "<b>Labour Totals</b>";
						        	return $model->end_date_time ;
						     	},	
				            ],	
				            [					         
					            'label' => 'Allowed Time',
					            'value'=>function ($model, $key, $index, $widget){	
						        	return Yii::$app->common->getTimedisplay($model->task->total_time*60) ;
						     	},						    
					     	],			            
			             	[					         
					            'attribute' => 'total_time',
					            'value'=>function ($model, $key, $index, $widget) use (&$total_time) {
						        	$total_time += $model->total_time;
						       		$widget->footer = "<b>".Yii::$app->common->getTimedisplay($total_time*60)."</b>";
						        	return Yii::$app->common->getTimedisplay($model->total_time*60);
						     	},						    
					     	],	
					     	//'billable',				 
					     	[					         
					            'attribute' => 'task_rate',
					            'value'=>function ($model, $key, $index, $widget) use (&$task_total) {
						        	$task_total += $model->task_rate;
						       		$widget->footer = "<b>".$task_total."</b>";
						        	return $model->task_rate;
						     	},						    
					     	],

					     	[
					     		'attribute'	=> 'discount_amount',
					     		'label' => 'Discount',
					     		'visible' => ((Yii::$app->common->company->vat_format == "exclusive")?false:true),
					     	],
					     	[
					            'label' => 'Net Price',
					            'value'=>function ($model, $key, $index, $widget) use (&$task_net_price_tot) {						        	
						        	$task_net_price = ((Yii::$app->common->company->vat_format == "exclusive")?$model->task_rate:($model->task_rate-$model->discount_amount));
						        	$task_net_price_tot += $task_net_price;
						        	$widget->footer = "<b>".$task_net_price_tot."</b>";
						        	return $task_net_price;					        	
						     	},
						     	'visible' => ((Yii::$app->common->company->vat_format == "exclusive")?false:true),						    
					     	],
					     	[					        
					            'attribute' => 'tax_rate',
					            'value'=>function ($model, $key, $index, $widget){
					            	if(Yii::$app->common->company->vat_format == "exclusive"){
					            		return "NA";
					            	}else{
					            		return (($model->tax_enabled == "yes")?$model->tax_rate:"NA");	
					            	}						        	
						     	},						    
				     		],
				     		[
				     			'attribute' => 'tax_amount',
					            'visible' => ((Yii::$app->common->company->vat_format == "exclusive")?false:true),
				     		],				     		     	
					     	[					        
					            'attribute' => 'billing_rate',
					            'visible' => ((Yii::$app->common->company->vat_format == "exclusive")?false:true),
					            'value'=>function ($model, $key, $index, $widget) use (&$billing_rate) {
					            	if($model->billable == "yes"){
					            		$billing_rate += $model->billing_rate;
					            	}
						       		$widget->footer = "<b>".Yii::$app->common->company->settings->currency->code." ".$billing_rate."</b>";
						        	return ($model->billable == "yes")?(Yii::$app->common->company->settings->currency->code." ".$model->billing_rate) :"NA";
						     	},						    
				     		],				     		
				     		'status',					     	
				            ['class' => 'yii\grid\ActionColumn',
				            'buttons' => [
		                        'update' => function ($url, $model, $key) {
		                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id'=>$model->jobcard_id, 'taskId' => $model->id]);
		                        	},		                    	
		                    	'view'	=> 	function ($url, $model, $key) {
		                        	 return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', "#", ['onclick' => 'openTask("'.$model->id.'");' ]);
		                        	},
		                        'delete'	=> 	function ($url, $model, $key) {
		                        	 return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete-task', 'task_id' => $model->id ]);
		                        	}	
	                        	]
				            ],
				        ],
				        'showFooter' => true,
				    ]); ?>				
			    	<?= $this->render('_taskform', ['jobcardTask' => $jobcardTask, 'vehicle_type' => $model->vehicle->vehicle_type]) ?>
			    </div>
			    </div>
			    </div>
		  	</div>
		  	<div class="tab-pane  <?php if($activeTab == "material"){echo 'active';}?>" id="material_<?php echo $cur_time;?>" role="tabpanel" aria-labelledby="material-tab">
		  	<div class="box-body">
        		<div class="row"> 
            	<div class="col-md-12">
            		<?php if(!$jobcardMaterial->isNewRecord){?>
	    				<p>
	                        <?= Html::a('Add New Material', ['update', 'id' => $model->id, 'tab' => 'material'], ['class' => 'btn btn-success']) ?>
	                    </p>
                    <?php } ?>
			  		<?= GridView::widget([
				        'dataProvider' => $materialdataProvider,			    
				        'columns' => [
				            ['class' => 'yii\grid\SerialColumn'],
				            'material_type',
				            'material.item_name',       
				            [
			            	 	'attribute' => 'num_unit',
			            	 	'value'=>function ($model, $key, $index, $widget){
						       		$widget->footer = "<b>Materials Totals</b>";
						        	return $model->num_unit ;
						     	},	
				            ],
				            'unit_rate',					         
				            [					         
					            'attribute' => 'total',
					            'label' => 'Price',
					            'value'=>function ($model, $key, $index, $widget) use (&$mat_total) {
						        	$mat_total += $model->total;
						       		$widget->footer = "<b>".$mat_total."</b>";
						        	return $model->total;
						     	},						    
					     	],
					     	[
					     		'attribute'	=> 'discount_amount',
					     		'label' => 'Discount',
					     		'visible' => ((Yii::$app->common->company->vat_format == "exclusive")?false:true),
					     	],
					     	[
					            'label' => 'Net Price',
					            'value'=>function ($model, $key, $index, $widget) use (&$net_price_tot) {						        	
						        	$net_price = ((Yii::$app->common->company->vat_format == "exclusive")?$model->total:($model->total-$model->discount_amount));
						        	$net_price_tot += $net_price;
						        	$widget->footer = "<b>".$net_price_tot."</b>";
						        	return $net_price;					        	
						     	},		
						     	'visible' => ((Yii::$app->common->company->vat_format == "exclusive")?false:true),				    
					     	],
				            [					        
					            'attribute' => 'tax_rate',
					            'value'=>function ($model, $key, $index, $widget){
					            	if(Yii::$app->common->company->vat_format == "exclusive"){
					            		return "NA";
					            	}else{
					            		return (($model->tax_enabled == "yes")?$model->tax_rate:"NA");	
					            	}
						        	
						     	},						    
				     		],
				     		[
				     			'attribute' => 'tax_amount',
					            'visible' => ((Yii::$app->common->company->vat_format == "exclusive")?false:true),
				     		],				     		
				            [					   
					            'attribute' => 'rate',
					            'value'=>function ($model, $key, $index, $widget) use (&$rate) {
						        	$rate += $model->rate;
						       		$widget->footer = "<b>".Yii::$app->common->company->settings->currency->code." ".$rate."</b>";
						        	return Yii::$app->common->company->settings->currency->code." ".$model->rate ;
						     	},	
						     	'visible' => ((Yii::$app->common->company->vat_format == "exclusive")?false:true),						    
					     	],					     
				            ['class' => 'yii\grid\ActionColumn',
				            'template' => '{update}{delete}',
				            'buttons' => [				            	
		                        'update' => function ($url, $model, $key) {
		                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id'=>$model->jobcard_id, 'jobcardMatId' => $model->id]);
		                        	},
	                        	'delete'	=> 	function ($url, $model, $key) {
	                        	 return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete-material', 'material_id' => $model->id ]);
	                        	}			                        
		                    	]
				            ],
				        ],
				        'showFooter' => true,
				    ]); ?>
			    	<?= $this->render('_materialform', compact('jobcardMaterial')) ?>
			    </div>
			    </div>
			    </div>
		  	</div>
		  	<div class="tab-pane <?php if($activeTab == "total"){echo 'active';}?>" id="total_<?php echo $cur_time;?>" role="tabpanel" aria-labelledby="total-tab">
			    <?= $this->render('_totalform', [
			        'model' => $model			        
			    ]) ?>
			</div>
		</div>
	</div>
        <!-- /.box -->
    </section>
</div>

<div id="task-info" class="modal">
 
</div>

<script type="text/javascript">

	function openTask(job_taskId){
		$.post('<?=Yii::$app->getUrlManager()->createUrl(['jobcard/task'])?>', { job_taskId: job_taskId })
	    .done(function( data ) {          
	             $("#task-info").html(data);  
	             $("#task-info").modal(); 
	    });
	}
</script>

</div>

