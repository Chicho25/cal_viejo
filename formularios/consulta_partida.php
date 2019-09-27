<?php function changueFormatDate($cdate){
    list($year,$month,$day)=explode("-",$cdate);
    return $day."/".$month."/".$year;
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_documento = 1;
$pageNum_documento = 0;
if (isset($_GET['pageNum_documento'])) {
  $pageNum_documento = $_GET['pageNum_documento'];
}
$startRow_documento = $pageNum_documento * $maxRows_documento;

mysql_select_db($database_conexion, $conexion);
$query_documento = "SELECT tipo_pago.DESCRIPCION AS tipo_pago, partidas.DESCRIPCION AS nombre_partida, pro_cli.NOMBRE AS nombre_proveedor, documentos.NUMERO AS numero_documento, documentos.FECHA_EMISION AS fecha_emision, documentos.FECHA_VENCIMIENTO AS fecha_vencimiento, documentos.DESCRIPCION AS descripcion, documentos.MONTO_EXENTO AS monto_exento, documentos.MONTO_GRABADO AS monto_grabado, documentos.MONTO_IMPUESTO AS monto_impuesto, documentos.STATUS_PENDIENTE AS pendiente FROM documentos INNER JOIN pro_cli ON documentos.ID_PRO_CLI = pro_cli.ID_PRO_CLI INNER JOIN tipo_pago ON documentos.TIPO = tipo_pago.TIPO INNER JOIN partidas ON documentos.ID_PARTIDA = partidas.ID";
$query_limit_documento = sprintf("%s LIMIT %d, %d", $query_documento, $startRow_documento, $maxRows_documento);
$documento = mysql_query($query_limit_documento, $conexion) or die(mysql_error());
$row_documento = mysql_fetch_assoc($documento);

if (isset($_GET['totalRows_documento'])) {
  $totalRows_documento = $_GET['totalRows_documento'];
} else {
  $all_documento = mysql_query($query_documento);
  $totalRows_documento = mysql_num_rows($all_documento);
}
$totalPages_documento = ceil($totalRows_documento/$maxRows_documento)-1;

$queryString_documento = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_documento") == false && 
        stristr($param, "totalRows_documento") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_documento = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_documento = sprintf("&totalRows_documento=%d%s", $totalRows_documento, $queryString_documento);




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;" />
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
			<td width="135" bgcolor="#F0F0F0" class="textos_form">Proveedor:</td>
			<td colspan="3"><input name="cod_procli" class="textos_form required" id="project" value="<?php echo $row_documento['nombre_proveedor']; ?>" size="50" readonly="readonly"/></td>
		</tr>
		<tr>
			<td bgcolor="#F0F0F0" class="textos_form">Tipo:</td>
			

			<td><label for="tipo"></label>
			<input name="tipo" type="text" class="textos_form_derecha" id="tipo" value="<?php echo $row_documento['tipo_pago']; ?>" readonly="readonly" /></td>
			<td width="269"><p class="textos_form">Numero:</p></td>
			<td width="377"><input name="numero" type="text" class="textos_form_derecha" id="numero" value="<?php echo $row_documento['numero_documento']; ?>" readonly="readonly" /></td>
		</tr>
		<tr>
			<td bgcolor="#F0F0F0" class="textos_form">Fecha Emision:</td>
			<td><label for="fecha_emision"></label>
				<input name="fecha_emision" type="text" class="textos_form required" id="fecha_emision" value="<?php echo $row_documento['fecha_emision']; ?>" readonly="readonly" /></td>
			<td><span class="textos_form">Fecha Vencimiento</span></td>
			<td><input name="fecha_vencimiento" type="text" class="textos_form required" id="fecha_vencimiento" value="<?php echo $row_documento['fecha_vencimiento']; ?>" readonly="readonly" /></td>
		</tr>
		<tr>
			<td bgcolor="#F0F0F0" class="textos_form">Descripcion:</td>
			<td colspan="3"><label for="descripcion"></label>
				<textarea name="descripcion" cols="45" rows="5" readonly="readonly" class="textos_form" id="descripcion"><?php echo $row_documento['DESCRIPCION']; ?></textarea></td>
		</tr>
		<tr>
			<td bgcolor="#F0F0F0" class="textos_form">Partida:</td>
			<td colspan="3" bgcolor="#F0F0F0"><input name="partida" type="text" class="textos_form_derecha" id="partida" /></td>
		</tr>
		<tr>
			<td rowspan="5" valign="middle" bgcolor="#F0F0F0" class="textos_form">Monto:</td>
			<td width="309" class="textos_form">Monto Exento:</td>
			<td colspan="2"><label for="exento"></label>
				<input name="exento" type="text" class="textos_form_derecha" id="exento" value="<?php echo $row_documento['monto_exento']; ?>" readonly="readonly" /></td>
		</tr>
		<tr>
			<td><span class="textos_form">Monto Gravable:</span></td>
			<td colspan="2"><input name="bruto" type="text" class="textos_form_derecha" id="bruto" value="<?php echo $row_documento['monto_grabado']; ?>" readonly="readonly" /></td>
		</tr>
		<tr>
			<td><span class="textos_form">Impuesto:</span></td>
			<td colspan="2"><label for="total_impuesto"></label>
				<input name="total_impuesto" type="text" class="textos_form_derecha" id="total_impuesto" value="<?php echo $row_documento['monto_impuesto']; ?>" readonly="readonly" /></td>
		</tr>
		<tr>
			<td class="textos_form">Total:</td>
			<td colspan="2"><label for="total"></label>
				<input name="total" type="text" class="textos_form_derecha required" id="total" readonly="readonly" /></td>
		</tr>
				<tr>
			<td colspan="3" class="textos_form" align="center"><br />
				<br />
				<table border="0" cellpadding="10" cellspacing="5">
					<tr>
						<td><?php if ($pageNum_documento > 0) { // Show if not first page ?>
								<a href="<?php printf("%s?pageNum_documento=%d%s", $currentPage, 0, $queryString_documento); ?>"><img src="First.gif" /></a>
								<?php } // Show if not first page ?></td>
						<td><?php if ($pageNum_documento > 0) { // Show if not first page ?>
								<a href="<?php printf("%s?pageNum_documento=%d%s", $currentPage, max(0, $pageNum_documento - 1), $queryString_documento); ?>"><img src="Previous.gif" /></a>
								<?php } // Show if not first page ?></td>
						<td><?php if ($pageNum_documento < $totalPages_documento) { // Show if not last page ?>
								<a href="<?php printf("%s?pageNum_documento=%d%s", $currentPage, min($totalPages_documento, $pageNum_documento + 1), $queryString_documento); ?>"><img src="Next.gif" /></a>
								<?php } // Show if not last page ?></td>
						<td><?php if ($pageNum_documento < $totalPages_documento) { // Show if not last page ?>
								<a href="<?php printf("%s?pageNum_documento=%d%s", $currentPage, $totalPages_documento, $queryString_documento); ?>"><img src="Last.gif" /></a>
								<?php } // Show if not last page ?></td>
					</tr>
				</table></td>
		</tr>
	</table><table width="1100" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr bgcolor="#5C9CCC">
		<td>&nbsp;</td>
	</tr>
</table>


</form>
</body>
</html>

