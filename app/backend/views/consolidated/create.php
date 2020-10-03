<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Consolidated */

$this->title = 'Create Consolidated';
$this->params['breadcrumbs'][] = ['label' => 'Consolidateds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consolidated-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
