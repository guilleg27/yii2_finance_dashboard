<?php
namespace backend\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "fixed_cost".
 *
 * @property integer $id
 * @property string $period
 * @property string $cost
 * @property string $description
 * @property integer $cost_category_id
 * @property integer $business_model_id
 *
 * @property CostCategory $costCategory
 * @property BusinessModel $businessModel
 */
class FixedCost extends ActiveRecord
{
    public $revenue_server;
    public $revenue_transaction;
    public $agency_commission;
    public $revenue_to_validate;
    public $revenue_validated;
    public $revenue_invoiced;
    public $revenue_manual;
    public $spend_server;
    public $spend_off;
    public $spend_transaction;
    public $spend_to_validate;
    public $spend_validated;
    public $spend_invoiced;
    public $spend_manual;
    public $profit_manual;
    public $objective_revenue;
    public $objective_profit;
    public $fixedCost;
    public $businessModelName;
    public $cost_category;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fixed_cost';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['period', 'cost', 'cost_category_id', 'business_model_id'], 'required'],
            [['period'], 'safe'],
            [['cost'], 'number'],
            [['description'], 'string'],
            [['cost_category_id', 'business_model_id'], 'integer'],
            [['cost_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CostCategory::className(), 'targetAttribute' => ['cost_category_id' => 'id']],
            [['business_model_id'], 'exist', 'skipOnError' => true, 'targetClass' => BusinessModel::className(), 'targetAttribute' => ['business_model_id' => 'id']],
            [['period'], 'unique', 'targetAttribute' => ['period', 'cost_category_id', 'business_model_id'], 'message' => 'The combination of Period, Cost Category and Business Model has already been taken.' ],
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
            'cost' => 'Cost',
            'description' => 'Description',
            'cost_category_id' => 'Cost Category',
            'business_model_id' => 'Business Model',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCostCategory()
    {
        return $this->hasOne(CostCategory::className(), ['id' => 'cost_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessModel()
    {
        return $this->hasOne(BusinessModel::className(), ['id' => 'business_model_id']);
    }

    public function getCosts(){
        return $this::find()
              ->select(['cost_category.cost_category as cost_category', 'business_model.business_model as businessModelName', 'sum(cost) as cost'])
              ->joinWith('costCategory')
              ->joinWith('businessModel')
              ->groupBy(['business_model.business_model', 'cost_category.cost_category'])
              ->all();
    }
}
