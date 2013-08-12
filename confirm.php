<?php
require './functions.php';

$rid 		  	= $_REQUEST['rid'];
$recordingURL 	= $_REQUEST['RecordingUrl'];
$from 		  	= $_REQUEST['from'];
$db 		  	= $_REQUEST['db'];

if ($rid) {
    $confirm = $_REQUEST['Digits'];
    if ($confirm == '1'){        
        $response = 'Your message is being broadcasted.';        
        $response = new Services_Twilio_Twiml();
        $response->say("Your message is being broadcasted.");
		header('content-type: text/xml');
        print $response;
		BroadcastMessage($from, $db, $rid);
        exit();
    }
}

$response = new Services_Twilio_Twiml();
if($error){
    $gather->say("Please enter your selection.");
}
$gather = $response->gather(array(
    'numDigits' => '1',
	'method' => 'GET', 
	'action'    => 'confirm.php?rid=' . $recordingURL . '&from=' . $from . '&db=' . $db)
);
$gather->play($_REQUEST['RecordingUrl']);
$gather->say("Press 1 to broadcast the following message or any other key to cancel.");
$gather->pause(array('length' => '10'));
header("content-type: text/xml");
print $response;

?>