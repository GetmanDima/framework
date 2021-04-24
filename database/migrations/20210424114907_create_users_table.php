<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUsersTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('users');

        $table->addColumn('name', 'string');
        $table->addColumn('email', 'string');
        $table->addColumn('email_verified_at', 'timestamp', ['null' => true, 'default' => null]);
        $table->addColumn('password', 'string');
        $table->addColumn('remember_token',
                'string',
                ['null' => true, 'default' => null, 'limit' => 100]);

        $table->addTimestamps();

        $table->addIndex('email', ['unique' => true]);

        $table->create();
    }
}
