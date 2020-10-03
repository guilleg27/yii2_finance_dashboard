<?php
namespace backend\models;

use Yii;

/**
 * This is the model class for table "business_model".
 *
 * @property integer $id
 * @property string $business_model
 *
 * @property FixedCost[] $fixedCosts
 */
class BusinessModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'business_model';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['business_model'], 'required'],
            [['business_model'], 'unique'],
            [['business_model'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'business_model' => 'Business Model',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFixedCosts()
    {
        return $this->hasMany(FixedCost::className(), ['business_model_id' => 'id']);
    }
}
