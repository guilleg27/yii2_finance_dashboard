<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "geo_location".
 *
 * @property integer $id_location
 * @property string $status
 * @property string $name
 * @property string $detail
 * @property string $code
 * @property string $ISO2_CITY
 * @property string $ISO2
 * @property string $ISO3
 * @property string $type
 *
 * @property Carriers[] $carriers
 * @property Client[] $clients
 * @property Contact[] $contacts
 * @property DailyPublishers[] $dailyPublishers
 * @property DailyPublishers2[] $dailyPublishers2s
 * @property Deals[] $deals
 * @property Exchanges[] $exchanges
 * @property Ios[] $ios
 * @property Opportunities[] $opportunities
 * @property Providers[] $providers
 * @property TransactionCount[] $transactionCounts
 */
class GeoLocation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'geo_location';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'required'],
            [['status'], 'string'],
            [['name', 'detail', 'code'], 'string', 'max' => 255],
            [['ISO2_CITY'], 'string', 'max' => 10],
            [['ISO2'], 'string', 'max' => 2],
            [['ISO3'], 'string', 'max' => 3],
            [['type'], 'string', 'max' => 22],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_location' => 'Id Location',
            'status' => 'Status',
            'name' => 'Name',
            'detail' => 'Detail',
            'code' => 'Code',
            'ISO2_CITY' => 'Iso2  City',
            'ISO2' => 'Iso2',
            'ISO3' => 'Iso3',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarriers()
    {
        return $this->hasMany(Carriers::className(), ['id_country' => 'id_location']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClients()
    {
        return $this->hasMany(Client::className(), ['country_id' => 'id_location']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContacts()
    {
        return $this->hasMany(Contact::className(), ['country_id' => 'id_location']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDailyPublishers()
    {
        return $this->hasMany(DailyPublishers::className(), ['country_id' => 'id_location']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDailyPublishers2s()
    {
        return $this->hasMany(DailyPublishers2::className(), ['country_id' => 'id_location']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeals()
    {
        return $this->hasMany(Deals::className(), ['country_id' => 'id_location']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExchanges()
    {
        return $this->hasMany(Exchanges::className(), ['country_id' => 'id_location']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIos()
    {
        return $this->hasMany(Ios::className(), ['country_id' => 'id_location']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpportunities()
    {
        return $this->hasMany(Opportunities::className(), ['country_id' => 'id_location']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProviders()
    {
        return $this->hasMany(Providers::className(), ['country_id' => 'id_location']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionCounts()
    {
        return $this->hasMany(TransactionCount::className(), ['country' => 'id_location']);
    }

    /**
     * @inheritdoc
     * @return GeoLocationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GeoLocationQuery(get_called_class());
    }
}
