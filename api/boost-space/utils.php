<?php

function get_boost_url($service)
{
    switch ($service) {
        case 'bdhcollective':
            return 'https://bdhcollective.boost.space';
        default:
            http_response_code(400);
            die(json_encode(["error" => "No auth token received"]));
    }
}

?>