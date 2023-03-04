<?php 
namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\Services\PostService;
use Slim\Views\Twig;

class PostController{
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
        return $this->view->render($response, 'posts/index.twig', [
            'posts' => $posts
        ]);
    }

    public function show(Request $request, Response $response, $args) {
        // Get post by ID
        $post = $this->postService->getById($args['id']);

        // Render view
        return $this->view->render($response, 'posts/show.twig', [
            'post' => $post
        ]);
    }

    public function create(Request $request, Response $response) {
        // Render view
        return $this->view->render($response, 'posts/create.twig');
    }

    public function store(Request $request, Response $response) {
        // Get request parameters
        $params = $request->getParsedBody();

        // Create new post object
        $post = new Post();
        $post->setTitle($params['title']);
        $post->setBody($params['body']);

        // Insert post into database
        $post = $this->postService->create($post);

        // Redirect to posts index
        return $response->withRedirect('/posts');
    }

    public function edit(Request $request, Response $response, $args) {
        // Get post by ID
        $post = $this->postService->getById($args['id']);

        // Render view
        return $this->view->render($response, 'posts/edit.twig', [
            'post' => $post
        ]);
    }

    public function update(Request $request, Response $response, $args) {
        // Get request parameters
        $params = $request->getParsedBody();

        // Get post by ID
        $post = $this->postService->getById($args['id']);

        // Update post object
        $post->setTitle($params['title']);
        $post->setBody($params['body']);

        // Update post in database
        $post = $this->postService->update($post->getId(), $post);

        // Redirect to posts index
        return $response->withRedirect('/posts');
    }

    public function delete(Request $request, Response $response, $args) {
        // Get post by ID
        $post = $this->postService->getById($args['id']);

        // Delete post from database
        $this->postService->delete($post->getId());

        // Redirect to posts index
        return $response->withRedirect('/posts');
    }
}
