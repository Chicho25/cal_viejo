<?php require_once('../Connections/conexion.php');?><?php
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

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysql_select_db($database_conexion, $conexion);

$query_DetailRS1 = sprintf("SELECT * FROM usuarios WHERE ID_USUARIO = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysql_query($query_DetailRS1, $conexion) or die(mysql_error());
$row_DetailRS1 = mysql_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysql_num_rows($DetailRS1);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<table border="1" align="center">
  <tr>
    <td>ALIAS</td>
    <td><?php echo $row_DetailRS1['ALIAS']; ?></td>
  </tr>
  <tr>
    <td>PASSWORD</td>
    <td><?php echo $row_DetailRS1['PASSWORD']; ?></td>
  </tr>
  <tr>
    <td>NOMBRES</td>
    <td><?php echo $row_DetailRS1['NOMBRES']; ?></td>
  </tr>
  <tr>
    <td>APELLIDOS</td>
    <td><?php echo $row_DetailRS1['APELLIDOS']; ?></td>
  </tr>
  <tr>
    <td>CARGO</td>
    <td><?php echo $row_DetailRS1['CARGO']; ?></td>
  </tr>
  <tr>
    <td>NIVEL</td>
    <td><?php echo $row_DetailRS1['NIVEL']; ?></td>
  </tr>
</table>
</body>
</html><?php
mysql_free_result($DetailRS1);
?>