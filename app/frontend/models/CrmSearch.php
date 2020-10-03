<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Crm;

/**
 * CrmSearch represents the model behind the search form about `frontend\models\Crm`.
 */
class CrmSearch extends Crm
{

    public $contact; 
    public $status; 
    public $client; 
    public $user; 
    public $advertiser; 
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'contact_id', 'status_crm_id', 'client_id', 'advertisers_id', 'user_id'], 'integer'],
            [['comment', 'date', 'client', 'contact', 'user', 'advertiser', 'status'], 'safe'],
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
    public function search($params, $filters = NULL)
    {
        $query = Crm::find();

        // add conditions that should always apply here


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $dataProvider->sort->attributes['contact'] = [ 
           'asc' => ['contact.name' => SORT_ASC], 
           'desc' => ['contact.name' => SORT_DESC], 
        ]; 

        $dataProvider->sort->attributes['status'] = [ 
           'asc' => ['status.name' => SORT_ASC], 
           'desc' => ['status.name' => SORT_DESC], 
        ]; 

        $dataProvider->sort->attributes['client'] = [ 
           'asc' => ['client.name' => SORT_ASC], 
           'desc' => ['client.name' => SORT_DESC], 
        ]; 

        $dataProvider->sort->attributes['user'] = [
           'asc' => ['user.name' => SORT_ASC], 
           'desc' => ['user.name' => SORT_DESC], 
        ]; 

        $dataProvider->sort->attributes['advertiser'] = [
           'asc' => ['advertisers.name' => SORT_ASC], 
           'desc' => ['advertisers.name' => SORT_DESC], 
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith(['contact', 'client', 'statusCrm', 'user', 'advertisers']);
        // grid filtering conditions
        if(is_null($filters))
            $query->andFilterWhere([
                'id'             => $this->id,
                'contact_id'     => $this->contact_id,
                'status_crm_id'  => $this->status_crm_id,
                'date'           => $this->date,
                'client_id'      => $this->client_id,
                'advertisers_id' => $this->advertisers_id,
                'user_id'        => $this->user_id,
            ]);
        else
            $query->andFilterWhere([
                'id'              => $this->id,
                'contact_id'      => $filters['contact_id'],
                'status_crm_id'   => $this->status_crm_id,
                'date'            => $this->date,
                'client_id'       => $filters['client_id'],
                'advertisers_id'  => $filters['advertisers_id'],
                'user_id'         => $filters['user_id'],
                'crm.type_crm_id' => $filters['crm.type_crm_id'],
            ]);

        if(is_null($filters))
            $query->groupBy(['client_id', 'advertisers_id', 'contact_id', 'user_id']);
        else
            $query->groupBy(['status_crm_id','date']);

        $query->orderBy(['date'=>SORT_DESC]);

        $query->andFilterWhere(['like', 'comment', $this->comment]);
        $query->andFilterWhere(['like', 'contact.name', $this->contact]); 
        $query->andFilterWhere(['like', 'status_crm.status', $this->status]); 
        $query->andFilterWhere(['like', 'client.name', $this->client]); 
        $query->andFilterWhere(['like', 'user.name', $this->user]);
        $query->andFilterWhere(['like', 'advertisers.name', $this->advertiser]);

        return $dataProvider;
    }
}
