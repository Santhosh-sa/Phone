<?php
// The test receiver for text messages sent to my twilio #.  If the user starts the text with "test99", it will be sent back to them
// from my twilio number less "test99"

include './functions.php';
header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$text = $_REQUEST['Body'];
$number = $_REQUEST['From'];
$choppedText = substr($text,6);
if (stripos($text, 'test99') == 0) {
	SendText($number, $choppedText);
	SendText("8147014250", "got a hit");
}
else {
	SendText( $number, "nope");	
}
