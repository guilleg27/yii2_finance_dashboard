<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ProvidersValidation;

/**
 * ProvidersValidationSearch represents the model behind the search form about `backend\models\ProvidersValidation`.
 */
class ProvidersValidationSearch extends ProvidersValidation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'providers_id'], 'integer'],
            [['period', 'invoice', 'date', 'status', 'comment', 'payment_date'], 'safe'],
            [['amount'], 'number'],
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
        $query = ProvidersValidation::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'providers_id' => $this->providers_id,
            'period' => $this->period,
            'date' => $this->date,
            'payment_date' => $this->payment_date,
            'amount' => $this->amount,
        ]);

        $query->andFilterWhere(['like', 'invoice', $this->invoice])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }

    public function getAmountPaidByPeriod($startDate,$endDate)
    {
        $year  = date("Y", strtotime($endDate));
        $month = date("m", strtotime($endDate));
        $days  = cal_days_in_month(CAL_GREGORIAN, $month, $year); 
        $endDate   = $year.'-'.$month.'-'.$days;       

        $query = ProvidersValidation::find();
        $query->select(['sum(amount) as amount']);
        $query->where(['between', 'payment_date', $startDate, $endDate]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}
