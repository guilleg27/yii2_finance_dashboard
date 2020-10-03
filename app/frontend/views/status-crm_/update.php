<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\StatusCrm */

$this->title = 'Update Status Crm: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Status Crms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="status-crm-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
