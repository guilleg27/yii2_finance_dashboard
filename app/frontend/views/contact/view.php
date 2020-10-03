<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Contact */
?>
<div class="contact-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'mail',
            'phone',
            'country_id',
            'type_crm_id',
        ],
    ]) ?>

</div>
