<?php
$text = "test99 hey";
$choppedText = substr($text,6);
//echo $choppedText;
if (stripos($text, 'test99') == 0) {
	echo $choppedText;
}