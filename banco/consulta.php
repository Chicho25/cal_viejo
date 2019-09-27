<?php require_once('../../Connections/conexion.php'); ?>
<?php 
$proyecto="";
if($_GET['p']!=0)
{
$proyecto=" AND partidas.COD_PROYECTO = "	.$_GET['p']." ";
	}

?>

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

mysql_select_db($database_conexion, $conexion);
$query_PROYECTOS = "SELECT CODIGO, NOMBRE FROM proyectos";
$PROYECTOS = mysql_query($query_PROYECTOS, $conexion) or die(mysql_error());
$row_PROYECTOS = mysql_fetch_assoc($PROYECTOS);
$totalRows_PROYECTOS = mysql_num_rows($PROYECTOS);

$maxRows_cheques = 15;
$pageNum_cheques = 0;
if (isset($_GET['pageNum_cheques'])) {
  $pageNum_cheques = $_GET['pageNum_cheques'];
}
$startRow_cheques = $pageNum_cheques * $maxRows_cheques;

mysql_select_db($database_conexion, $conexion);
$query_cheques = "SELECT mov_banco_caja.NUMERO_PAGO, pro_cli.NOMBRE,documentos.ID_DOCUMENTO, DATE_FORMAT(mov_banco_caja.FECHA, '%d/%m/%Y') as FECHA, FORMAT(mov_banco_caja.MONTO,2) AS MONTO, mov_banco_caja.ANULADO, mov_banco_caja.PAGO_DIRECTO, mov_banco_caja.COD_PROYECTO, pagos.DESCRIPCION FROM mov_banco_caja INNER JOIN pagos_detalle ON mov_banco_caja.ID_PAGO = pagos_detalle.ID_PAGO INNER JOIN documentos ON pagos_detalle.ID_DOCUMENTO = documentos.ID_DOCUMENTO INNER JOIN pro_cli ON documentos.ID_PRO_CLI = pro_cli.ID_PRO_CLI INNER JOIN partidas ON documentos.ID_PARTIDA = partidas.ID INNER JOIN pagos ON mov_banco_caja.ID_PAGO = pagos.ID_PAGO WHERE mov_banco_caja.TIPO_PAGO = 2".$proyecto." ORDER BY ".$ordenar;
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="../js/jquery-1.4.2.min.js" language="javascript"></script>
<script src="../js/jquery-ui-1.8.5.custom.min.js" language="javascript"></script>
<script src="../js/jquery.ui.datepicker-es.js" language="javascript"></script>
<script src="../js/jquery.infieldlabel.min.js" language="javascript"></script>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<title>Untitled Document</title>
<link href="../js/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="../css/form.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>

<body>
<?php $opcion_menu=2; ?>
<?php include('../include/header.php'); ?>
<form action="pago3.php" method="post">
	<table width="1100" align="center" class="ui-widget-header" >
		<tr>
			<td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Cheques</div>
		</tr>
	</table>
	<center>
	</center>
</form>
<form>
<table width="1100" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#999999">
	<tr class="textos_form">
		<td colspan="2" align="center" bgcolor="#FFFFFF">&nbsp;</td></tr><tr class="textos_form">
		<td width="50%" align="right" bgcolor="#FFFFFF">Proyecto:</td>
		<td bgcolor="#FFFFFF"><label for="p"></label>
			<select name="p" id="p">
				<option value="0" <?php if (!(strcmp(0, $_GET['p']))) {echo "selected=\"selected\"";} ?>>Todos</option>
				<?php
do {  
?>
				<option value="<?php echo $row_PROYECTOS['CODIGO']?>"<?php if (!(strcmp($row_PROYECTOS['CODIGO'], $_GET['p']))) {echo "selected=\"selected\"";} ?>><?php echo $row_PROYECTOS['NOMBRE']?></option>
				<?php
} while ($row_PROYECTOS = mysql_fetch_assoc($PROYECTOS));
  $rows = mysql_num_rows($PROYECTOS);
  if($rows > 0) {
      mysql_data_seek($PROYECTOS, 0);
	  $row_PROYECTOS = mysql_fetch_assoc($PROYECTOS);
  }
