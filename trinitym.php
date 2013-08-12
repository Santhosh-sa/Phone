<?php 

// Define your username and password 
$username = "diet"; 
$password = "ofworms"; 

if ($_GET['deletemode'] == "yes"){
    setcookie("deletemode", true, time()+3600);    
}

if ($_GET['deletemode'] == "no"){
    setcookie("deletemode", false, time()+3600);
}

if ( ($_POST['txtUsername'] != $username || $_POST['txtPassword'] != $password) && $_COOKIE['LoggedIn'] == false) { 
    ?>

<h1>Login</h1> 

<form name="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
    <p><label for="txtUsername">Username:</label> 
    <br /><input type="text" title="Enter your Username" name="txtUsername" /></p> 

    <p><label for="txtpassword">Password:</label> 
    <br /><input type="password" title="Enter your password" name="txtPassword" /></p> 

    <p><input type="submit" name="Submit" value="Login" /></p> 

</form> 

<?php 

} 
else {
setcookie("LoggedIn", true, time()+3600);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Trinity Lutheran Church Text Message System</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <script type="text/javascript" src="validation.js"></script> 
    <script language="javascript" type="text/javascript">
        function submitText() {            
            var confirmation = confirm("Send this text to all selected recepients?");
            if (confirmation == true){
                document.getElementById("trinity").submit();
            }
            else{
                alert("No message sent");
            }
        }
    </script>
    <link rel="stylesheet" href="stylem.css">
    </head>
    
<body> 
<?php
include 'functions.php';

if( isset($_POST['area_code']) ){
    $phone = $_POST['area_code']."-".$_POST['phone']."-".$_POST['phone2'];
    InsertPhone($phone, $_POST['name'], $_POST['notes']);
}

if( isset($_GET['delete']) ){
    $member_phone = $_GET['member_phone'];
    database_connection();
    @mysql_select_db(grover7_grovermind) or die ("Unable to access database - please try again later");
    $sql = "DELETE from trinity_phones WHERE phone = '$member_phone'";
    $phoneNumbers = mysql_query($sql) or die(mysql_error());
    mysql_close();
}

else if( isset($_GET['member_phone']) ){
    $member_phone = $_GET['member_phone'];
    $active = 1;
    if ($_GET['active'] == 1) {
        $active = 0;
    }
    database_connection();
    @mysql_select_db(grover7_grovermind) or die ("Unable to access database - please try again later");
    $sql = "UPDATE trinity_phones SET active = $active WHERE phone = '$member_phone'";    
    $phoneNumbers = mysql_query($sql) or die(mysql_error());
    mysql_close();
}

database_connection();
@mysql_select_db(grover7_grovermind) or die ("Unable to access database - please try again later");
$sql = "SELECT phone, name, notes, active FROM trinity_phones";
$phoneNumbers = mysql_query($sql) or die(mysql_error());
mysql_close();

?>
<body>
 

  <div id= "phonelist">
    <h2 class = "blue">Trinity Lutheran Church</h2>
<br>
<br>
<table class='gridtable'><tr><th>This page allows you to enter in phone numbers and send group text messages.  The recipients can be activated to recive messages (green) or inactivated (red) by clicking on them.  The phone number to call to broadcast calls is (814) 275-6101.
</tr></th></table>
<br><br>

<table><table class='noborder'><th>
    <table class ='gridtable'><caption><h2>Phone List</caption>
        <TR><TH><h3>Name</TH><TH><h3>Phone</TH>
    
        <?php    
        $count = 0;        
        while($count < mysql_num_rows($phoneNumbers)){
            $row = mysql_fetch_array($phoneNumbers);
            if ($row['active'] == 1){
                $color = "green";
            }
            else{
                $color = "red";
            }
            echo "<TR>"; 
            echo "<TH class = '$color'>";
            echo "<a href = trinity.php?member_phone=".$row['phone']."&active=".$row['active'].">";
            echo($row['name']);
            echo "<TH class = '$color'>";            
            echo "<a href = trinity.php?member_phone=".$row['phone']."&active=".$row['active'].">";
            echo $row['phone'];
//            echo "</div>";//<TH class = '$color'><div style='width: 40%'>";
//            echo "<a href = trinity.php?member_phone=".$row['phone']."&active=".$row['active'].">";
//           echo $row['notes'];
//			echo "</div>";
            if( ($_COOKIE['deletemode'] == true || $_GET['deletemode'] == "yes") && $_GET['deletemode'] != "no"){
            	echo "<th bgcolor='#FF0000'>";
            	echo "<a href = trinity.php?member_phone=".$row['phone']."&delete=yes>";
            	echo "Delete";
            }
        $count = $count + 1;
        }
        ?>    
    </table> 
</th></table>
<br>
<?php 
if ( ($_COOKIE['deletemode'] == true || $_GET['deletemode'] == "yes") && $_GET['deletemode'] != "no"){
    echo('<form action="trinity.php?deletemode=no" method="post">');
}
else{
    echo('<form action="trinity.php?deletemode=yes" method="post">');
}
?>
<button name="deletemode" type="submit" align="left">Enable/Disable Deletions</button>
</form>
<br>
</div>
<div id= "phoneentry">
<table class='noborder'><th>
<table class='gridtable'><caption><h2>Phone Number Entry</caption>
    <th>
<form action="trinity.php" method="post">
    <fieldset>
    <p></p>
    <label for="area_code" class="displayBlock">Name</label>
    <input type="text" id="name" name="name" size = "30" maxlength="30">
    <p></p>
    <label for="area_code" class="displayBlock">Phone</label>
    (
    <input type="text" id="area_code" name="area_code" size = "3" maxlength="3">
    )
    <input type="text" id="phone" name="phone" size = "3" maxlength="3">
    -
    <input type="text" id="phone2" name="phone2" size = "4" maxlength="4">    
    <p></p>
<!--    <label for="area_code" class="displayBlock">Notes</label>
    <input type="text" id="notes" name="notes" size = "40" maxlength="100"> -->
    </fieldset> 
    <input type="submit" value="Store Number" /></form>
</th></table>

</th></table>
<br>
<br>
<table class='gridtable'><caption><h2>Text Message</caption><th>
    <br>
    Input a text message of up to 160 characters here and press "Send Text" to send it to all recipients shown in green.
    <form id="trinity" action="send.php" method="post">
        <textarea cols="30" rows="4" maxlength = "160" name="textmessage"></textarea><br>
        <input type="button" onclick="submitText()" value="Send Text">  
    </form>
</th></table>
<br>

</div>

</div></div>

<?php } ?>