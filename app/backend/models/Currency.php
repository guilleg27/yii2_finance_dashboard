<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "currency".
 *
 * @property integer $id
 * @property string $date
 * @property string $ARS
 * @property string $EUR
 * @property string $BRL
 * @property string $GBP
 * @property string $MXN
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['ARS', 'EUR', 'BRL', 'GBP', 'MXN'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'ARS' => 'Ars',
            'EUR' => 'Eur',
            'BRL' => 'Brl',
            'GBP' => 'Gbp',
            'MXN' => 'Mxn',
        ];
    }
    /**
     * Find for the nearest currency dated lower
     * @param  $date
     * @return Currency
     */
    public function findByDate($date)
    {
        $date = date('Y-m-d', strtotime($date));
        return Currency::find()
                        ->where('date <= DATE("'.$date.'")'/*['<=', 'date', 'DATE('.$date.')',]*/)
                        ->orWhere('date > DATE("'.$date.'")')
                        ->andWhere('MONTH(date) = MONTH("'.$date.'")')
                        ->orderBy(['date' => SORT_DESC])
                        ->one();
    }

    public function convert($from, $to, $value, $date = NULL)
    {
        if (is_null($date))
            $date = date('Y-m-d', strtotime('today'));
        else
            $date = date('Y-m-d', strtotime($date));

        if ($from == $to)
            return $value;
        
        $currency = $this->findByDate($date);

        if ($from == 'USD')
            return $value * $currency[$to];

        if ($to == 'USD')
            return $value / $currency[$from];

        return $value / $currency[$from] * $currency[$to];
    }
}
