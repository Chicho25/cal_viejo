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
$query_CUENTAS = "SELECT * FROM vista_banco_cuentas";
$CUENTAS = mysql_query($query_CUENTAS, $conexion) or die(mysql_error());
$row_CUENTAS = mysql_fetch_assoc($CUENTAS);
$totalRows_CUENTAS = mysql_num_rows($CUENTAS);

mysql_select_db($database_conexion, $conexion);
$query_ANOS = "SELECT ANO FROM vista_banco_movimientos WHERE FECHA_DATE IS NOT NULL AND YEAR(FECHA_DATE)<>0 GROUP BY ANO";
$ANOS = mysql_query($query_ANOS, $conexion) or die(mysql_error());
$row_ANOS = mysql_fetch_assoc($ANOS);
$totalRows_ANOS = mysql_num_rows($ANOS);
?>
<?php
/*Definiciones*/
$formulario="Banco01-Busqueda-Listado";
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
<title>Untitled Document</title>
<?php include("../include/_js.php"); ?>
<?php include("../include/_css.php"); ?>
</head>

<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
<?php $opcion_menu=2; ?>
<?php include("../include/menu.php"); ?>

      <table width="1100" align="center" class="ui-widget-header" >
    <tr>
          <td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Estado de Cuenta</div>
    </tr>
  </table>
<?php //include("_menu.php"); ?>
<form name="enviar" method="GET" id="enviar" action="edo_cuenta.php">
      <table width="1100" align="center" >
    <tr>
      <td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >

Cuenta:<td align="left" bgcolor="#F3F3F3" ><label for="ID_CUENTA_BANCARIA"></label>
	<select name="ID_CUENTA_BANCARIA" id="ID_CUENTA_BANCARIA">
		<?php
do {  
?>
		<option value="<?php echo $row_CUENTAS['ID_CUENTA']?>"<?php if (!(strcmp($row_CUENTAS['ID_CUENTA'], $row_CUENTAS['ID_CUENTA']))) {echo "selected=\"selected\"";} ?>><?php echo $row_CUENTAS['NOMBRE_PROYECTO']; ?>-<?php echo $row_CUENTAS['NOMBRE_BANCO']; ?>-<?php echo $row_CUENTAS['NUMERO_CUENTA']?></option>
		<?php
} while ($row_CUENTAS = mysql_fetch_assoc($CUENTAS));
  $rows = mysql_num_rows($CUENTAS);
  if($rows > 0) {
      mysql_data_seek($CUENTAS, 0);
	  $row_CUENTAS = mysql_fetch_assoc($CUENTAS);
  }
?>
	</select>
	<label for="textfield"></label></tr>
    <tr>
      <td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >A&ntilde;o:
      <td align="left" bgcolor="#F3F3F3" ><label for="ANO"></label>
      	<select name="ANO" id="ANO">
      		<?php
do {  
?>
      		<option value="<?php echo $row_ANOS['ANO']?>"<?php if (!(strcmp($row_ANOS['ANO'], $row_ANOS['ANO']))) {echo "selected=\"selected\"";} ?>><?php echo $row_ANOS['ANO']?></option>
      		<?php
} while ($row_ANOS = mysql_fetch_assoc($ANOS));
  $rows = mysql_num_rows($ANOS);
  if($rows > 0) {
      mysql_data_seek($ANOS, 0);
	  $row_ANOS = mysql_fetch_assoc($ANOS);
  }
?>
      		</select>
      	<label for="MONTO_ESTIMADO"></label></tr>
    <tr>
      <td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Mes:      
      <td align="left" bgcolor="#F3F3F3" ><label for="MES"></label>
      	<select name="MES" id="MES">
      		<option value="01" selected="selected">Enero</option>
      		<option value="02">Febrero</option>
      		<option value="03">Marzo</option>
      		<option value="04">Abril</option>
      		<option value="05">Mayo</option>
      		<option value="06">Junio</option>
      		<option value="07">Julio</option>
      		<option value="08">Agosto</option>
      		<option value="09">Septiembre</option>
      		<option value="10">Octubre</option>
      		<option value="11">Noviembre</option>
      		<option value="12">Diciembre</option>
      		</select>
      	<label for="textfield3"></label></tr>
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
mysql_free_result($CUENTAS);

mysql_free_result($ANOS);


?>
