<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[ProvidersValidation]].
 *
 * @see ProvidersValidation
 */
class ProvidersValidationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ProvidersValidation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ProvidersValidation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
