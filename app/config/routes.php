<?php
namespace App\Config;

use App\Controllers\HomeController;
use App\Controllers\PostController;
use App\Controllers\UserController;

$app->get('/', 'HomeController:index');

$app->post('/login', 'AuthController:login'); 
$app->post('/register', 'AuthController:register');
$app->post('/logout', 'AuthController:logout');
$app->get('/login', 'AuthController:loginForm');
$app->get('/register', 'AuthController:registrationForm');

$app->group('/users', function () use ($app) {
    $app->get('', 'UserController:index');
    $app->get('/{id}', 'UserController:show');
    $app->put('/{id}', 'UserController:update');
    $app->delete('/{id}', 'UserController:delete');
});

$app->group('/posts', function () use ($app) {
    $app->get('', 'PostController:index');
    $app->get('/{slug}', 'PostController:show');
    $app->post('', 'PostController:create');
    $app->put('/{id}', 'PostController:update');
    $app->delete('/{id}', 'PostController:delete');
});
