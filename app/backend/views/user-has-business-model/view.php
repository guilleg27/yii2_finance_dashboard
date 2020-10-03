<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\UserHasBusinessModel */
?>
<div class="user-has-business-model-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user_id',
            'business_model_id',
        ],
    ]) ?>

</div>
