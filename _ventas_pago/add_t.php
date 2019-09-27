<?php function changueFormatDate($cdate){
    list($day,$month,$year)=explode("/",$cdate);
    return $year."-".$month."-".$day;
}?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
  $insertSQL = sprintf("INSERT INTO pagos (FECHA, DESCRIPCION) VALUES (%s, %s)",
                       GetSQLValueString(changueFormatDate($_POST['FECHA']), "date"),
                       GetSQLValueString($_POST['DESCRIPCION'], "text"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  $ID_PAGO=mysql_insert_id();

  $insertSQL = sprintf("INSERT INTO pagos_detalle (ID_DOCUMENTO, ID_PAGO, MONTO_PAGADO) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['ID_DOCUMENTO'], "int"),
                       GetSQLValueString($ID_PAGO, "int"),
                       GetSQLValueString($_POST['MONTO'], "double"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());

  $insertSQL = sprintf("INSERT INTO mov_banco_caja (ID_PAGO, TIPO_PAGO, NUMERO_PAGO, FECHA, DESCRIPCION, MONTO, ID_CUENTA_BANCARIA, COD_PROYECTO) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($ID_PAGO, "int"),
                       GetSQLValueString($_POST['TIPO'], "int"),
                       GetSQLValueString($_POST['NUMERO'], "text"),
                       GetSQLValueString(changueFormatDate($_POST['FECHA']), "date"),
                       GetSQLValueString($_POST['DESCRIPCION'], "text"),
                       GetSQLValueString($_POST['MONTO'], "double"),
                       GetSQLValueString($_POST['ID_CUENTA_BANCARIA'], "int"),
                       GetSQLValueString($_POST['COD_PROYECTO'], "text"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  echo ' <script type="text/javascript">
alert("Proceso Completado con Exito.");
window.location = "../_doc_venta/listado.php?ID_INMUEBLES_MOV='. $_GET['ID_INMUEBLES_MOV'].'";
</script>';
}




mysql_select_db($database_conexion, $conexion);
$query_TIPO = "SELECT * FROM tesoreria_tipo_mov WHERE MODULO=2";
$TIPO = mysql_query($query_TIPO, $conexion) or die(mysql_error());
$row_TIPO = mysql_fetch_assoc($TIPO);
$totalRows_TIPO = mysql_num_rows($TIPO);

$colname_CONSULTA2 = "-1";
if (isset($_GET['ID_DOCUMENTO'])) {
  $colname_CONSULTA2 = $_GET['ID_DOCUMENTO'];
}
mysql_select_db($database_conexion, $conexion);
$query_CONSULTA2 = sprintf("SELECT * FROM vista_documentos WHERE ID_DOCUMENTO = %s", GetSQLValueString($colname_CONSULTA2, "int"));
$CONSULTA2 = mysql_query($query_CONSULTA2, $conexion) or die(mysql_error());
$row_CONSULTA2 = mysql_fetch_assoc($CONSULTA2);
$totalRows_CONSULTA2 = mysql_num_rows($CONSULTA2);

mysql_select_db($database_conexion, $conexion);
$query_CONSULTA = "SELECT * FROM vista_ventas WHERE ID_INMUEBLES_MOV=".$row_CONSULTA2['ID_INMUEBLES_MOV'];
$CONSULTA = mysql_query($query_CONSULTA, $conexion) or die(mysql_error());
$row_CONSULTA = mysql_fetch_assoc($CONSULTA);
$totalRows_CONSULTA = mysql_num_rows($CONSULTA);

mysql_select_db($database_conexion, $conexion);
$query_cuenta = "SELECT * FROM vista_banco_cuentas WHERE CODIGO_PROYECTO = '".$row_CONSULTA2['COD_PROYECTO']."'";
$cuenta = mysql_query($query_cuenta, $conexion) or die(mysql_error());
$row_cuenta = mysql_fetch_assoc($cuenta);
$totalRows_cuenta = mysql_num_rows($cuenta);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<title>Untitled Document</title>
<?php include("../include/_js.php"); ?>
<?php include("../include/_css.php"); ?>

<?php 
$visivilidad="none";
?>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/menu_style.css" type="text/css" media="all" />
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />



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
<?php include("../include/menu.php"); ?>

<table width="1100" align="center" class="ui-widget-header" >
	<tr>
		<td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Recepcion de Pago</div>
	</tr>
</table><form name="form" action="<?php echo $editFormAction; ?>" method="POST">
<table width="1100" border="0" cellpadding="0" cellspacing="2" align="center">
	<tr>
		<td width="272" bgcolor="#F0F0F0" class="textos_form_derecha"><input name="COD_PROYECTO" type="hidden" id="COD_PROYECTO" value="<?php echo $row_CONSULTA['ID_PROYECTO']; ?>" />
	    Proyecto:</td>
		<td width="272" bgcolor="#F0F0F0"><label for="textfield"></label>
      <input name="textfield" type="text" disabled="disabled" class="textos_form" id="textfield" value="<?php echo $row_CONSULTA['PROYECTO']; ?>" size="40" readonly="readonly" />		  <label for="CODIGO"></label></td>
		<td width="156" bgcolor="#F0F0F0" class="textos_form_derecha"><span class="textos_form_derecha">Grupo:</span></td>
		<td width="390" bgcolor="#F0F0F0"><input name="textfield2" type="text" disabled="disabled" class="textos_form" id="textfield2" value="<?php echo $row_CONSULTA['NOMBRE_GRUPO']; ?>" size="40" readonly="readonly" /></td>
	</tr>
	<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Nombre:</td>
	  <td width="272" bgcolor="#F0F0F0"><input name="textfield3" type="text" disabled="disabled" class="textos_form" id="textfield3" value="<?php echo $row_CONSULTA['NOMBRE_INMUEBLE']; ?>" size="40" readonly="readonly" /></td>
	  <td width="156" bgcolor="#F0F0F0" class="textos_form_derecha"><span class="textos_form_derecha">Codigo:</span></td>
	  <td width="390" bgcolor="#F0F0F0"><input name="textfield6" type="text" disabled="disabled" class="textos_form" id="textfield6" value="<?php echo $row_CONSULTA['CODIGO_INMUEBLE']; ?>" size="40" readonly="readonly" /></td>
    </tr>
	<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Cliente:</td>
	  <td colspan="3" bgcolor="#F0F0F0"><input name="textfield4" type="text" disabled="disabled" class="textos_form" id="textfield4" value="<?php echo $row_CONSULTA2['NOMBRE_PRO_CLI']; ?>" size="107" readonly="readonly" />
      <input name="ID_PRO_CLI" type="hidden" id="ID_PRO_CLI" value="<?php echo $row_CONSULTA['ID_CLIENTE']; ?>" /></td>
    </tr>
	<tr>
		<td bgcolor="#F0F0F0" class="textos_form_derecha">Tipo</td>
		<td bgcolor="#F0F0F0"><label for="textfield7"></label>
			<input name="textfield7" type="text" disabled="disabled" class="textos_form" id="textfield7" value="<?php echo $row_CONSULTA2['TIPO_DOCUMENTO']; ?>" readonly="readonly" /></td>
		<td bgcolor="#F0F0F0" class="textos_form_derecha">Numero</td>
		<td bgcolor="#F0F0F0"><label for="textfield9"></label>
			<input name="textfield9" type="text" disabled="disabled" class="textos_form" id="textfield9" value="<?php echo $row_CONSULTA2['NUMERO_DOCUMENTO']; ?>" readonly="readonly" /></td>
	</tr>
	<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Id Documento</td>
	  <td colspan="3" valign="middle" bgcolor="#F0F0F0"><label for="DESCRIPCION"></label>
      <span id="sprytextarea1"><span class="textareaRequiredMsg">Requerido</span></span>
      <label for="textfield5"></label>
      <input name="textfield5" type="text" disabled="disabled" class="textos_form" id="textfield5" value="<?php echo $row_CONSULTA2['ID_DOCUMENTO']; ?>" readonly="readonly" />
      <input name="ID_DOCUMENTO" type="hidden" id="ID_DOCUMENTO" value="<?php echo $row_CONSULTA2['ID_DOCUMENTO']; ?>" /></td>
    </tr>
	<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Tipo</td>
	  <td bgcolor="#F0F0F0"><label for="TIPO"></label>
	    <select name="TIPO" id="TIPO">
	      <?php
do {  
?>
	      <option value="<?php echo $row_TIPO['ID_TESORERIA_TIPO_MOV']?>"><?php echo $row_TIPO['NOMBRE']?></option>
	      <?php
} while ($row_TIPO = mysql_fetch_assoc($TIPO));
  $rows = mysql_num_rows($TIPO);
  if($rows > 0) {
      mysql_data_seek($TIPO, 0);
	  $row_TIPO = mysql_fetch_assoc($TIPO);
  }
?>
      </select></td>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Cuenta Receptora:</td>
	  <td bgcolor="#F0F0F0"><label for="select"></label>
	    <label for="textfield8"></label>
      <input name="textfield8" type="text" disabled="disabled" class="textos_form" id="textfield8" value="<?php echo $row_cuenta['NOMBRE_BANCO']; ?>-<?php echo $row_cuenta['NUMERO_CUENTA']; ?>" readonly="readonly" />
      <input name="ID_CUENTA_BANCARIA" type="hidden" id="ID_CUENTA_BANCARIA" value="<?php echo $row_cuenta['ID_CUENTA']; ?>" /></td>
    </tr>
	<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Numero:</td>
	  <td bgcolor="#F0F0F0"><label for="NUMERO"></label>
	    <span id="sprytextfield2">
	    <input type="text" name="NUMERO" id="NUMERO" />
      <span class="textfieldRequiredMsg">Es Requerido.</span></span></td>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Fecha:</td>
	  <td bgcolor="#F0F0F0"><span id="sprytextfield4">
	    <input name="FECHA" type="text" class="textos_form" id="FECHA" />
      <span class="textfieldRequiredMsg">Es Requerido.</span></span></td>
    </tr>
	<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Descripcion:</td>
	  <td colspan="3" bgcolor="#F0F0F0"><label for="textarea"></label>
	    <span id="sprytextarea2">
      <label for="DESCRIPCION"></label>
      <textarea name="DESCRIPCION" id="DESCRIPCION" cols="45" rows="5"></textarea>
      <span class="textareaRequiredMsg">Es Requerido..</span></span></td>
    </tr>
	<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Monto Documento:</td>
	  <td colspan="3" bgcolor="#F0F0F0">
      <input name="MONTO_EXENTO" type="text" disabled="disabled" class="textos_form_derecha" id="MONTO_EXENTO" value="<?php echo number_format($row_CONSULTA2['MONTO_DOCUMENTO'],2); ?>" readonly="readonly" />
      </td>
    </tr>
	<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Monto Pagado:</td>
	  <td colspan="3" bgcolor="#F0F0F0"><input name="MONTO_EXENTO2" type="text" disabled="disabled" class="textos_form_derecha" id="MONTO_EXENTO2" value="<?php echo number_format($row_CONSULTA2['MONTO_PAGADO'],2); ?>" readonly="readonly" /></td>
    </tr>
	<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Monto Pendiente:</td>
	  <td colspan="3" bgcolor="#F0F0F0"><input name="MONTO_EXENTO3" type="text" disabled="disabled" class="textos_form_derecha" id="MONTO_EXENTO3" value="<?php echo number_format($row_CONSULTA2['MONTO_DOCUMENTO']-$row_CONSULTA2['MONTO_PAGADO'],2); ?>" readonly="readonly" /></td>
    </tr>
	<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Monto de este Pago:</td>
	  <td colspan="3" bgcolor="#F0F0F0"><span id="sprytextfield1">
      <input name="MONTO" type="text" class="textos_form" id="MONTO" />
      <span class="textfieldRequiredMsg">Es Requerido.</span><span class="textfieldInvalidFormatMsg">Debe ser numerico</span><span class="textfieldMaxValueMsg">El monto excede el monto restante.</span></span></td>
    </tr>
	<tr>
		<td colspan="4" align="center" bgcolor="#F0F0F0" class="textos_form"><input name="button" type="submit" class="ui-widget-header" id="button" value="Guardar" /></td>
	</tr>
</table>
<input type="hidden" name="MM_insert" value="form" />
</form>
<script type="text/javascript">
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "real");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "real", {validateOn:["change"], maxValue:<?php echo $row_CONSULTA2['MONTO_DOCUMENTO']-$row_CONSULTA2['MONTO_PAGADO']; ?>});
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2", {validateOn:["change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
</script>
</body>
</html>
<?php
mysql_free_result($CONSULTA);

mysql_free_result($TIPO);

mysql_free_result($CONSULTA2);

mysql_free_result($cuenta);
?>
