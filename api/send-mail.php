<?php

require 'utils.php';
require __DIR__ . '/../vendor/autoload.php';

// env vars

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$MJ_APIKEY_PUBLIC = $_ENV['MJ_APIKEY_PUBLIC'];
$MJ_APIKEY_PRIVATE = $_ENV['MJ_APIKEY_PRIVATE'];


//
check_retell_signature();

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$required_fields = ['toEmail', 'fromEmail', 'fromName', 'emailSubject', 'emailHtml'];

check_required($data, $required_fields);

$to_email = $data['toEmail'];
$from_email = $data['fromEmail'];
$from_name = $data['fromName'];
$email_subject = $data['emailSubject'];
$email_html = $data['emailHtml'];

$url = "https://api.mailjet.com/v3.1/send";

$data = [
    "Messages" => [
        [
            "From" => ["Email" => $from_email, "Name" => $from_name],
            "To" => [["Email" => $to_email]],
            "Subject" => $email_subject,
            "HTMLPart" => $email_html
        ]
    ]
];

$headers = [
    "Content-Type: application/json"
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, "$MJ_APIKEY_PUBLIC:$MJ_APIKEY_PRIVATE");
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

return ["status" => $http_code, "response" => json_decode($response, true)];

?>