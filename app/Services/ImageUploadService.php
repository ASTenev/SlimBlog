<?php

namespace App\Services;

use Exception;

class ImageUploadService
{
    private $uploadDirectory;

    public function __construct($uploadDirectory)
    {
        $this->uploadDirectory = $uploadDirectory;
    }

    public function upload($file)
    {
        $targetFilePath = $this->uploadDirectory . basename($file['name']);
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Check if file is an image
        if (getimagesize($file['tmp_name']) === false) {
            throw new Exception('File is not an image');
        }

        // Check if file already exists
        if (file_exists($targetFilePath)) {
            throw new Exception('File already exists');
        }

        // Check file size
        if ($file['size'] > 500000) {
            throw new Exception('File is too large');
        }

        // Allow only certain file types
        if (!in_array($fileType, array('jpg', 'jpeg', 'png', 'gif'))) {
            throw new Exception('Invalid file type');
        }

        // Upload file
        if (!move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            throw new Exception('Error uploading file');
        }

        return $targetFilePath;
    }
}
