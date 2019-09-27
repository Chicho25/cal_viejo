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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<title>Untitled Document</title>
<script src="../js/jquery-1.4.2.min.js" language="javascript"></script>
<script src="../js/jquery-ui-1.8.5.custom.min.js" language="javascript"></script>
<script src="../js/jquery.ui.datepicker-es.js" language="javascript"></script>
<script src="../js/jquery.infieldlabel.min.js" language="javascript"></script>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<title>Untitled Document</title>
<link href="../js/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="../css/form.css" rel="stylesheet" type="text/css" />

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
input {
	border: 1px solid #ccc;
	color: #999;
	font: inherit;
}
input:focus, input.focused {
	border-color: #000;
	color: #333;
}
</style>


<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script>
$(function() {

		$( "#FECHA" ).datepicker({
			changeMonth: true,
			changeYear: true,
			currentText: 'Now'
		});
});

</script>
</head>

<body>
<?php $opcion_menu=2; ?>
<?php include('../include/header.php'); ?>

	<table width="1100" align="center" class="ui-widget-header" >
		<tr>
			<td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Cheque Anulado</div>
		</tr>
	</table>
	<center>
	
	</center>
<form action="cheque_anulado2.php" method="post">
<table width="1100" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="462" class="textos_form_derecha">Cuenta:</td>
		<td width="638"><label for="ID_CUENTA_BANCARIA"></label>
			<select name="ID_CUENTA_BANCARIA" id="ID_CUENTA_BANCARIA">
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
		</select></td>
	</tr>
	<tr>
		<td class="textos_form_derecha">Numero de cheque:</td>
		<td><label for="NUMERO_PAGO"></label>
			<span id="sprytextfield1">
			<input type="text" name="NUMERO_PAGO" id="NUMERO_PAGO" />
			<span class="textfieldRequiredMsg">Introduzca el numero de cheque.</span><span class="textfieldInvalidFormatMsg">Solo Numeros.</span></span></td>
	</tr>
    	<tr>
      <td width="398" align="right" class="textos_form_derecha" >Fecha:<td align="left" ><label for="FECHA"></label>
        <input name="FECHA" type="text" class="textos_form" id="FECHA" />
</tr>
		<tr>
		<td class="textos_form_derecha">Descripcion:</td>
		<td><label for="DESCRIPCION"></label>
			<textarea name="DESCRIPCION" id="DESCRIPCION" cols="45" rows="5"></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center" class="textos_form"><label for="DESCRIPCION">
			<input name="button" type="submit" class="textos_form" id="button" value="Guardar" />
		</label></td>
	</tr>
</table></form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer");
</script>
</body>
</html>

