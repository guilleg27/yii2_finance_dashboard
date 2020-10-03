<?php
namespace backend\models;

use Yii;

/**
 * This is the model class for table "providers_costs".
 *
 * @property integer $id
 * @property string $cost
 * @property string $date
 * @property integer $providers_id
 * @property string $business_model
 *
 * @property Providers $providers
 */
class ProvidersCosts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'providers_costs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cost', 'providers_id'], 'required'],
            [['cost'], 'number'],
            [['date'], 'safe'],
            [['providers_id'], 'integer'],
            [['business_model'], 'string'],
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
            'cost' => 'Cost',
            'date' => 'Date',
            'providers_id' => 'Providers ID',
            'business_model' => 'Business Model',
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
     * @return ProvidersCostsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProvidersCostsQuery(get_called_class());
    }
}
