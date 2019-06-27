<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\components\AutoForm;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Manufacturer */

$this->title = 'Import Manufacturer';
$this->params['breadcrumbs'][] = ['label' => 'Import', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manufacturer-import main-body" id="manufacturer_import">
  <?= Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>
    <div class="content-main-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          <?= Html::encode($this->title) ?>        
        </h1>
      </section>

      <section class="content">
       <!-- SELECT2 EXAMPLE -->
       <div class="box box-default">	  
        <!-- <form enctype="multipart/form-data" action="/fakhroMotors/backend/web/index.php?r=manufacturer/import"> -->
        <?php $form = AutoForm::begin(["id" => "manufacturer-import-form"],'',['options' => ['enctype' => 'multipart/form-data']]); ?>
          <div class="box-body">
            <div class="row">           
              <div class="col-md-5 col-md-offset-3"> 
                <!-- <?= Html::fileInput('importfile','',['class'=>'form-control']);?> -->
                <?= $form->field($model, 'importfile')->fileInput(['class'=>'form-control']) ?>
              </div>
            </div>
          </div>
          <div class="box-footer">
            <?= Html::Button('Save', ['class' => 'btn btn-success','onclick'=>'send()']) ?>
          </div>
        <!-- </form> -->
        <?php AutoForm::end(); ?> 

      </div>
    </section>
  </div>
</div>
<script type="text/javascript">
// this script for collecting the form data and pass to the controller action and doing the on success validations
function send(){
    var formData = new FormData($("#manufacturer-import-form"));
    console.log(formData);exit;
    // $.ajax({
    //     url: '<?php echo Yii::$app->getUrlManager()->createUrl("forumPost/uploadPost"); ?>',
    //     type: 'POST',
    //     data: formData,
    //     datatype:'json',
    //     // async: false,
    //     beforeSend: function() {
    //         // do some loading options
    //     },
    //     success: function (data) {
    //       // on success do some validation or refresh the content div to display the uploaded images 
    //   jQuery("#list-of-post").load("<?php echo Yii::$app->getUrlManager()->createUrl('//forumPost/forumPostDisplay'); ?>");
    //     },

    // complete: function() {
    //         // success alerts
    //     },

    //     error: function (data) {
    //       alert("There may a error on uploading. Try again later";)
    //     },
    //     cache: false,
    //     contentType: false,
    //     processData: false
    // });

    // return false;
}
</script>