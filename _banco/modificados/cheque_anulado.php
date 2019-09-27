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
$query_cuentas = "SELECT ID_CUENTA_BANCARIA, NUMERO_CTA FROM cuentas_bancarias WHERE ID_CUENTA_BANCARIA=1";
$cuentas = mysql_query($query_cuentas, $conexion) or die(mysql_error());
$row_cuentas = mysql_fetch_assoc($cuentas);
$totalRows_cuentas = mysql_num_rows($cuentas);
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
</head>

<body>
<?php $opcion_menu=2; ?>
<?php include("../include/menu.php"); ?>

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
		  <label for="ID_CUENTA_BANCARIA"></label>
		<input name="ID_CUENTA_BANCARIA" type="text" class="textos_form" id="ID_CUENTA_BANCARIA" value="<?php echo $row_cuentas['NUMERO_CTA']; ?>" readonly="readonly" />
		<input name="ID_CUENTA_BANCARIA" type="hidden" id="ID_CUENTA_BANCARIA" value="1" /></td>
	</tr>
	<tr>
		<td class="textos_form_derecha">Numero de cheque:</td>
		<td><label for="NUMERO_PAGO"></label>
			<span id="sprytextfield1">
			<input name="NUMERO_PAGO" type="text" class="textos_form_derecha" id="NUMERO_PAGO"  value="<?php echo $_GET['CHEQUE']; ?>" readonly="readonly"/>
			<span class="textfieldRequiredMsg">Introduzca el numero de cheque.</span><span class="textfieldInvalidFormatMsg">Solo Numeros.</span></span></td>
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
<?php
mysql_free_result($cuentas);

?>
