 <?php
// use yii\helpers\Url;
 ?>
 <?=
    \dosamigos\highcharts\HighCharts::widget([
        'clientOptions' =>[
            // 'chart' => [
            //     'type' => 'pie'
            // ],
            'xAxis' =>[
                'categories' => $data['periodos']
            ],
            'title' => [
                'text' => 'Costo por categoria, modelo de negocio'
            ],
            'plotOptions' => [
                'pie' => [
                    'pie' => [
                        'shadow' => false,
                        'center' => ['50%', '50%']
                    ],
                ],
            ],
            'series' => [
                [ 
                    'type' => 'pie',
                    'data' => $data['businessModels'],
                    'name' => 'Costos',
                    'size' => '50%',
                    'innerSize' => '35%',
                    'center' => [100, 80],
                // 'dataLabels'=> [
                //     ]
                ],
                [
                    'type' => 'pie',
                    'data' => $data['categories'],
                    'size' => '35%',
                    'name' => 'Costos',
                    'center' => [100, 80],
                    'dataLabels' => [
                            // 'color'=> '#ffffff',
                            // 'distance'=> '-30',
                            'enabled' => false,
                        ]
                ],
                [
                    'type'=>'spline',
                    'data' => $data['costos'],
                    'name' => 'Costos'
                ]

            ]
        ]
        ]);
?>  