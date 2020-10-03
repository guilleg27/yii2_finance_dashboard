<?php

namespace backend\models;

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
    public $id;
    public $username;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_assignment';
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
}
