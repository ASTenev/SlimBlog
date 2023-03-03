<?php
//Here the app is initialized and the routes are loaded
//This file is required in public\index.php

//Require the composer autoloader responsible for loading all the dependencies
require __DIR__ .'/../vendor/autoload.php';

//Initialize the app
$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
        ]
    ]);

$container = $app->getContainer();

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/views', [
        'cache' => false
    ]);

    // Instantiate and add Slim specific extension
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container->router, 
        $container->request->getUri()));

    return $view;
};


//Load the routes
require __DIR__ .'/config/routes.php';

