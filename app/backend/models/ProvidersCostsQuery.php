<?php
namespace backend\models;

/**
 * This is the ActiveQuery class for [[ProvidersCosts]].
 *
 * @see ProvidersCosts
 */
class ProvidersCostsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ProvidersCosts[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ProvidersCosts|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
