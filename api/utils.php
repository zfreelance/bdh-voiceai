<?php

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


?>