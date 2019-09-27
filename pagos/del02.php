<?php include('../include/header.php'); ?>
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

function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
} 




 
$id_documentos="";

mysql_select_db($database_conexion, $conexion);
$query_cerrado = "SELECT * FROM pagos_detalle WHERE ID_PAGO = ".$_GET['CODIGO'];
$cerrado = mysql_query($query_cerrado, $conexion) or die(mysql_error());
$row_cerrado = mysql_fetch_assoc($cerrado);
$totalRows_cerrado = mysql_num_rows($cerrado);
?>
<?php do { ?>
<?php

mysql_select_db($database_conexion, $conexion);
$query_tipo = "UPDATE documentos SET documentos.STATUS_PENDIENTE=0 WHERE documentos.ID_DOCUMENTO IN (".$row_cerrado['ID_DOCUMENTO'].")";
$tipo = mysql_query($query_tipo, $conexion) or die(mysql_error());
//$row_tipo = mysql_fetch_assoc($tipo);
if($id_documentos!=""){
	$id_documentos=$id_documentos.", ".$row_cerrado['ID_DOCUMENTO'];
}else{
	$id_documentos=$row_cerrado['ID_DOCUMENTO'];
 
}

 ?>
	<?php } while ($row_cerrado = mysql_fetch_assoc($cerrado)); ?>
	<?php
	mysql_select_db($database_conexion, $conexion);
	$query_tipo = "UPDATE documentos SET documentos.STATUS_PENDIENTE=0 WHERE documentos.ID_DOCUMENTO IN (".$id_documentos.")";
	//echo $query_tipo;
	$tipo = mysql_query($query_tipo, $conexion) or die(mysql_error());
	//$row_tipo = mysql_fetch_assoc($tipo);
	$ids=$id_documentos;
aud($_SESSION['i'], $ids,'Edito registro en documentos con el id',$_GET['menu']);

	mysql_select_db($database_conexion, $conexion);
 



if ((isset($_GET['CODIGO'])) && ($_GET['CODIGO'] != "")) {
	
	mysql_select_db($database_conexion, $conexion);
$query_cerrados = "SELECT * FROM mov_banco_caja WHERE ID_PAGO = ".$_GET['CODIGO'];
$cerrados = mysql_query($query_cerrados, $conexion) or die(mysql_error());
$row_cerrados = mysql_fetch_assoc($cerrados);
$totalRows_cerrados = mysql_num_rows($cerrados);
	if ($row_cerrados['NUMERO_PAGO']!="" && $row_cerrados['TIPO_PAGO']==2){
		$query_detalle_bancos = "INSERT INTO mov_banco_caja (TIPO_PAGO, NUMERO_PAGO, ANULADO, DESCRIPCION, ID_CUENTA_BANCARIA, FECHA, COD_PROYECTO) VALUES (11,'".$row_cerrados['NUMERO_PAGO']."', 1, 'CHEQUE ANULADO Eliminacion del pago', ".$row_cerrados['ID_CUENTA_BANCARIA'].", now(), '".$row_cerrados['COD_PROYECTO']."')";
	//echo $query_detalle_banco;
	$detalle_banco = mysql_query($query_detalle_bancos, $conexion) or die(mysql_error());
	$ids=mysql_insert_id();
   aud($_SESSION['i'],$ids,'Anulacion de cheque en mov_banco_caja con el id ',13);

	}
	
  $deleteSQL = sprintf("DELETE mov_banco_caja, pagos, pagos_detalle FROM mov_banco_caja, pagos, pagos_detalle WHERE pagos.ID_PAGO=pagos_detalle.ID_PAGO AND pagos.ID_PAGO=mov_banco_caja.ID_PAGO AND pagos.ID_PAGO = %s",
                       GetSQLValueString($_GET['CODIGO'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($deleteSQL, $conexion) or die(mysql_error());
 $ids=$_GET['CODIGO'];
aud($_SESSION['i'], $ids,'Elimino registro en mov_banco_caja con el id de pago ',$_GET['menu']);
  
  $deleteGoTo = "del01.php?PROYECTO=&PROVEEDOR=&TIPO=&NUMERO=&FROM=&TO=&button=Buscar#";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $deleteGoTo));
}

$colname_cerrado = "-1";
if (isset($_GET['CODIGO'])) {
  $colname_cerrado = $_GET['CODIGO'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<script type="text/javascript">
alert("Proceso Completado con Exito.");
 window.location="list.php?titulo_formulario=<?php echo $_GET['titulo_formulario']; ?>&<?php if($_GET['modulo']==1){echo 'titulo_formulario=Emision de Pagos';} else {echo 'titulo_formulario=Recepcion de Pagos';} ?>&modulo=<?php echo $_GET['modulo']; ?>";

</script>

 
</body>
</html>
<?php
mysql_free_result($cerrado);
?>
