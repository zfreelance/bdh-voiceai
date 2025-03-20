<?php
require __DIR__ . '/../vendor/autoload.php';

// env vars

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$RETELL_APIKEY_PRIVATE = $_ENV['RETELL_APIKEY_PRIVATE'];

//

function getTimestamp()
{
    return date("Y-m-d H:i:s");
}

// check required vars
function check_required($data, $required_fields)
{
    foreach ($required_fields as $field) {
        if (empty($data[$field])) {
            http_response_code(400);
            die(json_encode(["error" => "Missing required field - $field."]));
        }
    }
}

function check_retell_signature(): void
{
    $api_key = $RETELL_APIKEY_PRIVATE ?? null;
    $signature_header = $_SERVER['HTTP_X_RETELL_SIGNATURE'] ?? null;

    $payload = file_get_contents('php://input');

    if (!$api_key || !$signature_header) {
        http_response_code(403);
        die(json_encode(["error" => "Missing API key or signature"]));
    }

    $expected_signature = hash_hmac('sha256', $payload, $api_key);

    if (!hash_equals($expected_signature, $signature_header)) {
        http_response_code(403);
        die(json_encode(["error" => "Invalid signature"]));
    }
}
?>