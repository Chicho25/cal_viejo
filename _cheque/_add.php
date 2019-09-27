<?php include ('../include/header.php');

// para validar que no exista un cheque con el mismo numero
 if (existe_cheque($_GET['ID_CTA_BANCARIA'],$_GET['CHEQUE'])=='Verdadero'){ ?>
 <script type="text/javascript">alert("Este numero de cheque ya existe por favor revise e intente de nuevo..."); window.location="../pagos/list.php?titulo_formulario=Emisi%F3n%20de%20Pagos&modulo=1";</script>
<?php } else {	
	 
mysql_select_db($database_conexion, $conexion);
$query_rst_longitud = "SELECT LONGITUD_NUMERO FROM banco_chequeras WHERE ID_CHEQUERA= '".$_GET['CUENTA']."'";
$rst_longitud = mysql_query($query_rst_longitud, $conexion) or die(mysql_error());
$row_rst_longitud = mysql_fetch_assoc($rst_longitud);
$totalRows_rst_longitud = mysql_num_rows($rst_longitud);

mysql_select_db($database_conexion, $conexion);
//$query_PAGO = "INSERT INTO mov_banco_caja (TIPO_PAGO, NUMERO_PAGO, FECHA, DESCRIPCION, MONTO, ID_CUENTA_BANCARIA ,BENEFICIARIO, PAGO_DIRECTO, COD_PROYECTO) VALUES ('11', '" .str_pad($_GET['CHEQUE'], $row_rst_longitud['LONGITUD_NUMERO'], 0, STR_PAD_LEFT)."',CURDATE(), '".$_GET['DESCRIPCION']."', '".$_GET['MONTO']."',  '".$_GET['ID_CTA_BANCARIA']."', '".$_GET['BENEFICIARIO']."', 1,'".$_GET['CODIGO_PROYECTO']."')";

$query_PAGO = "INSERT INTO mov_banco_caja (TIPO_PAGO, NUMERO_PAGO, FECHA, DESCRIPCION, MONTO, ID_CUENTA_BANCARIA ,BENEFICIARIO, PAGO_DIRECTO, COD_PROYECTO, ID_USUARIO) VALUES ('11', '" .str_pad($_GET['CHEQUE'], $row_rst_longitud['LONGITUD_NUMERO'], 0, STR_PAD_LEFT)."','".$_GET['FECHA']."', '".$_GET['DESCRIPCION']."', '".$_GET['MONTO']."',  '".$_GET['ID_CTA_BANCARIA']."', '".$_GET['BENEFICIARIO']."', 1,'".$_GET['CODIGO_PROYECTO']."','".$_SESSION['i']."')";
//echo $query_PAGO;
$PAGO = mysql_query($query_PAGO, $conexion) or die(mysql_error());
 $ids=mysql_insert_id();
   aud($_SESSION['i'],$ids,'Creo registro en movimiento banco caja con id ',36);

//$row_PAGO = mysql_fetch_assoc($PAGO); 
//$totalRows_PAGO = mysql_num_rows($PAGO);

mysql_select_db($database_conexion, $conexion);
$query_CHEQUE = "UPDATE banco_chequeras SET ULTIMO_CHEQUE='".$_GET['CHEQUE']."' WHERE AUTOMATICA =1  AND ID_CHEQUERA= '".$_GET['CUENTA']."'";
//echo $query_CHEQUE;
$CHEQUE = mysql_query($query_CHEQUE, $conexion) or die(mysql_error());

$ids=$_GET['CUENTA'];
   aud($_SESSION['i'],$ids,'Modifico registro de banco_chequeras al nuevo ultimo cheque '.$_GET['CHEQUE'].' con el id chequera',36);
?>

<script type="text/javascript">

alert("Proceso Completado con Exito.");
window.location = "list.php?titulo_formulario=Cheque Directo";

</script>
	<?php
 }
?>

<?php
mysql_free_result($rst_longitud);

//mysql_free_result($PAGO);
?>
