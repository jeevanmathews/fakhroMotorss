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
       Vehicle Search
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
                            <?= Html::textInput("reg_num", "", ['placeholder' => 'Veh.Reg. Number', 'id' => 'reg_num'])?>

                            <?= Html::button('Search', ['class' => 'btn btn-success', 'id' => 'advanced_search']) ?>
                        </p>
                  
                        <?php \yii\widgets\Pjax::begin(); ?>
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,                            
                            'columns' => [
                                //['class' => 'yii\grid\SerialColumn'],
                                'reg_num',                               
                                 [
                                    'attribute' => 'chasis_num',
                                    'format' => 'html',    
                                    'value' =>function ($model){
                                        return substr($model->chasis_num, 0, 3)."..."."<span class='hide'>".$model->chasis_num."</span>";
                                    }
                                ],
                                [
                                    'label' => 'Manufacturer',
                                    'format' => 'html',
                                    'value' =>function ($model){
                                        return utf8_decode($model->make->manufacturer->name)."<span class='hide'>".$model->make->manufacturer_id."</span>";
                                    }
                                ], 
                                [
                                    'label' => 'Make',
                                    'format' => 'html',
                                    'value' =>function ($model){
                                        return utf8_decode($model->make->make)."<span class='hide'>".$model->make_id."</span>";
                                    }
                                ],  
                                [
                                    'label' => 'Model',
                                    'format' => 'html',
                                    'value' =>function ($model){
                                        return utf8_decode($model->model->model)."<span class='hide'>".$model->model_id."</span>";
                                    }
                                ], 
                                'color',
                                ['class' => 'yii\grid\ActionColumn',
                                  'template' => '{select}',
                                  'buttons' => [
                                    'select' => function ($url, $model, $key) {
                                        return Html::button('select', ['class' => 'jobc-vehicle']);
                                    },        
                                    ]
                                ],
                            ],
                        ]); ?>
                        <?php \yii\widgets\Pjax::end(); ?>
                       
                    </div>
                </div>             
        </div>
        </div>
        </div>
        </div>
          <!-- /.box -->
    </section>
</div>

<script type="text/javascript">
    $(document).on('keyup', "[id='advanced_search']", function(){    
        searchVehicle();
    });
    $(document).on('keyup', "[id='reg_num']", function(){
        searchVehicle();
    });

    function searchVehicle(){
        $.ajaxSetup({async: false}); 
        $.post('<?=Yii::$app->getUrlManager()->createUrl(['jobcard/search-vehicle'])?>', {reg_num: $("#reg_num").val()})
        .done(function( data ) {
            $(".grid-view").html($(data).find(".grid-view").html());  
        });
        $.ajaxSetup({async: true});
    }

    var vehicle_ary = ['jobcardvehicle-reg_num', 'jobcardvehicle-chasis_num', 'jobcardvehicle-manufacturer', 'jobcardvehicle-make_id', 'jobcardvehicle-model_id', 'jobcardvehicle-color'];

    $(document).on('click', "[class='jobc-vehicle']", function(){
        $(this).closest("tr").children().each(function(index){
                if($(this).html().indexOf('<span class="hide">') != -1){
                    var col_val = $(this).html().substring($(this).html().indexOf('<span class="hide">'), $(this).html().indexOf('</span>'));
                    col_val = col_val.replace('<span class="hide">',"");
                    console.log(vehicle_ary[index]);
                    $("#"+vehicle_ary[index]).val(col_val);
                    if(vehicle_ary[index] == "jobcardvehicle-manufacturer"){
                        $("#"+vehicle_ary[index]).val(col_val).trigger("change");
                    }else if(vehicle_ary[index] == "jobcardvehicle-make_id"){console.log("34"+col_val)
                        $("#"+vehicle_ary[index]).val(col_val).trigger("change");
                    }
                }else{
                    $("#"+vehicle_ary[index]).val($(this).html());
                } 
        })
        $(".close-modal").trigger("click");
    });
</script>
