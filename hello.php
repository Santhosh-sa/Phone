<?php
//This is a test call that is initiated by hello.php 
require './functions.php';
           $response = new Services_Twilio_Twiml();
		   $response->pause(array('length' => '1'));
           $response->say("Knock Knock.  Who's There?  Madam.");
           $response->say("Madam who?  Madam foot got caught in the door!");
           $response->say("Ha ha ha hahaha.");
           print $response;
           exit();