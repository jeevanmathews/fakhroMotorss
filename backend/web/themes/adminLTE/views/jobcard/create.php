<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Jobcard */

$this->title = 'Create Jobcard';
$this->params['breadcrumbs'][] = ['label' => 'Jobcards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-main-wrapper main-body" id="jobcard_create">
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= Html::encode($this->title) ?>        
      </h1>
    </section>

     <section class="content">
      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">  

		<ul class="nav nav-tabs" id="myTab" role="tablist">
		  	<li class="nav-item <?php if($activeTab == "job-card"){echo 'active';}?>">
		    <a class="nav-link <?php if($activeTab == "job-card"){echo 'active';}?>" id="job-card-tab" data-toggle="tab" href="#job-card" role="tab" aria-controls="jobcard" aria-selected="true">
		    <span>Job Card</span></a>
		  	</li>
		  	<li class="nav-item <?php if($activeTab == "task"){echo 'active';}?>">
		    <a class="nav-link <?php if($activeTab == "task"){echo 'active';}?>" id="task-tab" data-toggle="tab" href="#task" role="tab" aria-controls="task" aria-selected="false"><span>Jobcard Tasks</span></a>
		  	</li>
		  	<li class="nav-item <?php if($activeTab == "material"){echo 'active';}?>">
		    <a class="nav-link <?php if($activeTab == "material"){echo 'active';}?>" id="material-tab" data-toggle="tab" href="#material" role="tab" aria-controls="material" aria-selected="false"><span>Materials</span></a>
		  	</li>
		</ul>
		<div class="tab-content" id="myTabContent">
		  	<div class="tab-pane <?php if($activeTab == "job-card"){echo 'active';}?>" id="job-card" role="tabpanel" aria-labelledby="home-tab">
		  		<?= $this->render('_form', [
			        'model' => $model,
			        'vehicle' => $vehicle,
			        'customer' => $customer
			    ]) ?>
		  	</div>
		  	<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
		  	</div>
		  	<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
		  	</div>
		</div>
	</div>
        <!-- /.box -->
    </section>
</div>
