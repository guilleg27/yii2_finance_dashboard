<?php

use yii\db\Migration;

/**
 * Handles the creation of table `consolidated`.
 */
class m201002_231627_create_consolidated_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('consolidated', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('consolidated');
    }
}
