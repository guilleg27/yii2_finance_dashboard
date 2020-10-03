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
<center>
    <?php foreach ($types as $key => $value): ?>
        <?= 
        Html::a(
            '<i class="fa">'.ucwords(str_split($value->type)[0]).'</i>'.$value->type
                ,
                [
                    'crm/index', 
                    'type'     => $value->id, 
                ], 
                [
                    'class'=>'btn btn-app'
                ]
        );
        ?>
    <?php endforeach; ?>
</center>