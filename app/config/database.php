<?php
if (file_exists(__DIR__ . '/../.env')) {
    $envVars = parse_ini_file($envFile);
    foreach ($envVars as $key => $value) {
        putenv("$key=$value");
    }
}

return [
    'host' => getenv('DB_HOST'),
    'name' => getenv('DB_NAME'),
    'username' => getenv('DB_USER'),
    'password' => getenv('DB_PASS'),
];