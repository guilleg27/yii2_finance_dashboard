<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Client */
?>
<div class="client-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'client_type_id',
            'country_id',
            'type_crm_id',
        ],
    ]) ?>

</div>
