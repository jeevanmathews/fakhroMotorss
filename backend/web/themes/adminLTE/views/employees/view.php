<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Employees */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="employees-view main-body" id="employees_view">
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
            <p><?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <!--<?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>-->
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'first_name',
            'last_name',
            'address:ntext',
            'email:email',
            'phone',
            'date_of_joining',
            'date_of_birth',
            [
            'label'=>'Department',
            'value'=>$model->designation->department->name
            ],
            [
            'label'=>'Designation',
            'value'=>$model->designation->name
            ],
            [
             'attribute' => 'login',
             'value' => (($model->login ==1) ? "Enabled": 'No login'),
            ],
            // 'user_id',
            // 'created_date',
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
</div>
