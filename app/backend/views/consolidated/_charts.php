<?php 

use yii\bootstrap\Progress;

?>

  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Charts</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-7">
              <div class="chart">
                <!-- Sales Chart Canvas -->
                <?=
                  \dosamigos\highcharts\HighCharts::widget([
                    'clientOptions' => [
                        'chart' => [
                              'type' => 'areaspline'
                        ],
                        'title' => [
                             'text' => ''
                             ],
                        'subtitle' => [
                            'text' => '<b>Total invoice<b>'
                        ],
                        'xAxis' => [
                          'categories' => $dataGraphic["months"],
                          'tickmarkPlacement'=>'on',
                          'title'=> [
                            'enabled'=> false
                          ]
                          ],
                        'yAxis' => [
                            'title' => [
                                'text' => ''
                            ],
                        ],
                      'tooltip' => [
                          'crosshairs' => true,
                          'shared' => true,
                          // 'valueSuffix' => ' millions'
                      ],
                      'colors' => ['#dd4b39', '#00c0ef', '#00a65a', '#f39c12'],
                     'plotOptions' => [
                      'spline' => [
                        'fillOpacity' => 0.5,
                        'lineWidth' => 4,
                        'marker' => [
                                     'enabled' => false,
                                 ]
                        ],
                      ],
                      'series' => [
                          ['name' => 'Revenue', 'data' => $dataGraphic["revenue_invoiced"]],
                          ['name' => 'Spend', 'data' => $dataGraphic["spend_invoiced"]],
                          ['name' => 'Profit', 'data' => $dataGraphic["profit_invoiced"]],
                          ['name' => 'Objective', 'data' => $dataGraphic["objective_revenue"], 'fillOpacity' => 0, 'lineWidth' => 3],
                      ]
                    ]
                  ]);
              ?>
              </div>
              <!-- /.chart-responsive -->
            </div>
            <!-- /.col -->
            <div class="col-md-5">
              <p class="text-center">
                <strong>Goal Completion</strong>
              </p>
              <?php
                if (isset($goalCompletionByModel["Branding"]) /*|| (in_array($businessModel, ["Branding"]))*/ )
                {
                  echo Progress::widget([
                      'percent' => $goalCompletionByModel["Branding"]["avg_profit"],
                      'barOptions' => ['class' => 'progress-bar-danger'],
                      'label' => 'Branding'.' ('.number_format(round($goalCompletionByModel["Branding"]["avg_profit"], 3), 0).'%)',
                  ]);
                }
                if (isset($goalCompletionByModel["Media Buying"]) /*|| (in_array($businessModel, ["Media Buying"]))*/ )
                {
                  echo Progress::widget([
                      'percent' => $goalCompletionByModel["Media Buying"]["avg_profit"],
                      'label' => 'Media Buying'.' ('.number_format(round($goalCompletionByModel["Media Buying"]["avg_profit"], 3), 0).'%)',
                  ]);
                }
                if (isset($goalCompletionByModel["Performance"]) /*|| (in_array($businessModel, ["Performance"]))*/ )
                {
                  echo Progress::widget([
                      'percent' => $goalCompletionByModel["Performance"]["avg_profit"],
                      'barOptions' => ['class' => 'progress-bar-warning'],
                      'label' => 'Performance'.' ('.number_format(round($goalCompletionByModel["Performance"]["avg_profit"], 3), 0).'%)',
                  ]);
                }
                if ( isset($goalCompletionByModel["Media Buying"]) && isset($goalCompletionByModel["Branding"]) && isset($goalCompletionByModel["Performance"]) 
                      && is_null($businessModelId)
                  )
                {
                  echo Progress::widget([
                      'percent' => $goalCompletionByModel["Global"]["avg_profit"],
                      'barOptions' => ['class' => 'progress-bar-success'],
                      'label' => 'Global'.' ('.number_format(round($goalCompletionByModel["Global"]["avg_profit"], 3), 0).'%)',
                  ]);
                }
              ?>
              <?php //if (is_null($businessModelId)) : ?>
              <?=
                \dosamigos\highcharts\HighCharts::widget([
                  'clientOptions'=>[
                    'chart' => [
                        'plotBackgroundColor' => null,
                        'plotBorderWidth' => null,
                        'plotShadow' => false,
                        'type' => 'pie',
                        'height' => '215'
                    ],
                    'title' => [
                        'text' => ''
                    ],
                    'subtitle' => [
                        'text' => '<b>Business models sharing</b>'
                    ],
                    'colors' => ['#FF2F2F', '#0563FE', '#FFD148'],
                    'tooltip' => [
                        'pointFormat' => '<b>{point.percentage:.1f}%</b><br/>Revenue: {point.y}'
                    ],
                    'plotOptions' => [
                        'pie' => [
                            'allowPointSelect' => true,
                            'cursor' => 'pointer',
                            'dataLabels' => [
                                'enabled' => false
                            ],
                            'showInLegend' => true
                        ]
                    ],
                    'series' => [
                        [
                        'name' => 'Brands',
                        'colorByPoint' => true,
                        'data' => [
                          [
                            'name' => 'Branding',
                            'y' => $goalCompletionByModel["Branding"]["rev"]
                          ], 
                          [
                            'name' => 'Media Buying',
                            'y' => $goalCompletionByModel["Media Buying"]["rev"],
                          ], 
                          [
                            'name' => 'Performance',
                            'y' => $goalCompletionByModel["Performance"]["rev"]
                          ]
                          ]
                      ]
                    ],
                  ]
                ]);
              ?>
            <?php //endif; ?>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- ./box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>