<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "type_crm".
 *
 * @property integer $id
 * @property string $type
 *
 * @property Client[] $clients
 * @property ClientType[] $clientTypes
 * @property Contact[] $contacts
 * @property Crm[] $crms
 * @property StatusCrm[] $statusCrms
 */
class TypeCrm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'type_crm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClients()
    {
        return $this->hasMany(Client::className(), ['type_crm_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientTypes()
    {
        return $this->hasMany(ClientType::className(), ['type_crm_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContacts()
    {
        return $this->hasMany(Contact::className(), ['type_crm_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCrms()
    {
        return $this->hasMany(Crm::className(), ['type_crm_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusCrms()
    {
        return $this->hasMany(StatusCrm::className(), ['type_crm_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return TypeCrmQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TypeCrmQuery(get_called_class());
    }
}
