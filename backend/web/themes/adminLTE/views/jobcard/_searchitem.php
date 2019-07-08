<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\JobcardVehicleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jobcard Vehicles';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="content-main-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Material Search ( Type : <?php echo $searchModel->type;?>)
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
                        <p>                            
                            <?= Html::textInput("item_name", "", ['placeholder' => 'Material Name', 'id' => 'item_name'])?>

                            <?= Html::button('Search', ['class' => 'btn btn-success', 'id' => 'advanced_search_item']) ?>
                        </p>                  
                   
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'options' => ['class' => 'grid-view modal-grid'],
                            'id' => $page_id,
                            'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],                       
                            'namewithPrice',                            
                            ['class' => 'yii\grid\ActionColumn',
                              'template' => '{select}',
                              'buttons' => [                                    
                                'select' => function ($url, $model, $key) {
                                    return Html::button('select', ['class' => 'jobc-item', 'onclick' => 'selectItem("'.$model->namewithPrice.'", '.$model->id.');']);
                                },         
                                ]
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


