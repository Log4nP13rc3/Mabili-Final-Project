<?php
//including the composer autoloader
require 'vendor/autoload.php';

//loading the .env file
Dotenv\Dotenv::createImmutable(__DIR__)->load();

//displaying the following
echo 'Database Hostname: ' . $_ENV['DB_HOSTNAME'] . "\n";
echo 'Database Port: ' . $_ENV['DB_PORT'] . "\n";
echo 'Database Username: ' . $_ENV['DB_USERNAME'] . "\n";
echo 'Database Password: ' . $_ENV['DB_PASSWORD'] . "\n";
echo 'Database Name: ' . $_ENV['DB_DATABASE'] . "\n";