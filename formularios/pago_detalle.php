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

$colname_documentos = "-1";
if (isset($_POST['elegido'])) {
  $colname_documentos = $_POST['elegido'];
}
mysql_select_db($database_conexion, $conexion);
$query_documentos = sprintf("SELECT * FROM documentos WHERE ID_PRO_CLI = %s", GetSQLValueString($colname_documentos, "text"));
$documentos = mysql_query($query_documentos, $conexion) or die(mysql_error());
$row_documentos = mysql_fetch_assoc($documentos);
$totalRows_documentos = mysql_num_rows($documentos);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<?php //echo //$_POST['elegido']; ?>
<?php if ($totalRows_documentos > 0) { // Show if recordset not empty ?>
	<table width="1100" border="0" cellspacing="2" cellpadding="0" bgcolor="#CCCCCC" align="center">
		<tr class="textos_form">
			<td width="49" align="center" bgcolor="#F0F0F0">Tipo</td>
			<td width="49" align="center" bgcolor="#F0F0F0">Numero</td>
			<td width="100" align="center" bgcolor="#F0F0F0">Fecha</td>
			<td width="300" align="center" bgcolor="#F0F0F0">Descripcion</td>
			<td width="150" align="center" bgcolor="#F0F0F0">Monto Total</td>
			<td width="150" align="center" bgcolor="#F0F0F0">Monto Pendiente</td>
			<td width="150" align="center" bgcolor="#F0F0F0">Monto a pagar</td>
			</tr>
		<?php do { ?>
			<tr>
				<?php $total=$total+$row_documentos['MONTO_EXENTO'];?>
				<td bgcolor="#FFFFFF"><?php //echo $row_documentos['TIPO']; ?></td>
				<td bgcolor="#FFFFFF"></td>
				<td bgcolor="#FFFFFF"><?php echo $row_documentos['FECHA_EMISION']; ?></td>
				<td bgcolor="#FFFFFF"><?php echo $row_documentos['DESCRIPCION']; ?></td>
				<td bgcolor="#FFFFFF" align="right"><?php echo number_format($row_documentos['MONTO_EXENTO'],2,',','.'); ?></td>
				<td bgcolor="#FFFFFF" align="right"><?php echo number_format($row_documentos['MONTO_EXENTO'],2,',','.'); ?></td>
				<td align="center" bgcolor="#FFFFFF"><label for="textfield"></label>
					<input name="textfield" type="text" class="textos_form" id="textfield" size="6" />
					<input type="checkbox" name="checkbox" id="checkbox" />
				<label for="checkbox" class="ui-accordion-content">Total</label></td>
			</tr>
			<?php } while ($row_documentos = mysql_fetch_assoc($documentos)); ?>
		<tr>
			<td colspan="4" align="right" bgcolor="#F0F0F0" class="textos_form">Totales:</td>
			<td bgcolor="#F0F0F0" align="right" class="textos_form"><?php echo $total; ?></td>
			<td bgcolor="#F0F0F0" align="right" class="textos_form"><?php echo $total; ?></td>
			<td align="center" bgcolor="#F0F0F0"><label for="textfield"></label>
				<input name="textfield" type="text" class="textos_form" id="textfield" size="6" />
				<input type="checkbox" name="checkbox" id="checkbox" />
				<label for="checkbox" class="ui-accordion-content">Total</label></td>
		</tr></table>
	<?php } // Show if recordset not empty ?>
	<?php if ($totalRows_documentos == 0) { // Show if recordset empty ?>
		<div class="textos_form" align="center"><br />No Existe documentos asociados a este proveedor</div>
	<?php } // Show if recordset empty ?>
</body>
</html>
<?php
mysql_free_result($documentos);
?>
