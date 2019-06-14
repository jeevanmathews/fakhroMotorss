<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Spareparts */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Spareparts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="spareparts-view main-body" id="spareparts_view">
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
                        // 'spare_type_id',
                        // [
                        // 'label'=>'Spare Type',
                        // 'value'=>$model->sparetype->name,
                        // ],
                        //  [
                        // 'label'=>'Item Type',
                        // 'value'=>$model->group->name,
                        // ],
                        ['label'=>'Item Group',
                        'value'=>(isset($model->parent)?$model->parent->category_name:''),
                        ],
                        'name',
                        'code',
                        'description:ntext',
                        'created_date',
						'rate',
                        // 'status',
						[
                        'label'=>'Tax Enabled',
                        'value'=>$model->tax_enabled?$model->tax_enabled:"Not Applicable",
                        ],
					  [
                        'label'=>'Tax rate',
                        'value'=>$model->tax_enabled?$model->tax_rate:"Not Applicable",
                        ],
                        ],
						
                        ]) ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
</div>
</div>
</div>
