<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\RolePermission */

$this->title = 'Create Role Permission';
$this->params['breadcrumbs'][] = ['label' => 'Role Permissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-permission-create">

   <section class="content-header">
      <h1>
        <?= Html::encode($this->title) ?>        
      </h1>
</section>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
