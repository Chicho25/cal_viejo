<?php include('../Connections/conexion.php'); ?>
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

mysql_select_db($database_conexion, $conexion);
$query_rst_longitud = "SELECT LONGITUD_NUMERO FROM banco_chequeras WHERE ID_CHEQUERA= '".$_GET['CUENTA']."'";
$rst_longitud = mysql_query($query_rst_longitud, $conexion) or die(mysql_error());
$row_rst_longitud = mysql_fetch_assoc($rst_longitud);
$totalRows_rst_longitud = mysql_num_rows($rst_longitud);

mysql_select_db($database_conexion, $conexion);
//$query_PAGO = "INSERT INTO mov_banco_caja (TIPO_PAGO, NUMERO_PAGO, FECHA, DESCRIPCION, MONTO, ID_CUENTA_BANCARIA ,BENEFICIARIO, PAGO_DIRECTO, COD_PROYECTO) VALUES ('11', '" .str_pad($_GET['CHEQUE'], $row_rst_longitud['LONGITUD_NUMERO'], 0, STR_PAD_LEFT)."',CURDATE(), '".$_GET['DESCRIPCION']."', '".$_GET['MONTO']."',  '".$_GET['ID_CTA_BANCARIA']."', '".$_GET['BENEFICIARIO']."', 1,'".$_GET['CODIGO_PROYECTO']."')";

$query_PAGO = "INSERT INTO mov_banco_caja (TIPO_PAGO, NUMERO_PAGO, FECHA, DESCRIPCION, MONTO, ID_CUENTA_BANCARIA ,BENEFICIARIO, PAGO_DIRECTO, COD_PROYECTO) VALUES ('11', '" .str_pad($_GET['CHEQUE'], $row_rst_longitud['LONGITUD_NUMERO'], 0, STR_PAD_LEFT)."','".$_GET['FECHA']."', '".$_GET['DESCRIPCION']."', '".$_GET['MONTO']."',  '".$_GET['ID_CTA_BANCARIA']."', '".$_GET['BENEFICIARIO']."', 1,'".$_GET['CODIGO_PROYECTO']."')";
//echo $query_PAGO;
$PAGO = mysql_query($query_PAGO, $conexion) or die(mysql_error());
//$row_PAGO = mysql_fetch_assoc($PAGO); 
//$totalRows_PAGO = mysql_num_rows($PAGO);

mysql_select_db($database_conexion, $conexion);
$query_CHEQUE = "UPDATE banco_chequeras SET ULTIMO_CHEQUE='".$_GET['CHEQUE']."' WHERE AUTOMATICA =1 AND ID_CHEQUERA= '".$_GET['CUENTA']."'";
//echo $query_CHEQUE;
$CHEQUE = mysql_query($query_CHEQUE, $conexion) or die(mysql_error());


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
window.location = "list.php";

</script>
</body>
</html>
<?php
mysql_free_result($rst_longitud);

//mysql_free_result($PAGO);
?>
