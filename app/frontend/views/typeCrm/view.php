<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\TypeCrm */
?>
<div class="type-crm-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'type',
        ],
    ]) ?>

</div>
