<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Exception;

class FileUploadMiddleware
{
    private $uploadDir;

    public function __construct($uploadDir)
    {
        $this->uploadDir = $uploadDir;
    }

    public function __invoke(Request $request, Response $response, $next)
    {
        $files = $request->getUploadedFiles();
        $errors = [];

        foreach ($files as $name => $file) {
            if ($file->getError() === UPLOAD_ERR_OK) {
                $fileName = $this->moveUploadedFile($this->uploadDir, $file);
                $request = $request->withParsedBody(array_merge($request->getParsedBody(), [
                    $name => $fileName
                ]));
            } else {
                $errors[] = $file->getError();
            }
        }

        if (count($errors) > 0) {
            return $response->withStatus(400)->write('Error uploading file');
        }

        return $next($request, $response);
    }

    private function moveUploadedFile($directory, $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8));
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }
}
