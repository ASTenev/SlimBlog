<?php

namespace App\Repositories;

use App\Interfaces\RepositoryInterface;
use App\Repositories\UserRepository;

class PostRepository
{
    private $repository;
    private $userRepostiory;
    private $table = 'posts';

    public function __construct(RepositoryInterface $repository, UserRepository $userRepostiory)
    {
        $this->repository = $repository;
        $this->userRepostiory = $userRepostiory;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function get($field = '', $value = '')
    {
        //Build ORM object
        $orm = new \stdClass();
        $orm->table = $this->table;
        if ($field && $value) {
            $orm->field = $field;
            $orm->value = $value;
        }
        $posts = $this->repository->get($orm);
        foreach ($posts as $key => $post) {
            $posts[$key]['user'] = $this->userRepostiory->get('id', $post['user_id'])[0];
        }
        return $posts;
    }

    public function create($params)
    {
        if (!count($params)) {
            return false; // Prevent creating empty record
        }
        $orm = new \stdClass();
        $orm->table = $this->table;
        $orm->params = $params;
        return $this->repository->create($orm);
    }

    public function update($params)
    {
        if (!isset($params['id'])) {
            return false; // Prevent updating all records without condition
        } else {
            $id = $params['id'];
            unset($params['id']);
        }

        $orm = new \stdClass();
        $orm->table = $this->table;
        $orm->id = $id;
        $orm->params = $params;
        return $this->repository->update($orm);
    }

    public function delete($id)
    {
        if (!isset($id)) {
            return false; // Prevent deleting all records without condition
        }
        $orm = new \stdClass();
        $orm->table = $this->table;
        $orm->id = $id;
        return $this->repository->delete($orm);
    }
}
