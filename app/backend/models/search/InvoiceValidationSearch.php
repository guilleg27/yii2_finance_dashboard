<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\InvoiceValidation;

/**
 * InvoiceValidationSearch represents the model behind the search form about `backend\models\InvoiceValidation`.
 */
class InvoiceValidationSearch extends InvoiceValidation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'invoice', 'business_model_id', 'entity_id'], 'integer'],
            [['amount'], 'number'],
            [['period', 'name', 'type', 'amount'], 'safe'],
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
        $businessModel = isset($params["businessModelId"]) ? $params["businessModelId"] : NULL;
        $notInvoiced = isset($params["notInvoiced"]) ? $params["notInvoiced"] : NULL;
        $validated = isset($params["validated"]) ? $params["validated"] : NULL;

        $query = InvoiceValidation::find();
        $query->joinWith(['businessModel']);
        $query->where(['between', 'period', $startDate, $endDate]);
        $query->andWhere(['!=', 'amount', 0]);
        // $query->orderBy([
        //     'period' => SORT_ASC,
        //     'business_model.business_model'=>SORT_ASC,
        //     'name'=>SORT_ASC,
        //     ]);
        if ($businessModel)
            $query->andWhere(['business_model_id'=>$businessModel]);   
        if ($validated)
            $query->andWhere(['validated'=>1]);     
        if ($notInvoiced)
            $query->andWhere(['invoice'=>0]);
        if (isset($params["type"]))
            $query->andWhere(['type'=>$params["type"]]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        $dataProvider->sort->attributes['business_model'] = [
            'asc' => ['business_model' => SORT_ASC],
            'desc' => ['business_model' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'period' => $this->period,
            'invoice' => $this->invoice,
            'business_model_id' => $this->business_model_id,
            'entity_id' => $this->entity_id,
            'amount' => $this->amount,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}
