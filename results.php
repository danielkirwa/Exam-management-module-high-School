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

mysql_select_db($database_conn, $conn);
$query_SchoolName = "SELECT schoolname FROM schooldetails";
$SchoolName = mysql_query($query_SchoolName, $conn) or die(mysql_error());
$row_SchoolName = mysql_fetch_assoc($SchoolName);
$totalRows_SchoolName = mysql_num_rows($SchoolName);

mysql_select_db($database_conn, $conn);
$query_Studentmarks = "SELECT `class`.classID, exam.examtype, marks.score, stream.streamID, student.admino, student.surname, student.othername, student.kcpe, subject.subjectcode, term.termID, `year`.`year` FROM `class`, exam, marks, stream, student, subject, term, `year`";
$Studentmarks = mysql_query($query_Studentmarks, $conn) or die(mysql_error());
$row_Studentmarks = mysql_fetch_assoc($Studentmarks);
$totalRows_Studentmarks = mysql_num_rows($Studentmarks);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $row_SchoolName['schoolname']; ?></title>
</head>

<body>
<center><img src="images/kibabiilogo.png" width="100" height="100" /></center><br /><br />
<center>

 <?php echo $row_SchoolName['schoolname']; ?> &nbsp;&nbsp;TERM : <?php echo $row_Studentmarks['termID']; ?>&nbsp;&nbsp; YEAR :   <?php echo $row_Studentmarks['year']; ?>&nbsp;&nbsp; EXAM TYPE : <?php echo $row_Studentmarks['examtype']; ?>&nbsp;&nbsp; FORM :  <?php echo $row_Studentmarks['classID']; ?>&nbsp;&nbsp; RESULTS :
<hr size="6" color="#000000" width="100%" />

<table width="100%">
  <tr>
    <td>ADMNO</td>
    <td>STUSENT NAME</td>
    <td>STREAM</td>
    <td>KCPE</td>
    <td>101</td>
    <td>102</td>
    <td>103</td>
    <td>104</td>
    <td>105</td>
    <td>106</td>
    <td>107</td>
    <td>108</td>
    <td>109</td>
    <td>110</td>
  </tr>
  <tr>
    <td><?php echo $row_Studentmarks['admino']; ?></td>
    <td><?php echo $row_Studentmarks['surname']; ?></td>
    <td><?php echo $row_Studentmarks['streamID']; ?></td>
    <td><?php echo $row_Studentmarks['kcpe']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

</center>

</body>
</html>
<?php
mysql_free_result($SchoolName);

mysql_free_result($Studentmarks);
?>
