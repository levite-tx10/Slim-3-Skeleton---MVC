<?php

$container = $app->getContainer();

/* Database */
$container['db'] = function ($container) {
    $settings = $container->get('settings')['db'];
    $pdo = new PDO("mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'],
        $settings['user'], $settings['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    /* This ensures that all the responses are in associative array*/
    //$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};


/* Respect Validation */
$container['validator'] = function () {
    return new Awurth\SlimValidation\Validator();
};

/* Monolog Logger */
$container['logger'] = function($container) {
    $logger = new \Monolog\Logger('Slim-3 Skeleton');
    $file_handler = new \Monolog\Handler\StreamHandler('../logs/logs.md');
    $logger->pushHandler($file_handler);
    return $logger;
};
