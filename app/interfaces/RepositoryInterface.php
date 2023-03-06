<?php

namespace App\Interfaces;

interface RepositoryInterface
{
    public function get(object $orm);
    public function create(object $orm);
    public function update(object $orm);
    public function delete(object $orm);
}
