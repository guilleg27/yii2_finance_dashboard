<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use frontend\models\GeoLocation;
use backend\models\BusinessModel;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $model backend\models\UserHasBusinessModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-has-business-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(User::find()->all(), 'id', 'username'),
                'language' => 'es',
                'options' => ['placeholder' => 'Select a user ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

    <?= $form->field($model, 'business_model_id')->widget(Select2::classname(), [
				'data'          => ArrayHelper::map(BusinessModel::find()->all(), 'id', 'business_model'),
				'language'      => 'es',
				'options'       => ['placeholder' => 'Select a business model ...'],
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
