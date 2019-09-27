<?php function changueFormatDate($cdate){
    list($day,$month,$year)=explode("/",$cdate);
    return $year."-".$month."-".$day;
}?>
<?php require_once('../Connections/conexion.php'); ?>
<?php
if(isset($_POST['STATUS_APROBADO']) && $_POST['STATUS_APROBADO']!='0'){$STATUS_APROBADO=$_POST['STATUS_APROBADO'];} else {$STATUS_APROBADO=0;}
/*
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
}*/

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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form")) {
  $updateSQL = sprintf("UPDATE documentos SET NUMERO=%s, TIPO=%s, FECHA_VENCIMIENTO=%s, DESCRIPCION=%s, ID_BANCO=%s, STATUS_APROBADO=%s, MONTO_EXENTO=%s WHERE ID_DOCUMENTO=%s",
                       GetSQLValueString($_POST['NUMERO'], "text"),
                       GetSQLValueString($_POST['TIPO'], "int"),
                       GetSQLValueString(changueFormatDate($_POST['FECHA_VENCIMIENTO']), "date"),
                       GetSQLValueString($_POST['DESCRIPCION'], "text"),
					   GetSQLValueString($_POST['ID_BANCO'], "int"),
					   GetSQLValueString($STATUS_APROBADO, "int"),
                       GetSQLValueString($_POST['MONTO_EXENTO'], "double"),
                       GetSQLValueString($_POST['ID_DOCUMENTO'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
}

$colname_CONSULTA = "-1";
if (isset($_GET['ID_DOCUMENTO'])) {
  $colname_CONSULTA = $_GET['ID_DOCUMENTO'];
}
mysql_select_db($database_conexion, $conexion);
$query_CONSULTA = sprintf("SELECT * FROM vista_documentos WHERE ID_DOCUMENTO = %s", GetSQLValueString($colname_CONSULTA, "int"));
$CONSULTA = mysql_query($query_CONSULTA, $conexion) or die(mysql_error());
$row_CONSULTA = mysql_fetch_assoc($CONSULTA);
$totalRows_CONSULTA = mysql_num_rows($CONSULTA);

mysql_select_db($database_conexion, $conexion);
$query_TIPO = "SELECT * FROM documentos_tipo WHERE MODULO = 2";
$TIPO = mysql_query($query_TIPO, $conexion) or die(mysql_error());
$row_TIPO = mysql_fetch_assoc($TIPO);
$totalRows_TIPO = mysql_num_rows($TIPO);

mysql_select_db($database_conexion, $conexion);
$query_INMUEBLE = "SELECT * FROM vista_ventas WHERE ID_INMUEBLES_MOV = ".$row_CONSULTA['ID_INMUEBLES_MOV']."";
$INMUEBLE = mysql_query($query_INMUEBLE, $conexion) or die(mysql_error());
$row_INMUEBLE = mysql_fetch_assoc($INMUEBLE);
$totalRows_INMUEBLE = mysql_num_rows($INMUEBLE);

mysql_select_db($database_conexion, $conexion);
$query_BANCO = "SELECT ID_BANCO_MASTER, NOMBRE FROM banco_master ORDER BY NOMBRE ASC";
$BANCO = mysql_query($query_BANCO, $conexion) or die(mysql_error());
$row_BANCO = mysql_fetch_assoc($BANCO);
$totalRows_BANCO = mysql_num_rows($BANCO);
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
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />



<script>
$(function() {

		$( "#FECHA_VENCIMIENTO" ).datepicker({
			changeMonth: true,
			changeYear: true,
			currentText: 'Now'
		});
});

</script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php $opcion_menu=2; ?>
<?php include("../include/menu.php"); ?>

<table width="1100" align="center" class="ui-widget-header" >
	<tr>
		<td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Editar Documento de Venta</div>
	</tr>
</table><form name="form" action="<?php echo $editFormAction; ?>" method="POST">
<table width="1100" border="0" cellpadding="0" cellspacing="2" align="center">
	<tr>
		<td width="272" bgcolor="#F0F0F0" class="textos_form_derecha"><input name="ID_DOCUMENTO" type="hidden" id="ID_DOCUMENTO" value="<?php echo $row_CONSULTA['ID_DOCUMENTO']; ?>" />
  Proyecto:</td>
		<td width="272" bgcolor="#F0F0F0"><label for="textfield"></label>
      <input name="textfield" type="text" disabled="disabled" class="textos_form" id="textfield" value="<?php echo $row_CONSULTA['NOMBRE_PROYECTO']; ?>" size="40" readonly="readonly" />		  <label for="CODIGO"></label></td>
		<td width="156" bgcolor="#F0F0F0" class="textos_form_derecha"><span class="textos_form_derecha">Grupo:</span></td>
		<td width="390" bgcolor="#F0F0F0"><input name="textfield2" type="text" disabled="disabled" class="textos_form" id="textfield2" value="<?php echo $row_INMUEBLE['NOMBRE_GRUPO']; ?>" size="40" readonly="readonly" /></td>
	</tr>
	<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Nombre:</td>
	  <td width="272" bgcolor="#F0F0F0"><input name="textfield3" type="text" disabled="disabled" class="textos_form" id="textfield3" value="<?php echo $row_INMUEBLE['NOMBRE_INMUEBLE']; ?>" size="40" readonly="readonly" /></td>
	  <td width="156" bgcolor="#F0F0F0" class="textos_form_derecha"><span class="textos_form_derecha">Codigo:</span></td>
	  <td width="390" bgcolor="#F0F0F0"><input name="textfield6" type="text" disabled="disabled" class="textos_form" id="textfield6" value="<?php echo $row_INMUEBLE['CODIGO_INMUEBLE']; ?>" size="40" readonly="readonly" /></td>
    </tr>
	<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Cliente:</td>
	  <td colspan="3" bgcolor="#F0F0F0"><input name="textfield4" type="text" disabled="disabled" class="textos_form" id="textfield4" value="<?php echo $row_CONSULTA['NOMBRE_PRO_CLI']; ?>" size="107" readonly="readonly" />
      <input name="ID_PRO_CLI" type="hidden" id="ID_PRO_CLI" value="<?php echo $row_CONSULTA['ID_PRO_CLI']; ?>" /></td>
    </tr>
	<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Fecha Venta:</td>
	  <td width="272" bgcolor="#F0F0F0"><input name="FECHA" type="text" disabled="disabled" class="textos_form" id="FECHA" value="<?php echo $row_CONSULTA['FECHA_DOCUMENTO']; ?>" />
      <input name="FECHA_EMISION" type="hidden" id="FECHA_EMISION" value="<?php echo $row_CONSULTA['FECHA_DOCUMENTO']; ?>" /></td>
	  <td width="156" bgcolor="#F0F0F0" class="textos_form_derecha"><span class="textos_form_derecha">Fecha Vencimiento:</span></td>
	  <td width="390" bgcolor="#F0F0F0"><span id="sprytextfield1">
	    <input name="FECHA_VENCIMIENTO" type="text" id="FECHA_VENCIMIENTO" value="<?php echo $row_CONSULTA['FECHA_VENCIMIENTO']; ?>" />
      <span class="textfieldRequiredMsg">Requerido</span></span></td>
    </tr>
	<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Descripcion;</td>
	  <td colspan="3" valign="middle" bgcolor="#F0F0F0"><label for="DESCRIPCION"></label>
	    <span id="sprytextarea1">
	    <textarea name="DESCRIPCION" id="DESCRIPCION" cols="72" rows="5"><?php echo $row_CONSULTA['DESCRIPCION_DOCUMENTO']; ?></textarea>
	    </span>
	    <input name="ID_INMUEBLES_MOV" type="hidden" id="ID_INMUEBLES_MOV" value="<?php echo $row_CONSULTA['ID_INMUEBLES_MOV']; ?>" />
      <input name="COD_PROYECTO" type="hidden" id="COD_PROYECTO" value="<?php echo $row_CONSULTA['COD_PROYECTO']; ?>" /></td>
    </tr>
	<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Tipo</td>
	  <td bgcolor="#F0F0F0"><label for="TIPO"></label>
	    <select name="TIPO" id="TIPO">
	      <?php
do {  
?>
	      <option value="<?php echo $row_TIPO['ID_DOCUMENTOS_TIPO']?>"<?php if (!(strcmp($row_TIPO['ID_DOCUMENTOS_TIPO'], $row_CONSULTA['CODIGO_TIPO_DOCUMENTO']))) {echo "selected=\"selected\"";} ?>><?php echo $row_TIPO['DESCRIPCION']?></option>
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
	  <td bgcolor="#F0F0F0"><span id="sprytextfield2">
	    <input name="NUMERO" type="text" id="NUMERO" value="<?php echo $row_CONSULTA['NUMERO_DOCUMENTO']; ?>" />
      <span class="textfieldRequiredMsg">Requerido</span></span></td>
    </tr>
	<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Banco Emisor Carta Promesa:</td>
	  <td bgcolor="#F0F0F0"><span id="spryselect1">
	    <label for="ID_BANCO"></label>
	    <select name="ID_BANCO" id="ID_BANCO">
	      <?php
do {  
?>
	      <option value="<?php echo $row_BANCO['ID_BANCO_MASTER']?>"<?php if (!(strcmp($row_BANCO['ID_BANCO_MASTER'], $row_CONSULTA['ID_BANCO']))) {echo "selected=\"selected\"";} ?>><?php echo $row_BANCO['NOMBRE']?></option>
	      <?php
} while ($row_BANCO = mysql_fetch_assoc($BANCO));
  $rows = mysql_num_rows($BANCO);
  if($rows > 0) {
      mysql_data_seek($BANCO, 0);
	  $row_BANCO = mysql_fetch_assoc($BANCO);
  }
?>
        </select>
      <span class="selectRequiredMsg">Please select an item.</span></span></td>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Aprobada:</td>
	  <td bgcolor="#F0F0F0"><input <?php if (!(strcmp($row_CONSULTA['STATUS_APROBADO'],1))) {echo "checked=\"checked\"";} ?> name="STATUS_APROBADO" type="checkbox" id="STATUS_APROBADO" value="1" />
	    <label for="STATUS_APROBADO"></label></td>
    </tr>
    	<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Monto:</td>
	  <td bgcolor="#F0F0F0"><span id="sprytextfield3">
	    <input name="MONTO_EXENTO" type="text" id="MONTO_EXENTO" value="<?php echo $row_CONSULTA['MONTO_DOCUMENTO']; ?>" />
      <span class="textfieldRequiredMsg">Requerido</span><span class="textfieldInvalidFormatMsg">Formato Invalido</span></span></td>
	    <label for="STATUS_APROBADO"></label>
	    <td colspan="2"  bgcolor="#F0F0F0" class="textos_form_derecha"></td>
    </tr>
	<tr>
		<td colspan="4" align="center" bgcolor="#F0F0F0" class="textos_form"><input name="button" type="submit" class="ui-widget-header" id="button" value="Guardar" /></td>
	</tr>
</table>
<input type="hidden" name="MM_insert" value="form" />
<input type="hidden" name="MM_update" value="form" />
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
</script>
</body>
</html>
<?php
mysql_free_result($CONSULTA);

mysql_free_result($TIPO);

mysql_free_result($INMUEBLE);
?>
