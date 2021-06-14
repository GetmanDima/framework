<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePasswordResetsTable extends AbstractMigration
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
        $table = $this->table('password_resets');

        $table->addColumn('email', 'string');
        $table->addColumn('token', 'string');
        $table->addColumn(
            'created_at',
            'timestamp',
            [
                'default' => 'CURRENT_TIMESTAMP',
                'update' => '',
                'timezone' => false,
            ]
        );

        $table->create();
    }
}
