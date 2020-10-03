<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Consolidated */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Consolidateds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consolidated-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'business_model',
            'period',
            'revenue_server',
            'revenue_transaction',
            'agency_commission',
            'revenue_validated',
            'revenue_invoiced',
            'revenue_manual',
            'spend_server',
            'spend_off',
            'spend_transaction',
            'spend_validated',
            'spend_invoiced',
            'spend_manual',
            'profit_manual',
            'objective_revenue',
            'objective_profit',
        ],
    ]) ?>

</div>
