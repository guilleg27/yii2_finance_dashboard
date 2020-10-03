<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\StatusCrm */

$this->title = 'Create Status Crm';
$this->params['breadcrumbs'][] = ['label' => 'Status Crms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="status-crm-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