?>
			</select>
			<input name="col" type="hidden" id="col" value="<?php echo $_GET['col']; ?>" />
			<input name="orden" type="hidden" id="orden" value="<?php echo $_GET['orden']; ?>" />
<input type="submit" name="Filtrar" id="Filtrar" value="Submit" /></td></tr></table></form>
<table width="1100" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#999999">
	<tr class="textos_form">
		<td width="50" align="center" bgcolor="#CCCCCC"><a href="consulta.php?p=<?php echo $_GET['p'] ?>&col=NUMERO_PAGO&orden=<?php echo $orden;  ?>">Numero de Cheque</a></td>
		<td width="100" align="center" bgcolor="#CCCCCC"><a href="consulta.php?p=<?php echo $_GET['p'] ?>&col=FECHA&orden=<?php echo $orden;  ?>">Fecha</a></td>
		<td width="200" align="center" bgcolor="#CCCCCC"><a href="consulta.php?p=<?php echo $_GET['p'] ?>&col=NOMBRE&orden=<?php echo $orden;  ?>">Proveedor</a></td>
		<td align="center" bgcolor="#CCCCCC"><a href="consulta.php?p=<?php echo $_GET['p'] ?>&col=DESCRIPCION&orden=<?php echo $orden;  ?>">Descripcion</a></td>
		<td width="50" align="center" bgcolor="#CCCCCC"><a href="consulta.php?p=<?php echo $_GET['p'] ?>&col=ID_DOCUMENTO&orden=<?php echo $orden;  ?>">ID Documento</a></td>
		<td width="100" align="center" bgcolor="#CCCCCC"><a href="consulta.php?p=<?php echo $_GET['p'] ?>&col=MONTO&orden=<?php echo $orden;  ?>">Monto</a></td>
	</tr>
	<?php do { ?><tr>
	<?php if (($row_cheques['ANULADO']==0) && ($row_cheques['PAGO_DIRECTO']==0)){ ?>
			<td width="19" align="center" bgcolor="#FFFFFF"><?php echo $row_cheques['NUMERO_PAGO']; ?></td>
			<td width="20" align="center" bgcolor="#FFFFFF"><?php echo $row_cheques['FECHA']; ?></td>
			<td width="150" bgcolor="#FFFFFF"><?php echo $row_cheques['NOMBRE']; ?></td>
			<td bgcolor="#FFFFFF"><?php echo $row_cheques['DESCRIPCION']; ?></td>
			<td width="30" align="center" bgcolor="#FFFFFF"><?php echo $row_cheques['ID_DOCUMENTO']; ?></td>
			<td width="100" align="right" bgcolor="#FFFFFF"><?php echo $row_cheques['MONTO']; ?></td>
			
	</tr><?php }else{?><?php 
	$color="#ffcaca";
	$mensaje="ANULADO";
	if($row_cheques['PAGO_DIRECTO']==1){$color="#a2dd5b"; $mensaje="PAGO DIRECTO";}
	?>

			<tr>
				<td width="19" align="center" bgcolor="<?php echo $color;?>"><?php echo $row_cheques['NUMERO_PAGO']; ?></td>
				<td width="20" align="center" bgcolor="<?php echo $color;?>"><?php echo $row_cheques['FECHA']; ?></td>
			<td width="150" align="left" bgcolor="<?php echo $color;?>"><strong>ANULADO</strong></td>
			<td bgcolor="<?php echo $color;?>"><?php echo $row_cheques['DESCRIPCION']; ?></td>
			<td width="30" bgcolor="<?php echo $color;?>"><?php echo $row_cheques['ID_DOCUMENTO']; ?></td>
			<td width="100" align="right" bgcolor="<?php echo $color;?>"><?php echo $row_cheques['MONTO']; ?></td>
			
	</tr>
	
	
	<?php }?>
	
	<?php } while ($row_cheques = mysql_fetch_assoc($cheques)); ?>
	<tr>
		<td colspan="6"><table border="0" align="center" cellspacing="6">
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
mysql_free_result($PROYECTOS);

mysql_free_result($cheques);

?>
