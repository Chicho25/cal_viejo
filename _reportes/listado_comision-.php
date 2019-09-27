<?php include("../include/_funciones.php"); ?>
<?php 
$NUMERO_COLUMNAS=6;
$col1="ID_DOCUMENTO";
$col2="CODIGO_INMUEBLE";
$col3="NOMBRE_VENDEDOR";
$col4="NOMBRE_CLIENTE";
$col5="PORCENTAJE_COMISION";
$col6="MONTO_COMISION";

$columnas=" '',".$col1.", ".$col2.", ".$col3.", ".$col4.", ".$col5.", format(".$col6.",2) ";


$titulo="Comisiones";
$titulo_col2="Codigo Inmueble";
$titulo_col3="Vendedor";
$titulo_col4="Cliente";
$titulo_col5="%";
$titulo_col6="Monto";

$titulo_col1="ID Doumento";
/*$titulo_col7="Descripcion";
$titulo_col8="Debito";
$titulo_col9="Credito";*/
$alineacion_1="center";
$alineacion_2="center";
$alineacion_3="left";
$alineacion_4="left";
$alineacion_5="center";
$alineacion_6="center";
$alineacion_7="left";
$alineacion_8="right";
$alineacion_9="right";

$pagina="listado_01.php";
include('_columnas.php');
/*if ($_GET['ID_PARTIDA']!=''){
	$id_partida=" AND ID_PARTIDA=".$_GET['ID_PARTIDA'];
	}else
	{
		$id_partida='';
		}

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




$titulo_col1="Nombre";
$titulo_col2="Monto Vendido";
$titulo_col3="Monto Por Vender";
$titulo_col4="Monto Cobrado";
$titulo_col5="Monto Por Cobrar";
$titulo_col6="Monto Vencido";
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
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "0,1,2";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
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

$maxRows_CONSULTA = 10000;
$pageNum_CONSULTA = 0;
if (isset($_GET['pageNum_CONSULTA'])) {
  $pageNum_CONSULTA = $_GET['pageNum_CONSULTA'];
}
$startRow_CONSULTA = $pageNum_CONSULTA * $maxRows_CONSULTA;

mysql_select_db($database_conexion, $conexion);
$query_CONSULTA = "SELECT ".$columnas." FROM vista_ventas_comisiones ; ";
//echo $query_CONSULTA."<BR>";
$CONSULTA = mysql_query($query_CONSULTA, $conexion) or die(mysql_error());
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



mysql_select_db($database_conexion, $conexion);
$query_CONSULTA_TOTAL = "SELECT '','', '', '', '', '', '', 'Total', FORMAT(SUM(DEBITO),2), FORMAT(SUM(CREDITO),2) FROM vista_edo_cuenta_proveedores WHERE MODULO=1 AND ID_PRO_CLI='".$_GET['PROVEEDOR']."' AND CODIGO_PROYECTO='".$_GET['CODIGO_PROYECTO']."'  ".$_GET['COMISIONES']." ".$id_partida."; ";
//echo $query_CONSULTA_TOTAL; 
$CONSULTA_TOTAL = mysql_query($query_CONSULTA_TOTAL, $conexion) or die(mysql_error());
$row_CONSULTA_TOTAL = mysql_fetch_row($CONSULTA_TOTAL);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1" />
<title>Untitled Document</title>
<?php include("../include/_js.php"); ?>
<?php include("../include/_css.php"); ?>
</head>

<body>
<?php $opcion_menu=2; ?>
<?php include("../include/menu.php"); ?>
<table width="1100" align="center" class="ui-widget-header" >
	<tr>
		<td width="100%" align="center" class="textos_form"><div class="titulo_formulario"><?php echo $titulo ?><br /><?php echo $row_CONSULTA[12] ?></div>
	</tr>
</table>
<?php $a=0;//include("_menu.php"); ?>
</td>
</tr>
</table>
<?php if ($totalRows_CONSULTA > 0) { // Show if recordset not empty
$a=$a+1 ?>
	<table width="1100" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#999999">
		<!--Inicio Encabezado de las columnas-->
		<tr class="menu">
			<?php for ($i = 1; $i <= $NUMERO_COLUMNAS; $i++) { ?>
			<td width="50" align="center" bgcolor="#cccccc" class="textos_form"><?php echo ${'titulo_col'.$i} //${'url_col'.$i}?></td>
			<?php }?>
			<td width="50" align="center" bgcolor="#cccccc" class="textos_form"></td>
		</tr>
		<!--Fin Encabezado de las columnas-->
				<?php 
				$saldo=0;
				$color='e0e0e0';
				$id_documento=$row_CONSULTA[2];
				do { 
				//echo "1:".$row_CONSULTA[10];
					if($id_documento!=$row_CONSULTA[2]){
						$id_documento=$row_CONSULTA[2];
						//echo 1;
						if($color=='e0e0e0'){
							$color='ffffff';
						}else{
							$color='e0e0e0';
						}
					}
				
				?>
		<tr style="font-family:Arial, Helvetica, sans-serif; font-size:12px" bgcolor="<?php echo $color ?>">
			<?php
 	for ($i = 1; $i <= $NUMERO_COLUMNAS; $i++) {
		

 ?>
			<td align="<?php echo ${'alineacion_'.$i} ?>" ><?php echo $row_CONSULTA[$i]; ?></td>
			<?php }?>
			<?php 
			$saldo=$saldo+$row_CONSULTA[10]-$row_CONSULTA[11];			
			?>
			<td align="right"></td>
		</tr>
	
		<?php } while ($row_CONSULTA = mysql_fetch_row($CONSULTA)); ?>
		<?php do { ?>
		<tr style="font-family:Arial, Helvetica, sans-serif; font-size:12px" bgcolor='#cccccc' class="textos_form" >
			<?php
 	for ($i = 1; $i <= $NUMERO_COLUMNAS; $i++) {
 ?>
			<td align="<?php echo ${'alineacion_'.$i} ?>" class="textos_form"><?php echo $row_CONSULTA_TOTAL[$i]; ?></td>
			<?php }?>
			<td align="right" class="textos_form"><?php //echo number_format($saldo,2); ?></td>
		</tr>
	
		<?php } while ($row_CONSULTA = mysql_fetch_row($CONSULTA)); ?>
		<!--<tr>
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
		</tr>-->
	</table>
	<?php } // Show if recordset not empty ?>
<?php if ($totalRows_CONSULTA == 0) { // Show if recordset empty ?>
	<div class="textos_form" align="center">No existen registros asociados a su busqueda</div>
	<?php } // Show if recordset empty ?>
</body>
</html>
<?php echo $a;
mysql_free_result($CONSULTA);

?>
