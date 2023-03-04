<?php 
namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Services\UserService as UserService;
use Slim\Views\Twig;

class UserController {
    private $userService;
    private $view;

    public function __construct(UserService $userService, Twig $view) {
        $this->userService = $userService;
        $this->view = $view;
    }

    public function index(Request $request, Response $response) {
        // Get all users
        $users = $this->userService->getAll();
        print_r($users);
        // Render view
        return $this->view->render($response, 'users/index.twig', [
            'users' => $users
        ]);
    }

    public function show(Request $request, Response $response, $args) {
        // Get user by ID
        $user = $this->userService->getById($args['id']);

        // Render view
        return $this->view->render($response, 'users/show.twig', [
            'user' => $user
        ]);
    }

    public function create(Request $request, Response $response) {
        // Render view
        return $this->view->render($response, 'users/create.twig');
    }

    public function store(Request $request, Response $response) {
        // Get request parameters
        $data = $request->getParsedBody();

        // Insert user into database
        $user = $this->userService->create($data);

        // Redirect to users index
        return $response->withRedirect('/users');
    }

    public function edit(Request $request, Response $response, $args) {
        // Get user by ID
        $user = $this->userService->getById($args['id']);

        // Render view
        return $this->view->render($response, 'users/edit.twig', [
            'user' => $user
        ]);
    }

    public function update(Request $request, Response $response, $args) {
        // Get request parameters
        $params = $request->getParsedBody();

        // Get the user by ID
        $user = $this->userService->getById($args['id']);

        // Update user object
        $user->setUsername($params['username']);
        $user->setEmail($params['email']);
        $user->setPassword($params['password']);

        // Update user in database
        $this->userService->update($user);

        // Redirect to users index
        return $response->withRedirect('/users');
    }

    public function delete(Request $request, Response $response, $args) {
        // Get the user by ID
        $user = $this->userService->getById($args['id']);

        // Delete user from database
        $this->userService->delete($user);

        // Redirect to users index
        return $response->withRedirect('/users');
    }
}
