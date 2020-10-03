<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CostCategory */
?>
<div class="cost-category-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'cost_category',
        ],
    ]) ?>

</div>
