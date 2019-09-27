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

$colname_grafica = "-1";
if (isset($_POST['elegido'])) {
  $colname_grafica = $_POST['elegido'];
}
mysql_select_db($database_conexion, $conexion);
$query_grafica = sprintf("SELECT * FROM partidas WHERE ID_GRUPO = %s", GetSQLValueString($colname_grafica, "int"));
$grafica = mysql_query($query_grafica, $conexion) or die(mysql_error());
$row_grafica = mysql_fetch_assoc($grafica);
$totalRows_grafica = mysql_num_rows($grafica);

$colname_principal = "-1";
if (isset($_POST['elegido'])) {
  $colname_principal = $_POST['elegido'];
}
mysql_select_db($database_conexion, $conexion);
$query_principal = sprintf("SELECT * FROM partidas WHERE ID = %s", GetSQLValueString($colname_principal, "int"));
$principal = mysql_query($query_principal, $conexion) or die(mysql_error());
$row_principal = mysql_fetch_assoc($principal);
$totalRows_principal = mysql_num_rows($principal);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
$nombres="";
$estimado="";
$pagado="";
?>
<?php do { ?>
<?php if($nombres==""){
	$nombres=$row_grafica['DESCRIPCION'];
	echo $row_grafica['DESCRIPCION'];
	$estimado=100;//$row_grafica['MONTO_ESTIMADO']*100/$row_principal['MONTO_ESTIMADO'];
	if($row_grafica['MONTO_ESTIMADO']>0){
		$pagado=$row_grafica['MONTO_PAGADO']*100/$row_grafica['MONTO_ESTIMADO'];
	}else{
		$pagado="0";
	}
	//echo $row_grafica['MONTO_PAGADO']."----".$row_grafica['MONTO_ESTIMADO'];
}else{
	$nombres=$nombres."|".$row_grafica['DESCRIPCION'];
	$estimado=$estimado.","."100";//($row_grafica['MONTO_ESTIMADO']*100/$row_principal['MONTO_ESTIMADO']);
	echo $row_grafica['DESCRIPCION'];
	
	if($row_grafica['MONTO_ESTIMADO']>0){
		$pagado=$pagado.",".($row_grafica['MONTO_PAGADO']*100/$row_grafica['MONTO_ESTIMADO']);
	}else{
		$pagado=$pagado.",0";
	}
	//$pagado=$pagado.",".($row_grafica['MONTO_PAGADO']*100/$row_grafica['MONTO_ESTIMADO']);
	//echo $row_grafica['MONTO_PAGADO']."----".$row_grafica['MONTO_ESTIMADO'];
	
	
}?>
<?php } while ($row_grafica = mysql_fetch_assoc($grafica)); 
//echo $nombres;
?>

   <img src="http://chart.apis.google.com/chart?chxl=0:|<?php echo $nombres; ?>&chxt=y&chbh=r,0,0&chs=700x400&cht=bhs&chco=4D89F9,C6D9FD&chd=t:<?php echo $pagado."|".$estimado; ?>&chdl=Pagado|Estimado&chtt=<?php echo $row_principal['DESCRIPCION'] ; ?>&chts=676767,22" width="700" height="400" alt="Vertical bar chart" />
   <br />
   <br />
</body>
</html>
<?php
mysql_free_result($grafica);

mysql_free_result($principal);
?>
