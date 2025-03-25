<?php

require 'utils.php';
require __DIR__ . '/../vendor/autoload.php';

use Twilio\Rest\Client;

// env vars

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$TW_ACCOUNT_SID = env(key: 'TW_ACCOUNT_SID');
$TW_AUTH_TOKEN = env('TW_AUTH_TOKEN');

$twilio_number = "+14389019449";

check_retell_signature();

$json = file_get_contents('php://input');
$data = json_decode($json, true) ?? null;
$args = $data['args'] ?? null;

$required_fields = ['message'];

check_required($args, $required_fields);

$message = $data['message'];
$to_number = $data['call']['from_number'];

$client = new Client($TW_ACCOUNT_SID, $TW_AUTH_TOKEN);

$client->messages->create(
    $to_number,

    array(
        'from' => $twilio_number,
        'body' => $message
    )
);
?>