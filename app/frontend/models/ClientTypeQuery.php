<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[ClientType]].
 *
 * @see ClientType
 */
class ClientTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ClientType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ClientType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
