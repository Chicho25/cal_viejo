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

if ((isset($_GET['ID_MOV_BANCO_CAJA'])) && ($_GET['ID_MOV_BANCO_CAJA'] != "")) {
  $deleteSQL = sprintf("DELETE FROM mov_banco_caja WHERE ID_MOV_BANCO_CAJA=%s",
                       GetSQLValueString($_GET['ID_MOV_BANCO_CAJA'], "int"));
					   //echo $deleteSQL;

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($deleteSQL, $conexion) or die(mysql_error());

  $deleteGoTo = "listado.php?ID_CUENTA_BANCARIA=1&orden=1&col=FECHA_DATE&DESCRIPCION=&ID_MOV_BANCO_CAJA=&DEBITO=&CREDITO=&FECHA_DATE=&NOMBRE_TIPO_MOV=&TIPO_IO=T&ID_TESORERIA_TIPO_MOV=&NUMERO_PAGO=&FROM=&TO=&button=Buscar";
/*  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }*/
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
<script type="text/javascript">
<!--
//window.location = "listado.php?ID_CUENTA_BANCARIA=1&orden=1&col=FECHA_DATE&DESCRIPCION=&ID_MOV_BANCO_CAJA=&DEBITO=&CREDITO=&FECHA_DATE=&NOMBRE_TIPO_MOV=&TIPO_IO=T&ID_TESORERIA_TIPO_MOV=&NUMERO_PAGO=&FROM=&TO=&button=Buscar"
//-->
</script>
</body>
</html>