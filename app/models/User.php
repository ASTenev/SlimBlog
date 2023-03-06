<?php

namespace App\Models;

use Exception;
use App\Repositories\UserRepository;

class User
{
    private $repository;

    public function __construct(UserRepository $repository)
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

        $user_data = $this->repository->get('id', $id);
        return $user_data[0] ?? null;
    }

    public function getByEmail($email)
    {
        // Get user by email from database
        if (!isset($email) || !$email) {
            throw new Exception('Invalid parameters');
        }

        $user_data = $this->repository->get('email', $email);
        return $user_data[0] ?? null;
    }

    public function create($params)
    {
        // Register user
        $user_data = $this->repository->get('email', $params['email']);

        if ($user_data) {
            throw new Exception('Email already exists');
        }
        try {
            return $this->repository->create($params);
        } catch (Exception $e) {
            return $e;
        }
    }
}
