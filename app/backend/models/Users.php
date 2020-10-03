<?php

namespace backend\models;

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
 * @property integer $user_type_id
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
 * @property UserType $userType
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
            [['username', 'password', 'email', 'name', 'lastname', 'user_type_id'], 'required'],
            [['status'], 'string'],
            [['email'], 'email'],
            ['username', 'validateCheckIfExist'],
            [['user_type_id'], 'integer'],
            [['username', 'password', 'email', 'name', 'lastname'], 'string', 'max' => 128],
            [['user_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserType::className(), 'targetAttribute' => ['user_type_id' => 'id']],
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
            'user_type_id' => 'User Type ID',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserType()
    {
        return $this->hasOne(UserType::className(), ['id' => 'user_type_id']);
    }


    public function validateCheckIfExist($attribute, $params, $validator){
        if($this->isNewRecord){
        $exisUser = $this::find()->where(['username'=>$this->username])->exists();
        if($exisUser)
            $this->addError($attribute, 'This user already exist');
        }
    }
}
