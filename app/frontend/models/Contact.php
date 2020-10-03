<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "contact".
 *
 * @property integer $id
 * @property string $name
 * @property string $mail
 * @property string $phone
 * @property integer $country_id
 * @property integer $type_crm_id
 *
 * @property GeoLocation $country
 * @property TypeCrm $typeCrm
 * @property Crm[] $crms
 */
class Contact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_id', 'type_crm_id'], 'required'],
            [['country_id', 'type_crm_id'], 'integer'],
            [['name', 'mail', 'phone'], 'string', 'max' => 45],
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
            'mail' => 'Mail',
            'phone' => 'Phone',
            'country_id' => 'Country ID',
            'type_crm_id' => 'Type Crm ID',
        ];
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
        return $this->hasMany(Crm::className(), ['contact_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ContactQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ContactQuery(get_called_class());
    }
}
