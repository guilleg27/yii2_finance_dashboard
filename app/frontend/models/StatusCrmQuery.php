<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[StatusCrm]].
 *
 * @see StatusCrm
 */
class StatusCrmQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return StatusCrm[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return StatusCrm|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
