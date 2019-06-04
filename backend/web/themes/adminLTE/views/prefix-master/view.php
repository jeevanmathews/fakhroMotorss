<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\PrefixMaster */

$this->title = $model->prefix;
$this->params['breadcrumbs'][] = ['label' => 'Prefix Masters', 'url' => ['index']];
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
                  

                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                            // 'id',
                            'prefix',
                            ['attribute'=>'process',
                            'value'=>function ($model){
                            return ucwords(str_replace('-', ' ', $model->process));
                            },
                            ],
                            'description:ntext',
                            // 'created_date',
                            // 'status',
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
