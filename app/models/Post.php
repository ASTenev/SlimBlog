<?php

namespace App\Models;

use Exception;
use App\Repositories\PostRepository;

class Post
{
    private $repository;

    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        // Get all users from database
        return $this->repository->get();
    }

    public function getById($id)
    {
        // Get user by ID from database
        if (!isset($id) || !$id) {
            throw new Exception('Invalid parameters');
        }
        $posts = $this->repository->get('id', $id);
        return $posts[0] ?? null;
    }

    public function getByUserId($user_id)
    {
        // Get user by ID from database
        if (!isset($user_id) || !$user_id) {
            throw new Exception('Invalid parameters');
        }

        $posts = $this->repository->get('user_id', $user_id);

        return $posts ?? null;
    }

    public function create($params)
    {
        // Create post in database
        return $this->repository->create($params);
    }

    public function update($params)
    {
        // Update user in database
        if (empty($params['id'])) {
            throw new Exception('Invalid parameters');
        }
        return $this->repository->update($params);
    }

    public function delete($id)
    {
        // Delete user from database
        if (empty($id)) {
            throw new Exception('Invalid parameters');
        }

        return $this->repository->delete($id);
    }
}
