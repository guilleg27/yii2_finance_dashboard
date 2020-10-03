<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\FixedCost;

/**
 * FixedCostSearch represents the model behind the search form about `backend\models\FixedCost`.
 */
class FixedCostSearch extends FixedCost
{
    public $business_model;
    public $cost_category;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cost_category_id', 'business_model_id'], 'integer'],
            [['period', 'description','business_model','cost_category'], 'safe'],
            [['cost'], 'number'],
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
            $endDate   = date('Y-m-01',strtotime('NOW -1 month'));
        }
        $businessModelId = isset($params["businessModelId"]) ? $params["businessModelId"] : NULL;

        $query = FixedCost::find();
        $query->joinWith(['businessModel','costCategory']);
        // $query->orderBy('period DESC');
        $query->where(['between', 'period', $startDate, $endDate]);

        if (isset($params["businessModelId"]))
            $query->andWhere(['in','business_model_id',$businessModelId]);

        if (isset($params["groupByModel"]))
        {
            $query->select('business_model.business_model as description,sum(cost) as cost');
            $query->groupBy(['business_model_id']);
        }

        if (isset($params["groupByCostCategory"]))
        {
            $query->select('cost_category.cost_category as description,sum(cost) as cost');
            $query->groupBy(['cost_category_id']);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['business_model'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['business_model' => SORT_ASC],
            'desc' => ['business_model' => SORT_DESC],
        ];
        // Lets do the same with country now
        $dataProvider->sort->attributes['cost_category'] = [
            'asc' => ['cost_category' => SORT_ASC],
            'desc' => ['cost_category' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id'     => $this->id,
            'period' => $this->period,
            'cost'   => $this->cost
        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);
        $query->andFilterWhere(['like', 'cost_category.cost_category', $this->cost_category]);
        $query->andFilterWhere(['like', 'business_model.business_model', $this->business_model]);

        return ['data' => $query->all(), 'dataProvider' => $dataProvider];
    }
}
