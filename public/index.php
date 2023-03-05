<?php
session_cache_limiter(false);
session_start();
//Require the composer autoloader responsible for loading all the dependencies
require __DIR__ . '/../app/bootstrap.php';


//Run the application
$app->run();
