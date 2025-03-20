<?php

require __DIR__ . '/../vendor/autoload.php'; // Adjust path if needed

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../'); // Adjust path if needed
$dotenv->load();

echo "App Name: " . $_ENV['APP_NAME'] . "<br>";


function getTimestamp()
{
    return date("Y-m-d H:i:s");
}


?>