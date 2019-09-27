<?php function changueFormatDate($cdate){
    list($day,$month,$year)=explode("/",$cdate);
    return $year."-".$month."-".$day;
}?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
	if(isset($_POST['STATUS_APROBADO']) && $_POST['STATUS_APROBADO']!=""){$APROBADO=1;} else {$APROBADO=0;};
  $insertSQL = sprintf("INSERT INTO documentos (NUMERO, ID_PRO_CLI, TIPO, FECHA_EMISION, FECHA_VENCIMIENTO, DESCRIPCION, ID_INMUEBLES_MOV, MONTO_EXENTO, ID_BANCO, STATUS_APROBADO, COD_PROYECTO) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['NUMERO'], "text"),
                       GetSQLValueString($_POST['ID_PRO_CLI'], "int"),
                       GetSQLValueString($_POST['TIPO'], "int"),
                       GetSQLValueString(changueFormatDate($_POST['FECHA_EMISION']), "date"),
                       GetSQLValueString(changueFormatDate($_POST['FECHA_VENCIMIENTO']), "date"),
                       GetSQLValueString($_POST['DESCRIPCION'], "text"),
                       GetSQLValueString($_POST['ID_INMUEBLES_MOV'], "int"),
                       GetSQLValueString($_POST['MONTO_EXENTO'], "double"),
					   GetSQLValueString($_POST['ID_BANCO'], "int"),
					   GetSQLValueString($APROBADO, "int"),
                       GetSQLValueString($_POST['COD_PROYECTO'], "text"));
					  //echo $insertSQL;

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());

  $insertGoTo = "add.php?ID_INMUEBLES_MOV=".$_POST['ID_INMUEBLES_MOV'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}


$colname_CONSULTA = "-1";
if (isset($_GET['ID_INMUEBLES_MOV'])) {
  $colname_CONSULTA = $_GET['ID_INMUEBLES_MOV'];
}
mysql_select_db($database_conexion, $conexion);
$query_CONSULTA = sprintf("SELECT * FROM vista_ventas WHERE ID_INMUEBLES_MOV = %s", GetSQLValueString($colname_CONSULTA, "int"));
$CONSULTA = mysql_query($query_CONSULTA, $conexion) or die(mysql_error());
$row_CONSULTA = mysql_fetch_assoc($CONSULTA);
$totalRows_CONSULTA = mysql_num_rows($CONSULTA);

mysql_select_db($database_conexion, $conexion);
$query_TIPO = "SELECT * FROM documentos_tipo WHERE MODULO = 2";
$TIPO = mysql_query($query_TIPO, $conexion) or die(mysql_error());
$row_TIPO = mysql_fetch_assoc($TIPO);
$totalRows_TIPO = mysql_num_rows($TIPO);


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
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/menu_style.css" type="text/css" media="all" />
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />



