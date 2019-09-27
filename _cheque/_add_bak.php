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

mysql_select_db($database_conexion, $conexion);
$query_PAGO = "INSERT INTO mov_banco_caja (TIPO_PAGO, NUMERO_PAGO, FECHA, DESCRIPCION, MONTO, ID_CUENTA_BANCARIA ,BENEFICIARIO, PAGO_DIRECTO, COD_PROYECTO) VALUES ('11', '".$_GET['CHEQUE']."',CURDATE(), '".$_GET['DESCRIPCION']."', '".$_GET['MONTO']."', '1', '".$_GET['BENEFICIARIO']."', 1,'".$_GET['ID_CUENTA_BANCARIA']."')";
//echo $query_PAGO;
$PAGO = mysql_query($query_PAGO, $conexion) or die(mysql_error());
//$row_PAGO = mysql_fetch_assoc($PAGO);
//$totalRows_PAGO = mysql_num_rows($PAGO);

mysql_select_db($database_conexion, $conexion);
$query_CHEQUE = "UPDATE banco_chequeras SET ULTIMO_CHEQUE='".$_GET['CHEQUE']."' WHERE ID_CHEQUERA= ".$_GET['ID_CUENTA_BANCARIA'];
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
window.location = "directo.php";

</script>
</body>
</html>
<?php
//mysql_free_result($PAGO);
?>
