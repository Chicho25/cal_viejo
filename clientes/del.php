<?php //require_once('../Connections/conexion.php'); ?>
<?php include('../include/header.php'); ?>
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
$menu=18;
$usua=$_SESSION['i'];
if ((isset($_GET['ID_PRO_CLI_MASTER'])) && ($_GET['ID_PRO_CLI_MASTER'] != "")) {
  $deleteSQL = sprintf("DELETE FROM pro_cli_master WHERE ID_PRO_CLI_MASTER=%s",
                       GetSQLValueString($_GET['ID_PRO_CLI_MASTER'], "int"));
aud($usua,$_GET['ID_PRO_CLI_MASTER'],'Eliminando el inmueble ID. '.$_GET['ID_PRO_CLI_MASTER'],$menu);
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($deleteSQL, $conexion) or die(mysql_error());
 errores(mysql_errno($conexion),"list.php",$usua,$_GET['ID_PRO_CLI_MASTER'],'Error numero'.mysql_errno($conexion). ' eliminando el inmueble id '.$_GET['ID_PRO_CLI_MASTER'],$menu);

  $deleteGoTo = "list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $deleteGoTo));
}
?>
<script type="text/javascript">
alert("Se elimino con exito");
window.location = "list.php?titulo_formulario=Clientes"

</script>