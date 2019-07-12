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
            
            
            <?php if($pending_jobcards) {
                foreach ($pending_jobcards as $pending_jobcard) {                
                if($pending_jobcard->materials) {
                    echo "<h5>Jobcard No : " .$pending_jobcard->id ."</h5>";
                    echo "<h5>Materials : ".Html::button("Approve", ["class" => "btn btn-default", "onclick" => "reduceStock(".$pending_jobcard->id.")"])."</h5>"."</br>";
                    echo '<table class="table table-striped table-bordered detail-view table-hover">';
                    echo "<thead><th>Material Name</th><th>Quantity</th></thead>";
                    foreach ($pending_jobcard->materials as $jcmaterial) {
                        echo "<tr><td>".Html::a($jcmaterial->material->item_name, ['items/view', 'id' => $jcmaterial->material->id]). "</td><td>" .$jcmaterial->num_unit."</td></tr>";
                    }
                    echo "</table>";
                    echo "<hr/>";
                }
                
            } } else{
                echo "<div class='alert alert-info'>Sorry, No Jobcards for Pending Approval !</div>";
            } ?>
                        
        </div> 
        </div>             
        </div>
        </div>
    </section>
</div>


