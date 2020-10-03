<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
//Agregar gif de carga de modal
// echo "<div id='modalContent'><div style="text-align:center"><img src="my/path/to/loader.gif"></div></div>";
echo "<div id='modalContent'></div>";
yii\bootstrap\Modal::end();
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->


        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    // ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    // ['label' => 'CRM', 'url' => ['/crm']],
                    ['label' => 'Finance Consolidated', 'url' => ['/consolidated/admin'], 'visible' => Yii::$app->user->can('consolidated/admin')],
                    ['label' => 'Fixed Costs', 'url' => ['/fixed-cost'], 'visible' => Yii::$app->user->can('fixed-cost/admin')],
                    ['label' => 'Admin User', 'url' => ['/user/admin'], 'visible' => Yii::$app->user->can('user/admin')],
                    ['label' => 'Login', 'url' => ['user/login'], 'visible' => Yii::$app->user->isGuest],
                    ['label' => 'Logout', 'icon' => 'sign-out' ,'url' => ['site/logout'], 'visible' => !Yii::$app->user->isGuest],
                ],
            ]
        ) ?>

    </section>

</aside>
