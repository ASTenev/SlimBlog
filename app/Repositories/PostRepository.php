<?php
namespace App\Repositories;

use App\Interfaces\RepositoryInterface;

class PostRepository
{
    private $repository;
    private $table = 'posts';
    private $data = [];
    private $id;
    private $condition_field = '';
    private $condition_value = '';

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function setCondition($field, $value)
    {
        $this->condition_field = $field;
        $this->condition_value = $value;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getAll()
    {
        return $this->repository->read($this->table);
    }

    public function getByField()
    {
        return $this->repository->read($this->table,$this->condition_field,$this->condition_value);
    }

    public function create($data)
    {
        return $this->repository->create($this->table,$this->data);
    }

    public function update($id, $data)
    {
        return $this->repository->update($this->table,$this->id,$this->data);
    }

    public function delete($id)
    {
        return $this->repository->delete($this->table,$this->id);
    }
}
