<?php

use batsg\migrations\BaseMigrationCreateTable;

/**
 * Handles the creation of table `{{%login_attempt}}`.
 */
class m200311_005938_create_login_attempt_table extends BaseMigrationCreateTable
{
    protected $table = 'login_attempt';

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function createDbTable()
    {
        $this->createTableWithExtraFields($this->table, [
            'id' => $this->primaryKey(),
            'key' => $this->string()->notNull(),
            'amount' => $this->integer(),
            'reset_at' => $this->integer(),
        ]);
        $this->createIndexes($this->table, [
            'key',
            'amount',
            'reset_at',
        ]);
    }
}
