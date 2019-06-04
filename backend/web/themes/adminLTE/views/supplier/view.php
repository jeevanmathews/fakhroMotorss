<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Supplier */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Suppliers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
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
            
            <div class="row">
                    <div class="col-md-12"> 
                    <h5 class="heading"><span>Supplier Details</span> </h5>
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [                               
                                'name',
                                'email:email',
                                'phone',
                                'address',
                                'status',
                            ],
                        ]) ?>
                        <p>
                        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>       
                        </p>
                     </div>
                </div>
            </div>
        </div>
        </div>
        </div>
          <!-- /.box -->
    </section>
</div>
