<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\select2\Select2;
use frontend\models\StatusCrm;
use dosamigos\highcharts\HighCharts;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CrmSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kickads Crm';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="crm-index">
<?php Pjax::begin(); ?>   

<?= 
Highcharts::widget([
    'clientOptions' => [
        'title' => [
            'text' => 'General Status CRM',
        ],
        'xAxis' => [
            'categories' => $graphic['x'],
        ],
        'labels' => [
            'items' => [
                [
                    'html'  => '',
                    'style' => [
                        'left'  => '50px',
                        'top'   => '18px',
                        'color' => new JsExpression('(Highcharts.theme && Highcharts.theme.textColor) || "black"'),
                    ],
                ],
            ],
        ],
        'series' => [
            [
                'type'   => 'spline',
                'name'   => 'Average',
                'data'   => $graphic['y'],
                'marker' => [
                    'lineWidth' => 2,
                    'lineColor' => new JsExpression('Highcharts.getOptions().colors[3]'),
                    'fillColor' => 'white',
                ],
            ],
        ],
    ]
]);
?> 
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'grid-crm',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'client',
                'value'    => 'client.name'
            ],
            [
                'attribute' => 'advertiser',
                'value'    => 'advertisers.name'
            ],
            [
                'attribute' => 'user',
                'value'    => 'user.username'
            ],
            [
                'attribute' => 'contact',
                'value'     => 'contact.name'
            ],
            'comment',
            'date',
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
