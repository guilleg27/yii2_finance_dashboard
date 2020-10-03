<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\BusinessModel */
?>
<div class="business-model-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'business_model',
        ],
    ]) ?>

</div>
