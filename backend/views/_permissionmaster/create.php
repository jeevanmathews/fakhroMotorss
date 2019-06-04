<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PermissionMaster */

$this->title = 'Create Permission Master';
$this->params['breadcrumbs'][] = ['label' => 'Permission Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-master-create">

   <section class="content-header">
      <h1>
        <?= Html::encode($this->title) ?>        
      </h1>
</section>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
