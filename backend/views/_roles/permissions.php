    <?php

    use yii\helpers\Html;
    use yii\grid\GridView;
    use yii\widgets\ActiveForm;
    /* @var $this yii\web\View */
    /* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title = 'Set Permission';
    $this->params['breadcrumbs'][] = $this->title;
    ?>
    
    <div class="col-md-8">

        <?php $form = ActiveForm::begin(['action' => ['rolepermission/create'],'options' => ['method' => 'post']]); ?>
       <section class="content-header">
          <h1>
            Set Permission        
          </h1>
        </section>
        <!-- <h3>Set Permission</h3> -->
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
            ['class' => 'yii\grid\SerialColumn'],                
            'module',
            'action',
                // ['class' => 'yii\grid\ActionColumn'],

            [
            'class' => 'yii\grid\CheckboxColumn',
                    // 'checkboxOptions' => function ($model) use ($permitted) {
                        // var_dump($permitted);
                        // return in_array($model->id,$permitted)?['checked' => true] : [];//$model->id > 0 ? ['checked' => true] : [];
                    // },
            'name'  =>'permission_id',
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
            <?= Html::hiddenInput('role_id', $role_id)?>
            <div class="form-group">
                <?= Html::submitButton('Set Permission', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>

        <div class="permission-master-index col-md-4">
            <section class="content-header">
          <h1>
           Permitted Actions      
          </h1>
        </section>
            <!-- <h3>Permitted Actions</h3> -->
            <?= GridView::widget([
                'dataProvider' => $permitted,
                'columns' => [
                ['class' => 'yii\grid\SerialColumn'],                
                'module',
                'action',
                // ['class' => 'yii\grid\ActionColumn'],

                // [
                //     'class' => 'yii\grid\CheckboxColumn',
                //     'checkboxOptions' => function ($model) use ($permitted) {
                //         // var_dump($permitted);
                //         // return in_array($model->id,$permitted)?['checked' => true] : [];//$model->id > 0 ? ['checked' => true] : [];
                //     },
                //     'name'  =>'permission_id',
                //     'header' => Html::checkBox('selection_all', false, [
                //         'class' => 'select-on-check-all',
                //         'label' => 'Check All',
                //     ]),
                
                // ],

                ],
'tableOptions' => [
        'id' => 'theDatatable',
        'class'=>'table table-striped table-bordered table-hover'
        ],
                ]); ?>

            </div>