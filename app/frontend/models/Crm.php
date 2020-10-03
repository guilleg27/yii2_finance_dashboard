<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "crm".
 *
 * @property integer $id
 * @property integer $contact_id
 * @property integer $status_crm_id
 * @property string $comment
 * @property string $date
 * @property integer $client_id
 * @property integer $advertisers_id
 * @property integer $user_id
 * @property integer $type_crm_id
 *
 * @property Advertisers $advertisers
 * @property Client $client
 * @property Contact $contact
 * @property StatusCrm $statusCrm
 * @property TypeCrm $typeCrm
 * @property User $user
 */
class Crm extends \yii\db\ActiveRecord
{
    public $level;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'crm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contact_id', 'status_crm_id', 'client_id', 'advertisers_id', 'user_id', 'type_crm_id'], 'required'],
            [['contact_id', 'status_crm_id', 'client_id', 'advertisers_id', 'user_id', 'type_crm_id'], 'integer'],
            [['comment'], 'string'],
            [['date'], 'safe'],
            [['advertisers_id'], 'exist', 'skipOnError' => true, 'targetClass' => Advertisers::className(), 'targetAttribute' => ['advertisers_id' => 'id']],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['contact_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contact::className(), 'targetAttribute' => ['contact_id' => 'id']],
            [['status_crm_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusCrm::className(), 'targetAttribute' => ['status_crm_id' => 'id']],
            [['type_crm_id'], 'exist', 'skipOnError' => true, 'targetClass' => TypeCrm::className(), 'targetAttribute' => ['type_crm_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'contact_id' => 'Contact ID',
            'status_crm_id' => 'Status Crm ID',
            'comment' => 'Comment',
            'date' => 'Date',
            'client_id' => 'Client ID',
            'advertisers_id' => 'Advertisers ID',
            'user_id' => 'User ID',
            'type_crm_id' => 'Type Crm ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisers()
    {
        return $this->hasOne(Advertisers::className(), ['id' => 'advertisers_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContact()
    {
        return $this->hasOne(Contact::className(), ['id' => 'contact_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusCrm()
    {
        return $this->hasOne(StatusCrm::className(), ['id' => 'status_crm_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeCrm()
    {
        return $this->hasOne(TypeCrm::className(), ['id' => 'type_crm_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return CrmQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CrmQuery(get_called_class());
    }

    public function getTotalGraphic($filters = [])
    {
        if(isset($filters['type_crm_id']) || empty($filters)){
            $groupBy = ['DATE(date)'];
            $date    = 'DATE(date) as date';
        }
        else{
            $groupBy = ['status_crm_id'];
            $date = 'date';
        }

        $data = $this::find()
                ->joinWith('statusCrm')
                ->andFilterWhere($filters)
                ->groupBy($groupBy)
                ->select([$date, 'SUM(status_crm.level) as level', 'contact_id','status_crm_id','advertisers_id'])
                ->all();

        $graphic_data['x'] = array();
        $graphic_data['y'] = array();

        foreach ($data as $key => $value) {
            $graphic_data['y'][] = IntVal($value->level);
            $graphic_data['x'][] = $value->date;
        }

        return $graphic_data;
    }

    public function getLastComment()
    {
        return $this::find()
                ->joinWith('statusCrm')
                ->andFilterWhere([
                        'contact_id'     => $this->contact_id,
                        'status_crm_id'  => $this->status_crm_id,
                        'client_id'      => $this->client_id,
                        'advertisers_id' => $this->advertisers_id,
                        'user_id'        => $this->user_id,
                    ])
                ->select(['comment'])
                ->orderBy('DATE(date) DESC')
                ->one()
                ->comment;
    }

    public function getLastUpdate()
    {
        return $this::find()
                ->joinWith('statusCrm')
                ->andFilterWhere([
                        'contact_id'     => $this->contact_id,
                        'status_crm_id'  => $this->status_crm_id,
                        'client_id'      => $this->client_id,
                        'advertisers_id' => $this->advertisers_id,
                        'user_id'        => $this->user_id,
                    ])
                ->select(['DATE(date) as date'])
                ->orderBy('DATE(date) DESC')
                ->one()
                ->date;
    }

    public function getLastStatusId()
    {
        return $this::find()
                ->andFilterWhere([
                        'contact_id'     => $this->contact_id,
                        'status_crm_id'  => $this->status_crm_id,
                        'client_id'      => $this->client_id,
                        'advertisers_id' => $this->advertisers_id,
                        'user_id'        => $this->user_id,
                    ])
                ->select(['status_crm_id'])
                ->orderBy('DATE(date) DESC')
                ->one()
                ->status_crm_id;
    }
}
