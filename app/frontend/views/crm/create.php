<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Crm */

$this->title = 'Crear nuevo seguimiento';
$this->params['breadcrumbs'][] = ['label' => 'Crms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="crm-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
