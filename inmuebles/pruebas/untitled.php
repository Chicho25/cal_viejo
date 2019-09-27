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

$maxRows_reporte = 30;
$pageNum_reporte = 0;
if (isset($_GET['pageNum_reporte'])) {
  $pageNum_reporte = $_GET['pageNum_reporte'];
}
$startRow_reporte = $pageNum_reporte * $maxRows_reporte;

mysql_select_db($database_conexion, $conexion);
$query_reporte = "SELECT documentos.ID_DOCUMENTO as 'ID', doc_tipo.DESCRIPCION as 'TIPO', pro_cli.NOMBRE as 'PROVEEDOR', documentos.FECHA_EMISION as 'EMISION', documentos.FECHA_VENCIMIENTO as 'VENCIMIENTO', documentos.DESCRIPCION as 'DESCRIPCION', documentos.MONTO_EXENTO+documentos.MONTO_GRABADO+documentos.MONTO_IMPUESTO as 'TOTAL', pagado.MONTO_PAGADO as 'PAGADO', if(documentos.STATUS_PENDIENTE='1','SI','NO') 'PENDIENTE' FROM documentos INNER JOIN doc_tipo ON doc_tipo.TIPO = documentos.TIPO INNER JOIN pro_cli ON pro_cli.ID_PRO_CLI = documentos.ID_PRO_CLI LEFT JOIN (SELECT a.ID_DOCUMENTO, sum(a.MONTO_PAGADO) as MONTO_PAGADO FROM pagos_detalle a GROUP BY ID_DOCUMENTO) as pagado ON pagado.ID_DOCUMENTO = documentos.ID_DOCUMENTO ORDER BY 1 ";
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
</head>

<body>
<table width="1100" border="0" cellspacing="0" cellpadding="0"><tr>
			<td><?php echo 'ID'; ?></td>
			<td><?php echo 'TIPO'; ?></td>
			<td><?php echo 'PROVEEDOR'; ?></td>
			<td><?php echo 'EMISION'; ?></td>
			<td><?php echo 'VENCIMIENTO'; ?></td>
			<td><?php echo 'DESCRIPCION'; ?></td>
			<td><?php echo 'TOTAL'; ?></td>
			<td><?php echo 'PAGADO'; ?></td>
			<td><?php echo 'PENDIENTE'; ?></td></tr>
	<?php do { ?>
		<tr>
			<td><?php echo $row_reporte['ID']; ?></td>
			<td><?php echo $row_reporte['TIPO']; ?></td>
			<td><?php echo $row_reporte['PROVEEDOR']; ?></td>
			<td><?php echo $row_reporte['EMISION']; ?></td>
			<td><?php echo $row_reporte['VENCIMIENTO']; ?></td>
			<td><?php echo $row_reporte['DESCRIPCION']; ?></td>
			<td><?php echo $row_reporte['TOTAL']; ?></td>
			<td><?php echo $row_reporte['PAGADO']; ?></td>
			<td><?php echo $row_reporte['PENDIENTE']; ?></td>
		</tr>
		<?php } while ($row_reporte = mysql_fetch_assoc($reporte)); ?>
</table>
<p>&nbsp;
<table border="0">
	<tr>
		<td><?php if ($pageNum_reporte > 0) { // Show if not first page ?>
				<a href="<?php printf("%s?pageNum_reporte=%d%s", $currentPage, 0, $queryString_reporte); ?>">First</a>
				<?php } // Show if not first page ?></td>
		<td><?php if ($pageNum_reporte > 0) { // Show if not first page ?>
				<a href="<?php printf("%s?pageNum_reporte=%d%s", $currentPage, max(0, $pageNum_reporte - 1), $queryString_reporte); ?>">Previous</a>
				<?php } // Show if not first page ?></td>
		<td><?php if ($pageNum_reporte < $totalPages_reporte) { // Show if not last page ?>
				<a href="<?php printf("%s?pageNum_reporte=%d%s", $currentPage, min($totalPages_reporte, $pageNum_reporte + 1), $queryString_reporte); ?>">Next</a>
				<?php } // Show if not last page ?></td>
		<td><?php if ($pageNum_reporte < $totalPages_reporte) { // Show if not last page ?>
				<a href="<?php printf("%s?pageNum_reporte=%d%s", $currentPage, $totalPages_reporte, $queryString_reporte); ?>">Last</a>
				<?php } // Show if not last page ?></td>
	</tr>
</table>
</p>
</body>
</html>
<?php
mysql_free_result($reporte);
?>
