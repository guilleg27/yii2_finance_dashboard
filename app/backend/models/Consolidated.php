<?php
namespace backend\models;

use yii\db\ActiveRecord;


/**
 * This is the model class for table "consolidated".
 *
 * @property integer $id
 * @property string $business_model
 * @property string $period
 * @property string $revenue_server
 * @property string $revenue_transaction
 * @property string $agency_commission
 * @property string $revenue_validated
 * @property string $revenue_invoiced
 * @property string $revenue_manual
 * @property string $spend_server
 * @property string $spend_off
 * @property string $spend_transaction
 * @property string $spend_validated
 * @property string $spend_invoiced
 * @property string $spend_manual
 * @property string $profit_manual
 * @property string $objective_revenue
 * @property string $objective_profit
 */
class Consolidated extends ActiveRecord
{
    public $businessModelId;
    public $businessModelName;
    public $fixedCost;
    public $avgInvoicedRevenue;
    public $avgInvoicedSpend;
    public $name;
    public $amount;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'consolidated';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['business_model_id', 'period'], 'required'],
            [['business_model_id', 'period'], 'safe'],
            [['business_model_id'], 'integer'],
            [['revenue_server', 'revenue_transaction', 'agency_commission', 'revenue_validated', 'revenue_invoiced', 'revenue_manual', 'spend_server', 'spend_off', 'spend_transaction', 'spend_validated', 'spend_invoiced', 'spend_manual', 'profit_manual', 'objective_revenue', 'objective_profit'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'business_model_id' => 'Business Model',
            'period' => 'Period',
            'revenue_server' => 'Revenue Server',
            'revenue_transaction' => 'Revenue Transaction',
            'agency_commission' => 'Agency Commission',
            'revenue_validated' => 'Revenue Validated',
            'revenue_invoiced' => 'Revenue Invoiced',
            'revenue_manual' => 'Revenue Manual',
            'spend_server' => 'Spend Server',
            'spend_off' => 'Spend Off',
            'spend_transaction' => 'Spend Transaction',
            'spend_validated' => 'Spend Validated',
            'spend_invoiced' => 'Spend Invoiced',
            'spend_manual' => 'Spend Manual',
            'profit_manual' => 'Profit Manual',
            'objective_revenue' => 'Objective Revenue',
            'objective_profit' => 'Objective Profit',
            'businessModelName' => 'Business Model',
            'avgInvoicedRevenue' => 'Invoiced Revenue',
            'avgInvoicedSpend' => 'Invoiced Spend',
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
