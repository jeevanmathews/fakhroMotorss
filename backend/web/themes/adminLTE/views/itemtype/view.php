<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Itemtype */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Itemtypes', 'url' => ['index']];
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

                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                            // 'id',
                            'name',
                            ['label'=>'group_id',
                            'value'=>((isset($model->group))?$model->group->name:''),
                            ],
                            'quantity_added',
                            'set_tax',
                            'created_at',
                            // 'status',
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
