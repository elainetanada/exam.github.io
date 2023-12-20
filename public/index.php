<?php

// Set error reporting to display all errors and warnings.
error_reporting(E_ALL);
ini_set('display_errors', 1); // comment to remove warnings and error messages.

require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../'); // The directory containing .env file
$dotenv->load();

require '../src/routes.php';