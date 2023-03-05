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

    public function getAll()
    {
        $orm = new \stdClass();
        $orm->table = $this->table;
        $orm->join = $this->userRepostiory->getTable();
        $orm->join_field1 = 'user_id';
        $orm->join_field2 = 'id';
        $result = $this->repository->read($orm);
        foreach($result as $key => $value) {
            //remove password and email from result
            unset($result[$key]['password']);
            unset($result[$key]['email']);
        }
        return $result;
        }

    public function getByField($field, $value)
    {
        if (!isset($field) || !isset($value)) {
            return false; // Prevent reading all records without condition
        }

        $orm = new \stdClass();
        $orm->table = $this->table;
        $orm->join = $this->userRepostiory->getTable();
        $orm->join_field1 = 'user_id';
        $orm->join_field2 = 'id';
        $orm->field = $field;
        $orm->value = $value;
        $result = $this->repository->read($orm);
        foreach($result as $key => $value) {
            //remove password and email from result
            unset($result[$key]['password']);
            unset($result[$key]['email']);
        }
        return $result;
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

    public function delete($params)
    {
        if (!isset($params['id'])) {
            return false; // Prevent deleting all records without condition
        } else {
            $id = $params['id'];
            unset($params['id']);
        }

        $orm = new \stdClass();
        $orm->table = $this->table;
        $orm->id = $id;

        return $this->repository->delete($orm);
    }
}
