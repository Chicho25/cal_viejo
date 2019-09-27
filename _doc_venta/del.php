<?php require_once('../../Connections/conexion.php'); ?>
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
$colname_consulta = "-1";
if (isset($_GET['ID_DOCUMENTO'])) {
  $colname_consulta = $_GET['ID_DOCUMENTO'];
}
mysql_select_db($database_conexion, $conexion);
$query_consulta = sprintf("SELECT ID_INMUEBLES_MOV FROM documentos WHERE ID_DOCUMENTO = %s", GetSQLValueString($colname_consulta, "int"));
$consulta = mysql_query($query_consulta, $conexion) or die(mysql_error());
$row_consulta = mysql_fetch_assoc($consulta);
$totalRows_consulta = mysql_num_rows($consulta);


if ((isset($_GET['ID_DOCUMENTO'])) && ($_GET['ID_DOCUMENTO'] != "")) {
  $deleteSQL = sprintf("DELETE FROM documentos WHERE ID_DOCUMENTO=%s",
                       GetSQLValueString($_GET['ID_DOCUMENTO'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($deleteSQL, $conexion) or die(mysql_error());

  $deleteGoTo = "listado.php?ID_INMUEBLES_MOV=".$row_consulta['ID_INMUEBLES_MOV'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}


mysql_free_result($consulta);
?>
