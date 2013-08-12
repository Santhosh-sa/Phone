<?php
require './functions.php';

// Outgoing Caller ID you have previously validated with Twilio

$client = new Services_Twilio($sid, $token, $version);
$record = ($_REQUEST['rid']);

if(strlen($_REQUEST['Digits'])){
    $number = '';
    $contacts = '';
    $output = '';
    if (empty($contacts)) {
        // Warn the caller if we didn't find any contacts
        $response = 'No Contacts could be found';

    } else {

        // Call each contact
        //foreach ($contacts as $output) {
            try {
                $url = $URLbase . 'play.php?url=' . $record;
                //MakeCall($number,$output,$url);
                $client->account->calls->create($number, $output, $url);
            } 
            catch (Exception $e) {
                // log error
            }
        //}
        $response = 'Your message has been broadcasted';
    }
}

header('content-type: text/xml');
print $response;

?>