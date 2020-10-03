<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "providers_validation".
 *
 * @property integer $id
 * @property integer $providers_id
 * @property string $period
 * @property string $invoice
 * @property string $date
 * @property string $status
 * @property string $comment
 * @property string $payment_date
 * @property string $amount
 *
 * @property Providers $providers
 */
class ProvidersValidation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'providers_validation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['providers_id', 'period', 'date'], 'required'],
            [['providers_id'], 'integer'],
            [['period', 'date', 'payment_date'], 'safe'],
            [['status'], 'string'],
            [['amount'], 'number'],
            [['invoice'], 'string', 'max' => 45],
            [['comment'], 'string', 'max' => 255],
            [['providers_id'], 'exist', 'skipOnError' => true, 'targetClass' => Providers::className(), 'targetAttribute' => ['providers_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'providers_id' => 'Providers ID',
            'period' => 'Period',
            'invoice' => 'Invoice',
            'date' => 'Date',
            'status' => 'Status',
            'comment' => 'Comment',
            'payment_date' => 'Payment Date',
            'amount' => 'Amount',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProviders()
    {
        return $this->hasOne(Providers::className(), ['id' => 'providers_id']);
    }

    /**
     * @inheritdoc
     * @return ProvidersValidationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProvidersValidationQuery(get_called_class());
    }
}
