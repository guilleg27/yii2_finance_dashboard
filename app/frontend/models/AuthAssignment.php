<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "AuthAssignment".
 *
 * @property string $itemname
 * @property string $userid
 * @property string $bizrule
 * @property string $data
 *
 * @property AuthItem $itemname0
 */
class AuthAssignment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'AuthAssignment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['itemname', 'userid'], 'required'],
            [['bizrule', 'data'], 'string'],
            [['itemname', 'userid'], 'string', 'max' => 64],
            [['itemname'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['itemname' => 'name']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'itemname' => 'Itemname',
            'userid' => 'Userid',
            'bizrule' => 'Bizrule',
            'data' => 'Data',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemname0()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'itemname']);
    }

    /**
     * @inheritdoc
     * @return AuthAssignmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AuthAssignmentQuery(get_called_class());
    }
}
