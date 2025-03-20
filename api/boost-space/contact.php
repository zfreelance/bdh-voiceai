<?php

require '../utils.php';
require './utils.php';


$BOOST_SPACE_APIKEY_PRIVATE = env('BOOST_SPACE_APIKEY_PRIVATE');

//
check_retell_signature();

$json = file_get_contents('php://input');
$data = json_decode($json, true)['args'] ?? null;

$required_fields = ['service', 'spaces', 'email', 'firstName', 'name', 'phone', 'customFieldsValues'];

check_required($data, $required_fields);

$service = $data['service'];
$spaces = $data['spaces'];
$email = $data['email'];
$first_name = $data['firstName'];
$name = $data['name'];
$phone = $data['phone'];
$customFieldsValues = $data['customFieldsValues'];

$boostUrl = get_boost_url($service);

$url = $boostUrl . "/api/contact";

// Payload data
$data = [
    "name" => $name,
    "email" => $email,
    "spaces" => $spaces,
    "firstname" => $first_name,
    "type" => "person",
    "phone" => $phone,
    "customFieldsValues" => $customFieldsValues
];
// Set up cURL request
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $BOOST_SPACE_APIKEY_PRIVATE"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode !== 200 && $httpCode !== 201) {
    http_response_code($httpCode);
    die(json_encode(["error" => "Request failed", "response" => $response]));
}

echo $response;
?>