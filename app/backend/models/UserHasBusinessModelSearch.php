<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\UserHasBusinessModel;

/**
 * UserHasBusinessModelSearch represents the model behind the search form about `backend\models\UserHasBusinessModel`.
 */
class UserHasBusinessModelSearch extends UserHasBusinessModel
{
    public $username; 
    public $business_model; 
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'business_model_id'], 'integer'],
            [['username', 'business_model'], 'safe']
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
        $query = UserHasBusinessModel::find()->joinWith(['user', 'businessModel']);

        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['business_model'] = [
            'asc' => ['business_model.business_model' => SORT_ASC],
            'desc' => ['business_model.business_model' => SORT_DESC],
            ];
        $dataProvider->sort->attributes['username'] = [
            'asc' => ['username' => SORT_ASC],
            'desc' => ['username' => SORT_DESC],
            ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'business_model', $this->business_model]);
        $query->andFilterWhere(['like', 'username', $this->username]);

        return $dataProvider;
    }
}
