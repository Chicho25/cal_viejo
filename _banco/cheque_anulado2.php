<?php include('../include/header.php');
 
// para validar que no exista un cheque con el mismo numero
 if (existe_cheque($_POST['ID_CUENTA'],$_POST['NUMERO_PAGO'])=='Verdadero'){ ?>
 <script type="text/javascript">alert("Este numero de cheque ya existe por favor revise e intente de nuevo..."); window.location="../pagos/list.php?titulo_formulario=Emisi%F3n%20de%20Pagos&modulo=1";</script>
<?php } else {	

	$query_detalle_banco = "INSERT INTO mov_banco_caja (TIPO_PAGO, NUMERO_PAGO, ANULADO, DESCRIPCION, ID_CUENTA_BANCARIA, FECHA, COD_PROYECTO) VALUES (11,'".$_POST['NUMERO_PAGO']."', 1, 'CHEQUE ANULADO ".$_POST['DESCRIPCION']."', ".$_POST['ID_CUENTA'].", now(), '".$_POST['PROYECTO']."')";
	//echo $query_detalle_banco;
	$detalle_banco = mysql_query($query_detalle_banco, $conexion) or die(mysql_error("aqui"));
	$ids=mysql_insert_id();
   aud($_SESSION['i'],$ids,'Anulacion de cheque en mov_banco_caja con el id ',13);

	mysql_select_db($database_conexion, $conexion);
	$query_CHEQUE = "UPDATE banco_chequeras SET ULTIMO_CHEQUE='".$_POST['NUMERO_PAGO']."' WHERE ID_CHEQUERA = ".$_POST['ID_CHEQUERA'];
	//echo $query_CHEQUE;
	$CHEQUE = mysql_query($query_CHEQUE, $conexion) or die(mysql_error());
	$ids=$_POST['ID_CHEQUERA'];
   aud($_SESSION['i'],$ids,'Modifico registro de banco_chequeras al nuevo ultimo cheque '.$_POST['NUMERO_PAGO'].' con el id chequera',13);

	?>
<script type="text/javascript">
alert("Proceso Completado con Exito.");
window.location = "../pagos/list.php?titulo_formulario=Emisi%F3n%20de%20Pagos&modulo=1";

</script>
	<?php } ?>


