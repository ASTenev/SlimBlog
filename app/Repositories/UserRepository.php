<?php

namespace App\Repositories;

use App\Interfaces\RepositoryInterface;

class UserRepository
{
    private $repository;
    private $table = 'users';

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getAll()
    {
        $orm = new \stdClass();
        $orm->table = $this->table;

        return $this->repository->read($orm);
    }

    public function getByField($field, $value)
    {
        if (!isset($field) || !isset($value)) {
            return false; // Prevent reading all records without condition
        }
        //Build ORM object
        $orm = new \stdClass();
        $orm->table = $this->table;
        $orm->field = $field;
        $orm->value = $value;
        return $this->repository->read($orm);
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
        $orm->field = 'id';
        $orm->value = $id;
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
        $orm->value = $id;

        return $this->repository->delete($orm);
    }
}
