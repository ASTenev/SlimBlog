<?php
use Phinx\Seed\AbstractSeed;

class UsersSeed extends AbstractSeed
{
    public function run(): void
    {
        $UsersSeed = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
            ],
            [
                'name' => 'Jane Doe',
                'email' => 'jane@example.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
            ],
        ];
        $users = $this->table('users');
        $users->insert($UsersSeed)
              ->saveData();
    }
}
