<?php
$db = require __DIR__ . '/app/config/database.php';
return
[
    'paths' => [
        'migrations' => 'app/migrations',
        'seeds' => 'app/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'production' => [
            'adapter' => 'mysql',
            'host' => $db['host'],
            'name' => $db['name'],
            'user' => $db['username'],
            'pass' => $db['password'],
            'port' => '3306',
            'charset' => 'utf8',
        ],
        'development' => [
            'adapter' => 'mysql',
            'host' => $db['host'],
            'name' => $db['name'],
            'user' => $db['username'],
            'pass' => $db['password'],
            'port' => '3306',
            'charset' => 'utf8',
        ],
        'testing' => [
            'adapter' => 'mysql',
            'host' => $db['host'],
            'name' => $db['name'],
            'user' => $db['username'],
            'pass' => $db['password'],
            'port' => '3306',
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];
