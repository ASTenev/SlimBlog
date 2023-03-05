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

    public function getAll()
    {
        return $this->repository->read($this->table);
    }

    public function getByField($params)
    {
        if(!isset($params['field']) || !isset($params['value'])){
            return false;// Prevent reading all records without condition
        } 
        return $this->repository->read($this->table,$params['field'],$this->$params['value']);
    }

    public function create($params)
    {
        if(!count($params)){
            return false;// Prevent creating empty record
        } 
        return $this->repository->create($this->table,$params);
    }

    public function update($params)
    {
        if(!isset($params['id'])){
            return false;// Prevent updating all records without condition
        } else {
            $id = $params['id'];
            unset($params['id']);
        }

        return $this->repository->update($this->table,$id,$params);
    }

    public function delete($params)
    {
        if(!isset($params['id'])){
            return false;// Prevent deleting all records without condition
        } else {
             $id = $params['id'];
            unset($params['id']);
        }
        return $this->repository->delete($this->table,$id);
    }
}