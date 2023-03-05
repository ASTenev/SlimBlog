<?php
namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\User;
use Slim\Views\Twig;

class AuthController {
    private $user;
    private $view;

    public function __construct(User $user, Twig $view) {
        $this->user = $user;
        $this->view = $view;
    }

    public function loginForm(Request $request, Response $response) {
        // Render view
        return $this->view->render($response, 'auth/login.twig');
    }

    public function login(Request $request, Response $response) {
        // Get request parameters
        $params = $request->getParsedBody();
        $this->user->setEmail($params['email']);
        $this->user->setPassword($params['password']);
        // Get user from database
        $user_data = $this->user->findByEmail();
        
        // Verify password
        if (!$user_data || !password_verify($params['password'], $user_data->getPassword())) {
            return $response->withStatus(401)->write('Invalid email or password');
        }

        // Set user ID in session
        $_SESSION['user_id'] = $user_data->getId();

        // Return success response
        return $response->withJson(['message' => 'Login successful']);
    }

    public function logout(Request $request, Response $response) {
        // Clear session data
        session_unset();
        session_destroy();

        // Return success response
        return $response->withJson(['message' => 'Logout successful']);
    }
}
