<?php
namespace App\Interfaces;

interface DatabaseInterface 
{
    public function read(string $table, array $condition = []);
    public function create(string $table, array $data);
    public function update(string $table, int $id, array $data);
    public function delete(string $table, int $id);
}