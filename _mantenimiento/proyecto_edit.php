<?php require_once('../Connections/conexion.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "enviar")) {
  $updateSQL = sprintf("UPDATE proyectos SET NOMBRE=%s, COD_EMP=%s WHERE CODIGO=%s",
                       GetSQLValueString($_POST['NOMBRE_PROYECTO'], "text"),
                       GetSQLValueString($_POST['codigos'], "text"),
                       GetSQLValueString($_POST['CODIGO'], "text"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
}

mysql_select_db($database_conexion, $conexion);
$query_PROYECTO = "SELECT * FROM VISTA_PROYECTOS";
$PROYECTO = mysql_query($query_PROYECTO, $conexion) or die(mysql_error());
$row_PROYECTO = mysql_fetch_assoc($PROYECTO);
$totalRows_PROYECTO = mysql_num_rows($PROYECTO);

mysql_select_db($database_conexion, $conexion);
$query_EMPRESAS = "SELECT * FROM empresas_master";
$EMPRESAS = mysql_query($query_EMPRESAS, $conexion) or die(mysql_error());
$row_EMPRESAS = mysql_fetch_assoc($EMPRESAS);
$totalRows_EMPRESAS = mysql_num_rows($EMPRESAS);

mysql_select_db($database_conexion, $conexion);
$query_edit_proyecto = "SELECT * FROM proyectos WHERE CODIGO=".$_GET['CODIGO'];
$edit_proyecto = mysql_query($query_edit_proyecto, $conexion) or die(mysql_error());
$row_edit_proyecto = mysql_fetch_assoc($edit_proyecto);
$totalRows_edit_proyecto = mysql_num_rows($edit_proyecto);

/*Definiciones*/
$formulario="Grupos-Add";
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

      <table width="1100" align="center" class="ui-widget-header" >
    <tr>
          <td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Editar Proyecto</div>
    </tr>
  </table>
<?php include("_menu_proyecto.php"); ?>
<form action="<?php echo $editFormAction; ?>" name="enviar" method="POST" id="enviar">
      <table width="1100" align="center" >
    <tr>
    	<td width="398" align="left" >
    		      <table width="1100" align="center" >
    <tr>
    	<td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" ><!--<input name="ORDEN" type="hidden" id="ORDEN" value="<?php echo $totalRows_orden_partida +1; ?>" />-->
    	  Codigo:
	  <td align="left" bgcolor="#F3F3F3" ><label for="CODIGO"></label>
    			<span id="sprytextfield2">
    			<input name="CODIGO" type="text" id="CODIGO" value="<?php echo $row_edit_proyecto['CODIGO']; ?>" />
   			<span class="textfieldRequiredMsg">Requerido.</span></span></tr>
    <tr>
    	<td align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Proyecto: 	
    	<td align="left" bgcolor="#F3F3F3" ><label for="textfield2"></label>
    			<span id="sprytextfield1">
   				<input name="NOMBRE_PROYECTO" type="text" id="textfield2" value="<?php echo $row_edit_proyecto['NOMBRE']; ?>" size="50" />
   				<span class="textfieldRequiredMsg">Requerido.</span></span>
		  <label for="MONTO_ESTIMADO"></label>	
    </tr>
    <tr>
    	<td align="right" bgcolor="#F3F3F3" class="textos_form_derecha" ><input name="codigos" type="hidden" id="codigos" value="<?php echo $row_edit_proyecto['COD_EMP']?>" />
    	  Empresas:	
    	<td align="left" bgcolor="#F3F3F3" ><label for="EMPRESA"></label>
    		<select name="EMPRESA" id="EMPRESA">
    		  <?php
do {  
?>
    		  <option value="<?php echo $row_EMPRESAS['CODIGO_EMPRESAS_MASTER']?>"<?php if (!(strcmp($row_EMPRESAS['CODIGO_EMPRESAS_MASTER'], $row_edit_proyecto['COD_EMP']))) {echo "selected=\"selected\"";} ?>><?php echo $row_EMPRESAS['NOMBRE']?></option>
    		  <?php
} while ($row_EMPRESAS = mysql_fetch_assoc($EMPRESAS));
  $rows = mysql_num_rows($EMPRESAS);
  if($rows > 0) {
      mysql_data_seek($EMPRESAS, 0);
	  $row_EMPRESAS = mysql_fetch_assoc($EMPRESAS);
  }
?>
			</select>
    	</tr>
        </table>
        
    		<div class="validity-summary-container" style="color:#F00">
    			
    			<ul></ul>
</div></tr>

          <td align="center" bgcolor="#999999" class="textos_form" ><input name="button" type="submit" class="ui-widget-header" id="button" value="Guardar" /></tr>
</table>
      <input type="hidden" name="MM_update" value="enviar" />
</form>
<table align="center" width="1100">
    <tr>
      <td width="389" align="center" bgcolor="#F3F3F3" class="textos_form" >Codigo 
      <td width="323" align="center" bgcolor="#F3F3F3" class="textos_form" >Nombre
      <td width="320" align="center" bgcolor="#F3F3F3" class="textos_form" >Empresa        
      <td width="24" align="center" bgcolor="#F3F3F3" class="textos_form" >		
          <td width="24" align="center" bgcolor="#F3F3F3" class="textos_form" >			
          </tr>
          <?php do { ?>
          	<tr>
          		<td align="center" bgcolor="#FFFFFF" ><?php echo $row_PROYECTO['CODIGO']; ?>
       		    <td align="left" bgcolor="#FFFFFF" ><?php echo $row_PROYECTO['NOMBRE']; ?>
              <td align="left" bgcolor="#FFFFFF" ><?php echo $row_PROYECTO['NOMBRE_EMPRESA']; ?>
	          <td align="left" bgcolor="#FFFFFF" ><a href="proyecto_edit.php?CODIGO=<?php echo $row_PROYECTO['CODIGO']; ?>"><img src="../image/icon_doc.png" width="24" height="24" /></a>				
   		  <td align="left" bgcolor="#FFFFFF" ><?php if($row_PROYECTO['TIENE_PARTIDAS']==1){ ?><img src="../image/Delete-iconbw.png" width="24" height="24" /><?php } else { ?><a href="proyecto_del.php?CODIGO=<?php echo $row_PROYECTO['CODIGO']; ?>"><img src="../image/Delete-icon.png" width="24" height="24" /></a> <?php } ?>				          	</tr>
          	<?php } while ($row_PROYECTO = mysql_fetch_assoc($PROYECTO)); ?>
	</table>
<?php include("../include/_foot.php"); ?>
</body>
</html>
<?php
mysql_free_result($PROYECTO);

mysql_free_result($EMPRESAS);

mysql_free_result($edit_proyecto);
?>
