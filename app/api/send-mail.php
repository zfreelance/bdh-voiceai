<?php

if (!isset($_POST['fromEmail'], $_POST['fromName'], $_POST['emailSubject'], $_POST['emailHtml'])) {
    die("Error: Missing required fields.");
}


$from_email = $_POST['fromEmail'];
$from_name = $_POST['fromName'];
$email_subject = $_POST['emailSubject'];
$email_html = $_POST['emailHtml'];


?>