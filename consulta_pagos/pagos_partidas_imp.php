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

mysql_select_db($database_conexion, $conexion);
$query_reporte = "SELECT * FROM pagos_partidas  ORDER BY pagos_partidas.ID_PARTIDA ASC";
$reporte = mysql_query($query_reporte, $conexion) or die(mysql_error());
$row_reporte = mysql_fetch_assoc($reporte);
$totalRows_reporte = mysql_num_rows($reporte);

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
<meta http-equiv="Content-Type" content="text/html"  charset="iso-8859-1" />
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

</style>


</head>

<body>
<center><form><input type="button" value=" Imprimir este reporte "
onclick="window.print();return false;" /></form></center>


	<table width="1100" border="0" cellspacing="2" cellpadding="0" bgcolor="#CCCCCC">
	<tr bgcolor="#CCCCCC" class="textos_form" align="center" >
			<td width="500">Partida / Descripcion de Documento</td>
			<td width="120">Fecha</td>
			<td width="150">Numero de pago</td>
			<td width="120">Monto Documento </td>
			<td width="120">Monto Pagado</td>
			</tr>
			<?php 
	$nombre="";
	?>
	<?php do { ?>
		<?php if( $row_reporte['DESCRIPCION_COMPLETA']!=$nombre){?>
		<tr bgcolor="#ffffff">
			<td colspan="5" class="textos_form"><?php echo $row_reporte['DESCRIPCION_COMPLETA'];?></td>
			</tr>		
			<tr bgcolor="#fff">
			<td><?php echo $row_reporte['DESCRIPCION_DOCUMENTO'];?></td>
			<td align="center"><?php echo $row_reporte['FECHA']; ?></td>
			<td align="right"><?php echo $row_reporte['NUMERO_PAGO']; ?></td>
			<td align="right"><?php echo $row_reporte['MONTO_DOCUMENTO']; ?></td>
			<td align="right"><?php echo number_format($row_reporte['MONTO_PAGADO'],2); ?></td>
			</tr>
			<?php } else {?>
				
			<tr bgcolor="#FFFFFF">
			<td><?php echo $row_reporte['DESCRIPCION_DOCUMENTO'];?></td>
			<td align="center"><?php echo $row_reporte['FECHA']; ?></td>
			<td align="right"><?php echo $row_reporte['NUMERO_PAGO']; ?></td>
			<td align="right"><?php echo $row_reporte['MONTO_DOCUMENTO']; ?></td>
			<td align="right"><?php echo number_format($row_reporte['MONTO_PAGADO'],2); ?></td>
			</tr>
			<?php }?>
			<?php $nombre= $row_reporte['DESCRIPCION_COMPLETA'];?>
		<?php } while ($row_reporte = mysql_fetch_assoc($reporte)); ?>

<tr>
	<td colspan="5" align="center"></tr></table>
	
		
</body>
</html>
<?php
mysql_free_result($reporte);


?>
