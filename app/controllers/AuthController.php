<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\User;
use Slim\Views\Twig;

class AuthController
{
    private $user;
    private $view;

    public function __construct(User $user, Twig $view)
    {
        $this->user = $user;
        $this->view = $view;
    }

    public function loginForm(Request $request, Response $response)
    {
        if (isset($_SESSION['user'])) {
            return $response->withRedirect('/');
        }
        // Render view
        if (isset($_SESSION['flash'])) {
            $flash_message = $_SESSION['flash'];
            unset($_SESSION['flash']);
        }

        return $this->view->render($response, 'auth/login.twig', [
            'flash_message' => $flash_message ?? null,
            'session' => $_SESSION
        ]);
    }

    public function login(Request $request, Response $response)
    {
        // Get request parameters
        $params = $request->getParsedBody();
        // Get user from database

        $user_data = $this->user->getByEmail($params['email']);

        // Verify password
        if (!$user_data || !password_verify($params['password'], $user_data['password'])) {
            return $this->view->render($response, 'auth/login.twig', [
                'flash_message' => 'Invalid email or password!',
                'session' => $_SESSION
            ]);
        }
        session_start();
        // Set user ID in session
        $_SESSION['user'] = [
            'id' => $user_data['id'],
            'name' => $user_data['name']
        ];
        // Return success response
        return $response->withRedirect('/');
    }

    public function logout(Request $request, Response $response)
    {
        // Clear session data
        session_unset();
        session_destroy();

        // Return success response
        return $response->withRedirect('/');
    }
}
