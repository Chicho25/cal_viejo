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
//include('../include/funciones.php');
	$menu=15;
	$usua=$_SESSION['i'];

if ((isset($_GET['ID_INMUEBLE_MASTER'])) && ($_GET['ID_INMUEBLE_MASTER'] != "")) {
  $deleteSQL = sprintf("DELETE FROM inmuebles_master WHERE ID_INMUEBLES_MASTER=%s",
                       GetSQLValueString($_GET['ID_INMUEBLE_MASTER'], "int"));
					   aud($usua,$_GET['ID_INMUEBLE_MASTER'],'Eliminando el inmueble ID. '.$_GET['ID_INMUEBLE_MASTER'],$menu);

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($deleteSQL, $conexion) or die(mysql_error());
 errores(mysql_errno($conexion),"list.php",$usua,$_GET['ID_INMUEBLE_MASTER'],'Error numero'.mysql_errno($conexion). ' eliminando el inmueble id '.$_GET['ID_INMUEBLE_MASTER'],$menu);
  $deleteGoTo = "list.php";
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
