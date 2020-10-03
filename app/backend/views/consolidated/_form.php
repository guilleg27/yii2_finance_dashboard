<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Consolidated */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="consolidated-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'business_model')->dropDownList([ 'Branding' => 'Branding', 'Performance' => 'Performance', 'Exchange' => 'Exchange', 'Branding Development' => 'Branding Development', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'period')->textInput() ?>

    <?= $form->field($model, 'revenue_server')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'revenue_transaction')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'agency_commission')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'revenue_validated')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'revenue_invoiced')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'revenue_manual')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'spend_server')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'spend_off')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'spend_transaction')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'spend_validated')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'spend_invoiced')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'spend_manual')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'profit_manual')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'objective_revenue')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'objective_profit')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
