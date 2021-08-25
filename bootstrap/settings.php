<?php
/*  call the environment variables */
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

return [
    'settings' => [
        // Error display
        'displayErrorDetails'=>true,
        // Database connection settings
        "db" => [
            "host" => $_ENV['DB_HOST'],
            "dbname" => $_ENV['DB_NAME'],
            "user" => $_ENV['DB_USER'],
            "pass" => ""
        ],
    ],
];
