<?php
require __DIR__ . '/../vendor/autoload.php';

// env vars

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$RETELL_IP_ADDRESS = $_ENV['RETELL_IP_ADDRESS'];

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
    global $RETELL_IP_ADDRESS;

    $client_ip = $_SERVER['REMOTE_ADDR'] ?? null;

    if (!$client_ip || $client_ip !== $RETELL_IP_ADDRESS) {
        die(json_encode(["error" => "Unauthorized request. IP mismatch."]));
    }
}
?>