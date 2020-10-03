<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user_has_business_model".
 *
 * @property integer $user_id
 * @property integer $business_model_id
 *
 * @property BusinessModel $businessModel
 * @property User $user
 */
class UserHasBusinessModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_has_business_model';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'business_model_id'], 'required'],
            [['user_id', 'business_model_id'], 'integer'],
            [['business_model_id'], 'exist', 'skipOnError' => true, 'targetClass' => BusinessModel::className(), 'targetAttribute' => ['business_model_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['username', 'business_model'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User',
            'business_model_id' => 'Business Model',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessModel()
    {
        return $this->hasOne(BusinessModel::className(), ['id' => 'business_model_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
