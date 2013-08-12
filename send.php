<?php

include './functions.php';
if( (empty($_POST['area_code'])) && (empty($_POST['textmessage']) )){
   header('Location:http://www.grovermind.com');
}
else{
    if( isset($_POST['textmessage']) ){
        SendTexts($_POST['textmessage']);
    }

    if( isset($_POST['area_code']) ){
        $phone = $_POST['area_code']."-".$_POST['phone']."-".$_POST['phone2'];
        echo $phone;
        InsertPhone($phone, $_POST['name'], $_POST['notes']);
    }
    header('Location:http://www.grovermind.com/phone/trinity.php');
}

?>