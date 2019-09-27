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
$query_TIPO = "SELECT ID_TESORERIA_TIPO_MOV, NOMBRE, MODULO, CASE WHEN modulo = 1 THEN 'COSTOS' WHEN modulo = 2 THEN 'VENTAS' WHEN modulo = 3 THEN 'BANCOS' END AS NOMBRE_MODULO, AFECTA_BANCO, TIPO_IO FROM tesoreria_tipo_mov WHERE AFECTA_BANCO=1 ORDER BY MODULO ";
$TIPO = mysql_query($query_TIPO, $conexion) or die(mysql_error());
$row_TIPO = mysql_fetch_assoc($TIPO);
$totalRows_TIPO = mysql_num_rows($TIPO);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html" />
<title>Untitled Document</title>
<?php include("../include/_js.php"); ?>
<?php include("../include/_css.php"); ?>
	<style>
	.ui-button { margin-left: -1px; }
	.ui-button-icon-only .ui-button-text { padding: 0.35em; } 
	.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; width:690px; font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bolder }
	</style>
<!--Autocompletar--->
<style>
#project-label {
	display: block;
	font-weight: bold;
	margin-bottom: 1em;
}
#project-icon {
	float: left;
	height: 32px;
	width: 32px;
}
#project-description {
	margin: 0;
	padding: 0;
	color:#F00;
}
body, td, th {
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
}

</style>
<script>
$(function() {
	var dates = $( "#from, #to" ).datepicker({
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		onSelect: function( selectedDate ) {
			var option = this.id == "from" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" );
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
	
	$("#TIPO_IO").change(function () {
	$("#TIPO_IO option:selected").each(function () {
		//alert($(this).val());
			elegido=$(this).val();
			//$("#ID_TESORERIA_TIPO_MOV").html("");
			$.post("_tipo.php", { TIPO_IO: elegido }, function(data){
			$("#ID_TESORERIA_TIPO_MOV").html(data);
		});			
		});
})

});
</script>
<script>
$('#from').change(function() {
  alert('Handler for .change() called.');
});
</script>
	
	
	
<?php 
$visivilidad="none";
?>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/menu_style.css" type="text/css" media="all" />
</head>

<body>
<?php $opcion_menu=2; ?>
<?php include("../include/menu.php"); ?>

<table width="1100" align="center" class="ui-widget-header" >
	<tr>
		<td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Consulta de Movimiento Bancario</div>
	</tr>
</table><?php include("_menu.php"); ?><form action="listado.php" method="get">
<table width="1100" border="0" cellpadding="0" cellspacing="2" align="center">
	<tr>
	  <td width="33%" bgcolor="#F0F0F0" class="textos_form_derecha">Cuenta:</td>
	  <td width="33%" colspan="3" bgcolor="#F0F0F0"><select name="ID_CUENTA_BANCARIA" class="textos_form" id="ID_CUENTA_BANCARIA">
          <?php
do {  
?>
          <option value="<?php echo $row_CUENTAS['ID_CUENTA']?>"><?php echo $row_CUENTAS['NOMBRE_PROYECTO']?> - <?php echo $row_CUENTAS['NOMBRE_BANCO']?> - <?php echo $row_CUENTAS['NUMERO_CUENTA']?></option>
          <?php
} while ($row_CUENTAS = mysql_fetch_assoc($CUENTAS));
  $rows = mysql_num_rows($CUENTAS);
  if($rows > 0) {
      mysql_data_seek($CUENTAS, 0);
	  $row_CUENTAS = mysql_fetch_assoc($CUENTAS);
  }
?>
      </select>
      <input name="orden" type="hidden" id="orden" value="1" />
      <input name="col" type="hidden" id="col" value="FECHA_DATE" />
      <input type="hidden" name="DESCRIPCION" id="DESCRIPCION" />
      <input type="hidden" name="ID_MOV_BANCO_CAJA" id="ID_MOV_BANCO_CAJA" />
      <input type="hidden" name="DEBITO" id="DEBITO" />
      <input type="hidden" name="CREDITO" id="CREDITO" />
      <input type="hidden" name="FECHA_DATE" id="FECHA_DATE" />
      <input type="hidden" name="NOMBRE_TIPO_MOV" id="NOMBRE_TIPO_MOV" /></td>
    </tr>
	<tr>
		<td bgcolor="#F0F0F0" class="textos_form_derecha">Tipo Movimiento:</td>
		<td bgcolor="#F0F0F0"><label for="TIPO_IO"></label>
		  <select name="TIPO_IO" class="textos_form" id="TIPO_IO">
		    <option value="T" selected="selected">Todos</option>
		    <option value="O">Debito</option>
		    <option value="I">Credito</option>
        </select></td>
		<td bgcolor="#F0F0F0" class="textos_form_derecha">Tipo:</td>
		<td bgcolor="#F0F0F0"><label for="ID_TESORERIA_TIPO_MOV"></label>
		  <select name="ID_TESORERIA_TIPO_MOV" class="textos_form" id="ID_TESORERIA_TIPO_MOV">
          <option value="">Todos</option>
		    <?php
do {  
?>
		    <option value="<?php echo $row_TIPO['ID_TESORERIA_TIPO_MOV']?>">[<?php echo $row_TIPO['NOMBRE_MODULO']?>]-<?php echo $row_TIPO['NOMBRE']?></option>
		    <?php
} while ($row_TIPO = mysql_fetch_assoc($TIPO));
  $rows = mysql_num_rows($TIPO);
  if($rows > 0) {
      mysql_data_seek($TIPO, 0);
	  $row_TIPO = mysql_fetch_assoc($TIPO);
  }
?>
        </select></td>
	</tr>
	<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Numero:</td>
	  <td colspan="3" bgcolor="#F0F0F0"><label for="NUMERO_PAGO"></label>
      <input type="text" name="NUMERO_PAGO" id="NUMERO_PAGO" /></td>
    </tr>
	<tr>
		<td bgcolor="#F0F0F0" class="textos_form_derecha">Desde</td>
		<td bgcolor="#F0F0F0"><input type="text" id="from" name="FROM"/></td>
		<td width="162" align="right" bgcolor="#F0F0F0"><span class="textos_form_derecha">Hasta</span></td>
		<td width="33%" bgcolor="#F0F0F0"><input type="text" id="to" name="TO"/></td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0" class="textos_form_derecha">Anulado:</td>
		<td bgcolor="#F0F0F0"><input name="ANULADO" type="checkbox" id="ANULADO" value="AND ANULADO=1" />
			<label for="ANULADO"></label></td>
		<td width="162" align="right" bgcolor="#F0F0F0">&nbsp;</td>
		<td width="33%" bgcolor="#F0F0F0">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" align="center" bgcolor="#F0F0F0" class="textos_form"><input name="button" type="submit" class="ui-widget-header" id="button" value="Buscar" /></td>
	</tr>
</table>
</form>



</body>
</html>
<?php

mysql_free_result($CUENTAS);

mysql_free_result($TIPO);

?>
