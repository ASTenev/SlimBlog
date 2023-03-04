<?php
namespace App\Services;

use App\Services\DatabaseService;
use App\Models\Post;

class PostService 
{
    private $db;
    private $post;

    public function __construct(DatabaseService $db, Post $post)
    {
        $this->db = $db;
        $this->post = $post;
    }

    public function getAll()
    {
        return $this->db->get('posts');
    }

    public function getById($id)
    {
        return $this->db->get('posts',['id'=> $id]);
    }

    public function getByUserId($user_id)
    {
        return $this->db->get('posts',['user_id' => $user_id]);
    }

    public function create($data)
    {
        return $this->db->create('posts', $data);
    }

    public function update($id, $data)
    {
        return $this->db->update('posts', $id, $data);
    }

    public function delete($id)
    {
        return $this->db->delete('posts', $id);
    }
}