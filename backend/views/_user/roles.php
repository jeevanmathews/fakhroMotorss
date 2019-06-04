    <?php

    use yii\helpers\Html;
    use yii\grid\GridView;
    use yii\widgets\ActiveForm;
    /* @var $this yii\web\View */
    /* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title = 'Set Role';
    $this->params['breadcrumbs'][] = $this->title;
    ?>
    
    <div class="col-md-12">

        <?php $form = ActiveForm::begin(['action' => ['user/setroles'],'options' => ['method' => 'post']]); ?>
         <section class="content-header">
          <h1>
           Set Roles   
          </h1>
        </section>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
            ['class' => 'yii\grid\SerialColumn'],                
            'name',
            
                // ['class' => 'yii\grid\ActionColumn'],

            [
            'class' => 'yii\grid\RadioButtonColumn',
                    // 'checkboxOptions' => function ($model) use ($permitted) {
                        // var_dump($permitted);
                        // return in_array($model->id,$permitted)?['checked' => true] : [];//$model->id > 0 ? ['checked' => true] : [];
                    // },
            'name'  =>'role_id',
            'header' => Html::hiddeninput('selection_all', false, [
                'class' => 'select-on-check-all',
                'label' => 'Check All',
                ]),
            
            ],

            ],
'tableOptions' => [
        'id' => 'theDatatable',
        'class'=>'table table-striped table-bordered table-hover'
        ],
            ]); ?>
            <?= Html::hiddenInput('id', $user_id)?>
            <div class="form-group">
                <?= Html::submitButton('Set Roles', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>

    