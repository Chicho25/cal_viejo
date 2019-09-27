<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<title>Untitled Document</title>
<?php //require_once('../Connections/conexion.php'); ?>
<?php require_once('../include/header.php'); ?>
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

	$menu=15;
	$usua=$_SESSION['i'];
if ((isset($_GET['ID_INMUEBLE_MASTERS'])) && ($_GET['ID_INMUEBLE_MASTERS'] != "")) {
  $deleteSQL = sprintf("DELETE FROM inmuebles_mov WHERE ID_INMUEBLES_MASTER=%s",
                       GetSQLValueString($_GET['ID_INMUEBLE_MASTERS'], "int"));
					   //echo $deleteSQL;
					   aud($usua,$_GET['ID_INMUEBLE_MASTERS'],'Eliminando la reservacion de inmueble ID. '.$_GET['ID_INMUEBLE_MASTERS'],$menu);
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($deleteSQL, $conexion) or die(mysql_error());
  if (mysql_errno($conexion)> 0){
errores(mysql_errno($conexion),"list.php",$usua,$_GET['ID_INMUEBLE_MASTERS'],'Error numero'.mysql_errno($conexion). 'Eliminando la reservacion de inmueble ID. '.$_GET['ID_INMUEBLE_MASTERS'],$menu);}
  $deleteGoTo = "list.php?titulo_formulario=Inmuebles";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $deleteGoTo));
}
?>
<script type="text/javascript">

window.location = "list.php?titulo_formulario=Inmuebles"
</script>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>