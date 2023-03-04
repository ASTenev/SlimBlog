<?php
namespace App\Interfaces;

interface RepositoryInterface 
{
    public function read();
    public function create();
    public function update();
    public function delete();
}