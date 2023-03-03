<?php
use App\Controllers\HomeController;
use App\Controllers\PostController;
use App\Controllers\UserController;

$app->get('/', function ($request, $response, $args) {
    return $this->view->render($response, 'home.twig');
});


//$app->get('/', [HomeController::class, 'index']);

$app->post('/login', [UserController::class, 'login']);
$app->post('/register', [UserController::class, 'register']);

$app->group('/users', function () use ($app) {
    $app->get('', [UserController::class, 'getAll']);
    $app->get('/{id}', [UserController::class, 'getById']);
    $app->put('/{id}', [UserController::class, 'update']);
    $app->delete('/{id}', [UserController::class, 'delete']);
});

$app->group('/posts', function () use ($app) {
    $app->get('', [PostController::class, 'index']);
    $app->get('/{slug}', [PostController::class, 'show']);
    $app->post('', [PostController::class, 'create']);
    $app->put('/{id}', [PostController::class, 'update']);
    $app->delete('/{id}', [PostController::class, 'delete']);
});
