<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class PostsTableCreate extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('posts');
        $table->addColumn('title', 'string')
              ->addColumn('content', 'text')
              ->addColumn('image', 'string', ['null' => true])
              ->addColumn('user_id', 'integer', ['signed' => false])
              ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
              ->addColumn('updated_at', 'datetime', ['null' => true])
              ->addForeignKey('user_id', 'users', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
              ->create();
    }
}
