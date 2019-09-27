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

if ((isset($_GET['ID_INMUEBLES_MOV'])) && ($_GET['ID_INMUEBLES_MOV'] != "")) {
  $deleteSQL = sprintf("DELETE FROM inmuebles_mov_detalle WHERE ID_INMUEBLES_MOV=%s",
                       GetSQLValueString($_GET['ID_INMUEBLES_MOV'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($deleteSQL, $conexion) or die(mysql_error());

}

if ((isset($_GET['ID_INMUEBLES_MOV'])) && ($_GET['ID_INMUEBLES_MOV'] != "")) {
  $deleteSQL = sprintf("DELETE FROM inmuebles_mov WHERE ID_INMUEBLES_MOV=%s",
                       GetSQLValueString($_GET['ID_INMUEBLES_MOV'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($deleteSQL, $conexion) or die(mysql_error());

  $deleteGoTo ="edit2.php?ID_INMUEBLES_MOV=&titulo_formulario=Contrato de Venta&ID_PROYECTO=&ID_GRUPO=&FECHA_VENTA_DATE=&ID_CLIENTE=&MONTO_VENTA=&FECHA_VENTA_DATE=&FECHA_HASTA=&CODIGO_INMUEBLE=&col=FECHA_VENTA_DATE&orden=1";

  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    //$deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>
