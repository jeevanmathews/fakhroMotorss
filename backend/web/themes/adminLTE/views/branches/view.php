<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;
/* @var $this yii\web\View */
/* @var $model backend\models\Branches */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Branches', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="branches-view main-body" id="branches_view">
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
                <div class="row">
                    <div class="col-md-12"> 
                    <h5 class="heading"><span>Branch Details</span> </h5>
                        <?= DetailView::widget([
                        'model' => $model,
                        'options' => ['class' => 'table table-striped table-bordered detail-view table-hover'],
                        'attributes' => [ 
                         [
                            'label'=>'Company Name',
                            'value' => $model->company->name,
                            ],      
                            'name', 
                            'code',   
                           
                         
                           
                            'created_at',
                        ],
                    ]) ?>
                    </div>
                    <div class="col-md-12"> 
                    <h5 class="heading"><span>Contact Details</span> </h5>
                            <?= DetailView::widget([
                            'model' => $model,
                            'options' => ['class' => 'table table-striped table-bordered detail-view table-hover'],
                            'attributes' => [ 
                                'mailing_name',
                                 [                      // the owner name of the model
                            'label' => 'Branch Address',
                            'format' => 'ntext',
                            'value' => $model->address."\n".$model->state."\n".(isset($model->country->name)?$model->country->name:"")."\n zip: ".$model->zipcode,
                            ],
							[                      // the owner name of the model
                            'label' => 'Logo',
                            'format' => 'html',
                            'value' => Html::img("../../backend/web/uploads/branches/".$model->logo, ["class" => "img-responsive"])
                            ],    							
                            
                                'email:email',
                                'phone',
                                'fax', 
                                'website',                               
                            ],
                        ]) ?>
                    </div>
                </div>             
        </div>
         <div class="col-md-6"> 
               
                    <h5 class="heading"><span>Branch Type</span> </h5>
                        <?= DetailView::widget([
                        'model' => $model,
                        'options' => ['class' => 'table table-striped table-bordered detail-view table-hover'],
                        'attributes' => [ 
                         [ 
                         'label' => 'Branch Type',
                        'value' =>implode(',',\yii\helpers\ArrayHelper::map($model->branchtype, 'id', 'type')),
                        // },
                        ],
                        ],
                    ]) ?>
                    <p>
                        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Edit Branch', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    </p> 
            </div>
        </div>
        </div>
        </div>
    </section>
</div>
