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

$maxRows_cheques = 15;
$pageNum_cheques = 0;
if (isset($_GET['pageNum_cheques'])) {
  $pageNum_cheques = $_GET['pageNum_cheques'];
}
$startRow_cheques = $pageNum_cheques * $maxRows_cheques;

mysql_select_db($database_conexion, $conexion);
$query_cheques = "SELECT * FROM mov_banco_caja WHERE TIPO_PAGO = 2 AND ANULADO = 1 ORDER BY NUMERO_PAGO ASC";
$query_limit_cheques = sprintf("%s LIMIT %d, %d", $query_cheques, $startRow_cheques, $maxRows_cheques);
$cheques = mysql_query($query_limit_cheques, $conexion) or die(mysql_error());
$row_cheques = mysql_fetch_assoc($cheques);

if (isset($_GET['totalRows_cheques'])) {
  $totalRows_cheques = $_GET['totalRows_cheques'];
} else {
  $all_cheques = mysql_query($query_cheques);
  $totalRows_cheques = mysql_num_rows($all_cheques);
}
$totalPages_cheques = ceil($totalRows_cheques/$maxRows_cheques)-1;

$queryString_cheques = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_cheques") == false && 
        stristr($param, "totalRows_cheques") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_cheques = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_cheques = sprintf("&totalRows_cheques=%d%s", $totalRows_cheques, $queryString_cheques);
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
<?php include('../include/header.php'); ?>
<form action="pago3.php" method="post">
	<table width="1100" align="center" class="ui-widget-header" >
		<tr>
			<td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Cheques Anulados</div>
		</tr>
	</table>
	<center>
	</center>
</form>
<table width="1100" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#999999">
	<tr class="textos_form">
		<td colspan="2" align="center" bgcolor="#FFFFFF">&nbsp;</td></tr><tr class="textos_form">
		<td bgcolor="#FFFFFF">&nbsp;</td>
		<td bgcolor="#FFFFFF">&nbsp;</td></tr></table>
<table width="1100" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#999999">
	<tr class="textos_form">
		<td width="40" align="center" bgcolor="#CCCCCC">Numero de Cheque</td>
		<td width="150" align="center" bgcolor="#CCCCCC">&nbsp;</td>
		<td width="212" align="center" bgcolor="#CCCCCC">Descripcion</td>
		<td width="30" align="center" bgcolor="#CCCCCC">Id Documento</td>
		<td width="100" align="center" bgcolor="#CCCCCC">Monto</td>
	</tr>
	<?php do { ?><tr>
	<?php if (($row_cheques['ANULADO']==0) && ($row_cheques['PAGO_DIRECTO']==0) && (($row_cheques['ID_PAGO']!=NULL)) ){ ?>
		<?php 
		mysql_select_db($database_conexion, $conexion);
		$query_detalle = "SELECT pagos.DESCRIPCION AS descripcion,pro_cli.NOMBRE AS nombre_proveedor,pagos_detalle.ID_DOCUMENTO AS numero_pago FROM pagos_detalle INNER JOIN documentos ON pagos_detalle.ID_DOCUMENTO = documentos.ID_DOCUMENTO INNER JOIN pro_cli ON documentos.ID_PRO_CLI = pro_cli.ID_PRO_CLI INNER JOIN pagos ON pagos_detalle.ID_PAGO = pagos.ID_PAGO WHERE pagos_detalle.ID_PAGO = ".$row_cheques['ID_PAGO'].";";
		$detalle = mysql_query($query_detalle, $conexion) or die(mysql_error());
		$row_detalle = mysql_fetch_assoc($detalle);
		$totalRows_detalle = mysql_num_rows($detalle);
		?>
			<td width="40" align="center" bgcolor="#FFFFFF"><?php echo $row_cheques['NUMERO_PAGO']; ?></td>
			<td width="150" bgcolor="#FFFFFF"><?php echo $row_detalle['nombre_proveedor']; ?></td>
			<td bgcolor="#FFFFFF"><?php echo $row_detalle['descripcion']; ?></td>
			<td width="30" bgcolor="#FFFFFF"><?php echo $row_detalle['numero_pago']; ?></td>
			<td width="100" align="right" bgcolor="#FFFFFF"><?php echo number_format($row_cheques['MONTO'],2); ?></td>
			
	</tr><?php }else{?><?php 
	$color="#ffcaca";
	$mensaje="ANULADO";
	if($row_cheques['PAGO_DIRECTO']==1){$color="#a2dd5b"; $mensaje="PAGO DIRECTO";}
	?>

			<td width="40" align="center" bgcolor="<?php echo $color;?>"><?php echo $row_cheques['NUMERO_PAGO']; ?></td>
			<td width="150" align="left" bgcolor="<?php echo $color;?>"><strong><?php echo $mensaje;?></strong></td>
			<td bgcolor="<?php echo $color;?>"><?php echo $row_cheques['DESCRIPCION']; ?></td>
			<td width="30" bgcolor="<?php echo $color;?>"><?php echo $row_detalle['numero_pago']; ?></td>
			<td width="100" align="right" bgcolor="<?php echo $color;?>"><?php echo number_format($row_cheques['MONTO'],2); ?></td>
			
	</tr>
	
	
	<?php }?>
	
	<?php } while ($row_cheques = mysql_fetch_assoc($cheques)); ?>
	<tr>
		<td colspan="5"><table border="0" align="center" cellspacing="6">
				<tr>
					<td><?php if ($pageNum_cheques > 0) { // Show if not first page ?>
							<a href="<?php printf("%s?pageNum_cheques=%d%s", $currentPage, 0, $queryString_cheques); ?>"><img src="First.gif" /></a>
							<?php } // Show if not first page ?></td>
					<td><?php if ($pageNum_cheques > 0) { // Show if not first page ?>
							<a href="<?php printf("%s?pageNum_cheques=%d%s", $currentPage, max(0, $pageNum_cheques - 1), $queryString_cheques); ?>"><img src="Previous.gif" /></a>
							<?php } // Show if not first page ?></td>
					<td><?php if ($pageNum_cheques < $totalPages_cheques) { // Show if not last page ?>
							<a href="<?php printf("%s?pageNum_cheques=%d%s", $currentPage, min($totalPages_cheques, $pageNum_cheques + 1), $queryString_cheques); ?>"><img src="Next.gif" /></a>
							<?php } // Show if not last page ?></td>
					<td><?php if ($pageNum_cheques < $totalPages_cheques) { // Show if not last page ?>
							<a href="<?php printf("%s?pageNum_cheques=%d%s", $currentPage, $totalPages_cheques, $queryString_cheques); ?>"><img src="Last.gif" /></a>
							<?php } // Show if not last page ?></td>
				</tr>
			</table>
		</td></tr>
</table>

		
</body>
</html>
<?php
mysql_free_result($cheques);


?>
