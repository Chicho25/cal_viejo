<?php include("../include/_funciones.php"); ?>
<?php 
$NUMERO_COLUMNAS=12;
include('_columnas.php');
/*$col1="ID_CUENTA_BANCARIA";
$col2="ID_TESORERIA_TIPO_MOV";
$col3="TIPO_IO";
$col4="NUMERO_PAGO";
$col5="DESCRIPCION";
$col6="ID_MOV_BANCO_CAJA";
$col7="FROM";
$col8="TO";
$col9="DEBITO";
$col10="CREDITO";
$col11="FECHA_DATE";
$col12="NOMBRE_TIPO_MOV";




$titulo_col1="ID";
$titulo_col2="TIPO MOVIMIENTO";
$titulo_col3="TIPO PAGO";
$titulo_col4="NUMERO";
$titulo_col5="DESCRIPCION";
$titulo_col6="ID";
$titulo_col9="DEBITO";
$titulo_col10="CREDITO";
$titulo_col11="FECHA";
$titulo_col12="TIPO MOVIMIENTO";

$where=' WHERE AFECTA_BANCO=1 ';



if($valor_col1!="")
{
	if($where=='')
	{
		$where=' WHERE '.$col1.'='.$valor_col1;
	}else{
		$where=$where.' AND '.$col1.'='.$valor_col1;
	}
}

if($valor_col2!="")
{
	if($where=='')
	{
		$where=' WHERE '.$col2.'='.$valor_col2;
	}else{
		$where=$where.' AND '.$col2.'='.$valor_col2;
	}
}

if($valor_col3!="T")
{
	if($where=='')
	{
		$where=' WHERE '.$col3.'="'.$valor_col3.'"';
	}else{
		$where=$where.' AND '.$col3.'="'.$valor_col3.'"';
	}
}

if($valor_col4!="")
{
	if($where=='')
	{
		$where=' WHERE '.$col4.'='.$valor_col4;
	}else{
		$where=$where.' AND '.$col4.'='.$valor_col4;
	}
}

if($valor_col5!="")
{
	if($where=='')
	{
		$where=' WHERE '.$col5.'='.$valor_col5;
	}else{
		$where=$where.' AND '.$col5.'='.$valor_col5;
	}
}

if($valor_col6!="")
{
	if($where=='')
	{
		$where=' WHERE '.$col6.'='.$valor_col6;
	}else{
		$where=$where.' AND '.$col6.'='.$valor_col6;
	}
}
if($valor_col7!="")
{
	if($valor_col8=="")
	{
		if($where=='')
		{
			$where=' WHERE '.$col11.'="'.DMAtoAMD($valor_col7).'" ';
		}else{
			$where=$where.' AND '.$col11.'="'.DMAtoAMD($valor_col7).'" ';
		}
	}else{
		
		if($where=='')
		{
			$where=' WHERE '.$col11.' BETWEEN "'.DMAtoAMD($valor_col7).'" AND "'.DMAtoAMD($valor_col8).'" ';
		}else{
			$where=$where.' AND '.$col11.' BETWEEN "'.DMAtoAMD($valor_col7).'" AND "'.DMAtoAMD($valor_col8).'" ';
		}
	}
}
if($valor_col10!="")
{
	if($where=='')
	{
		$where=' WHERE '.$col10.'='.$valor_col10;
	}else{
		$where=$where.' AND '.$col10.'='.$valor_col10;
	}
}
?>
<?php
/////////////////////////////////////////
 /*?>$tipo=$_GET['TIPO'];

$status=$_GET['STATUS'];

$proyecto=$_GET['PROYECTO'];


$where="WHERE modulo=".$modulo;
if($_GET['elegido']!=""){
$where=$where." AND ID_PRO_CLI=".$_GET['elegido']." ";
}

if($_GET['ID_DOCUMENTO']!=""){
	
	$where=$where." AND ID_DOCUMENTO=".$_GET['ID_DOCUMENTO']." ";
}

if($_GET['TIPO']!="0"){
	
	$where=$where." AND CODIGO_TIPO_DOCUMENTO=".$tipo." ";
}
if($_GET['PROYECTO']!="0"){
	
	$where=$where." AND COD_PROYECTO='".$proyecto."' ";
}
if($_GET['STATUS']!="Todos"){
	
		if($_GET['STATUS']==0){
			$where=$where." AND TIENE_PAGOS=0 ";
		};
		if($_GET['STATUS']==1){
			$where=$where." AND STATUS_DOCUMENTO=1 ";
		};
		if($_GET['STATUS']==2){
			$where=$where." AND TIENE_PAGOS=1 AND STATUS_DOCUMENTO=1 ";
		};
		if($_GET['STATUS']==3){
			$where=$where." AND STATUS_DOCUMENTO=0 ";
		};
		
	}
	<?php */?>
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

$maxRows_CONSULTA = 10000;
$pageNum_CONSULTA = 0;
if (isset($_GET['pageNum_CONSULTA'])) {
  $pageNum_CONSULTA = $_GET['pageNum_CONSULTA'];
}
$startRow_CONSULTA = $pageNum_CONSULTA * $maxRows_CONSULTA;

