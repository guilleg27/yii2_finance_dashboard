<?php 

use kartik\grid\GridView;
use yii\bootstrap\Progress;
use kartik\export\ExportMenu;

$gridColumnsNonInvoicedRevenue = require(__DIR__.'/grid-columns/_nonInvoicedRevenue.php');

$fullExportMenu = ExportMenu::widget([
    'dataProvider'    => $dataProviderPendingInvoiceRevenue,
    'columns'         => $gridColumnsNonInvoicedRevenue,
    'pjaxContainerId' => 'kv-non-invoiced-revenue',
    'filename'        => 'grid-non-invoiced-revenue',
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

?>
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Revenue Info</h3>
          <div class="box-tools pull-right">
            <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button> -->
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Stats</a></li>
              <li><a href="#tab_2" data-toggle="tab">Invoiced By Month</a></li>
              <li><a href="#tab_3" data-toggle="tab">Non Invoiced</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <div class="row">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-sm-3 col-xs-6">
                        <div class="description-block border-right">
                          <span class="description-percentage text-black"><h2>$<?=number_format($totalSum["revenue"]["to_validate"],2)?></h2></span>
                          <span class="description-text">TOTAL REVENUE</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-3 col-xs-6">
                        <div class="description-block border-right">
                          <span class="description-percentage text-green"><h2><?=$avgRevenue["validated"]?>%</h2></span>
                          <h5 class="description-header">$<?=number_format($totalSum["revenue"]["validated"],2)?></h5>
                          <span class="description-text">VALIDATED</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-3 col-xs-6">
                        <div class="description-block border-right">
                          <span class="description-percentage text-yellow"><h2><?=$avgRevenue["not_validated"]?>%</h2></span>
                          <h5 class="description-header">$<?=number_format($totalSum["revenue"]["not_validated"],2)?></h5>
                          <span class="description-text">NOT VALIDATED</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-3 col-xs-6">
                        <div class="description-block">
                          <span class="description-percentage text-red"><h2><?=$avgRevenue["invoiced"]?>%</h2></span>
                          <h5 class="description-header">$<?=number_format($totalSum["revenue"]["invoiced"],2)?></h5>
                          <span class="description-text">INVOICED</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                    </div>
                    <!-- /.row -->
                  </div>
                  <!-- /.col -->
                </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <!-- /.box-header -->
                <div class="box-body no-padding">
                <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        // 'filterModel' => $searchModel,
                        'layout' => '{items}{pager}',
                        'autoXlFormat'=>true,
                        'export'=>[
                            'fontAwesome'=>true,
                            'showConfirmAlert'=>false,
                            'target'=>GridView::TARGET_BLANK
                        ],
                        'columns' => [
                            [
                                'attribute'=>'businessModelName',
                                'value'=>'businessModelName',
                                'vAlign'=>'middle',
                                'width'=>'250px',
                            ],
                            [
                                'attribute'=>'period',
                                'vAlign'=>'middle',
                                'width'=>'250px',
                                'format'=>['date', 'php:M Y']
                            ],
                            // 'avgInvoicedRevenue',
                            [
                              'attribute'=>'avgInvoicedRevenue',
                              'content' => function($data) {
                                  return Progress::widget([
                                      // 'percent' => $data->avgInvoicedRevenue,
                                      'barOptions' => [
                                          'class' => 'progress-bar-danger',
                                          "style"=>"min-width: 4%; width: ".number_format(round($data->avgInvoicedRevenue, 3), 0)."%", 
                                          "aria-valuemin"=>0, 
                                          "aria-valuemax"=>100
                                        ],
                                      'label' => number_format(round($data->avgInvoicedRevenue, 3), 0).'%',
                                  ]);
                                },
                            ], 
                        ],
                        'pjax'=>true,
                        'pjaxSettings' =>[
                            'neverTimeout'=>true,
                            'options'=>[
                                    'id'=>'kv-unique-id-1',
                                ]
                            ], 
                        // 'panel'=>[
                        //     'type'=>'info',
                        // ]
                    ]); 
                ?>
                <!-- /.row -->
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
                <?= GridView::widget([
                    'dataProvider' => $dataProviderPendingInvoiceRevenue,
                    'columns'      => $gridColumnsNonInvoicedRevenue,
                    'pjax'=>true,
                    'pjaxSettings' =>[
                        'neverTimeout'=>true,
                        'options'=>[
                                'id'=>'kv-non-invoiced-revenue',
                            ]
                        ], 
                    'panel'=>[
                        'type'=>'danger',
                    ],
                    'export' => [
                        'label' => 'Page',
                        'fontAwesome' => true,
                    ],
                    'exportConfig' => [
                        GridView::CSV => ['filename' => ('grid-non-invoiced-revenue'),],
                        GridView::EXCEL => ['filename' => ('grid-non-invoiced-revenue'),],
                    ],
                    // your toolbar can include the additional full export menu
                    'toolbar' => [
                        '{export}',
                        $fullExportMenu,
                    ]
                ]); ?>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        <!-- ./box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
