<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\TypeCrm;
use frontend\models\GeoLocation;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model frontend\models\Contact */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contact-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'country_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(GeoLocation::find()->where(['type'=>'country'])->all(), 'id_location', 'name'),
                'language' => 'es',
                'options' => ['placeholder' => 'Select a country ...'],
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
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
