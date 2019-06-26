<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use common\components\AutoForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employee Roles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-main-wrapper main-body">

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
        <div class="col-md-4"> 
            <h5 class="heading"><span>Employee Details</span> </h5>
            <?= DetailView::widget([
            'model' => $model,
            'attributes' => [  
                'fullname',       
                'phone',          
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
            ],
            ]) ?>
        </div>
        <div class="col-md-8">
            <h5 class="heading"><span>Active Roles</span> </h5> 
            <?php $form = AutoForm::begin(["id" => "assign_roles-".time()]); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'name',
                        'label' => 'Role',
                        'value' => function($model){
                            return $model->name;
                        }    
                    ],              
                    ['class' => 'yii\grid\ActionColumn',
                    'template' => '{my_button}', 
                    'buttons' => [
                        'my_button' => function ($url, $model, $key) use ($userRoles) {
                         
                           return Html::checkbox('roles[]', (in_array($model->id, $userRoles)?true:false), ['value' => $model->id]);         
                        },
                    ]
                    ],
             
                ],
                'tableOptions' => [
                'id' => 'theDatatable',
                'class'=>'table table-striped table-bordered table-hover'
                ],
            ]); ?>
            <div class="box-footer">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

            <?php AutoForm::end(); ?>
        </div>
        </div>
        </div>
        </div>
          <!-- /.box -->
    </section>
</div>
