<?php 
namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\Services\PostService;
use Slim\Views\Twig;

class HomeController{
    private $postService;
    private $view;

    public function __construct(PostService $postService, Twig $view) {
        $this->postService = $postService;
        $this->view = $view;
    }

    public function index(Request $request, Response $response) {
        // Get all posts
        $posts = $this->postService->getAll();

        // Render view
        return $this->view->render($response, '/home.twig', [
            'posts' => $posts
        ]);
    }
}
