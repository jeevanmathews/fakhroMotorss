<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BranchesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Branches';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-main-wrapper branches-index main-body">
<section class="content-header">
      <h1>
        <?= Html::encode($this->title) ?>        
      </h1>
    </section>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
 
    <section class="content">
    <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">   

        <div class="box-body">
        <div class="row">
        <div class="col-md-12"> 
    <p>
        <?= Html::a('Create Branches', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'company_id',
            'name',
            'code',
            'mailing_name',
            //'address:ntext',
            //'country_id',
            //'state',
            //'zipcode',
            //'phone',
            //'email:email',
            //'fax',
            //'website',
            //'cr_number',
            //'cr_expiry',
            //'vat_number',
            //'vat_expiry',
            //'branchtype_id:ntext',
            //'created_at',
            //'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
        </div>
        </div>
        </div>
          <!-- /.box -->
    </section>
</div>
