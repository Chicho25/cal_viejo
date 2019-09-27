<?php require_once('../../Connections/conexion.php'); ?>
<?php function changueFormatDate($cdate){
    list($day,$month,$year)=explode("/",$cdate);
    return $year."-".$month."-".$day;
}?>
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

$colname_documento = "-1";
if (isset($_GET['ID_DOCUMENTO'])) {
  $colname_documento = $_GET['ID_DOCUMENTO'];
}
mysql_select_db($database_conexion, $conexion);
$query_documento = sprintf("SELECT * FROM documentos WHERE ID_DOCUMENTO = %s", GetSQLValueString($colname_documento, "int"));
$documento = mysql_query($query_documento, $conexion) or die(mysql_error());
$row_documento = mysql_fetch_assoc($documento);
$totalRows_documento = mysql_num_rows($documento);




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; " />
<title>Untitled Document</title>
<link href="../js/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />

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
label.error { float: none; color: red; padding-left: .5em; vertical-align: top; font-family:Arial, Helvetica, sans-serif; size:12px }
</style>
<link href="../css/form.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/menu_style.css" type="text/css" media="all" />
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 00px;
	margin-bottom: 0px;
}
</style>
</head>

<body>

<?php $opcion_menu=2; ?>
<?php include("../include/menu.php"); ?>

<form id="form1" name="form1" method="POST"><table width="1100" align="center" class="ui-widget-header" >
	<tr>
	<td width="1100" align="center" class="textos_form"><div class="titulo_formulario">Consulta Documentos</div></tr></table>
	<table width="1100" border="0" align="center" cellpadding="0" cellspacing="2" bgcolor="#F0F0F0" >
		<tr>
			<td width="135" bgcolor="#F0F0F0" class="textos_form">Proveedor:</td><?php 
			mysql_select_db($database_conexion, $conexion);
$query_cliente = "SELECT * FROM pro_cli WHERE ID_PRO_CLI = ".$row_documento['ID_PRO_CLI'];
$cliente = mysql_query($query_cliente, $conexion) or die(mysql_error());
$row_cliente = mysql_fetch_assoc($cliente);
$totalRows_cliente = mysql_num_rows($cliente);
			
			
			?>
			<td colspan="3"><input name="cod_procli" class="textos_form required" id="project" value="<?php echo $row_cliente['NOMBRE']; ?>" size="50"/></td>
		</tr>
		<tr>
			<td bgcolor="#F0F0F0" class="textos_form">Tipo:</td>
			
			<?php 
			
			mysql_select_db($database_conexion, $conexion);
$query_tipo = "SELECT * FROM doc_tipo WHERE TIPO = ".$row_documento['TIPO'];
$tipo = mysql_query($query_tipo, $conexion) or die(mysql_error());
$row_tipo = mysql_fetch_assoc($tipo);
$totalRows_tipo = mysql_num_rows($tipo);
			?>
			<td><label for="tipo"></label>
			<input name="tipo" type="text" class="textos_form_derecha" id="tipo" value="<?php echo $row_tipo['DESCRIPCION']; ?>" /></td>
			<td width="269"><span class="textos_form">Numero:</span></td>
			<td width="377"><input name="numero" type="text" class="textos_form_derecha" id="numero" value="<?php echo $row_documento['NUMERO']; ?>" /></td>
		</tr>
		<tr>
			<td bgcolor="#F0F0F0" class="textos_form">Fecha Emision:</td>
			<td><label for="fecha_emision"></label>
				<input name="fecha_emision" type="text" class="textos_form required" id="fecha_emision" value="<?php echo $row_documento['FECHA_EMISION']; ?>" /></td>
			<td><span class="textos_form">Fecha Vencimiento</span></td>
			<td><input name="fecha_vencimiento" type="text" class="textos_form required" id="fecha_vencimiento" value="<?php echo $row_documento['FECHA_VENCIMIENTO']; ?>" /></td>
		</tr>
		<tr>
			<td bgcolor="#F0F0F0" class="textos_form">Descripcion:</td>
			<td colspan="3"><label for="descripcion"></label>
				<textarea name="descripcion" cols="45" rows="5" class="textos_form" id="descripcion"><?php echo $row_documento['DESCRIPCION']; ?></textarea></td>
		</tr>
		<tr>
			<td bgcolor="#F0F0F0" class="textos_form">Partida:</td>
			<td colspan="3" bgcolor="#F0F0F0"><input name="partida" type="text" class="textos_form_derecha" id="partida" /></td>
		</tr>
		<tr>
			<td rowspan="5" valign="middle" bgcolor="#F0F0F0" class="textos_form">Monto:</td>
			<td width="309" class="textos_form">Monto Exento:</td>
			<td colspan="2"><label for="exento"></label>
				<input name="exento" type="text" class="textos_form_derecha" id="exento" value="<?php echo $row_documento['MONTO_EXENTO']; ?>" /></td>
		</tr>
		<tr>
			<td><span class="textos_form">Monto Gravable:</span></td>
			<td colspan="2"><input name="bruto" type="text" class="textos_form_derecha" id="bruto" value="<?php echo $row_documento['MONTO_GRABADO']; ?>" /></td>
		</tr>
		<tr>
			<td><span class="textos_form">Impuesto:</span></td>
			<td colspan="2"><label for="total_impuesto"></label>
				<input name="total_impuesto" type="text" class="textos_form_derecha" id="total_impuesto" value="<?php echo $row_documento['MONTO_IMPUESTO']; ?>" readonly="readonly" /></td>
		</tr>
		<tr>
			<td class="textos_form">Total:</td>
			<td colspan="2"><label for="total"></label>
				<input name="total" type="text" class="textos_form_derecha required" id="total" readonly="readonly" /></td>
		</tr>
				<tr>
			<td colspan="3" class="textos_form" align="center"><br />
				<br /></td>
		</tr>
	</table>
	<table width="1100" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr bgcolor="#5C9CCC">
			<td><table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr class="titulo_formulario">
					<td width="100" align="center" bgcolor="#5C9CCC" class="menu"><a href="../formularios/consulta_partida.php">Inicio</a></td>
					<td align="center" bgcolor="#5C9CCC"><span class="menu"><?php if($row_documento['ID_DOCUMENTO']>3){  ?><a href="consulta_partida2.php?ID_DOCUMENTO=<?php echo $row_documento['ID_DOCUMENTO']-1; ?>">Previo</a><?php } else {?>Previo<?php }?></span></td>
					<td width="100" align="center" bgcolor="#5C9CCC" class="menu"><a href="consulta_partida2.php?ID_DOCUMENTO=<?php echo $row_documento['ID_DOCUMENTO']+1; ?>" class="menu">Siguiente</a></td>
					<td width="100" align="center" bgcolor="#5C9CCC" class="menu">Fin</td>
				</tr>
			</table></td>
		</tr>
	</table>
</form>
</body>
</html>
<?php
mysql_free_result($documento);

mysql_free_result($tipo);

mysql_free_result($cliente);
?>
