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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO partidas (DESCRIPCION, DESCRIPCION_COMPLETA, DESCRIPCION_CORTA, COD_PROYECTO, ID_GRUPO, TIPO, NIVEL, ID_INMUEBLES_GRUPO, MONTO_ESTIMADO) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString(utf8_decode($_POST['DESCRIPCION_COMPLETA2']), "text"),
                       GetSQLValueString(utf8_decode($_POST['DESCRIPCION_COMPLETA2']), "text"),
                       GetSQLValueString(utf8_decode($_POST['DESCRIPCION_COMPLETA2']), "text"),
                       GetSQLValueString($_POST['COD_PROYECTO'], "text"),
                       GetSQLValueString(1, "int"),
                       GetSQLValueString(1, "int"),
                       GetSQLValueString(1, "int"),
                       GetSQLValueString($_POST['ID_INMUEBLE_GRUPO'], "int"),
                       GetSQLValueString($_POST['MONTO_ESTIMADO'], "text"));
//echo $insertSQL;

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());

  $insertGoTo = "../_partidas/listado.php?MONTO_ESTIMADO_DISPONIBLE=&COD_PROYECTO=&col=ID_PARTIDA&orden=1&DESCRIPCION_COMPLETA=&MONTO_ESTIMADO=&MONTO_ASIGNADO=&MONTO_PAGADO=&ESTIMADO_EXCEDIDO=&ID_PARTIDA=&button=Buscar";
/*  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  header(sprintf("Location: %s", $insertGoTo));
}

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
if (isset($_GET['CODIGO'])) {
  $colname_PROYECTO = $_GET['CODIGO'];
}
mysql_select_db($database_conexion, $conexion);
$query_PROYECTO = sprintf("SELECT * FROM proyectos WHERE CODIGO = %s", GetSQLValueString($colname_PROYECTO, "text"));
$PROYECTO = mysql_query($query_PROYECTO, $conexion) or die(mysql_error());
$row_PROYECTO = mysql_fetch_assoc($PROYECTO);
$totalRows_PROYECTO = mysql_num_rows($PROYECTO);

$colname_PARTIDA = "-1";
if (isset($_GET['ID_PARTIDA'])) {
  $colname_PARTIDA = $_GET['ID_PARTIDA'];
}
mysql_select_db($database_conexion, $conexion);
$query_PARTIDA = sprintf("SELECT * FROM partidas WHERE ID = %s", GetSQLValueString($colname_PARTIDA, "int"));
$PARTIDA = mysql_query($query_PARTIDA, $conexion) or die(mysql_error());
$row_PARTIDA = mysql_fetch_assoc($PARTIDA);
$totalRows_PARTIDA = mysql_num_rows($PARTIDA);

$colname_INMUEBLES = "-1";
if (isset($_GET['CODIGO'])) {
  $colname_INMUEBLES = $_GET['CODIGO'];
}
mysql_select_db($database_conexion, $conexion);
$query_INMUEBLES = sprintf("SELECT * FROM inmuebles_grupo WHERE COD_PROYECTOS_MASTER = %s", GetSQLValueString($colname_INMUEBLES, "text"));
$INMUEBLES = mysql_query($query_INMUEBLES, $conexion) or die(mysql_error());
$row_INMUEBLES = mysql_fetch_assoc($INMUEBLES);
$totalRows_INMUEBLES = mysql_num_rows($INMUEBLES);

/*Definiciones*/
$formulario="Partidas00-Editar";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<title>Untitled Document</title>
<?php include("../include/menu.php"); ?>
<?php include("../include/_js.php"); ?>
<?php include("../include/_css.php"); ?>

<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
<?php $opcion_menu=2; ?>


      <table width="1100" align="center" class="ui-widget-header" >
    <tr>
          <td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Partida Principal del Proyecto</div>
    </tr>
  </table>
<?php include("../_partidas/_menu.php"); ?>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
      <table width="1100" align="center" >
	      <tr>
      <td width="311" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >

Proyecto: 
      <td width="777" align="left" bgcolor="#F3F3F3" ><label for="NOMBRE_PROYECTO"></label>
      	<input name="NOMBRE_PROYECTO" type="text" class="textos_form" id="NOMBRE_PROYECTO" value="<?php echo $row_PROYECTO['NOMBRE']; ?>" size="50" readonly="readonly" />
      	<input name="COD_PROYECTO" type="hidden" id="COD_PROYECTO" value="<?php echo $row_PROYECTO['CODIGO']; ?>" />      <label for="NOMBRE_PROYECTO2">
      	  <input name="ID_GRUPO" type="hidden" id="ID_GRUPO" value="<?php echo $row_PARTIDA['ID']; ?>" />
    	  </label>
        <input name="NIVEL" type="hidden" id="NIVEL" value="<?php echo $row_PARTIDA['NIVEL']+1; ?>" />      <input name="DESCRIPCION_COMPLETA1" type="hidden" id="DESCRIPCION_COMPLETA1" value="<?php echo $row_PARTIDA['DESCRIPCION_COMPLETA']; ?> --> " />      </tr>
    <tr>
      <td width="311" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Descripcion Partida:      
      <td align="left" bgcolor="#F3F3F3" ><span id="sprytextfield1">
      	<input name="DESCRIPCION_COMPLETA2" type="text" id="textfield3" size="50" />
      	<span class="textfieldRequiredMsg">Requerido.</span></span></tr>
    <tr>
      <td width="311" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Inmueble:<td align="left" bgcolor="#F3F3F3" ><label for="textfield6"></label>
      		<label for="ID_INMUEBLE_GRUPO"></label>
      		<select name="ID_INMUEBLE_GRUPO" id="ID_INMUEBLE_GRUPO">
      		  <option value="0">NO TIENE</option>
      		  <?php
do {  
?>
      		  <option value="<?php echo $row_INMUEBLES['ID_INMUEBLES_GRUPO']?>"><?php echo $row_INMUEBLES['NOMBRE']?></option>
      		  <?php
} while ($row_INMUEBLES = mysql_fetch_assoc($INMUEBLES));
  $rows = mysql_num_rows($INMUEBLES);
  if($rows > 0) {
      mysql_data_seek($INMUEBLES, 0);
	  $row_INMUEBLES = mysql_fetch_assoc($INMUEBLES);
  }
?>
      			</select>
      		<label for="textfield5" class="ui-state-error-text">Nota: Solo en caso de partidas de comisiones de venta</label></tr>
    <tr>
    	<td width="311" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Monto Estimado:
<td align="left" ><span id="sprytextfield3">
<input name="MONTO_ESTIMADO" type="text"  class="textos_form_derecha"  id="textfield6" value="0"/>
<span class="textfieldRequiredMsg">Requerido.</span><span class="textfieldInvalidFormatMsg">Debe ser numerico.</span></span></tr>
    <tr>
          <td colspan="2" align="left" >
              <div class="validity-summary-container" style="color:#F00">
    
    <ul></ul>
</div></tr>

          <td colspan="2" align="center" bgcolor="#999999" class="textos_form" ><input name="button" type="submit" class="ui-widget-header" id="button" value="Guardar" /></tr>
</table>
      <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
<?php include("../include/_foot.php"); ?>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "real");
</script>
</body>
</html>
<?php

mysql_free_result($PROYECTO);

mysql_free_result($PARTIDA);

mysql_free_result($INMUEBLES);
?>
