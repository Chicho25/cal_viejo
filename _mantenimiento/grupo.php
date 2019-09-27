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

mysql_select_db($database_conexion, $conexion);
$query_CONSULTA = "SELECT inmuebles_grupo.ID_INMUEBLES_GRUPO, proyectos.NOMBRE AS NOMBRE_PROYECTO, inmuebles_grupo.NOMBRE AS NOMBRE_GRUPO FROM inmuebles_grupo INNER JOIN proyectos ON inmuebles_grupo.COD_PROYECTOS_MASTER = proyectos.CODIGO";
$CONSULTA = mysql_query($query_CONSULTA, $conexion) or die(mysql_error());
$row_CONSULTA = mysql_fetch_assoc($CONSULTA);
$totalRows_CONSULTA = mysql_num_rows($CONSULTA);

mysql_select_db($database_conexion, $conexion);
$query_ELIMINAR = "SELECT * FROM vista_inmuebles WHERE ID_GRUPO = ID_GRUPO";
$ELIMINAR = mysql_query($query_ELIMINAR, $conexion) or die(mysql_error());
$row_ELIMINAR = mysql_fetch_assoc($ELIMINAR);
$totalRows_ELIMINAR = mysql_num_rows($ELIMINAR);

/*Definiciones*/
$formulario="Partidas00-Editar";
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<title>Untitled Document</title>
<?php include("../include/_js.php"); ?>
<?php include("../include/_css.php"); ?>

</head>

<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
<?php $opcion_menu=2; ?>
<?php include("../include/menu.php"); ?>
<?php include("../include/funciones.php"); ?>
      <table width="1100" align="center" class="ui-widget-header" >
    <tr>
          <td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Editar Grupo de Inmuebles</div>
    </tr>
  </table>
<?php include("_menu_grupo.php"); ?>
<form name="enviar" method="POST" id="enviar">
      <table width="1100" align="center" cellpadding="2" cellspacing="2" >
    <tr class="textos_form">
      <td width="50" align="center" bgcolor="#F3F3F3" class="textos_form" >ID
      	<td width="300" align="center" bgcolor="#F3F3F3" class="textos_form" >Proyecto
      	
      	<td align="center" bgcolor="#F3F3F3" >Nombre	
   		<td colspan="2" align="center" bgcolor="#F3F3F3" >    </tr><?php do { ?>
	<tr>
      	
      		<td align="center" bgcolor="#FFFFFF" ><?php echo $row_CONSULTA['ID_INMUEBLES_GRUPO']; ?>
      			<td bgcolor="#FFFFFF" ><?php echo $row_CONSULTA['NOMBRE_PROYECTO']; ?>		
      			<td bgcolor="#FFFFFF" ><?php echo $row_CONSULTA['NOMBRE_GRUPO']; ?>
   				<?php if (validador(17,$_SESSION['i'],"edi")==1){?><td width="25" bgcolor="#FFFFFF" ><a href="grupo_edit.php?ID_GRUPO=<?php echo $row_CONSULTA['ID_INMUEBLES_GRUPO']; ?>"><img src="../image/icon_doc.png" width="24" height="24" /></a></td><?php } ?>
      			<?php if (validador(17,$_SESSION['i'],"eli")==1){?><td width="25" bgcolor="#FFFFFF" ><?php
				mysql_select_db($database_conexion, $conexion);
				$query_ELIMINAR = "SELECT * FROM vista_inmuebles WHERE ID_GRUPO = ".$row_CONSULTA['ID_INMUEBLES_GRUPO'];
				$ELIMINAR = mysql_query($query_ELIMINAR, $conexion) or die(mysql_error());
				$row_ELIMINAR = mysql_fetch_assoc($ELIMINAR);
				$totalRows_ELIMINAR = mysql_num_rows($ELIMINAR);
				  ?>
					<?php if ($totalRows_ELIMINAR == 0) { // Show if recordset empty ?>
						<a href="grupo_del.php?ID_GRUPO=<?php echo $row_CONSULTA['ID_INMUEBLES_GRUPO']; ?>"><img src="../image/Delete-icon.png" width="24" height="24" /></a>
			<?php } // Show if recordset empty ?>
			<?php if ($totalRows_ELIMINAR > 0) { // Show if recordset not empty ?>
	<img src="../image/Delete-iconbw.png" width="24" height="24" /></td><?php } ?>
	<?php } // Show if recordset not empty ?></tr><?php } while ($row_CONSULTA = mysql_fetch_assoc($CONSULTA)); ?>
</table>
</form>

<?php include("../include/_foot.php"); ?>
</body>
</html>
<?php
mysql_free_result($CONSULTA);

mysql_free_result($ELIMINAR);

?>
