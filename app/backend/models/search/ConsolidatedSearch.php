<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Consolidated;
use backend\models\FixedCost;
use yii\data\ArrayDataProvider;

/**
 * ConsolidatedSearch represents the model behind the search form about `backend\models\Consolidated`.
 */
class ConsolidatedSearch extends Consolidated
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'business_model_id'], 'integer'],
            [['business_model_id', 'period'], 'safe'],
            [['revenue_server', 'revenue_transaction', 'agency_commission', 'revenue_validated', 'revenue_invoiced', 'revenue_manual', 'spend_server', 'spend_off', 'spend_transaction', 'spend_validated', 'spend_invoiced', 'spend_manual', 'profit_manual', 'objective_revenue', 'objective_profit'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        if (isset($params["startDate"]) && isset($params["endDate"]))
        {
            $startDate = $params["startDate"];
            $endDate   = $params["endDate"];
        }else{
            $startDate = date('Y-m-01',strtotime('NOW -1 month'));
            $endDate = date('Y-m-01',strtotime('NOW -1 month'));
        }

        $query = Consolidated::find();
        $query->select(['consolidated.*', '(select sum(fc.cost) from fixed_cost fc where consolidated.business_model_id=fc.business_model_id AND consolidated.period=fc.period ) as fixedCost']);
        $query->joinWith(['businessModel']);
        $query->where(['between', 'period', $startDate, $endDate]);
        $query->orderBy('period');
        
        if (isset($params["businessModelId"]))
            $query->andWhere(['business_model_id'=>$params["businessModelId"]]);

        if (isset($params["groupByMonth"]))
        {
            $query->select('period, sum(revenue_invoiced) as revenue_invoiced, sum(spend_invoiced) as spend_invoiced, sum(revenue_invoiced-spend_invoiced) as profit_invoiced, sum(objective_revenue) as objective_revenue, sum(objective_profit) as objective_profit');
            $query->groupBy(['period']);
        }
        if (isset($params["groupByModel"]))
        {
            $query->select('business_model.business_model as businessModelName, period, sum(revenue_validated) as revenue_validated, sum(spend_validated) as spend_validated, sum(objective_revenue) as objective_revenue, sum(objective_profit) as objective_profit');
            $query->groupBy(['business_model_id']);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }

    public function searchGridAverages($params)
    {
        if (isset($params["startDate"]) && isset($params["endDate"]))
        {
            $startDate = $params["startDate"];
            $endDate   = $params["endDate"];
        }else{
            $startDate = date('Y-m-01',strtotime('NOW -1 month'));
            $endDate = date('Y-m-01',strtotime('NOW -1 month'));
        }

        $query = Consolidated::find();
        $query->select('consolidated.*, business_model.business_model as businessModelName, (revenue_invoiced * 100 / revenue_to_validate) as avgInvoicedRevenue, (spend_invoiced * 100 / spend_to_validate) as avgInvoicedSpend');
        $query->joinWith(['businessModel']);
        $query->where(['between', 'period', $startDate, $endDate]);
        // $query->orderBy('period');
        
        if (isset($params["businessModelId"]))
            $query->andWhere(['business_model_id'=>$params["businessModelId"]]);

        if (isset($params["averageInvoiced"]))
        {
            $query->select('consolidated.*, business_model.business_model as businessModelName, (revenue_invoiced * 100 / revenue_to_validate) as avgInvoicedRevenue, (spend_invoiced * 100 / spend_to_validate) as avgInvoicedSpend');
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'businessModelName' => [
                        'asc' => ['businessModelName' => SORT_ASC],
                        'desc' => ['businessModelName' => SORT_DESC],
                    ],
                    'period','avgInvoicedRevenue','avgInvoicedSpend'                ],
            ],
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }

    public function searchGrid($params)
    {
        if (isset($params["startDate"]) && isset($params["endDate"]))
        {
            $startDate = $params["startDate"];
            $endDate   = $params["endDate"];
        }else{
            $startDate = date('Y-m-01',strtotime('NOW -1 month'));
            $endDate = date('Y-m-01',strtotime('NOW -1 month'));
        }
        $businessModelId = isset($params["businessModelId"]) ? $params["businessModelId"] : NULL;
        $bids            = $businessModelId ? implode(",", $businessModelId) : NULL;
        $dataArray       = [];
        $countFixedCost  = 0;

        $queryConsolidated = "
        SELECT `consolidated`.*, 
        (select sum(fc.cost) from fixed_cost fc where consolidated.business_model_id=fc.business_model_id AND consolidated.period=fc.period ) as fixedCost,
        business_model.business_model as businessModelName
        FROM `consolidated` LEFT JOIN `business_model` ON `consolidated`.`business_model_id` = `business_model`.`id` 
        WHERE `period` BETWEEN '".$startDate."' AND '".$endDate."'";
        if($bids)
            $queryConsolidated .= " AND consolidated.business_model_id IN (".$bids.")";
        $consolidated = Consolidated::findBySql($queryConsolidated)->all();

        $queryFixedCost = "
        SELECT fixed_cost.id, fixed_cost.period, 0 as revenue_server, 0 as revenue_transaction, 0 as agency_commission,
        0 as revenue_to_validate, 0 as revenue_validated, 0 as revenue_invoiced, 0 as revenue_manual,
        0 as spend_server, 0 as spend_off, 0 as spend_transaction, 0 as spend_to_validate, 0 as spend_validated,
        0 as spend_invoiced, 0 as spend_manual, 0 as profit_manual, 0 as objective_revenue, 0 as objective_profit,
        fixed_cost.business_model_id, sum(fixed_cost.cost) as fixedCost,
        business_model.business_model as businessModelName
        FROM `fixed_cost` 
        LEFT JOIN `business_model` ON `fixed_cost`.`business_model_id` = `business_model`.`id` 
        WHERE `period` BETWEEN '".$startDate."' AND '".$endDate."'";
        if($bids)
            $queryFixedCost .= " AND fixed_cost.business_model_id IN (".$bids.")";
        $queryFixedCost .= " AND (fixed_cost.business_model_id NOT IN (1,2,3))
        group by fixed_cost.business_model_id"; 
        $fixedCosts = FixedCost::findBySql($queryFixedCost)->all();
        
        $results = array_merge($consolidated,$fixedCosts);

        foreach ($results as $record) {
            if (is_null($record->id))
                continue;

            $i = $record->id;
            $dataArray[$i]['period'] = $record->period;
            $dataArray[$i]['revenue_server'] = $record->revenue_server;
            $dataArray[$i]['revenue_transaction'] = $record->revenue_transaction;
            $dataArray[$i]['agency_commission'] = $record->agency_commission;
            $dataArray[$i]['revenue_to_validate'] = $record->revenue_to_validate;
            $dataArray[$i]['revenue_validated'] = $record->revenue_validated;
            $dataArray[$i]['revenue_invoiced'] = $record->revenue_invoiced;
            $dataArray[$i]['revenue_manual'] = $record->revenue_manual;
            $dataArray[$i]['spend_server'] = $record->spend_server;
            $dataArray[$i]['spend_off'] = $record->spend_off;
            $dataArray[$i]['spend_transaction'] = $record->spend_transaction;
            $dataArray[$i]['spend_to_validate'] = $record->spend_to_validate;
            $dataArray[$i]['spend_validated'] = $record->spend_validated;
            $dataArray[$i]['spend_invoiced'] = $record->spend_invoiced;
            $dataArray[$i]['spend_manual'] = $record->spend_manual;
            $dataArray[$i]['profit_manual'] = $record->profit_manual;
            $dataArray[$i]['objective_revenue'] = $record->objective_revenue;
            $dataArray[$i]['objective_profit'] = $record->objective_profit;
            $dataArray[$i]['business_model_id'] = $record->business_model_id;
            $dataArray[$i]['fixedCost'] = $record->fixedCost;
            $dataArray[$i]['businessModelName'] = $record->businessModelName;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $dataArray,
            'sort' => [
                'attributes' => [
                    'businessModelName' => [
                        'asc' => ['businessModelName' => SORT_ASC],
                        'desc' => ['businessModelName' => SORT_DESC],
                    ],
                    'period','revenue_server','revenue_transaction','agency_commission','revenue_to_validate','revenue_validated','revenue_invoiced',
                    'objective_revenue','spend_server','spend_transaction','spend_to_validate','spend_validated','spend_invoiced','fixedCost',
                ],
            ],
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        return $dataProvider;
    }

}
