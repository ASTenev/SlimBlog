<?php
namespace App\Config;

use App\Middlewares\AuthMiddleware;

$app->get('/', 'HomeController:index');

$app->post('/login', 'AuthController:login'); 
$app->post('/logout', 'AuthController:logout')->add(new AuthMiddleware());;
$app->get('/login', 'AuthController:loginForm');

$app->get('/register', 'UserController:registrationForm');
$app->post('/register', 'UserController:create');

$app->group('/users', function () use ($app) {
    $app->get('/{id}', 'UserController:show')->add(new AuthMiddleware());;
    $app->put('/{id}', 'UserController:update')->add(new AuthMiddleware());;
    $app->delete('/{id}', 'UserController:delete')->add(new AuthMiddleware());;
    $app->get('/{id}/edit', 'UserController:edit')->add(new AuthMiddleware());;
});

$app->group('/posts', function () use ($app) {
    $app->get('/create', 'PostController:createForm')->add(new AuthMiddleware());;
    $app->get('', 'PostController:index');
    $app->get('/{slug}', 'PostController:show');
    $app->post('', 'PostController:create')->add(new AuthMiddleware());;
    $app->put('/{id}', 'PostController:update')->add(new AuthMiddleware());;
    $app->delete('/{id}', 'PostController:delete')->add(new AuthMiddleware());;
    $app->get('/{id}/edit', 'PostController:edit')->add(new AuthMiddleware());;
    
});
