<?php
namespace App\Config;

use App\Middlewares\AuthMiddleware;
use App\Models\Post;

$app->get('/', 'HomeController:index');

$app->post('/login', 'AuthController:login'); 
$app->get('/logout', 'AuthController:logout')->add('AuthMiddleware');
$app->get('/login', 'AuthController:loginForm');

$app->get('/register', 'UserController:registrationForm');
$app->post('/register', 'UserController:create');

$app->group('/users', function () use ($app) {
    $app->get('/{id}/posts', 'PostController:showUserPosts')->add('AuthMiddleware');
});

$app->group('/posts', function () use ($app) {
    $app->get('/create', 'PostController:createForm')->add('AuthMiddleware');
    $app->get('', 'PostController:index');
    $app->get('/{slug}', 'PostController:show');
    $app->post('', 'PostController:create')->add('AuthMiddleware');
    $app->put('/{id}', 'PostController:update')->add('AuthMiddleware');
    $app->delete('/{id}', 'PostController:delete')->add('AuthMiddleware');
    $app->get('/{id}/edit', 'PostController:edit')->add('AuthMiddleware');
    
});
