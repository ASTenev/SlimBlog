<?php
namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Services\UserService;
use App\Models\User;
use Slim\Views\Twig;

class AuthController {
    private $userService;
    private $view;

    public function __construct(UserService $userService, Twig $view) {
        $this->userService = $userService;
        $this->view = $view;
    }

    public function loginForm(Request $request, Response $response) {
        // Render view
        return $this->view->render($response, 'auth/login.twig');
    }

    public function registrationForm(Request $request, Response $response) {
        // Render view
        return $this->view->render($response, 'auth/register.twig');
    }

    public function register (Request $request, Response $response) {
        // Get request parameters
        $params = $request->getParsedBody();

        // Create new user object
        $user = new User();
        $user->setName($params['name']);
        $user->setEmail($params['email']);
        $user->setPassword(password_hash($params['password'], PASSWORD_DEFAULT));

        // Insert user into database
        $user = $this->userService->create($user);

        // Return success response
        return $response->withJson(['message' => 'Registration successful']);
    }

    public function login(Request $request, Response $response) {
        // Get request parameters
        $params = $request->getParsedBody();

        // Get user from database
        $user = $this->userService->getByEmail($params['email']);

        // Verify password
        if (!$user || !password_verify($params['password'], $user->getPassword())) {
            return $response->withStatus(401)->write('Invalid email or password');
        }

        // Set user ID in session
        $_SESSION['user_id'] = $user->getId();

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
