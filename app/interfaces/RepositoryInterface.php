<?php
namespace App\Interfaces;

interface RepositoryInterface 
{
    public function read(string $table, string $condition_field = '', string $condition_value = '');
    public function create(string $table, array $data);
    public function update(string $table, int $id, array $data);
    public function delete(string $table, int $id);
}