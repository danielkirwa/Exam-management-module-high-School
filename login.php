<?php require_once('Connections/conn.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['userpassword'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "home.php";
  $MM_redirectLoginFailed = "login.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_conn, $conn);
  
  $LoginRS__query=sprintf("SELECT username, userpassword FROM users WHERE username=%s AND userpassword=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $conn) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IndustrialTraining</title>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
</head>

<body bgcolor="skyblue">
<center>
<table width="100%" bgcolor="gold">
  <tr>
    <td>
    <center>
      <img src="images/kibabiilogo.png" width="100" height="100" /><br/>
      KIBABII UNIVERSITY
    </center>
    </td>
  </tr>
</table>
<table width="100%" bgcolor="skyblue">
  <tr>
    <td></td>
  </tr>
</table>
<table width="25%" height="400" bgcolor="#ffffff">
  <tr>
    <td><fieldset><legend align="center">Login here</legend>
    <br /><br/>
   <form action="<?php echo $loginFormAction; ?>" method="POST" name="loginform">
   <center>
   <table width="100%">
  <tr>
    <td > <center>USERNAME</center></td>
  </tr>
  <tr>
    <td> <center><label for="username"></label>
      <input type="username" name="username" id="textfield2"  style="width:100%"/> </center></td>
  </tr>
  <tr>
    <td><center>PASSWORD</center></td>
  </tr>
  <tr>
    <td><center><label for="userpassword"></label>
      <input type="password" name="userpassword" id="textfield3" style="width:100%"/></center></td>
  </tr>
  
  <tr>
  
    <td><center><input type="submit" name="button" id="button" value="Submit" style="width:45% ; margin-top: 10px; padding: 6px 8px;"/>
      <input type="reset" name="button2" id="button2" value="Refresh" style="width:45%; margin-top: 10px; padding: 6px 8px;" /></center></td>
  </tr>
</table>
</center>
   </form>


    </fieldset></td>
    
  </tr>
</table>
<table width="100%" bgcolor="gold">
  <tr>
    <td><center>&copy;COPYRIGHT 2021 INDUSRIAL TRAINING ALL RIGHTS RESERVED</center></td>
  </tr>
</table>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</center>
</body>
</html>

