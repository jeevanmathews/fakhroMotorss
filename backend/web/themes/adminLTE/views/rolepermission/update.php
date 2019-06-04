<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\RolePermission */

$this->title = 'Update Role Permission: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Role Permissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="role-permission-update">

  <section class="content-header">
      <h1>
        <?= Html::encode($this->title) ?>        
      </h1>
</section>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
