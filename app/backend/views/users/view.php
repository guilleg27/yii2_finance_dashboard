<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Users */
?>
<div class="users-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'password',
            'email:email',
            'name',
            'lastname',
            'status',
            'user_type_id',
        ],
    ]) ?>

</div>
