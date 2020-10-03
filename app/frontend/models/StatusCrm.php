<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "status_crm".
 *
 * @property integer $id
 * @property string $status
 * @property integer $level
 * @property integer $type_crm_id
 *
 * @property Crm[] $crms
 * @property TypeCrm $typeCrm
 */
class StatusCrm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'status_crm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'type_crm_id'], 'integer'],
            [['type_crm_id'], 'required'],
            [['status'], 'string', 'max' => 45],
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
            'status' => 'Status',
            'level' => 'Level',
            'type_crm_id' => 'Type Crm ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCrms()
    {
        return $this->hasMany(Crm::className(), ['status_crm_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeCrm()
    {
        return $this->hasOne(TypeCrm::className(), ['id' => 'type_crm_id']);
    }

    /**
     * @inheritdoc
     * @return StatusCrmQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StatusCrmQuery(get_called_class());
    }
}
