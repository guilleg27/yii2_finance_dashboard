<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use backend\models\BusinessModel;
use backend\models\CostCategory;

/* @var $this yii\web\View */
/* @var $model backend\models\FixedCost */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fixed-cost-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'period')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Enter Period'],
        'pluginOptions' => [
            'autoclose' => true,
            'startView'=>'year',
            'minViewMode'=>'months',
            'format' => 'yyyy-mm-dd'
        ]
    ]); ?>

    <?= $form->field($model, 'business_model_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(BusinessModel::find()->orderBy('business_model')->all(), 'id', 'business_model'),
                'language' => 'es',
                'options' => ['placeholder' => 'Select a Business Model'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

    <?= $form->field($model, 'cost_category_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(CostCategory::find()->orderBy('cost_category')->all(), 'id', 'cost_category'),
                'language' => 'es',
                'options' => ['placeholder' => 'Select a Category'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
  
    <?= $form->field($model, 'cost')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>
    
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
