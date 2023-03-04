<?php
$container['view'] = function ($container) {
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
        $container->get('PostService'),
        $container->get('view')
    );
};

$container['UserController'] = function ($container) {
    return new App\Controllers\UserController(
        $container->get('UserService'),
        $container->get('view')
    );
};

$container['AuthController'] = function ($container) {
    return new App\Controllers\AuthController(
        $container->get('UserService'),
        $container->get('view')
    );
};

$container['PostController'] = function ($container) {
    return new App\Controllers\PostController(
        $container->get('PostService'),
        $container->get('view')
    );
};

$container['UserService'] = function ($container) {
    return new App\Services\UserService(
        $container->get('DatabaseService'),
        $container->get('UserModel')
    );
};

$container['PostService'] = function ($container) {
    return new App\Services\PostService(
        $container->get('DatabaseService'),
        $container->get('PostModel')
    );
};

$container['UserModel'] = function ($container) {
    return new App\Models\User();
};

$container['PostModel'] = function ($container) {
    return new App\Models\Post();
};

$container['DatabaseService'] = function ($container) {
    return new App\Services\DatabaseService(
        $container->get('Mysql')
    );
};

$container['Mysql'] = function ($container) {
    return new App\Database\Mysql();
};