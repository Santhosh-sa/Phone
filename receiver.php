<?php
// This is the main received called when a call is initiated to my twilio number.  
// The caller to my twilio number is prompted for a passcode which is validated againt my mysql database.
// The action programmed for that user is then taken.  Includes some test functions for when my friends call.
include './functions.php';
$error=false;

function ProcessAction($p_action){
    // Determines caller based on entered passcode (list stored in MySQL database) and takes appropriate action.
    switch ($p_action){
        case "trinity":        
            header("content-type: text/xml");
            $response = new Services_Twilio_Twiml();
            $response->pause(array('length' => '1'));
            $response->say("Passcode accepted.  Please leave a message at the beep, followed by the #.");
            $response->pause(array('length' => '1'));
            $response->record(array(
                'action' => $url . 'confirm.php?from=8142756101&db=trinity_phones',
                'maxLength' => '120')
            );
            $response->say('I did not receive a message');
            print $response;
            exit;            
            break;

        case "temporary":
            header("content-type: text/xml");
            $response = new Services_Twilio_Twiml();
            $response->say("Spacetime Continuum.");
            print $response;
            exit();
            break;

        case "amber":            
            header("content-type: text/xml");
            $response = new Services_Twilio_Twiml();
            $response->say("Passcode accepted.");
            $response->pause(array('length' => '1'));
            $response->say("A mushroom walks into a coffee shop and says, could I please have a cup of coffee?");
            $response->pause(array('length' => '1'));
            $response->say("Then the barista tells the mushroom food is not served there.");
            $response->pause(array('length' => '1'));
            $response->say("The mushroom says, why not?  I am a fungi!");
            $response->pause(array('length' => '1'));
            $response->say("Ha ha ha ha.  Remember, identify vegetation as safe before eating it.");
            $response->pause(array('length' => '1'));
            print $response;
            SendText("8147014250", "Amber Alert");
            exit();
            break;

        case "ambertweet":
            header("content-type: text/xml");
            $response = new Services_Twilio_Twiml();
            $response->say("Passcode accepted.  Goodbye for now.");
            print $response;
            SendText("8147014250", "Amber Alert");
            $tweetString = SetupRocksTweet('@AmberBoozer');
            $nothing = SendTweet($tweetString);            
            exit();
            break;

        case "kelsee":
            header("content-type: text/xml");
            $response = new Services_Twilio_Twiml();
            $response->say("Passcode accepted.  Have a great day, Kelsee.");        
            print $response;
            SendText($_REQUEST['From'], "Kelsee is awesome.  Have a great day.  Carlton");
            exit();
            break;

       case "kelseetweet":
            header("content-type: text/xml");
            $response = new Services_Twilio_Twiml();
            $response->say("Passcode accepted.  Goodbye for now.");
            print $response;
            SendText("8147014250", "Amber Alert");
            $tweetString = SetupRocksTweet('@kelseeboozer');
            $nothing = SendTweet($tweetString);
            exit();
            break;

        case "tina":
            header("content-type: text/xml");
            $response = new Services_Twilio_Twiml();
            $response->say("Passcode accepted.  Major mud is awesome.");
            SendText($_REQUEST['From'], "Majormud is awesome --  Carlton");     
            print $response;
            exit();
            break;

        default:
            $error=true;
            break;
    }  
}

if (strlen($_REQUEST['Digits'])) {
    $response = new Services_Twilio_Twiml();
    //$gather = $response->gather();
    $passcode = $_REQUEST['Digits'];
 
    //if the mailbox exists, redirect the call to the leave_a_message.php
    $p_action = GetPasscode($passcode);
    if ($p_action) {
        ProcessAction($p_action);
    } 
    else {
        $error=true;
    }
}
 
$response = new Services_Twilio_Twiml();
$gather = $response->gather();
 
if($error){
    $gather->say("Passcode not found.");
}

$gather->say("Enter your passcode, followed by the #");
$response->pause(array('length' => '10'));
$response->say('No passcode entered.  Enter your passcode, followed by the #');
$response->pause(array('length' => '10'));
$response->redirect('receiver.php');
print $response;
?>