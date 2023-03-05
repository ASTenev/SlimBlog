<?php 
namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\Models\Post;
use Slim\Views\Twig;

class HomeController{
    private $post;
    private $view;

    public function __construct(Post $post, Twig $view) {
        $this->post = $post;
        $this->view = $view;
    }

    public function index(Request $request, Response $response) {
        // Get all posts
        $posts = $this->post->findAll();
        // Render view
        return $this->view->render($response, 'posts/index.twig', [
            'posts' => $posts
        ]);
    }
}
