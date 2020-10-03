<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "invoice_validation".
 *
 * @property integer $id
 * @property string $period
 * @property string $name
 * @property integer $invoice
 * @property string $type
 * @property integer $business_model_id
 * @property integer $entity_id
 *
 * @property BusinessModel $businessModel
 */
class InvoiceValidation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice_validation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['period', 'name', 'type', 'business_model_id', 'entity_id'], 'required'],
            [['period', 'amount'], 'safe'],
            [['invoice', 'business_model_id', 'entity_id'], 'integer'],
            [['type'], 'string'],
            [['name'], 'string', 'max' => 128],
            [['amount'], 'number'],
            [['business_model_id'], 'exist', 'skipOnError' => true, 'targetClass' => BusinessModel::className(), 'targetAttribute' => ['business_model_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'period' => 'Period',
            'name' => 'Name',
            'invoice' => 'Invoice',
            'type' => 'Type',
            'business_model_id' => 'Business Model ID',
            'entity_id' => 'Entity ID',
            'amount' => 'Amount',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessModel()
    {
        return $this->hasOne(BusinessModel::className(), ['id' => 'business_model_id']);
    }
}
