<?php
include './functions.php';
//require "storenumbers.php";

/* File Location for use in REST URL */

/* Start TwiML */
header("content-type: text/xml");
$response = new Services_Twilio_Twiml();
    $response->record(array(
        'action' => $url . 'broadcast.php?number=' . $_REQUEST['From']
    ));
    $response->say('I did not receive a message');
print $response;
//http://twimlets.com/echo?Twiml=%3CResponse%3E%3CSay%3EHello+Carlton%2C+thanks+for+the+call%21%3C%2FSay%3E%3C%2FResponse%3E
?>
