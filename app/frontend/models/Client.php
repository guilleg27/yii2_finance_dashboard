<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "client".
 *
 * @property integer $id
 * @property string $name
 * @property integer $client_type_id
 * @property integer $country_id
 * @property integer $type_crm_id
 *
 * @property ClientType $clientType
 * @property GeoLocation $country
 * @property TypeCrm $typeCrm
 * @property Crm[] $crms
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_type_id', 'country_id', 'type_crm_id'], 'required'],
            [['client_type_id', 'country_id', 'type_crm_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['client_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClientType::className(), 'targetAttribute' => ['client_type_id' => 'id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => GeoLocation::className(), 'targetAttribute' => ['country_id' => 'id_location']],
            [['type_crm_id'], 'exist', 'skipOnError' => true, 'targetClass' => TypeCrm::className(), 'targetAttribute' => ['type_crm_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'client_type_id' => 'Client Type ID',
            'country_id' => 'Country ID',
            'type_crm_id' => 'Type Crm ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientType()
    {
        return $this->hasOne(ClientType::className(), ['id' => 'client_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(GeoLocation::className(), ['id_location' => 'country_id']);
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
    public function getCrms()
    {
        return $this->hasMany(Crm::className(), ['client_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ClientQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClientQuery(get_called_class());
    }
}
