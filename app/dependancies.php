<?php
$container['View'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/views', [
        'cache' => false
    ]);

    // Instantiate and add Slim specific extension
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));

    return $view;
};

$container['HomeController'] = function ($container) {
    return new App\Controllers\HomeController(
        $container->get('Post'),
        $container->get('View')
    );
};

$container['UserController'] = function ($container) {
    return new App\Controllers\UserController(
        $container->get('User'),
        $container->get('View')
    );
};

$container['AuthController'] = function ($container) {
    return new App\Controllers\AuthController(
        $container->get('User'),
        $container->get('View'),
        $container
    );
};

$container['PostController'] = function ($container) {
    return new App\Controllers\PostController(
        $container->get('Post'),
        $container->get('View')
    );
};

$container['User'] = function ($container) {
    return new App\Models\User(
        $container->get('UserRepository')
    );
};

$container['Post'] = function ($container) {
    return new App\Models\Post(
        $container->get('PostRepository')
    );
};

$container['Mysql'] = function ($container) {
    return new App\Database\Mysql();
};

$container['UserRepository'] = function ($container) {
    return new App\Repositories\UserRepository(
        $container->get('Mysql')
    );
};

$container['PostRepository'] = function ($container) {
    return new App\Repositories\PostRepository
    (
        $container->get('Mysql')
    );
};
