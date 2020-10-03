<?php 

use kartik\grid\GridView;
use yii\bootstrap\Progress;
use kartik\export\ExportMenu;

$gridColumnsNonInvoicedSpend = require(__DIR__.'/grid-columns/_nonInvoicedSpend.php');

$fullExportMenu = ExportMenu::widget([
    'dataProvider'    => $dataProviderPendingInvoiceSpend,
    'columns'         => $gridColumnsNonInvoicedSpend,
    'pjaxContainerId' => 'kv-non-invoiced-spend',
    'filename'        => 'grid-non-invoiced-spend',
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
          <h3 class="box-title">Spend Info</h3>
          <div class="box-tools pull-right">
            <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button> -->
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#spend_tab_1" data-toggle="tab">Stats</a></li>
              <li><a href="#spend_tab_2" data-toggle="tab">Invoiced By Month</a></li>
              <li><a href="#spend_tab_3" data-toggle="tab">Non Invoiced</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="spend_tab_1">
                <div class="row">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-sm-3 col-xs-6">
                        <div class="description-block border-right">
                          <span class="description-percentage text-black"><h2>$<?=number_format($totalSum["spend"]["to_validate"],2)?></h2></span>
                          <span class="description-text">TOTAL SPEND</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-3 col-xs-6">
                        <div class="description-block border-right">
                          <span class="description-percentage text-green"><h2><?=$avgSpend["validated"]?>%</h2></span>
                          <h5 class="description-header">$<?=number_format($totalSum["spend"]["validated"],2)?></h5>
                          <span class="description-text">VALIDATED</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-3 col-xs-6">
                        <div class="description-block border-right">
                          <span class="description-percentage text-yellow"><h2><?=$avgSpend["not_validated"]?>%</h2></span>
                          <h5 class="description-header">$<?=number_format($totalSum["spend"]["not_validated"],2)?></h5>
                          <span class="description-text">NOT VALIDATED</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-3 col-xs-6">
                        <div class="description-block">
                          <span class="description-percentage text-red"><h2><?=$avgSpend["invoiced"]?>%</h2></span>
                          <h5 class="description-header">$<?=number_format($totalSum["spend"]["invoiced"],2)?></h5>
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
              <div class="tab-pane" id="spend_tab_2">
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <?=
                      GridView::widget([
                          'dataProvider' => $dataProvider,
                          // 'filterModel' => $searchModel,
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
                              [
                                'attribute'=>'avgInvoicedSpend',
                                'content' => function($data) {
                                    return Progress::widget([
                                        // 'percent' => $data->avgInvoicedSpend,
                                        'barOptions' => [
                                            'class' => 'progress-bar-info',
                                            "style"=>"min-width: 4%; width: ".number_format(round($data->avgInvoicedSpend, 3), 0)."%", 
                                            "aria-valuemin"=>0, 
                                            "aria-valuemax"=>100
                                          ],
                                        'label' => number_format(round($data->avgInvoicedSpend, 3), 0).'%',
                                    ]);
                                  },
                              ], 
                          ],
                          'pjax'=>true,
                          'pjaxSettings' =>[
                              'neverTimeout'=>true,
                              'options'=>[
                                      'id'=>'kv-unique-id-3',
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
              <div class="tab-pane" id="spend_tab_3">
                <?= GridView::widget([
                    'dataProvider' => $dataProviderPendingInvoiceSpend,
                    'columns'      => $gridColumnsNonInvoicedSpend,
                    'pjax'=>true,
                    'pjaxSettings' =>[
                        'neverTimeout'=>true,
                        'options'=>[
                                'id'=>'kv-non-invoiced-spend',
                            ]
                        ], 
                    'panel'=>[
                        'type'=>'info',
                    ],
                    'export' => [
                        'label' => 'Page',
                        'fontAwesome' => true,
                    ],
                    'exportConfig' => [
                        GridView::CSV => ['filename' => ('grid-non-invoiced-spend'),],
                        GridView::EXCEL => ['filename' => ('grid-non-invoiced-spend'),],
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

  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Spend Details</h3>
          <div class="box-tools pull-right">
            <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button> -->
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#spend_details_tab_1" data-toggle="tab">General</a></li>
              <li><a href="#spend_details_tab_2" data-toggle="tab">Invoiced Media</a></li>
              <!-- <li><a href="#spend_details_tab_3" data-toggle="tab">Non Invoiced</a></li> -->
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="spend_details_tab_1">
                <div class="row">
                  <div class="col-md-4">
                    <div class="row">
                    <?=
                      \dosamigos\highcharts\HighCharts::widget([
                        'clientOptions'=>[
                          'chart' => [
                              'plotBackgroundColor' => null,
                              'plotBorderWidth' => null,
                              'plotShadow' => false,
                              'type' => 'pie',
                              'height' => '215',
                              'width' => '350'
                          ],
                          'title' => [
                              // 'text' => 'SPEND'
                          ],
                          'colors' => ['#00a65a','#FF2F2F'],
                          'tooltip' => [
                              'pointFormat' => '<b>{point.percentage:.2f}%</b><br/>Amount: {point.y}'
                          ],
                          'plotOptions' => [
                              'pie' => [
                                  'allowPointSelect' => true,
                                  'cursor' => 'pointer',
                                  'dataLabels' => [
                                      'enabled' => true,
                                      'format'  => '<b>{point.name}:</b> %{point.percentage:.0f}',
                                      'style'   => ['color' => 'black']
                                  ],
                                  'showInLegend' => true
                              ]
                          ],
                          'series' => [
                              [
                              'name' => 'Spend',
                              'colorByPoint' => true,
                              'data' => [
                                [
                                  'name' => 'Media',
                                  'y' => $totalSum["spend"]["to_validate"]
                                ], 
                                [
                                  'name' => 'Fixed Cost',
                                  'y' => $totalSum["spend"]["fixed_cost"],
                                ], 
                                ]
                            ]
                          ],
                        ]
                      ]);
                    ?>
                    </div>
                    <!-- /.row -->
                  </div>
                  <div class="col-md-4">
                    <div class="row">
                      <?= 
                      \dosamigos\highcharts\HighCharts::widget([
                        'clientOptions'=>[
                          'chart' => [
                              'plotBackgroundColor' => null,
                              'plotBorderWidth' => null,
                              'plotShadow' => false,
                              'type' => 'pie',
                              'height' => '215',
                              'width' => '350'
                          ],
                          'title' => [
                            'text' => ''
                          ],
                          'subtitle' => [
                              'text' => 'Fixed cost by model'
                          ],
                          'tooltip' => [
                              'pointFormat' => '<b>{point.percentage:.2f}%</b><br/>Cost: ${point.y}'
                          ],
                          'plotOptions' => [
                              'pie' => [
                                  'allowPointSelect' => true,
                                  'cursor' => 'pointer',
                                  'dataLabels' => [
                                      'enabled' => true,
                                      'format'  => '<b>{point.name}:</b> %{point.percentage:.0f}',
                                      'style'   => ['color' => 'black']
                                  ],
                                  'showInLegend' => true
                              ]
                          ],
                          'series' => [
                              [
                              'name' => 'Spend',
                              'colorByPoint' => true,
                              'data' => $dataChartFixedCostsByModel
                            ]
                          ],
                        ]
                      ]);
                       ?>
                    </div>
                    <!-- /.row -->
                  </div>
                  <div class="col-md-4">
                    <div class="row">
                      <?= 
                      \dosamigos\highcharts\HighCharts::widget([
                        'clientOptions'=>[
                          'chart' => [
                              'plotBackgroundColor' => null,
                              'plotBorderWidth' => null,
                              'plotShadow' => false,
                              'type' => 'pie',
                              'height' => '215',
                              'width' => '350'
                          ],
                          'title' => [
                            'text' => ''
                          ],
                          'subtitle' => [
                              'text' => 'Fixed cost by category'
                          ],
                          'tooltip' => [
                              'pointFormat' => '<b>{point.percentage:.2f}%</b><br/>Cost: ${point.y}'
                          ],
                          'plotOptions' => [
                              'pie' => [
                                  'allowPointSelect' => true,
                                  'cursor' => 'pointer',
                                  'dataLabels' => [
                                      'enabled' => true,
                                      'format'  => '<b>{point.name}:</b> %{point.percentage:.0f}',
                                      'style'   => ['color' => 'black']
                                  ],
                                  'showInLegend' => true
                              ]
                          ],
                          'series' => [
                              [
                              'name' => 'Spend',
                              'colorByPoint' => true,
                              'data' => $dataChartFixedCostsByCategory
                            ]
                          ],
                        ]
                      ]);
                       ?>
                    </div>
                    <!-- /.row -->
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="spend_details_tab_2">
                <div class="row">
                  <div class="col-md-12">
                    <div class="row">
                    <?=
                      \dosamigos\highcharts\HighCharts::widget([
                        'clientOptions'=>[
                          'chart' => [
                              'plotBackgroundColor' => null,
                              'plotBorderWidth' => null,
                              'plotShadow' => false,
                              'type' => 'pie',
                              'height' => '215',
                              'width' => '350'
                          ],
                          'title' => [
                              // 'text' => 'SPEND'
                          ],
                          'colors' => ['#00a65a','#FF2F2F'],
                          'tooltip' => [
                              'pointFormat' => '<b>{point.percentage:.2f}%</b><br/>Amount: {point.y}'
                          ],
                          'plotOptions' => [
                              'pie' => [
                                  'allowPointSelect' => true,
                                  'cursor' => 'pointer',
                                  'dataLabels' => [
                                      'enabled' => true,
                                      'format'  => '<b>{point.name}:</b> %{point.percentage:.0f}',
                                      'style'   => ['color' => 'black']
                                  ],
                                  'showInLegend' => true
                              ]
                          ],
                          'series' => [
                              [
                              'name' => 'Spend',
                              'colorByPoint' => true,
                              'data' => [
                                [
                                  'name' => 'Invoiced',
                                  'y' => $totalSum["spend"]["invoiced"]
                                ], 
                                [
                                  'name' => 'Fixed Cost',
                                  'y' => $totalSum["spend"]["fixed_cost"],
                                ], 
                                ]
                            ]
                          ],
                        ]
                      ]);
                    ?>
                    </div>
                    <!-- /.row -->
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
