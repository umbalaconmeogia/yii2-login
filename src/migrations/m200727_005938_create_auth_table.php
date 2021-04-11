<?php

use batsg\migrations\BaseMigrationCreateTable;

/**
 * Handles the creation of table `auth`.
 */
class m200727_005938_create_auth_table extends BaseMigrationCreateTable
{
    protected $table = 'auth';

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function createDbTable()
    {
        $this->createTableWithExtraFields($this->table, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'source' => $this->string()->notNull(),
            'source_id' => $this->string()->notNull(),
        ]);
    }
}
