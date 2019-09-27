<?php require_once('../../Connections/conexion.php'); ?>
<?php 
$ordenar=$_GET['col'];
if($_GET['orden']==1)
{
	$ordenar=$ordenar." ASC";
	$orden=2;
}
else
{
	$ordenar=$ordenar." DESC";
	$orden=1;
}

?>
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

$maxRows_reporte = 15;
$pageNum_reporte = 0;
if (isset($_GET['pageNum_reporte'])) {
  $pageNum_reporte = $_GET['pageNum_reporte'];
}
$startRow_reporte = $pageNum_reporte * $maxRows_reporte;

mysql_select_db($database_conexion, $conexion);
$query_reporte = "SELECT documentos.ID_DOCUMENTO as 'ID', doc_tipo.DESCRIPCION as 'TIPO', pro_cli.NOMBRE as 'PROVEEDOR', documentos.FECHA_EMISION as 'EMISION', documentos.FECHA_VENCIMIENTO as 'VENCIMIENTO', documentos.DESCRIPCION as 'DESCRIPCION', documentos.MONTO_EXENTO+documentos.MONTO_GRABADO+documentos.MONTO_IMPUESTO as 'TOTAL', pagado.MONTO_PAGADO as 'PAGADO', if(documentos.STATUS_PENDIENTE='1','SI','NO') 'PENDIENTE' FROM documentos INNER JOIN doc_tipo ON doc_tipo.TIPO = documentos.TIPO INNER JOIN pro_cli ON pro_cli.ID_PRO_CLI = documentos.ID_PRO_CLI LEFT JOIN (SELECT a.ID_DOCUMENTO, sum(a.MONTO_PAGADO) as MONTO_PAGADO FROM pagos_detalle a GROUP BY ID_DOCUMENTO) as pagado ON pagado.ID_DOCUMENTO = documentos.ID_DOCUMENTO ORDER BY ".$ordenar;
$query_limit_reporte = sprintf("%s LIMIT %d, %d", $query_reporte, $startRow_reporte, $maxRows_reporte);
$reporte = mysql_query($query_limit_reporte, $conexion) or die(mysql_error());
$row_reporte = mysql_fetch_assoc($reporte);

if (isset($_GET['totalRows_reporte'])) {
  $totalRows_reporte = $_GET['totalRows_reporte'];
} else {
  $all_reporte = mysql_query($query_reporte);
  $totalRows_reporte = mysql_num_rows($all_reporte);
}
$totalPages_reporte = ceil($totalRows_reporte/$maxRows_reporte)-1;

$queryString_reporte = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_reporte") == false && 
        stristr($param, "totalRows_reporte") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_reporte = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_reporte = sprintf("&totalRows_reporte=%d%s", $totalRows_reporte, $queryString_reporte);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
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
			<td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Documentos </div>
		</tr>
	</table>
	<center>
	<table width="1100" border="0" cellspacing="2" cellpadding="0" bgcolor="#CCCCCC"><tr bgcolor="#CCCCCC" class="textos_form" align="center" >
			<td width="20"><a href="listado_documentos.php?col=ID&orden=<?php echo $orden;  ?>">ID</a></td>
			<td width="100"><a href="listado_documentos.php?col=TIPO&orden=<?php echo $orden;  ?>">TIPO</a></td>
			<td width="200"><a href="listado_documentos.php?col=PROVEEDOR&orden=<?php echo $orden;  ?>">PROVEEDOR</a></td>
			<td width="100"><a href="listado_documentos.php?col=EMISION&orden=<?php echo $orden;  ?>">EMISION</a></td>
			<td width="100"><a href="listado_documentos.php?col=VENCIMIENTO&orden=<?php echo $orden;  ?>">VENCIMIENTO</a></td>
			<td><a href="listado_documentos.php?col=DESCRIPCION&orden=<?php echo $orden;  ?>">DESCRIPCION</a></td>
			<td width="100"><a href="listado_documentos.php?col=TOTAL&orden=<?php echo $orden;  ?>">TOTAL</a></td>
			<td width="100"><a href="listado_documentos.php?col=PAGADO&orden=<?php echo $orden;  ?>">PAGADO</a></td>
			<td width="100"><a href="listado_documentos.php?col=PENDIENTE&orden=<?php echo $orden;  ?>">PENDIENTE</a></td></tr>
	<?php do { ?>
		<tr bgcolor="#FFFFFF">
			<td><?php echo $row_reporte['ID']; ?></td>
			<td><?php echo $row_reporte['TIPO']; ?></td>
			<td><?php echo $row_reporte['PROVEEDOR']; ?></td>
			<td><?php echo $row_reporte['EMISION']; ?></td>
			<td><?php echo $row_reporte['VENCIMIENTO']; ?></td>
			<td><?php echo $row_reporte['DESCRIPCION']; ?></td>
			<td align="right"><?php echo $row_reporte['TOTAL']; ?></td>
			<td align="right"><?php echo $row_reporte['PAGADO']; ?></td>
			<td align="right"><?php echo $row_reporte['PENDIENTE']; ?></td>
		</tr>
		<?php } while ($row_reporte = mysql_fetch_assoc($reporte)); ?>

<tr><td colspan="9" align="center"><table border="0" cellpadding="8" cellspacing="8">
	<tr>
		<td><?php if ($pageNum_reporte > 0) { // Show if not first page ?>
				<a href="<?php printf("%s?pageNum_reporte=%d%s", $currentPage, 0, $queryString_reporte); ?>"><img src="First.gif" /></a>
				<?php } // Show if not first page ?></td>
		<td><?php if ($pageNum_reporte > 0) { // Show if not first page ?>
				<a href="<?php printf("%s?pageNum_reporte=%d%s", $currentPage, max(0, $pageNum_reporte - 1), $queryString_reporte); ?>"><img src="Previous.gif" /></a>
				<?php } // Show if not first page ?></td>
		<td><?php if ($pageNum_reporte < $totalPages_reporte) { // Show if not last page ?>
				<a href="<?php printf("%s?pageNum_reporte=%d%s", $currentPage, min($totalPages_reporte, $pageNum_reporte + 1), $queryString_reporte); ?>"><img src="Next.gif" /></a>
				<?php } // Show if not last page ?></td>
		<td><?php if ($pageNum_reporte < $totalPages_reporte) { // Show if not last page ?>
				<a href="<?php printf("%s?pageNum_reporte=%d%s", $currentPage, $totalPages_reporte, $queryString_reporte); ?>"><img src="Last.gif" /></a>
				<?php } // Show if not last page ?></td>
	</tr>
</table>
</tr></table>
	</center>
</form>
		
</body>
</html>
<?php
mysql_free_result($reporte);


?>
