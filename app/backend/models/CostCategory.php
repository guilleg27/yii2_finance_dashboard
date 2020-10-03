<?php
namespace backend\models;

use Yii;

/**
 * This is the model class for table "cost_category".
 *
 * @property integer $id
 * @property string $cost_category
 *
 * @property FixedCost[] $fixedCosts
 */
class CostCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cost_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cost_category'], 'required'],
            [['cost_category'], 'unique'],
            [['cost_category'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cost_category' => 'Cost Category',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFixedCosts()
    {
        return $this->hasMany(FixedCost::className(), ['cost_category_id' => 'id']);
    }

}
