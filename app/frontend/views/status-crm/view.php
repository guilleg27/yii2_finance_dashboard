<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\StatusCrm */
?>
<div class="status-crm-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'status',
            'level',
            'type_crm_id',
        ],
    ]) ?>

</div>
