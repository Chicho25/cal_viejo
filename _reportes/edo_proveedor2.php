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

$colname_PROYECTO = "-1";
if (isset($_GET['PROYECTO'])) {
  $colname_PROYECTO = $_GET['PROYECTO'];
}
mysql_select_db($database_conexion, $conexion);
$query_PROYECTO = sprintf("SELECT * FROM proyectos WHERE CODIGO = %s", GetSQLValueString($colname_PROYECTO, "text"));
$PROYECTO = mysql_query($query_PROYECTO, $conexion) or die(mysql_error());
$row_PROYECTO = mysql_fetch_assoc($PROYECTO);
$totalRows_PROYECTO = mysql_num_rows($PROYECTO);



/*Definiciones*/
$formulario="Reporte01-Editar";
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<title>Untitled Document</title>
<?php include("../include/menu.php"); ?>
<?php include("../include/_js.php"); ?>
<?php include("../include/_css.php"); ?>

</head>

<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
<?php $opcion_menu=2; 
$colname_NOMBRE_USUARIO = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_NOMBRE_USUARIO = $_SESSION['MM_Username'];
}
mysql_select_db($database_conexion, $conexion);
$query_NOMBRE_USUARIO = sprintf("SELECT * FROM usuarios WHERE `ALIAS` = %s", GetSQLValueString($colname_NOMBRE_USUARIO, "text"));
$NOMBRE_USUARIO = mysql_query($query_NOMBRE_USUARIO, $conexion) or die(mysql_error());
$row_NOMBRE_USUARIO = mysql_fetch_assoc($NOMBRE_USUARIO);
$totalRows_NOMBRE_USUARIO = mysql_num_rows($NOMBRE_USUARIO);
?>
<table width="1100" align="center" class="ui-widget-header" >
    <tr>
          <td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Estado de Cuenta Proveedor</div>
    </tr>
  </table>
<?php //include("_menu.php"); ?>
<form name="enviar" method="GET" id="enviar" action="edo_proveedor_listado.php">
      <table width="1100" align="center" >    <tr>
          <td width="371" align="center" bgcolor="#F0F0F0" class="textos_form_derecha"><div>Proyecto</div></td>
          <td width="717" bgcolor="#F0F0F0"><span class="textos_form"><?php echo $row_PROYECTO['NOMBRE']; ?></span><input name="CODIGO_PROYECTO" type="hidden" id="CODIGO_PROYECTO" value="<?php echo $_GET['PROYECTO'] ?>" />
          <input type="hidden" name="COMISIONES" id="COMISIONES" value="<?php echo $_GET['COMISIONES'] ?>" /></td>
    </tr>
<!-- Busqueda Proyectos-->    
<?php //include('../include/_combo_proyectos.php'); ?>

<!--Fin Proyectos-->
<!-- Busqueda Proveedor-->
<?php $where_proveedor="where tipo=1 or tipo=3"?>
<?php include('../include/_combo_proveedor.php'); ?>
<!--Fin Proveedor-->
<!-- Busqueda Partidas--> 
<?php $where=' WHERE TIPO=2 AND COD_PROYECTO='.$_GET['PROYECTO'].' '.$_GET['COMISIONES'];
$nombre_campo='Partida';
 ?>   
<?php include('../include/_combo_partidas_funcion.php'); ?>
<!--Fin Partidas-->

<!-- Busqueda Desde_Hasta-->    
<?php //include('../include/_combo_desde_hasta.php'); ?>
<!--Fin Desde_Hasta-->
    
    <tr>
    	<td colspan="2" align="left" >
    		<div class="validity-summary-container" style="color:#F00">
    			
    			<ul></ul>
</div></tr>

          <td colspan="2" align="center" bgcolor="#999999" class="textos_form" ><input name="button" type="submit" class="ui-widget-header" id="button" value="Buscar" /></tr>
</table>
</form>


<?php include("../include/_foot.php"); ?>
</body>
</html>
<?php
mysql_free_result($NOMBRE_USUARIO);

mysql_free_result($PROYECTO);




?>
