<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Profile */
?>
<div class="profile-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'full_name',
        ],
    ]) ?>

</div>
