<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Manufacturer */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Manufacturers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>       
<div class="manufacturer-view main-body" id="manufacturer_view">
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

        <div class="box-body">
        <div class="row">
            <div class="col-md-6"> 
                
                    <h5 class="heading"><span>Manufacturer Details</span> </h5>
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [                           
                            'name',
                            'email:email',
                            'phone',
                            'address:ntext',
                            [                      // the owner name of the model
                            'label' => 'Status',
                            'format' => 'ntext',
                            'value' => ($model->status == '0'? "Disable":"Enable"),
                            ],
                            [                      // the owner name of the model
                            'label' => 'Logo',
                            'format' => 'html',
                            'value' => Html::img("../../backend/web/uploads/manufacturer/".$model->logo, ["class" => "img-responsive"])
                            ],                            
                        ],
                    ]) ?>
                    <p>
                        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Edit Details', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>       
                    </p>
            </div>

        </div>             
        </div>
        </div>
    </section>
</div>
</div>
