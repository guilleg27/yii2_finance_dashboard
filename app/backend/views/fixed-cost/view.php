<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\FixedCost */
?>
<div class="fixed-cost-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'period',
            'businessModel.business_model',
            'costCategory.cost_category',
            'cost',
            'description:ntext',
        ],
    ]) ?>

</div>
