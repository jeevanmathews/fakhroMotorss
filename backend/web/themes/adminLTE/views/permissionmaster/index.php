    <?php

    use yii\helpers\Html;
    use yii\grid\GridView;

    /* @var $this yii\web\View */
    /* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title = 'Permission Master';
    $this->params['breadcrumbs'][] = $this->title;
    ?>
    <div class="permission-master-index">

<section class="content-header">
      <h1>
        <?= Html::encode($this->title) ?>        
      </h1>
</section>

        <p>
            <?= Html::a('Create Permission Master', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php //var_dump($dataProvider);?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],                
                'module',
                'action',
                // ['class' => 'yii\grid\ActionColumn'],
            ],
            'tableOptions' => [
        'id' => 'theDatatable',
        'class'=>'table table-striped table-bordered table-hover'
        ],
        ]); ?>
    </div>
