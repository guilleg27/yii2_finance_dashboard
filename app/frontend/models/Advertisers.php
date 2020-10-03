<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "advertisers".
 *
 * @property integer $id
 * @property string $prefix
 * @property string $name
 * @property integer $commercial_id
 * @property string $status
 * @property integer $users_id
 *
 * @property Users $commercial
 * @property Users $users
 * @property ApiKey[] $apiKeys
 * @property Crm[] $crms
 * @property Deals[] $deals
 * @property ExternalIoForm[] $externalIoForms
 * @property Ios[] $ios
 */
class Advertisers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'advertisers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prefix', 'name', 'status'], 'required'],
            [['commercial_id', 'users_id'], 'integer'],
            [['status'], 'string'],
            [['prefix'], 'string', 'max' => 45],
            [['name'], 'string', 'max' => 128],
            [['commercial_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['commercial_id' => 'id']],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['users_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prefix' => 'Prefix',
            'name' => 'Name',
            'commercial_id' => 'Commercial ID',
            'status' => 'Status',
            'users_id' => 'Users ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommercial()
    {
        return $this->hasOne(Users::className(), ['id' => 'commercial_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id' => 'users_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApiKeys()
    {
        return $this->hasMany(ApiKey::className(), ['advertisers_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCrms()
    {
        return $this->hasMany(Crm::className(), ['advertisers_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeals()
    {
        return $this->hasMany(Deals::className(), ['advertisers_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExternalIoForms()
    {
        return $this->hasMany(ExternalIoForm::className(), ['advertisers_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIos()
    {
        return $this->hasMany(Ios::className(), ['advertisers_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return AdvertisersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdvertisersQuery(get_called_class());
    }
}
