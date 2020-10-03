<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $name
 * @property string $lastname
 * @property string $status
 *
 * @property Advertisers[] $advertisers
 * @property Advertisers[] $advertisers0
 * @property Affiliates[] $affiliates
 * @property Commission[] $commissions
 * @property Deals[] $deals
 * @property Deals[] $deals0
 * @property ExternalIoForm[] $externalIoForms
 * @property Implementations[] $implementations
 * @property Opportunities[] $opportunities
 * @property Opportunities[] $opportunities0
 * @property Opportunities[] $opportunities1
 * @property Prospects[] $prospects
 * @property Publishers[] $publishers
 * @property Publishers[] $publishers0
 * @property ReportFilters[] $reportFilters
 * @property TransactionCount[] $transactionCounts
 * @property TransactionCountBranding[] $transactionCountBrandings
 * @property TransactionExchanges[] $transactionExchanges
 * @property TransactionProviders[] $transactionProviders
 * @property User[] $users
 * @property UsersObjectives[] $usersObjectives
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'email', 'name', 'lastname'], 'required'],
            [['status'], 'string'],
            [['username', 'password', 'email', 'name', 'lastname'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'name' => 'Name',
            'lastname' => 'Lastname',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisers()
    {
        return $this->hasMany(Advertisers::className(), ['commercial_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisers0()
    {
        return $this->hasMany(Advertisers::className(), ['users_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAffiliates()
    {
        return $this->hasMany(Affiliates::className(), ['users_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommissions()
    {
        return $this->hasMany(Commission::className(), ['users_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeals()
    {
        return $this->hasMany(Deals::className(), ['users_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeals0()
    {
        return $this->hasMany(Deals::className(), ['sales_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExternalIoForms()
    {
        return $this->hasMany(ExternalIoForm::className(), ['commercial_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImplementations()
    {
        return $this->hasMany(Implementations::className(), ['users_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpportunities()
    {
        return $this->hasMany(Opportunities::className(), ['account_manager_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpportunities0()
    {
        return $this->hasMany(Opportunities::className(), ['sem_analyst_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpportunities1()
    {
        return $this->hasMany(Opportunities::className(), ['commercial_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProspects()
    {
        return $this->hasMany(Prospects::className(), ['users_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPublishers()
    {
        return $this->hasMany(Publishers::className(), ['account_manager_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPublishers0()
    {
        return $this->hasMany(Publishers::className(), ['users_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReportFilters()
    {
        return $this->hasMany(ReportFilters::className(), ['users_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionCounts()
    {
        return $this->hasMany(TransactionCount::className(), ['users_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionCountBrandings()
    {
        return $this->hasMany(TransactionCountBranding::className(), ['users_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionExchanges()
    {
        return $this->hasMany(TransactionExchanges::className(), ['users_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionProviders()
    {
        return $this->hasMany(TransactionProviders::className(), ['users_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['users_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersObjectives()
    {
        return $this->hasMany(UsersObjectives::className(), ['users_id' => 'id']);
    }
}
