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
       Customer Search
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
                            <?= Html::textInput("cus_name", "", ['placeholder' => 'Customer Name', 'id' => 'cus_name'])?>

                            <?= Html::button('Search', ['class' => 'btn btn-success', 'id' => 'advanced_search']) ?>
                        </p>
                  
                        <?php \yii\widgets\Pjax::begin(); ?>
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,                            
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                'name',
                                'contact_name',
                                'contact_number',
                                'email',                            
                                ['class' => 'yii\grid\ActionColumn',
                                  'template' => '{select}',
                                  'buttons' => [
                                    'select' => function ($url, $model, $key) {
                                        return Html::button('select', ['class' => 'jobc-customer']);
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
    $(document).on('click', "[id='advanced_search']", function(){    
        searchCustomer();
    });
    $(document).on('keyup', "[id='cus_name']", function(){  
        searchCustomer();
    });
    function searchCustomer(){
        $.ajaxSetup({async: false}); 
        $.post('<?=Yii::$app->getUrlManager()->createUrl(['jobcard/search-customer'])?>', {cus_name: $("#cus_name").val()})
        .done(function( data ) {
            $(".grid-view").html($(data).find(".grid-view").html());  
        });
        $.ajaxSetup({async: true});
    }
    var cus_ary = ['customer-name', 'customer-contact_name', 'customer-contact_number', 'customer-email'];
    $(document).on('click', "[class='jobc-customer']", function(){
        $(this).closest("tr").children().each(function(index){
            if($.inArray(index, [0,1])){
                $("#"+cus_ary[index-1]).val($(this).html());
                console.log(cus_ary[index-1]);
            }
        })
        $(".close-modal").trigger("click");
    });
</script>
