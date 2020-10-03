<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[GeoLocation]].
 *
 * @see GeoLocation
 */
class GeoLocationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return GeoLocation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return GeoLocation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
