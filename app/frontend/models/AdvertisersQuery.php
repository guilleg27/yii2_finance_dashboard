<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[Advertisers]].
 *
 * @see Advertisers
 */
class AdvertisersQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Advertisers[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Advertisers|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
