<?php 

//Modulo 1=Costos 2=Ventas
$modulo=1;
/////////////////////////////////////////////

$where="WHERE doc_tipo.MODULO=".$modulo;
if($_POST['elegido']!=""){
$where=$where." AND documentos.ID_PRO_CLI=".$_POST['elegido']." ";
}
if($_POST['TIPO']!="0"){
	if($where==""){
		$where=" WHERE documentos.TIPO=".$_POST['TIPO']." ";
		
	} else {
		$where=$where." AND documentos.TIPO=".$_POST['TIPO']." ";
	}
	
}
if($_POST['PROYECTO']!="0"){
	if($where==""){
		$where=" WHERE documentos.COD_PROYECTO='".$_POST['PROYECTO']."' ";
		
	} else {
		$where=$where." AND documentos.COD_PROYECTO='".$_POST['PROYECTO']."' ";
	}
	
}
if($_POST['STATUS']!=""){
	if($where==""){
		$where=" WHERE documentos.STATUS_PENDIENTE='".$_POST['STATUS']."' ";
		
	} else {
		$where=$where." AND documentos.STATUS_PENDIENTE='".$_POST['STATUS']."' ";
	}
	
}
?>

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

$maxRows_proveeedor = 10;
$pageNum_proveeedor = 0;
if (isset($_GET['pageNum_proveeedor'])) {
  $pageNum_proveeedor = $_GET['pageNum_proveeedor'];
}
$startRow_proveeedor = $pageNum_proveeedor * $maxRows_proveeedor;

mysql_select_db($database_conexion, $conexion);
$query_proveeedor = "SELECT     pro_cli.NOMBRE AS nombre_proveedor     , doc_tipo.DESCRIPCION AS tipo_documento     , documentos.ID_DOCUMENTO AS id_documento     , documentos.NUMERO AS numero_documento     , documentos.FECHA_EMISION AS fecha_documento     , documentos.MONTO_EXENTO     , documentos.MONTO_GRABADO     , documentos.STATUS_PENDIENTE AS status_documento     , proyectos.NOMBRE AS nombre_proyecto     , documentos.DESCRIPCION FROM     grupocal_calpe.documentos     INNER JOIN grupocal_calpe.doc_tipo          ON (documentos.TIPO = doc_tipo.TIPO)     INNER JOIN grupocal_calpe.pro_cli          ON (documentos.ID_PRO_CLI = pro_cli.ID_PRO_CLI)     INNER JOIN grupocal_calpe.proyectos          ON (documentos.COD_PROYECTO = proyectos.CODIGO)".$where." ";
$query_limit_proveeedor = sprintf("%s LIMIT %d, %d", $query_proveeedor, $startRow_proveeedor, $maxRows_proveeedor); 
$proveeedor = mysql_query($query_limit_proveeedor, $conexion) or die(mysql_error());
$row_proveeedor = mysql_fetch_assoc($proveeedor);

if (isset($_GET['totalRows_proveeedor'])) {
  $totalRows_proveeedor = $_GET['totalRows_proveeedor'];
} else {
  $all_proveeedor = mysql_query($query_proveeedor);
  $totalRows_proveeedor = mysql_num_rows($all_proveeedor);
}
$totalPages_proveeedor = ceil($totalRows_proveeedor/$maxRows_proveeedor)-1;

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

<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/menu_style.css" type="text/css" media="all" />
</head>

<body>
<?php $opcion_menu=2; ?>
<?php include("../include/menu.php"); ?>

<table width="1100" align="center" class="ui-widget-header" >
	<tr>
		<td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Documentos</div>
	</tr>
</table><form action="pago2.php" method="post">
	<table width="1100" border="0" align="center" cellpadding="0" cellspacing="2" bgcolor="#CCCCCC">
		<tr class="menu">
			<td align="center">Id</td>
			<td align="center">Proyecto</td>
			<td align="center">Tipo</td>
			<td align="center">Fecha</td>
			<td align="center">Proveedor</td>
			<td align="center">Descripcion</td>
			<td align="center">Monto</td>
		</tr>
		<?php do { ?>
			<tr style="font-family:Arial, Helvetica, sans-serif; font-size:12px" bgcolor=<?php if ($row_proveeedor['status_documento']==1){ ?>"#FFFF99"<?php }else{  ?>"#FFFFFF"<?php }?> >
				<td align="center"><p><a href="edit3.php?id_documento=<?php echo $row_proveeedor['id_documento']; ?>"><?php echo $row_proveeedor['id_documento']; ?></a></p></td>
				<td><p><?php echo $row_proveeedor['nombre_proyecto']; ?></p></td>
				<td><p><?php echo $row_proveeedor['tipo_documento']; ?></p></td>
				<td><p><?php echo $row_proveeedor['fecha_documento']; ?></p></td>
				<td><p><?php echo $row_proveeedor['nombre_proveedor']; ?></p></td>
				<td><p><?php echo $row_proveeedor['DESCRIPCION']; ?></p></td>
				<td><p><?php echo $row_proveeedor['MONTO_EXENTO']+$row_proveeedor['MONTO_GRABADO']; ?></p></td>
			</tr>
			<?php } while ($row_proveeedor = mysql_fetch_assoc($proveeedor)); ?>
	</table>
</form>

</body>
</html>
<?php
mysql_free_result($proveeedor);

?>
