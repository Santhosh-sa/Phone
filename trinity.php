<?php 
// The user page for the text and voice broadcast system.  Allows sending of texts and addition of users to the database.
// Personal information and passwords have been removed.
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
header('Location: ./trinitym.php');
// Define your username and password 
$username = ""; 
$password = ""; 

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
    <link rel="stylesheet" href="style.css">
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
 <div align="center">
  <table border="0" cellspacing="0" cellpadding="0">
   <tr>
    <td>
     <table border="0" cellspacing="0" cellpadding="0" width="1002">
      <tr valign="top" align="left">
       <td height="4"></td>
      </tr>
      <tr valign="top" align="left">
       <td height="90" width="1002"><img id="Picture509" height="88" width="1000" src="../trinity/trinity1.jpg" border="0" alt="k_01" title="k_01" style="border: 1px solid rgb(0,0,0);"></td>
      </tr>
     </table>

  <table border="0" cellspacing="0" cellpadding="0" width="1002">
      <tr valign="top" align="left">
       <td height="2"></td>
      </tr>
      <tr valign="top" align="left">
       <td height="42" width="1002"><img id="Picture97" height="40" width="1000" src="../trinity/trinity2.jpg" border="0" alt="k_02" title="k_02" style="border: 1px solid rgb(0,0,0);"></td>
      </tr>
  </table>
  <table border="0" cellspacing="0" cellpadding="0" width="1002">
      <tr valign="top" align="left">
       <td height="2"></td>
      </tr>
      <tr valign="top" align="left">
       <td height="54" width="1002"><img id="Picture292" height="52" width="1000" src="../trinity/trinity3.jpg" border="0" alt="k_01" title="k_01" style="border: 1px solid rgb(51,51,51);"></td>
      </tr>
  </table>

<div id= "info">
<a href="http://www.trinitysomerset.org">Home</a>
<a href="http://www.trinitysomerset.org/html/about_us.html">About Us</a>
<a href="http://www.trinitysomerset.org/html/calendar___events.html">Calendar <br>and Events</a>
<a href="http://www.trinitysomerset.org/html/christian_education.html">Christian <br>Education</a>
<a href="http://www.trinitysomerset.org/html/contact_us.html">Contact Us</a>
<a href="http://www.trinitysomerset.org/html/ministries.html">Ministries</a>
<a href="http://www.trinitysomerset.org/Easter_II_2013.pdf">Newsletter</a>
<a href="http://www.trinitysomerset.org/html/photos.html">Photos</a>
<a href="http://www.trinitysomerset.org/html/staff.html">Staff</a>
<a href="http://www.trinitysomerset.org/html/what_to_expect.html">What to <br>Expect</a>
</div>

<div id= "main">
  <div id= "phonelist">
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
    <input type="text" id="name" name="name" size = "40" maxlength="30">
    <p></p>
    <label for="area_code" class="displayBlock">Phone</label>
    (
    <input type="text" id="area_code" name="area_code" size = "1" maxlength="3">
    )
    <input type="text" id="phone" name="phone" size = "1" maxlength="3">
    -
    <input type="text" id="phone2" name="phone2" size = "2" maxlength="4">    
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
        <textarea cols="46" rows="4" maxlength = "160" name="textmessage"></textarea><br>
        <input type="button" onclick="submitText()" value="Send Text">  
    </form>
</th></table>
<br>

</div>

</div></div></div>

<?php } ?>