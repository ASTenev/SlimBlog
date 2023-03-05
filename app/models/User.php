<?php

namespace App\Models;

use Exception;
use App\Repositories\UserRepository;

class User
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function init($params)
    {
        if (isset($params['id'])) {
            $this->id = $params['id'];
        }
        if (isset($params['name'])) {
            $this->name = $params['name'];
        }
        if (isset($params['email'])) {
            $this->email = $params['email'];
        }
        if (isset($params['password'])) {
            $this->password = $params['password'];
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getAll()
    {
        // Get all users from database
        return $this->repository->getAll();
    }

    public function getById($id)
    {
        // Get user by ID from database
        if (!isset($id) || !$id) {
            throw new Exception('Invalid parameters');
        }

        $this->repository->getByField('id',$id);
    }

    public function getByEmail($email)
    {
        // Get user by email from database
        if (!isset($email) || !$email) {
            throw new Exception('Invalid parameters');
        }
        
        return $this->repository->getByField('email',$email);
    }

    public function create($params)
    {
        // Register user
        if (!isset($params['name']) || !isset($params['email']) || !isset($params['password'])) {
            throw new Exception('Invalid parameters');
        }
        $user_data = $this->repository->getByField('email', $params['email']);

        if ($user_data) {
            throw new Exception('Email already exists');
        }
        try {
            return $this->repository->create($params);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function update($params)
    {
        // Update user in database
        if (empty($params['id'])) {
            throw new Exception('Invalid parameters');
        }

        return $this->repository->update($params);
    }

    public function delete($params)
    {
        // Delete user from database
        if (empty($params['id'])) {
            throw new Exception('Invalid parameters');
        }

        return $this->repository->delete($params);
    }
}
