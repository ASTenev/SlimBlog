<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Post;
use Slim\Views\Twig;
use Exception;

class PostController
{
    private $post;
    private $view;

    public function __construct(Post $post, Twig $view)
    {
        $this->post = $post;
        $this->view = $view;
    }

    public function index (Request $request, Response $response)
    {
        // Get all posts
        $posts = $this->post->getAll();

        // Render view
        return $this->view->render($response, 'posts/index.twig', [
            'posts' => $posts
        ]);
    }

    public function show(Request $request, Response $response, $args)
    {
        //Check if id is set
        if (!isset($args['slug']) || !$args['slug']) {
            throw new Exception('Invalid parameters');
        }
        // Get post by ID
        $post_data = $this->post->getById($args['slug']);
        
        // Render view
        return $this->view->render($response, 'posts/show.twig', [
            'post' => $post_data[0]
        ]);
    }

    public function create(Request $request, Response $response)
    {
        // Get request parameters
        $params = $request->getParsedBody();
        if (!isset($params['title']) || !isset($params['content']) || !isset($params['image'])) {
            throw new Exception('Invalid parameters');
        }
        $params = [
            'name' => $params['title'],
            'email' => $params['content'],
            'password' => $params['image']
        ];

        // Try to Insert post into database
        session_start();
        try {
            $this->post->create($params);
            $_SESSION['flash'] = 'Post created successfully.';
            return $response->withRedirect('/login');
        } catch (Exception $e) {
            $_SESSION['flash'] = $e->getMessage();
            return $response->withRedirect('/register');
        }
    }

    public function edit(Request $request, Response $response, $args)
    {
        //Check if id is set
        if (!isset($args['id']) || !$args['id']) {
            throw new Exception('Invalid parameters');
        }
        $post_data = $request->getParsedBody();
        // Render view
        if (!count($post_data)) {
            $errors = ['Invalid post id'];
        }
        return $this->view->render($response, 'posts/edit.twig', [
            'post' => $post_data,
            'errors' => $errors
        ]);
    }

    public function update(Request $request, Response $response, $args)
    {
        //Check if id is set
        if (!isset($args['id']) || !$args['id']) {
            throw new Exception('Invalid parameters');
        }
        // Get request parameters
        $params = $request->getParsedBody();

        // Update post in database
        $this->post->update($args['id'], $params);

        // Redirect to posts index
        return $response->withRedirect('/posts');
    }

    public function delete(Request $request, Response $response, $args)
    {
        //Check if id is set
        if (!isset($args['id']) || !$args['id']) {
            throw new Exception('Invalid parameters');
        }

        // Delete post from database
        $this->post->delete($args['id']);

        // Redirect to posts index
        return $response->withRedirect('/posts');
    }
}
