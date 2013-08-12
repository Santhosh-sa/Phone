<?php
// Plays a recorded message. 
require './functions.php';
header("content-type: text/xml");
if ($_REQUEST['URL']) {
    $response = new Services_Twilio_Twiml();
	$response->say("The following is a recorded message.");
    $response->pause(array('length' => '1'));
	$response->play($_REQUEST['URL']);
    print $response;
}
