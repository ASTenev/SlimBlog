<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\User;
use Slim\Views\Twig;
use Exception;

class UserController
{
    private $user;
    private $view;

    public function __construct(User $user, Twig $view)
    {
        $this->user = $user;
        $this->view = $view;
    }

    public function registrationForm(Request $request, Response $response)
    {
        return $this->view->render($response, 'users/register.twig');
    }

    public function show(Request $request, Response $response, $args)
    {
        //Check if id is set
        if (!isset($args['slug']) || !$args['slug']) {
            throw new Exception('Invalid parameters');
        }
        // Get user by ID
        $user_data = $this->user->getById($args['slug']);

        // Render view
        return $this->view->render($response, 'users/show.twig', [
            'user' => $user_data
        ]);
    }

    public function create(Request $request, Response $response)
    {
        // Get request parameters
        $params = $request->getParsedBody();
        if (!isset($params['name']) || !isset($params['email']) || !isset($params['password'])) {
            throw new Exception('Invalid parameters');
        }
        $params = [
            'name' => $params['name'],
            'email' => $params['email'],
            'password' => $params['password']
        ];

        // Try to Insert user into database
        session_start();
        try {
            $this->user->create($params);
            $_SESSION['flash'] = 'User created successfully.';
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
        $user_data = $request->getParsedBody();
        // Render view
        if (!count($user_data)) {
            $errors = ['Invalid user id'];
        }
        return $this->view->render($response, 'users/edit.twig', [
            'user' => $user_data,
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

        // Update user in database
        $this->user->update($args['id'], $params);

        // Redirect to users index
        return $response->withRedirect('/users');
    }

    public function delete(Request $request, Response $response, $args)
    {
        //Check if id is set
        if (!isset($args['id']) || !$args['id']) {
            throw new Exception('Invalid parameters');
        }

        // Delete user from database
        $this->user->delete($args['id']);

        // Redirect to users index
        return $response->withRedirect('/users');
    }
}
