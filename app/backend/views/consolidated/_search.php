<?php

use backend\models\BusinessModel;
use kartik\date\DatePicker;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\ConsolidatedSearch */
/* @var $form yii\widgets\ActiveForm */

$layout = <<< HTML
    <span class="input-group-addon">From </span>
    {input1}
    {separator}
    <span class="input-group-addon">To </span>
    {input2}
    <span class="input-group-addon kv-date-remove">
        <i class="glyphicon glyphicon-remove"></i>
    </span>
HTML;
?>

<div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><b>Filters</b></h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
          <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?php $form = ActiveForm::begin([
                'action' => ['admin'],
                'method' => 'get',
            ]); ?>
            <?php   echo '<label class="control-label">Date Range</label>';
                    echo DatePicker::widget([
                        'type' => DatePicker::TYPE_RANGE,
                        'name' => 'startDate',
                        'value' => $startDate,
                        // 'value' => date("F Y",strtotime($startDate)),
                        'name2' => 'endDate',
                        'value2' => $endDate,
                        // 'value2' => date("F Y",strtotime($endDate)),
                        'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
                        'layout' => $layout,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'startView'=>'year',
                            'minViewMode'=>'months',
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    echo '<br />';
                    echo Select2::widget([
                        'name'    => 'businessModelId',
                        'value'   => $businessModelId,
                        'data'    => ArrayHelper::map(BusinessModel::find()->orderBy('business_model')->all(), 'id', 'business_model'),
                        'options' => ['multiple' => true, 'placeholder' => 'Select Business Model'],
                        'pluginOptions' => [
                        ],
                    ]);
             ?>
            <br />
            <div class="form-group">
                <?= Html::submitButton('Filter', ['class' => 'btn btn-primary btn-md']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

