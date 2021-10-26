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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO student (admino, surname, othername, gender, kcpe, kcsetarget, streamID, photo, guardianID) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['admino'], "text"),
                       GetSQLValueString($_POST['surname'], "text"),
                       GetSQLValueString($_POST['othername'], "text"),
                       GetSQLValueString($_POST['gender'], "text"),
                       GetSQLValueString($_POST['kcpe'], "int"),
                       GetSQLValueString($_POST['kcsetarget'], "text"),
                       GetSQLValueString($_POST['streamID'], "text"),
                       GetSQLValueString($_POST['photo'], "text"),
                       GetSQLValueString($_POST['guardianID'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
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
    <td><ul id="MenuBar1" class="MenuBarHorizontal">
      <li><a href="#">HOME</a>        </li>
      <li><a href="#" class="MenuBarItemSubmenu MenuBarItemSubmenu">EXAM</a>
        <ul>
          <li><a href="#">COURSE</a></li>
          <li><a href="#">PERFORMANCE</a></li>
          <li><a href="#">PROVISION RESULT</a></li>
        </ul>
      </li>
<li><a href="#">FEE </a></li>
<li><a href="#" class="MenuBarItemSubmenu">ACCOUNT</a>
  <ul>
          <li><a href="#">REGISTER</a></li>
          <li><a href="#">LOGIN</a></li>
        </ul>
    </li>
    </ul></td>
  </tr>
</table>
<table width="100%" height="400" bgcolor="#ffffff">
  <tr>
    <td><fieldset>
      <legend align="center">
      Student   details </legend>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Admino:</td>
            <td><input type="text" name="admino" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Surname:</td>
            <td><input type="text" name="surname" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Othername:</td>
            <td><input type="text" name="othername" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Gender:</td>
            <td><input type="text" name="gender" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Kcpe:</td>
            <td><input type="text" name="kcpe" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Kcsetarget:</td>
            <td><input type="text" name="kcsetarget" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">StreamID:</td>
            <td><input type="text" name="streamID" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Photo:</td>
            <td><input type="text" name="photo" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">GuardianID:</td>
            <td><input type="text" name="guardianID" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Insert record" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1" />
      </form>
      <p>&nbsp;</p>
    </fieldset></td>
    <td><fieldset><legend align="center">Guardians</legend>
       
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
