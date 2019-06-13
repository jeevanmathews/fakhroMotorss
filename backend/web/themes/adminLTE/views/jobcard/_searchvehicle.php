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
                                ['class' => 'yii\grid\SerialColumn'],
                                'reg_num',                               
                                 [
                                    'attribute' => 'chasis_num',
                              
                                    'value' =>function ($model){
                                        return substr($model->chasis_num, 0, 8)."...";
                                    }
                                ],
                                'make',
                                'model',
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

    var vehicle_ary = ['jobcardvehicle-reg_num', 'jobcardvehicle-chasis_num', 'jobcardvehicle-make', 'jobcardvehicle-model', 'jobcardvehicle-color'];

    $(document).on('click', "[class='jobc-vehicle']", function(){
        $(this).closest("tr").children().each(function(index){
            if($.inArray(index, [0,1])){
                $("#"+vehicle_ary[index-1]).val($(this).html());
                console.log(vehicle_ary[index-1]);
            }
        })
        $(".close-modal").trigger("click");
    });
</script>
