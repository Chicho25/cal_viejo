<?php
require_once ('../../Connections/conexion.php');
echo $_GET['ID_CHEQUERA'];
?>
<?php
if(!function_exists("GetSQLValueString")) {
	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
		if(PHP_VERSION < 6) {
			$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
		}

		$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

		switch ($theType) {
			case "text" :
				$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				break;
			case "long" :

			case "int" :
				$theValue = ($theValue != "") ? intval($theValue) : "NULL";
				break;
			case "double" :
				$theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
				break;
			case "date" :
				$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				break;
			case "defined" :
				$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
				break;
		}
		return $theValue;
	}

}

$colname_PAGO = "-1";
if(isset($_GET['ID_PAGO'])) {
	$colname_PAGO = $_GET['ID_PAGO'];
}
mysql_select_db($database_conexion, $conexion);
$query_PAGO = "UPDATE mov_banco_caja SET ID_USUARIO='" . $_GET['ID_USUARIO'] . "', NUMERO_PAGO='" . $_GET['CHEQUE'] . "', BENEFICIARIO='" . $_GET['BENEFICIARIO'] . "' WHERE ID_PAGO = " . $_GET['ID_PAGO'];
echo $query_PAGO;
$PAGO = mysql_query($query_PAGO, $conexion) or die(mysql_error());
/*$row_PAGO = mysql_fetch_assoc($PAGO);
 $totalRows_PAGO = mysql_num_rows($PAGO);*/

mysql_select_db($database_conexion, $conexion);
$query_CHEQUE = "UPDATE banco_chequeras SET ULTIMO_CHEQUE='" . $_GET['CHEQUE'] . "' WHERE ID_CHEQUERA = " . $_GET['ID_CHEQUERA'] . " ";
echo $query_CHEQUE;
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
			<!--alert("Proceso Completado con Exito.");
			window.location = "../pago_eliminar/del01.php?ID_PAGO=&ID_DOCUMENTO=&PROYECTO=&PROVEEDOR=&TIPO=&NUMERO=&FROM=&TO=&STATUS=0&button=Buscar";
			//-->
		</script>
	</body>
</html>
<?php
//mysql_free_result($PAGO);
?>
