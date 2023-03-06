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

    public function get($field = '', $value = '')
    {
        //Build ORM object
        $orm = new \stdClass();
        $orm->table = $this->table;
        if ($field && $value) {
            $orm->field = $field;
            $orm->value = $value;
        }
        return $this->repository->get($orm);
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
}
