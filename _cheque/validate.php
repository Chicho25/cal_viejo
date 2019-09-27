<?php require_once('../Connections/conexion.php'); 
//id_cuenta_bancaria:1, tipo_pago:11

mysql_select_db($database_conexion, $conexion);
/*$query_rst_chequera = sprintf("select * from `mov_banco_caja` where `mov_banco_caja`.`NUMERO_PAGO`=".($_GET['ULTIMO_CHEQUE']+1)." and `mov_banco_caja`.`ID_CUENTA_BANCARIA`=".$_GET['ID_CUENTA_BANCARIA']." and `mov_banco_caja`.`TIPO_PAGO`=".$_GET['TIPO_PAGO']);*/
$query_rst_chequera = sprintf("select * from `mov_banco_caja` where `mov_banco_caja`.`NUMERO_PAGO`=353 and `mov_banco_caja`.`ID_CUENTA_BANCARIA`=".$_POST['ID_CUENTA_BANCARIA']." and `mov_banco_caja`.`TIPO_PAGO`=11");
//echo $query_rst_chequera;
$rst_chequera = mysql_query($query_rst_chequera, $conexion) or die(mysql_error());
$row_rst_chequera = mysql_fetch_assoc($rst_chequera);
$totalRows_rst_chequera = mysql_num_rows($rst_chequera);
if ($totalRows_rst_chequera > 0){echo "Este numero de cheque ya ha sido utilizado";};
?>
<?php
mysql_free_result($rst_chequera);

?>
