<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use frontend\models\Client;
use frontend\models\StatusCrm;
use frontend\models\Contact;
use frontend\models\User;
use frontend\models\Advertisers;
use frontend\models\TypeCrm;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model frontend\models\Crm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="crm-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'contact_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Contact::find()->all(), 'id', 'name'),
                'language' => 'es',
                'options' => ['placeholder' => 'Select a contact...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

    <?= $form->field($model, 'status_crm_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(StatusCrm::find()->all(), 'id', 'status'),
                'language' => 'es',
                'options' => ['placeholder' => 'Select a status ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'client_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Client::find()->all(), 'id', 'name'),
                'language' => 'es',
                'options' => ['placeholder' => 'Select a client ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

    <?= $form->field($model, 'user_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(User::find()->all(), 'id', 'username'),
                'language' => 'es',
                'options' => ['placeholder' => 'Select a user ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

    <?= $form->field($model, 'advertisers_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Advertisers::find()->all(), 'id', 'name'),
                'language' => 'es',
                'options' => ['placeholder' => 'Select a advertiser ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
  
    <?= $form->field($model, 'type_crm_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(TypeCrm::find()->all(), 'id', 'type'),
                'language' => 'es',
                'options' => ['placeholder' => 'Select a crm type ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
  
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