<script>
$(function() {

		$( "#FECHA_VENCIMIENTO" ).datepicker({
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
		<td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Nuevo Documento de Venta</div>
	</tr>
</table><form name="form" action="<?php echo $editFormAction; ?>" method="POST">
<table width="1100" border="0" cellpadding="0" cellspacing="2" align="center">
	<tr>
		<td width="298" bgcolor="#F0F0F0" class="textos_form_derecha">Proyecto:</td>
		<td width="280" bgcolor="#F0F0F0"><label for="textfield"></label>
      <input name="textfield" type="text" disabled="disabled" class="textos_form" id="textfield" value="<?php echo $row_CONSULTA['PROYECTO']; ?>" size="40" readonly="readonly" />		  <label for="CODIGO"></label></td>
		<td width="122" bgcolor="#F0F0F0" class="textos_form_derecha"><span class="textos_form_derecha">Grupo:</span></td>
		<td width="390" bgcolor="#F0F0F0"><input name="textfield2" type="text" disabled="disabled" class="textos_form" id="textfield2" value="<?php echo $row_CONSULTA['NOMBRE_GRUPO']; ?>" size="40" readonly="readonly" /></td>
	</tr>
	<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Nombre:</td>
	  <td width="280" bgcolor="#F0F0F0"><input name="textfield3" type="text" disabled="disabled" class="textos_form" id="textfield3" value="<?php echo $row_CONSULTA['NOMBRE_INMUEBLE']; ?>" size="40" readonly="readonly" /></td>
	  <td width="122" bgcolor="#F0F0F0" class="textos_form_derecha"><span class="textos_form_derecha">Codigo:</span></td>
	  <td width="390" bgcolor="#F0F0F0"><input name="textfield6" type="text" disabled="disabled" class="textos_form" id="textfield6" value="<?php echo $row_CONSULTA['CODIGO_INMUEBLE']; ?>" size="40" readonly="readonly" /></td>
    </tr>
	<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Cliente:</td>
	  <td colspan="3" bgcolor="#F0F0F0"><input name="textfield4" type="text" disabled="disabled" class="textos_form" id="textfield4" value="<?php echo $row_CONSULTA['NOMBRE_CLIENTE']; ?>" size="107" readonly="readonly" />
      <input name="ID_PRO_CLI" type="hidden" id="ID_PRO_CLI" value="<?php echo $row_CONSULTA['ID_CLIENTE']; ?>" /></td>
    </tr>
	<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Fecha Venta:</td>
	  <td width="280" bgcolor="#F0F0F0"><input name="FECHA" type="text" disabled="disabled" class="textos_form" id="FECHA" value="<?php echo $row_CONSULTA['FECHA_VENTA']; ?>" />
      <input name="FECHA_EMISION" type="hidden" id="FECHA_EMISION" value="<?php echo $row_CONSULTA['FECHA_VENTA']; ?>" /></td>
	  <td width="122" bgcolor="#F0F0F0" class="textos_form_derecha"><span class="textos_form_derecha">Fecha Vencimiento:</span></td>
	  <td width="390" bgcolor="#F0F0F0"><span id="sprytextfield1">
	    <input type="text" name="FECHA_VENCIMIENTO" id="FECHA_VENCIMIENTO" />
      <span class="textfieldRequiredMsg">Requerido</span></span></td>
    </tr>
	<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Descripcion;</td>
	  <td colspan="3" valign="middle" bgcolor="#F0F0F0"><label for="DESCRIPCION"></label>
	    <span id="sprytextarea1">
	    <textarea name="DESCRIPCION" id="DESCRIPCION" cols="72" rows="5"></textarea>
	    <span class="textareaRequiredMsg">Requerido</span></span>
	    <input name="ID_INMUEBLES_MOV" type="hidden" id="ID_INMUEBLES_MOV" value="<?php echo $row_CONSULTA['ID_INMUEBLES_MOV']; ?>" />
      <input name="COD_PROYECTO" type="hidden" id="COD_PROYECTO" value="<?php echo $row_CONSULTA['ID_PROYECTO']; ?>" /></td>
    </tr>
	
	<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Tipo</td>
	  <td bgcolor="#F0F0F0"><label for="TIPO"></label>
	    <select name="TIPO" id="TIPO">
	      <?php
do {  
?>
	      <option value="<?php echo $row_TIPO['ID_DOCUMENTOS_TIPO']?>"><?php echo $row_TIPO['DESCRIPCION']?></option>
	      <?php
} while ($row_TIPO = mysql_fetch_assoc($TIPO));
  $rows = mysql_num_rows($TIPO);
  if($rows > 0) {
      mysql_data_seek($TIPO, 0);
	  $row_TIPO = mysql_fetch_assoc($TIPO);
  }
?>
      </select></td>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Numero:</td>
	  <td bgcolor="#F0F0F0"><span id="sprytextfield4">
	    <label for="NUMERO"></label>
	    <input type="text" name="NUMERO" id="NUMERO" />
      <span class="textfieldRequiredMsg">Requerido.</span></span></td>
    </tr>

	<tr>

	
	
<?php 	
mysql_select_db($database_conexion, $conexion);
$query_BANCO = "SELECT ID_BANCO_MASTER, NOMBRE FROM banco_master ORDER BY NOMBRE ASC";
$BANCO = mysql_query($query_BANCO, $conexion) or die(mysql_error());
$row_BANCO = mysql_fetch_assoc($BANCO);
$totalRows_BANCO = mysql_num_rows($BANCO);
?>
		<td bgcolor="#F0F0F0" class="textos_form_derecha">Banco Emisor Carta Promesa:
			<div class="ui-state-error-text">Nota: Aplica SOLO a Cartas Promesas</div></td>
		<td bgcolor="#F0F0F0"><label for="ID_BANCO"></label>
			<select name="ID_BANCO" id="ID_BANCO">
			<option value=""></option>
				<?php
do {  
?>
				<option value="<?php echo $row_BANCO['ID_BANCO_MASTER']?>"><?php echo $row_BANCO['NOMBRE']?></option>
				<?php
} while ($row_BANCO = mysql_fetch_assoc($BANCO));
  $rows = mysql_num_rows($BANCO);
  if($rows > 0) {
      mysql_data_seek($BANCO, 0);
	  $row_BANCO = mysql_fetch_assoc($BANCO);
  }
?>
			</select></td>
		<td bgcolor="#F0F0F0" class="textos_form_derecha">Aprobada:</td>
		<td bgcolor="#F0F0F0"><input name="STATUS_APROBADO" type="checkbox" id="STATUS_APROBADO" value="1" />
			<label for="STATUS_APROBADO"></label></td>
	</tr>
	<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Monto:</td>
	  <td colspan="3" bgcolor="#F0F0F0"><span id="sprytextfield3">
      <input type="text" name="MONTO_EXENTO" id="MONTO_EXENTO" />
      <span class="textfieldRequiredMsg">Requerido</span><span class="textfieldInvalidFormatMsg">Formato Invalido</span></span></td>
    </tr>
	<tr>
		<td colspan="4" align="center" bgcolor="#F0F0F0" class="textos_form"><input name="button" type="submit" class="ui-widget-header" id="button" value="Guardar" /></td>
	</tr>
</table>
<input type="hidden" name="MM_insert" value="form" />
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur", "change"]});
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur", "change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "real", {validateOn:["blur", "change"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur", "change"]});
</script>
</body>
</html>
<?php
mysql_free_result($CONSULTA);

mysql_free_result($TIPO);

mysql_free_result($BANCO);
?>
