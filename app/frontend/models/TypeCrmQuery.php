<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[TypeCrm]].
 *
 * @see TypeCrm
 */
class TypeCrmQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return TypeCrm[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TypeCrm|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
