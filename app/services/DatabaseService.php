<?php
namespace App\Services;

use App\Interfaces\DatabaseInterface;

class DatabaseService{
    private $db;
    private $table;
    private $conditions;
    private $data;

    function __construct(DatabaseInterface $db) {
        $this->db = $db;
    }

    function create(string $table, object $data) {
        return $this->db->create($table, $data);
    }

    function get(string $table, array $conditions = []) {
        return $this->db->read($table, $conditions);
    }

    function update(string $table, int $id, object $data) {
        return $this->db->update($table, $id, $data);
    }

    function delete(string $table, int $id) {
        return $this->db->delete($table, $id);
    }
}