mysql_select_db($database_conexion, $conexion);
$query_CONSULTA = "SELECT * FROM vista_banco_movimientos ";//.$where." ORDER BY ".$ordenar;
$query_limit_CONSULTA = sprintf("%s LIMIT %d, %d", $query_CONSULTA, $startRow_CONSULTA, $maxRows_CONSULTA);
echo $query_limit_CONSULTA;
$CONSULTA = mysql_query($query_limit_CONSULTA, $conexion) or die(mysql_error());
$row_CONSULTA = mysql_fetch_row($CONSULTA);

if (isset($_GET['totalRows_CONSULTA'])) {
  $totalRows_CONSULTA = $_GET['totalRows_CONSULTA'];
} else {
  $all_CONSULTA = mysql_query($query_CONSULTA);
  $totalRows_CONSULTA = mysql_num_rows($all_CONSULTA);
}
$totalPages_CONSULTA = ceil($totalRows_CONSULTA/$maxRows_CONSULTA)-1;

$queryString_CONSULTA = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_CONSULTA") == false && 
        stristr($param, "totalRows_CONSULTA") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_CONSULTA = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_CONSULTA = sprintf("&totalRows_CONSULTA=%d%s", $totalRows_CONSULTA, $queryString_CONSULTA);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<title>Untitled Document</title>
<?php include("../include/_js.php"); ?>
<?php include("../include/_css.php"); ?>
</head>

<body>
<?php $opcion_menu=2; ?>
<?php include("../include/menu.php"); ?>
<table width="1100" align="center" class="ui-widget-header" >
	<tr>
		<td width="100%" align="center" class="textos_form"><div class="titulo_formulario"><?php echo $titulo ?></div>
	</tr>
</table>
<?php //include("_menu.php"); ?>
</td>
</tr>
</table>
<?php if ($totalRows_CONSULTA > 0) { // Show if recordset not empty ?>
	<table width="1100" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#999999">
		<tr class="menu">
			<?php
 	for ($i = 1; $i <= $NUMERO_COLUMNAS; $i++) {
 ?>
			<td width="50" align="center" bgcolor="#cccccc" class="textos_form"><?php echo ${'url_col'.$i}?></td>
			<?php }?>
		</tr>
		<?php do { ?>
		<td colspan="<?php echo $NUMERO_COLUMNAS ?>" bgcolor="#FFFFFF">mariquera</td></tr>
		<tr style="font-family:Arial, Helvetica, sans-serif; font-size:12px" bgcolor='#cccccc' >
			<?php
 	for ($i = 1; $i <= $NUMERO_COLUMNAS; $i++) {
 ?>
			<td align="center"><?php echo $row_CONSULTA[$i]; ?></td>
			<?php }?>
		</tr>
		<tr>
		<?php } while ($row_CONSULTA = mysql_fetch_row($CONSULTA)); ?>
		<tr>
			<td colspan="11" align="center"><table border="0" cellspacing="10">
					<tr>
						<td><?php if ($pageNum_CONSULTA > 0) { // Show if not first page ?>
								<a href="<?php printf("%s?pageNum_CONSULTA=%d%s", $currentPage, 0, $queryString_CONSULTA); ?>"><img src="First.gif" alt="" /></a>
								<?php } // Show if not first page ?></td>
						<td><?php if ($pageNum_CONSULTA > 0) { // Show if not first page ?>
								<a href="<?php printf("%s?pageNum_CONSULTA=%d%s", $currentPage, max(0, $pageNum_CONSULTA - 1), $queryString_CONSULTA); ?>"><img src="Previous.gif" alt="" /></a>
								<?php } // Show if not first page ?></td>
						<td><?php if ($pageNum_CONSULTA < $totalPages_CONSULTA) { // Show if not last page ?>
								<a href="<?php printf("%s?pageNum_CONSULTA=%d%s", $currentPage, min($totalPages_CONSULTA, $pageNum_CONSULTA + 1), $queryString_CONSULTA); ?>"><img src="Next.gif" alt="" /></a>
								<?php } // Show if not last page ?></td>
						<td><?php if ($pageNum_CONSULTA < $totalPages_CONSULTA) { // Show if not last page ?>
								<a href="<?php printf("%s?pageNum_CONSULTA=%d%s", $currentPage, $totalPages_CONSULTA, $queryString_CONSULTA); ?>"><img src="Last.gif" alt="" /></a>
								<?php } // Show if not last page ?></td>
					</tr>
				</table></td>
		</tr>
	</table>
	<?php } // Show if recordset not empty ?>
<?php if ($totalRows_CONSULTA == 0) { // Show if recordset empty ?>
	<div class="textos_form" align="center">No existen registros asociados a su busqueda</div>
	<?php } // Show if recordset empty ?>
</body>
</html>
<?php
mysql_free_result($CONSULTA);

?>
