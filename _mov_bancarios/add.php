<?php require_once('../../Connections/conexion.php'); ?>
<?php //include("../include/_funciones.php"); ?>
<?php include('../include/header.php'); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "enviar")) {
  $insertSQL = sprintf("INSERT INTO mov_banco_caja (TIPO_PAGO, NUMERO_PAGO, FECHA, DESCRIPCION, MONTO, ID_CUENTA_BANCARIA) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['TIPO_PAGO'], "int"),
                       GetSQLValueString($_POST['NUMERO_PAGO'], "text"),
                       GetSQLValueString(DMAtoAMD($_POST['FECHA']), "date"),
                       GetSQLValueString($_POST['DESCRIPCION'], "text"),
                       GetSQLValueString($_POST['MONTO'], "double"),
                       GetSQLValueString($_POST['ID_CUENTA_BANCARIA'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
}

mysql_select_db($database_conexion, $conexion);
$query_CUENTAS = "SELECT * FROM vista_banco_cuentas";
$CUENTAS = mysql_query($query_CUENTAS, $conexion) or die(mysql_error());
$row_CUENTAS = mysql_fetch_assoc($CUENTAS);
$totalRows_CUENTAS = mysql_num_rows($CUENTAS);

mysql_select_db($database_conexion, $conexion);
$query_TIPO = "SELECT * FROM tesoreria_tipo_mov WHERE MODULO = 3 AND ID_TESORERIA_TIPO_MOV<>11";
$TIPO = mysql_query($query_TIPO, $conexion) or die(mysql_error());
$row_TIPO = mysql_fetch_assoc($TIPO);
$totalRows_TIPO = mysql_num_rows($TIPO);

/*Definiciones*/
$formulario="mov_bancario00-Editar";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
<title>Untitled Document</title>
<?php include("../include/_js.php"); ?>
<?php include("../include/_css.php"); ?>

<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script>
$(function() {

		$( "#FECHA" ).datepicker({
			changeMonth: true,
			changeYear: true,
			currentText: 'Now'
		});
});

</script>

<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
<?php $opcion_menu=2; ?>


      <table width="1100" align="center" class="ui-widget-header" >
    <tr>
          <td width="100%" align="center" class="textos_form"><div class="titulo_formulario">A&ntilde;adir Movimiento Bancario</div>
    </tr>
  </table>
  <?php //include("../include/funciones.php"); ?>
<?php include("_menu.php"); ?>
<form action="<?php echo $editFormAction; ?>" name="enviar" method="POST" id="enviar">
      <table width="1100" align="center" >
    <tr>
      <td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >

Cuenta: 
      <td align="left" bgcolor="#F3F3F3" ><label for="ID_CUENTA_BANCARIA"></label>
        <select name="ID_CUENTA_BANCARIA" class="textos_form" id="ID_CUENTA_BANCARIA">
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
      <label for="NUMERO_PAGO"></label></tr>
    <tr>
      <td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Tipo:      
      <td align="left" bgcolor="#F3F3F3" ><label for="TIPO_PAGO"></label>
        <select name="TIPO_PAGO" class="textos_form" id="TIPO_PAGO">
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
        </select>
      <label for="MONTO_ESTIMADO"></label></tr>
    <tr>
      <td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Fecha:<td align="left" bgcolor="#F3F3F3" ><label for="FECHA"></label>
        <span id="sprytextfield1">
        <input name="FECHA" type="text" class="textos_form" id="FECHA" />
        <span class="textfieldRequiredMsg">Requerido.</span><span class="textfieldInvalidFormatMsg">Formato Invalido.</span></span></tr>
    <tr>
      <td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Referencia o Numero:      
      <td align="left" bgcolor="#F3F3F3" ><label for="textfield3">        </label>      <input name="NUMERO_PAGO" type="text" class="textos_form" id="textfield6" />      </tr>
    <tr>
      <td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Monto:      
      <td align="left" bgcolor="#F3F3F3" ><label for="textfield6"></label>
        <span id="sprytextfield2">
        <label for="textfield4">
          <input name="MONTO" type="text" class="textos_form_derecha" id="textfield" />
        </label>
      <span class="textfieldRequiredMsg">Requerido.</span></span></tr>
    <tr>
      <td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Descripcion:      
      <td align="left" bgcolor="#F3F3F3" ><label for="DESCRIPCION"></label>
        <textarea name="DESCRIPCION" cols="45" rows="5" class="textos_form" id="DESCRIPCION"></textarea>
      <label for="textfield5"></label></tr>
    <tr>
          <td colspan="2" align="left" >
              <div class="validity-summary-container" style="color:#F00">
    
    <ul></ul>
</div></tr>

          <td colspan="2" align="center" bgcolor="#999999" class="textos_form" ><input name="button" type="submit" class="ui-widget-header" id="button" value="Guardar" /></tr>
</table>
      <input type="hidden" name="MM_insert" value="enviar" />
</form>


<?php include("../include/_foot.php"); ?>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"dd/mm/yyyy"});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
</body>
</html>
<?php
mysql_free_result($CUENTAS);

mysql_free_result($TIPO);

?>
