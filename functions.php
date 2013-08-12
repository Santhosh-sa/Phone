<?php
// Database Functions


function database_connection(){
    // Default database connection.  Add mysql_close() to end of each function
    $host = "";
    $user = "";
    $password = "";
    mysql_connect($host,$user,$password);
}

// Twilio
$sid = ""; // Your Account SID from www.twilio.com/user/account
$token = ""; // Your Auth Token from www.twilio.com/user/account
$version = '2010-04-01';
$URLbase = 'http://www.grovermind.com/phone/';

require('/home/grover7/pear/PEAR/Services/Twilio.php');

function GetPasscode($passcode){
    //Searches for a user based on the passcode they have entered
    database_connection();
    @mysql_select_db(grover7_grovermind) or die ("Unable to access database - please try again later"); 
    $query = "SELECT `action` FROM twilio_passcodes WHERE `passcode` = '$passcode'";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close();
    if($row = mysql_fetch_assoc($result)) {
        return $row['action'];
    }
    return false;    
}


function SendText($number, $text){
    //Sends a text message
    global $sid;
    global $token;
    $client = new Services_Twilio($sid, $token);
    try{
        $message = $client->account->sms_messages->create('8142756101',$number,$text);
    }
    catch (exception $ex) {
        return $ex;
    }  
    return TRUE;
}

function SendTexts($text){
    //Sends text message to a list of active users on a mysql table.
    database_connection();
    @mysql_select_db(grover7_grovermind) or die ("Unable to access database - please try again later");
    $sql = "SELECT phone from trinity_phones WHERE active = TRUE";
    $phoneNumbers = mysql_query($sql) or die(mysql_error());
    mysql_close();
    $count = 0;
    while ($count < mysql_num_rows($phoneNumbers)){
        $row = mysql_fetch_array($phoneNumbers);
        $result = SendText($row['phone'], $text);
        $count = $count + 1;
    }
    return true;
}

function MakeCall($from, $to, $URL){
    //Makes a Twilio call to a user and performs the action at the URL passed to the function.
    global $sid;
    global $token;
    // Twilio REST API version
    $version = "2010-04-01";
    
    // Instantiate a new Twilio Rest Client
    $client = new Services_Twilio($sid, $token, $version);
    try {
        // Initiate a new outbound call
        $call = $client->account->calls->create(
            $from, // The number of the phone initiating the call
            $to, // The number of the phone receiving call
            $URL // The URL Twilio will request when the call is answered
        );        
    } 
    catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
 }

function BroadcastMessage($from, $to, $URL){
    //Broadcasts a vioce message to a user
    database_connection();
    @mysql_select_db(grover7_grovermind) or die ("Unable to access database - please try again later");
    $sql = "SELECT phone from $to WHERE active = TRUE";
    $phoneNumbers = mysql_query($sql) or die(mysql_error());
    mysql_close();
    $count = 0;
    while ($count < mysql_num_rows($phoneNumbers)){
        $row = mysql_fetch_array($phoneNumbers);
        $result = MakeCall($from, $row['phone'], ('http://www.grovermind.com/phone/play.php?URL=' . $URL));
        $count = $count + 1;
    }
    return true;

}

function InsertPhone($number,$name,$notes){
    // Inserts an entered phone number into the database
    database_connection();
    @mysql_select_db(grover7_grovermind) or die ("Unable to access database - please try again later");        
    $sql = "INSERT INTO `trinity_phones`(`phone`, `name`, `notes`) VALUES ('$number', '$name', '$notes')";
    $result = mysql_query($sql) or die(mysql_error());    
    mysql_close();
    return $result;
}

function ProcessAction2($action){
    switch ($action){
        case "trinity":
            echo("trinity");
            break;

        case "temporary":
           echo("temporary");
           break;

        default:
            echo("error");
            break;
    }  
}

//Twitter - some experimenting using twilio and the Twitter to initiate messages when a phone call is madee.
 require_once '/home/grover7/php/Twitter-PHP/twitter.class.php';
$consumerKey       = "";
$consumerSecret    = "";
$accessToken       = "";
$accessTokenSecret = "";

function SetupRocksTweet($userID){
    date_default_timezone_set('EST');
    $time = date('H:i:s');
    $date = date('l \t\h\e jS \o\f F Y');
    $tweetString = "$userID Rocks at $time on $date.";
    return $tweetString;
}

function SendTweet($tweetString){
    global $consunerKey;
    global $comsumerSecret;
    global $accessToken;
    global $accessTokenSecret;
    $twitter = new Twitter($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
    $twitter->send($tweetString);
}

?>
