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

$colname_proveedor = "-1";
if (isset($_POST['elegido'])) {
  $colname_proveedor = $_POST['elegido'];
}
mysql_select_db($database_conexion, $conexion);
$query_proveedor = sprintf("SELECT * FROM pro_cli WHERE ID_PRO_CLI = %s", GetSQLValueString($colname_proveedor, "int"));
$proveedor = mysql_query($query_proveedor, $conexion) or die(mysql_error());
$row_proveedor = mysql_fetch_assoc($proveedor);
$totalRows_proveedor = mysql_num_rows($proveedor);

$colname_documentos = "-1";
if (isset($_POST['elegido'])) {
  $colname_documentos = $_POST['elegido'];
}
mysql_select_db($database_conexion, $conexion);
$query_documentos = sprintf("SELECT * FROM documentos WHERE ID_PRO_CLI = %s", GetSQLValueString($colname_documentos, "int"));
$documentos = mysql_query($query_documentos, $conexion) or die(mysql_error());
$row_documentos = mysql_fetch_assoc($documentos);
$totalRows_documentos = mysql_num_rows($documentos);

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
</head>

<body>
<?php $opcion_menu=2; ?>
<?php include("../include/menu.php"); ?>
<form action="pago3.php" method="post">
	<table width="1100" align="center" class="ui-widget-header" >
		<tr>
			<td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Pagos - <?php echo $row_proveedor['NOMBRE']; ?></div>
		</tr>
	</table>
	<center>
		<table width="1100" border="0" cellspacing="1" cellpadding="0" bgcolor="#999999">
			<tr class="textos_form">
				<td width="49" align="center" bgcolor="#F0F0F0">Id Doc.</td>
				<td width="100" align="center" bgcolor="#F0F0F0">Tipo</td>
				<td width="50" align="center" bgcolor="#F0F0F0">Numero</td>
				<td width="100" align="center" bgcolor="#F0F0F0">Fecha</td>
				<td align="center" bgcolor="#F0F0F0">Descripcion</td>
				<td width="100" align="center" bgcolor="#F0F0F0">Monto Total</td>
				<td width="100" align="center" bgcolor="#F0F0F0">Monto Pendiente</td>
				<td width="150" align="center" bgcolor="#F0F0F0">Monto a pagar</td>
			</tr>
		</table>
		<?php do { ?>
			<table width="1100" border="0" cellspacing="1" cellpadding="0" bgcolor="#999999">
				
			<?php 
			mysql_select_db($database_conexion, $conexion);
			$query_pago_detalle = "SELECT ID_DOCUMENTO, ID_PAGO, MONTO_PAGADO FROM pagos_detalle WHERE ID_PAGOS_DETALLE =". $row_documentos['ID_DOCUMENTO'].",";
			$pago_detalle = mysql_query($query_pago_detalle, $conexion) or die(mysql_error());
			$row_pago_detalle = mysql_fetch_assoc($pago_detalle);
			$totalRows_pago_detalle = mysql_num_rows($pago_detalle);
			echo $query_pago_detalle;

			mysql_select_db($database_conexion, $conexion);
			$query_mov_banco_caja = "SELECT * FROM mov_banco_caja WHERE ID_PAGO = ".$row_pago_detalle['ID_PAGO'].";";
			$mov_banco_caja = mysql_query($query_mov_banco_caja, $conexion) or die(mysql_error());
			$row_mov_banco_caja = mysql_fetch_assoc($mov_banco_caja);
			$totalRows_mov_banco_caja = mysql_num_rows($mov_banco_caja);
			echo $query_mov_banco_caja;
			
			?>
					<tr class="textos_form">
						<td width="49" align="center" bgcolor="#FFFFFF"><?php echo $row_documentos['ID_DOCUMENTO']; ?></td>
						<td width="100" align="center" bgcolor="#FFFFFF"><?php echo $row_documentos['TIPO']; ?></td>
						<td width="50" align="center" bgcolor="#FFFFFF"><?php echo $row_documentos['NUMERO']; ?></td>
						<td width="100" align="center" bgcolor="#F0F0F0"><?php echo $row_documentos['FECHA_EMISION']; ?></td>
						<td bgcolor="#FFFFFF"><?php echo $row_documentos['DESCRIPCION']; ?></td>
						<td width="100" align="center" bgcolor="#FFFFFF"><?php echo $row_documentos['MONTO_EXENTO']+$row_documentos['MONTO_GRABADO']+$row_documentos['MONTO_IMPUESTO']; ?></td>
						<td width="100" align="center" bgcolor="#FFFFFF">Monto Pendiente</td>
						<td width="150" align="center" bgcolor="#FFFFFF">Monto a pagar</td>
					</tr>
					<?php //do { ?>
					<tr class="textos_form">
						<td width="49" align="center" bgcolor="#F0F0F0">Id Doc.</td>
						<td width="100" align="center" bgcolor="#F0F0F0">Tipo</td>
						<td width="50" align="center" bgcolor="#F0F0F0">Numero</td>
						<td width="100" align="center" bgcolor="#F0F0F0"><?php echo $row_mov_banco_caja['FECHA']; ?></td>
						<td align="center" bgcolor="#F0F0F0"><?php echo $row_mov_banco_caja['DESCRIPCION']; ?></td>
						<td width="100" align="center" bgcolor="#F0F0F0">Monto Total</td>
						<td width="100" align="center" bgcolor="#F0F0F0">Monto Pendiente</td>
						<td width="150" align="center" bgcolor="#F0F0F0"><?php echo $row_mov_banco_caja['MONTO']; ?>r</td>
					</tr><?php //} while ($row_pago_detalle = mysql_fetch_assoc($pago_detalle)); ?>
					
			</table><?php } while ($row_documentos = mysql_fetch_assoc($documentos)); ?>
			
	</center>
</form>
</body>
</html>
<?php
mysql_free_result($proveedor);

mysql_free_result($documentos);

mysql_free_result($pago_detalle);

mysql_free_result($mov_banco_caja);
?>
