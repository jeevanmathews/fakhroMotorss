<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Branches';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-main-wrapper main-body"  id="branches_index">
<div class="content-main-wrapper">

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
        <div class="col-md-12"> 
        <p>
            <?= Html::a('Create Branch', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'name',
                    'code',
                    //'mailing_name',
                    //'company.name',
                 
                    //'country_id',
                    // 'state',
                    // 'zipcode',
                    'phone',
                    'email:email',
                    //'fax',
                    'website',
                    //'cr_number',
                    //'cr_expiry',
                    //'vat_number',
                    //'vat_expiry',
                    //'branchtype_id',
                    //'created_at',
					[
						'label'=>'Logo',
						'format' => 'html',
						'value' => function($model){
							return Html::img("../../backend/web/uploads/branches/".$model->logo, ["class" => "img-responsive"]);
						}
					],

                    [
                    'attribute' => 'status',
                    'value' =>function ($model){
                        return ($model->status == 1)?"Enabled":"Disabled";
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'status', ["1"=>"Enable", "0" => "Disable"],['class'=>'form-control','prompt' => 'Search by Status']),
                    ],
					

                    ['class' => 'yii\grid\ActionColumn',
                    'template' => '{update}{view}{changeStatus}',
                    'buttons' => [
                            'changeStatus' => function ($url, $model, $key) {
                                 $img = ($model->status == 1)?"button_cross.png":"button_tick_alt.png";
                                 $width = ($model->status == 1)?"25":"20";
                                return Html::a(Html::img($this->theme->getUrl("images/".$img),["width" =>  $width, "title" => (($model->status == 1)?"Disable":"Enable")]), ['change-status', 'id'=>$model->id],['class'=>'change_status']);
                            },
                        ]
                    ],
                ],
                'tableOptions' => [
                'id' => 'theDatatable',
                'class'=>'table table-striped table-bordered table-hover'
            ],
            ]); ?>
        </div>
        </div>
        </div>
        </div>
          <!-- /.box -->
    </section>
</div>
</div>


