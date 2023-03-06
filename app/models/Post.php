<?php
namespace App\Models;
use Exception;
use App\Repositories\PostRepository;

class Post 
{
    private $id;
    private $title;
    private $content;
    private $image;
    private $user_id;
    private $created_at;
    private $updated_at;
    private $repository;

     public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
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
        $post_data= $this->repository->getByField('id',$id);
        return $post_data[0] ?? null;
    }

    public function getByUserId($user_id)
    {
        // Get user by ID from database
        if (!isset($user_id) || !$user_id) {
            throw new Exception('Invalid parameters');
        }

        $user_data = $this->repository->getByField('user_id',$user_id);
        return $user_data[0] ?? null;
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

