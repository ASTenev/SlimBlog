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
//Get the container
$container = $app->getContainer();

//Include container dependencies
require __DIR__ .'/dependancies.php';

//Load the routes
require __DIR__ .'/config/routes.php';

