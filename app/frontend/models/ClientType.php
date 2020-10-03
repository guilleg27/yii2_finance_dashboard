<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "client_type".
 *
 * @property integer $id
 * @property string $type
 * @property integer $type_crm_id
 *
 * @property Client[] $clients
 * @property TypeCrm $typeCrm
 */
class ClientType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_crm_id'], 'required'],
            [['type_crm_id'], 'integer'],
            [['type'], 'string', 'max' => 45],
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
            'type' => 'Type',
            'type_crm_id' => 'Type Crm ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClients()
    {
        return $this->hasMany(Client::className(), ['client_type_id' => 'id']);
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
     * @return ClientTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClientTypeQuery(get_called_class());
    }
}
