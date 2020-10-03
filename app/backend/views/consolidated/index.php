<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ConsolidatedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Consolidated';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consolidated-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('Create Consolidated', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'business_model',
            'period',
            'revenue_server',
            'revenue_transaction',
            // 'agency_commission',
            // 'revenue_validated',
            // 'revenue_invoiced',
            // 'revenue_manual',
            // 'spend_server',
            // 'spend_off',
            // 'spend_transaction',
            // 'spend_validated',
            // 'spend_invoiced',
            // 'spend_manual',
            // 'profit_manual',
            // 'objective_revenue',
            // 'objective_profit',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
