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
    <p>
        <?= Html::a('Crear Nuevo Seguimiento', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Crear Nuevo Cliente', ['client/index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Crear Nuevo Tipo de Cliente', ['client-type/index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Crear Nuevo Contacto', ['contact/index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Crear Nuevo Status', ['status-crm/index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Crear Nuevo Tipo de CRM', ['type-crm/index'], ['class' => 'btn btn-success']) ?>
    </p>
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
                'attribute' => 'user',
                'value'    => 'user.users.name'
            ],
            [
                'attribute' => 'contact',
                'value'     => 'contact.name'
            ],
            [
                'attribute' => 'comment',
                'value'  => function ($data) {
                    return $data->getLastComment();
                },
            ],
            [
                'attribute' => 'date',
                'value'  => function ($data) {
                    return $data->getLastUpdate();
                },
            ],
            [
                'attribute' => 'status',
                'format'    => 'raw',
                'value'     => function ($model, $key, $index, $widget) {
                    return \yii\helpers\Html::dropDownList(
                        'status',
                        $model->getLastStatusId(),
                        ArrayHelper::map(
                            StatusCrm::find()->asArray()->all(),
                            'id',
                            'status'
                        ),
                        [
                        'onChange'=>'
                            var comment = prompt("Ingresa un comentario para actualizar el seguimiento!");
                            if(comment != null){
                                $.ajax({
                                    url: "'.Url::toRoute(['crm/update-status', 'id' => $key]).'"+"&status="+$(this).find("option:selected").val()+"&comment="+comment,
                                    context: document.body
                                }).done(function(data) {
                                    $.pjax.reload({container:"#grid-crm"});
                                });
                            }
                            ',
                        ]);
                },
            ],
            [
                'attribute' =>'Detail',
                'format'    =>'raw',
                'value'     =>function ($data) {
                            return Html::a(
                                Html::encode(
                                    Url::to('Detail'))
                                    ,
                                    [
                                        'crm/detail', 
                                        'client'     => $data->client_id, 
                                        'user'       => $data->user_id, 
                                        'contact'    => $data->contact_id,
                                        'advertiser' => $data->advertisers_id,
                                    ], 
                                    [
                                        'target'=>'_blank',
                                    ]  
                            );
                         },
            ],
            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
