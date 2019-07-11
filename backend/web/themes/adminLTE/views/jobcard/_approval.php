<?php

use yii\helpers\Html;
use common\components\AutoForm;
use yii\helpers\ArrayHelper;
use backend\models\Tasks;
use backend\models\Employees;

/* @var $this yii\web\View */
/* @var $model backend\models\Jobcard */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="content-main-wrapper main-body" id="jobcard_approval">
    <section class="content">
    <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">   

        <div class="box-body">
        <div class="row">
        <div class="col-md-6">
            
            <table class="table table-striped table-bordered detail-view table-hover">
            <?php foreach ($pending_jobcards as $pending_jobcard) {

                echo "Jobcard No:" .$pending_jobcard->id ;

                echo "Materials : "."</br>";

                foreach ($pending_jobcard->materials as $jcmaterial) {
                    echo $jcmaterial->material->item_name. " " .$jcmaterial->num_unit;
                }

                echo "</hr>";
                
            } ?>
                
            </table>            
        </div> 
        </div>             
        </div>
        </div>
    </section>
</div>

<script type="text/javascript">

     
</script>
