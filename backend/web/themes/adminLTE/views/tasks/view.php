<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model backend\models\Tasks */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Service Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tasks-view main-body" id="tasks_view">
<div class="content-main-wrapper">
<?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= Html::encode($this->title) ?>        
    </h1>
</section>

<section class="content">
    <!-- SELECT2 EXAMPLE -->
    <div class="box box-default">   

        <div class="box-body">
            <div class="row">
                <div class="col-md-6"> 
                    <p>
                        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                            ],
                            ]) ?>
                        </p>
					<?php
					
					$min= $model->total_time;
					$d = floor ($min / 1440);
					$h = floor (($min - $d * 1440) / 60);
					$m = $min - ($d * 1440) - ($h * 60);
					$full = $d."  days  " .$h." hours ".$m." minutes ";
					
					?>
	
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                            // 'id',
                            'task',
                            'description:ntext',
                            'type',
                            'created_date',
							'billable',
							[
							 'attribute' => "Allowed Time",
							 'value' => $full,
							],
                            // 'status',
							[
							 'attribute' => 'billing_rate' ,
							 'value' => (($model->billable =='yes') ? $model->billing_rate: "Not Applicable" ),
							],
							[
							 'attribute' => 'actual_rate',
							 'value' => (($model->billable =='yes') ? $model->actual_rate: " Not Applicable" ),
							],
							[
							 'attribute' =>  'tax_enabled',
							 'value' => (($model->billable =='yes') ? $model->tax_enabled: "Not Applicable " ),
							],
							[
							 'attribute' => 'tax_rate',
							 'value' => (($model->tax_enabled =='yes') ? $model->tax_rate: "Not Applicable" ),
							],
							
                            ],
							
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.box -->
</section>
</div>

