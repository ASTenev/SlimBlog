<?php
namespace App\Services;

use App\Services\DatabaseService;
use App\Models\User;

class UserService 
{
    private $db;
    private $user;

    public function __construct(DatabaseService $db, User $user)
    {
        $this->db = $db;
        $this->user = $user;
    }

    public function getAll()
    {
        return $this->db->get('users');
    }

    public function getById($id)
    {
        return $this->db->get('users',['id'=> $id]);
    }

    public function getByEmail($email)
    {
        return $this->db->get('users',['email' => $email]);
    }

    public function create($data)
    {
        return $this->db->create('users', $data);
    }

    public function update($id, $data)
    {
        return $this->db->update('users', $id, $data);
    }

    public function delete($id)
    {
        return $this->db->delete('users', $id);
    }
}
