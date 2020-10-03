<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\FixedCostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fixed Costs';
$this->params['breadcrumbs'][] = $this->title;

$columns = require(__DIR__.'/_columns.php');

$fullExportMenu = ExportMenu::widget([
    'dataProvider'    => $dataProvider,
    'columns'         => $columns,
    'pjaxContainerId' => 'crud-datatable-pjax',
    'filename'        => 'fixed-costs',
    'target'          => ExportMenu::TARGET_BLANK,
    'fontAwesome'     => true,
    'clearBuffers'    => true,
    'exportConfig' => [
        ExportMenu::FORMAT_HTML => false,
        ExportMenu::FORMAT_PDF  => false,
        ExportMenu::FORMAT_TEXT => false,
    ],
    'dropdownOptions' => [
        'label' => 'Full',
        'class' => 'btn btn-default',
        'itemsBefore' => [
            '<li class="dropdown-header">Export All Data</li>',
        ],
    ],
]);

CrudAsset::register($this);
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

<div>
    <?= Html::a('Create Business Model', ['/business-model/index'], ['class'=>'btn btn-success','target'=>'_blank']) ?>    
    <?= Html::a('Create Cost Category', ['/cost-category/index'], ['class'=>'btn btn-success','target'=>'_blank']) ?>    
</div>
<br>
<div class="row">
    <div class="col-md-12">
      <div class="box box-default">
        <div class="box-body">
            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
            ]); ?>
            <?php   echo '<label class="control-label">Date Range</label>';
                    echo DatePicker::widget([
                        'type' => DatePicker::TYPE_RANGE,
                        'name' => 'startDate',
                        'value' => $startDate,
                        'name2' => 'endDate',
                        'value2' => $endDate,
                        'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
                        'layout' => $layout,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'startView'=>'year',
                            'minViewMode'=>'months',
                            'format' => 'yyyy-mm-dd'
                        ]
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

<div class="row">
    <div class="col-md-12">
      <div class="box box-default">
        <div class="box-body">
            <?= $this->render('_charts', ['data' => $chart]); ?>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
<div class="fixed-cost-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $columns,
            'pjax'=>true,
            'pjaxSettings' =>[
                'neverTimeout'=>true,
                'options'=>[
                        'id'=>'crud-datatable-pjax',
                    ]
                ], 
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                    ['role'=>'modal-remote','title'=> 'Create new Fixed Costs','class'=>'btn btn-default']).
                    // Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    // ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                    '{export}'.$fullExportMenu,
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'primary', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Fixed Costs listing',
                'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                'after'=>BulkButtonWidget::widget([
                            'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Delete All',
                                ["bulk-delete"] ,
                                [
                                    "class"=>"btn btn-danger btn-xs",
                                    'role'=>'modal-remote-bulk',
                                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                    'data-request-method'=>'post',
                                    'data-confirm-title'=>'Are you sure?',
                                    'data-confirm-message'=>'Are you sure want to delete this item'
                                ]),
                        ]).                        
                        '<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>

