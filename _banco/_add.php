<?php
include ('../include/header.php');

// para validar que no exista un cheque con el mismo numero
 if (existe_cheque($_GET['ID_CUENTA'],$_GET['CHEQUE'])=='Verdadero'){ ?>
 <script type="text/javascript">alert("Este numero de cheque ya existe por favor revise e intente de nuevo..."); window.location="../pagos/list.php?titulo_formulario=Emisi%F3n%20de%20Pagos&modulo=1";</script>
<?php } else {	
$colname_PAGO = "-1";
if (isset($_GET['ID_PAGO'])) {
  $colname_PAGO = $_GET['ID_PAGO'];
}
mysql_select_db($database_conexion, $conexion);
$query_PAGO = "UPDATE mov_banco_caja SET NUMERO_PAGO='".$_GET['CHEQUE']."', BENEFICIARIO='".$_GET['BENEFICIARIO']."' WHERE ID_PAGO = ".$_GET['ID_PAGO'];
$PAGO = mysql_query($query_PAGO, $conexion) or die(mysql_error());
/*$row_PAGO = mysql_fetch_assoc($PAGO);
$totalRows_PAGO = mysql_num_rows($PAGO);*/

mysql_select_db($database_conexion, $conexion);
$query_CHEQUE = "UPDATE banco_chequeras SET ULTIMO_CHEQUE='".$_GET['CHEQUE']."' WHERE ID_CHEQUERA = '".$_GET['ID_CHEQUERA']."'";
$CHEQUE = mysql_query($query_CHEQUE, $conexion) or die(mysql_error());

//echo $query_CHEQUE;
?>

<script type="text/javascript">
<!--
alert("Proceso Completado con Exito.");
window.location = "../pagos/list.php?titulo_formulario=Emisi%F3n%20de%20Pagos&modulo=1"
</script>

 <?php
 }
?>
