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

    public function index(Request $request, Response $response)
    {
        // Get all posts
        $posts = $this->post->getAll();

        // Sort to show latest posts first
        usort($posts, function ($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        // Render view
        return $this->view->render($response, 'posts/index.twig', [
            'posts' => $posts,
            'session' => $_SESSION ?? null
        ]);
    }

    public function showUserPosts(Request $request, Response $response, $args)
    {
        //Check if id is set
        if (!isset($args['id']) || !$args['id']) {
            throw new Exception('Invalid parameters');
        }
        // Get post by ID
        $posts = $this->post->getByUserId($args['id']);
        // Render view
        return $this->view->render($response, 'posts/index.twig', [
            'posts' => $posts,
            'session' => $_SESSION ?? null
        ]);
    }

    public function show(Request $request, Response $response, $args)
    {
        //Check if id is set
        if (!isset($args['slug']) || !$args['slug']) {
            throw new Exception('Invalid parameters');
        }
        // Get post by ID
        $post = $this->post->getById($args['slug']);
        // Render view
        return $this->view->render($response, 'posts/show.twig', [
            'post' => $post,
            'session' => $_SESSION ?? null
        ]);
    }

    public function createForm(Request $request, Response $response)
    {
        // Render view
        return $this->view->render(
            $response,
            'posts/create.twig',
            ['session' => $_SESSION ?? null]
        );
    }

    public function create(Request $request, Response $response)
    {
        // Get request parameters
        $params = $request->getParsedBody();
        if (!isset($params['title']) || !isset($params['content'])) {
            throw new Exception('Invalid parameters');
        }
        $params = [
            'title' => $params['title'],
            'content' => $params['content'],
            'image' => $params['image'],
            'user_id' => $_SESSION['user']['id']
        ];

        // Try to Insert post into database
        try {
            $this->post->create($params);
            $_SESSION['flash'] = 'Post created successfully.';
            return $response->withRedirect('/posts');
        } catch (Exception $e) {
            $_SESSION['flash'] = $e->getMessage();
            return $response->withRedirect('/posts');
        }
    }

    public function edit(Request $request, Response $response, $args)
    {
        //Check if id is set
        if (!isset($args['id']) || !$args['id']) {
            throw new Exception('Invalid parameters');
        }
        $post_data = $this->post->getById($args['id']);

        // Render view
        if (!$post_data) {
            $errors = ['Invalid post id'];
        }

        return $this->view->render($response, 'posts/create.twig', [
            'post' => $post_data,
            'errors' => $errors ?? [],
            'session' => $_SESSION ?? null
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
        unset($params['_METHOD']);
        $params['id'] = $args['id'];
        // Update post in database
        $this->post->update($params);

        //Show the updated post
        return $response->withRedirect('/posts/' . $args['id']);
    }

    public function delete(Request $request, Response $response, $args)
    {
        //Check if id is set
        if (!isset($args['id']) || !$args['id']) {
            throw new Exception('Invalid parameters');
        }
        // Delete post image
        $post = $this->post->getById($args['id']);
        if (file_exists(__DIR__ . "/../../public/images/posts/{$post['image']}")) {
            unlink(__DIR__ . "/../../public/images/posts/{$post['image']}");
        }
        // Delete post from database
        $this->post->delete($args['id']);
        // Redirect to posts index
        return $response->withRedirect($request->getUri()->getPath());
    }
}
