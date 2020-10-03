<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\ClientType */
?>
<div class="client-type-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'type',
            'type_crm_id',
        ],
    ]) ?>

</div>
