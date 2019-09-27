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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "enviar")) {
  $updateSQL = sprintf("UPDATE inmuebles_grupo SET NOMBRE=%s, COD_PROYECTOS_MASTER=%s WHERE ID_INMUEBLES_GRUPO=%s",
                       GetSQLValueString($_POST['NOMBRE_GRUPO'], "text"),
                       GetSQLValueString($_POST['PROYECTO'], "text"),
                       GetSQLValueString($_POST['ID_GRUPO'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());

  $updateGoTo = "grupo.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_conexion, $conexion);
$query_PROYECTO = "SELECT * FROM proyectos";
$PROYECTO = mysql_query($query_PROYECTO, $conexion) or die(mysql_error());
$row_PROYECTO = mysql_fetch_assoc($PROYECTO);
$totalRows_PROYECTO = mysql_num_rows($PROYECTO);

$colname_CONSULTA = "-1";
if (isset($_GET['ID_GRUPO'])) {
  $colname_CONSULTA = $_GET['ID_GRUPO'];
}
mysql_select_db($database_conexion, $conexion);
$query_CONSULTA = sprintf("SELECT * FROM inmuebles_grupo WHERE ID_INMUEBLES_GRUPO = %s", GetSQLValueString($colname_CONSULTA, "int"));
$CONSULTA = mysql_query($query_CONSULTA, $conexion) or die(mysql_error());
$row_CONSULTA = mysql_fetch_assoc($CONSULTA);
$totalRows_CONSULTA = mysql_num_rows($CONSULTA);

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

<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
<?php $opcion_menu=2; ?>
<?php include("../include/menu.php"); ?>

      <table width="1100" align="center" class="ui-widget-header" >
    <tr>
          <td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Editar Grupo de Inmuebles</div>
    </tr>
  </table>
<?php include("_menu_grupo.php"); ?>
<form action="<?php echo $editFormAction; ?>" name="enviar" method="POST" id="enviar">
      <table width="1100" align="center" >
    <tr>
      <td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >

Proyecto: 
      <td align="left" bgcolor="#F3F3F3" ><label for="PROYECTO"></label>
      	<select name="PROYECTO" id="PROYECTO">
      		<?php
do {  
?>
      		<option value="<?php echo $row_PROYECTO['CODIGO']?>"<?php if (!(strcmp($row_PROYECTO['CODIGO'], $row_CONSULTA['COD_PROYECTOS_MASTER']))) {echo "selected=\"selected\"";} ?>><?php echo $row_PROYECTO['NOMBRE']?></option>
      		<?php
} while ($row_PROYECTO = mysql_fetch_assoc($PROYECTO));
  $rows = mysql_num_rows($PROYECTO);
  if($rows > 0) {
      mysql_data_seek($PROYECTO, 0);
	  $row_PROYECTO = mysql_fetch_assoc($PROYECTO);
  }
?>
      		</select>
      	<label for="textfield"></label>
      	<input name="ID_GRUPO" type="hidden" id="ID_GRUPO" value="<?php echo $row_CONSULTA['ID_INMUEBLES_GRUPO']; ?>" />
<label for="NOMBRE_GRUPO"></label></tr>
    <tr>
      <td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Grupo:      
      <td align="left" bgcolor="#F3F3F3" ><label for="textfield2"></label>
      	<span id="sprytextfield1">
      	<input name="NOMBRE_GRUPO" type="text" id="textfield2" value="<?php echo $row_CONSULTA['NOMBRE']; ?>" size="50" />
      	<span class="textfieldRequiredMsg">Requerido.</span></span>
      	<label for="MONTO_ESTIMADO"></label></tr>
    <tr>
    	<td colspan="2" align="left" >
    		<div class="validity-summary-container" style="color:#F00">
    			
    			<ul></ul>
</div></tr>

          <td colspan="2" align="center" bgcolor="#999999" class="textos_form" ><input name="button" type="submit" class="ui-widget-header" id="button" value="Guardar" /></tr>
</table>
      <input type="hidden" name="MM_update" value="enviar" />
</form>


<?php include("../include/_foot.php"); ?>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
</script>
</body>
</html>
<?php
mysql_free_result($PROYECTO);

mysql_free_result($CONSULTA);
?>
