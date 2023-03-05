<?php
namespace App\Models;

namespace App\Models;

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

    public function __construct( $repository) {
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
    
     public function findAll() {
        // Get all users from database
        return $this->repository->getAll();
    }

    public function findById($id) {
        // Get user by ID from database
        $this->repository->setCondition('id',$id);

        return $this->repository->getByField();
    }

    public function delete() {
        // Delete user from database
    }

    public function save() {
        // Save user to database
    }

    public function update() {
        // Update user in database
    }

    public function create() {
        

    }
}
