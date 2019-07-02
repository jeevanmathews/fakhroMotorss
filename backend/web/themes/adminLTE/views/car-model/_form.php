<?php

use yii\helpers\Html;
use common\components\AutoForm;
use backend\models\Manufacturer;
use backend\models\Make;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\CarModel */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = AutoForm::begin(["id" => "model-".time().(($model->isNewRecord)?"create":"update")."-form"]); ?>
    <div class="box-body">
        <div class="row"> 
            <div class="col-md-6">           
            <?= $form->field($model, 'make_id')->dropDownList(ArrayHelper::map(Manufacturer::find()->where(['status' => 1])->all(), 'id', 'name')) ?>

            <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'status')->dropDownList([ '0' => 'Disable', '1' => 'Enable', ], ['prompt' => '']) ?> 
            </div>
        </div>
    </div>
    <!-- /.box-body -->  
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php AutoForm::end(); ?>
