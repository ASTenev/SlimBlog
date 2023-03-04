<?php


use Phinx\Seed\AbstractSeed;

class PostsSeed extends AbstractSeed
{
    public function getDependencies(): array
    {
        return ['UsersSeed'];
    }
    public function run(): void
    {
         $PostSeed = [
            [
                'title' => 'First Post',                
                'content' => 'Quis alias quidem excepturi rerum atque nam. Eum ut est optio architecto a fugiat. Et quis repellendus voluptatum et. Sed inventore ea aperiam alias.
 
Earum nisi culpa. Praesentium a delectus praesentium voluptas rem cumque qui qui ut. Dolorem sed est tenetur est alias eum corrupti. Eaque dignissimos occaecati beatae quis in reprehenderit. Rem omnis incidunt vel rerum aut.
 
Odio sint ut qui omnis et qui deleniti. Eaque commodi rerum. Odio rerum repellat. Odio inventore quos. Temporibus laboriosam repellendus asperiores dolores provident ut. Voluptas aut harum rem repellat ea.',
                'user_id' => 1,
            ],
            [
                'title' => 'Second Post',                
                'content' => 'Quis alias quidem excepturi rerum atque nam. Eum ut est optio architecto a fugiat. Et quis repellendus voluptatum et. Sed inventore ea aperiam alias.
 
Earum nisi culpa. Praesentium a delectus praesentium voluptas rem cumque qui qui ut. Dolorem sed est tenetur est alias eum corrupti. Eaque dignissimos occaecati beatae quis in reprehenderit. Rem omnis incidunt vel rerum aut.
 
Odio sint ut qui omnis et qui deleniti. Eaque commodi rerum. Odio rerum repellat. Odio inventore quos. Temporibus laboriosam repellendus asperiores dolores provident ut. Voluptas aut harum rem repellat ea.',
                'user_id' => 1,
            ],
            [
                'title' => 'Thirt Post',
                'content' => 'Quis alias quidem excepturi rerum atque nam. Eum ut est optio architecto a fugiat. Et quis repellendus voluptatum et. Sed inventore ea aperiam alias.
 
Earum nisi culpa. Praesentium a delectus praesentium voluptas rem cumque qui qui ut. Dolorem sed est tenetur est alias eum corrupti. Eaque dignissimos occaecati beatae quis in reprehenderit. Rem omnis incidunt vel rerum aut.
 
Odio sint ut qui omnis et qui deleniti. Eaque commodi rerum. Odio rerum repellat. Odio inventore quos. Temporibus laboriosam repellendus asperiores dolores provident ut. Voluptas aut harum rem repellat ea.',
                'user_id' => 2,
            ],
            [
                'title' => 'Fourth Post',
                'content' => 'Quis alias quidem excepturi rerum atque nam. Eum ut est optio architecto a fugiat. Et quis repellendus voluptatum et. Sed inventore ea aperiam alias.
 
Earum nisi culpa. Praesentium a delectus praesentium voluptas rem cumque qui qui ut. Dolorem sed est tenetur est alias eum corrupti. Eaque dignissimos occaecati beatae quis in reprehenderit. Rem omnis incidunt vel rerum aut.
 
Odio sint ut qui omnis et qui deleniti. Eaque commodi rerum. Odio rerum repellat. Odio inventore quos. Temporibus laboriosam repellendus asperiores dolores provident ut. Voluptas aut harum rem repellat ea.',
                'user_id' => 2,
            ],
        ];
        $posts = $this->table('posts');
        $posts->insert($PostSeed)
              ->saveData();
    }
}
