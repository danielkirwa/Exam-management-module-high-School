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

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO schooldetails (schoolID, schoolname, schooladdress, schoollogo, schooltown) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['schoolID'], "text"),
                       GetSQLValueString($_POST['schoolname'], "text"),
                       GetSQLValueString($_POST['schooladdress'], "text"),
                       GetSQLValueString($_POST['schoollogo'], "text"),
                       GetSQLValueString($_POST['schooltown'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
}

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_conn, $conn);
$query_Recordset1 = "SELECT * FROM schooldetails";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $conn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);


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
      <li><a href="#">HOME</a></li>
      <li><a href="#" class="MenuBarItemSubmenu">SCHOOL</a>
        <ul>
          <li><a href="home.php">SCHOOL DETAILS</a></li>
          <li><a href="#">ADD CLASS</a></li>
          <li><a href="#">ADD STREAM</a></li>
          <li><a href="#">ADD TEACHER</a></li>
        </ul>
      </li>
      <li><a href="student.php" class="MenuBarItemSubmenu">STUDENT DETAILS</a>
        <ul>
          <li><a href="#">ADD STUDENT</a></li>
          <li><a href="#">ADD PARENT</a></li>
        </ul>
      </li>
      <li><a href="#">TERM/DATES</a></li>
      <li><a href="#" class="MenuBarItemSubmenu MenuBarItemSubmenu">EXAM</a>
        <ul>
          <li><a href="#">ADD EXAM</a></li>
          <li><a href="#">ADD GRADING</a></li>
          <li><a href="#">CAPTURE MARK</a></li>
</ul>
</li>
<li><a href="#" class="MenuBarItemSubmenu">FINANCE</a>
  <ul>
    <li><a href="#">UPDATE PAYMENT</a></li>
    <li><a href="#">CHECK STATEMENT</a></li>
  </ul>
</li>
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
    <td><fieldset><legend align="center">Enter school details</legend>
        <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
          <table align="center">
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">SchoolID:</td>
              <td><input type="text" name="schoolID" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Schoolname:</td>
              <td><input type="text" name="schoolname" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Schooladdress:</td>
              <td><input type="text" name="schooladdress" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Schoollogo:</td>
              <td><input type="text" name="schoollogo" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Schooltown:</td>
              <td><input type="text" name="schooltown" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">&nbsp;</td>
              <td><input type="submit" value="Submit Record" />
                <input type="reset" name="Reset" id="button" value="Reset " /></td>
            </tr>
          </table>
          <input type="hidden" name="MM_insert" value="form1" />
        </form>
        <p>&nbsp;</p>
    </fieldset></td>
    <td><fieldset><legend align="center">Available schools</legend>
        <table border="1" align="center">
          <tr>
            <td>schoolID</td>
            <td>schoolname</td>
            <td>schooladdress</td>
            <td>schoollogo</td>
            <td>schooltown</td>
          </tr>
          <?php do { ?>
            <tr>
              <td><a href="SchoolDetailsSet.php?recordID=<?php echo $row_Recordset1['schoolID']; ?>"> <?php echo $row_Recordset1['schoolID']; ?>&nbsp; </a></td>
              <td><?php echo $row_Recordset1['schoolname']; ?>&nbsp; </td>
              <td><?php echo $row_Recordset1['schooladdress']; ?>&nbsp; </td>
              <td><?php echo $row_Recordset1['schoollogo']; ?>&nbsp; </td>
              <td><?php echo $row_Recordset1['schooltown']; ?>&nbsp; </td>
            </tr>
            <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
        </table>
        <br />
        <table border="0">
          <tr>
            <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>">First</a>
                <?php } // Show if not first page ?></td>
            <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>">Previous</a>
                <?php } // Show if not first page ?></td>
            <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>">Next</a>
                <?php } // Show if not last page ?></td>
            <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>">Last</a>
                <?php } // Show if not last page ?></td>
          </tr>
        </table>
Records <?php echo ($startRow_Recordset1 + 1) ?> to <?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?> of <?php echo $totalRows_Recordset1 ?>
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
<?php
mysql_free_result($Recordset1);
?>
