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
	
	mysql_select_db($database_conexion, $conexion);
	$query_audita = "INSERT INTO auditoria (auditoria.DESCRIPCION, auditoria.IP_CONEXION, auditoria.MODULO) VALUES ('Eliminacion de Pago ID:".$_GET['CODIGO']." Documento(s) ID:".$id_documentos."','".getRealIpAddr()."', 1 )";
	//$audita = mysql_query($query_audita, $conexion) or die(mysql_error());
	//$row_audita = mysql_fetch_assoc($tipo);



if ((isset($_GET['CODIGO'])) && ($_GET['CODIGO'] != "")) {
  $deleteSQL = sprintf("DELETE mov_banco_caja, pagos, pagos_detalle FROM mov_banco_caja, pagos, pagos_detalle WHERE pagos.ID_PAGO=pagos_detalle.ID_PAGO AND pagos.ID_PAGO=mov_banco_caja.ID_PAGO AND pagos.ID_PAGO = %s",
                       GetSQLValueString($_GET['CODIGO'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($deleteSQL, $conexion) or die(mysql_error());
  
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
<!--
alert("Proceso Completado con Exito.");

window.location = "list.php?modulo=<?php echo $_GET['modulo']; ?>&titulo_formulario=<?php if($modulo==1){echo htmlentities('Emision de Pagos');} else {echo htmlentities('Recepcion de Pagos');} ?>";
//-->
</script>

</body>
</html>
<?php
mysql_free_result($cerrado);
?>
