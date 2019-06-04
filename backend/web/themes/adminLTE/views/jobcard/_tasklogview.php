<?php

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Jobcard */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="content-main-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Task Logs 
      </h1>
    </section>
    
    <section class="content">
    <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">   

        <div class="box-body">
        <div class="row">
            <div class="col-md-12"> 
                <div class="row">
                    <div class="col-md-12">                 
                       <?= GridView::widget([
                        'dataProvider' => $taskdlogdataProvider,                
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'], 
                            'date', 
                            'status', 
                            ['class' => 'yii\grid\ActionColumn',
                            'template' => '',                        
                            ],
                        ],                   
                        ]); ?>  
                    </div>
                </div>             
        </div>
        </div>
        </div>
        </div>
          <!-- /.box -->
    </section>
</div>