<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $users_id
 * @property integer $profile_id
 *
 * @property Crm[] $crms
 * @property Profile $profile
 * @property Users $users
 */
class User extends \yii\db\ActiveRecord
{   
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at', 'users_id', 'profile_id'], 'required'],
            [['status', 'created_at', 'updated_at', 'users_id', 'profile_id'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['users_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                   => 'ID',
            'username'             => 'Username',
            'auth_key'             => 'Auth Key',
            'password_hash'        => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email'                => 'Email',
            'status'               => 'Status',
            'created_at'           => 'Created At',
            'updated_at'           => 'Updated At',
            'users_id'             => 'Users',
            'profile_id'           => 'Profile',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCrms()
    {
        return $this->hasMany(Crm::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id' => 'users_id']);
    }

    public static function roleInArray($arr_role)
    {
        return in_array(Yii::$app->user->identity->role, $arr_role);
    }

    public static function isActive()
    {
        return Yii::$app->user->identity->status == self::STATUS_ACTIVE;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignment()
    {
        return $this->hasOne(AuthAssignment::className(), ['user_id' => 'id']);
    }

    public function findByRole($role){
        $authAssignment = new AuthAssignment;
        /*SELECT * FROM auth_assignment 
            INNER JOIN user ON auth_assignment.user_id = user.id;*/
        return User::find()->joinWith('authAssignment')
                ->where(['auth_assignment.item_name' => $role])
                ->filterWhere(['team_id' => User::findOne(Yii::$app->user->id)->team_id])
                ->orderBy('username')
                ->all();
    }

    public function getUsername()
    {
      return $this->username;
    }
}
