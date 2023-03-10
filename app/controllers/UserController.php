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
        if (isset($_SESSION['user'])) {
            return $response->withRedirect('/');
        }
        return $this->view->render($response, 'users/register.twig');
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
            'password' => password_hash($params['password'], PASSWORD_DEFAULT)
        ];

        // Try to Insert user into database
        try {
            $this->user->create($params);
            $_SESSION['flash'] = 'User created successfully.';
            return $response->withRedirect('/login');
        } catch (Exception $e) {
            $_SESSION['flash'] = $e->getMessage();
            return $response->withRedirect('/register');
        }
    }
}
