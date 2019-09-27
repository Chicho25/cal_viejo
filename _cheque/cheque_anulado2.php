<?php include('../include/header.php');  
 
// para validar que no exista un cheque con el mismo numero
 if (existe_cheque($_POST['ID_CUENTA'],$_POST['NUMERO_PAGO'])=='Verdadero'){ ?>
 <script type="text/javascript">alert("Este numero de cheque ya existe por favor revise e intente de nuevo..."); window.location="../_cheque/list.php?titulo_formulario=Cheque%20Directo&activa=0&CUENTA=&BENEFICIARIO=&cheque=&MONTO=&MONTO_LETRAS=";</script>
<?php } else {	

mysql_select_db($database_conexion, $conexion);
$query_rst_longitud = "SELECT LONGITUD_NUMERO FROM banco_chequeras WHERE ID_CHEQUERA= '".$_POST['ID_CUENTA']."'";
$rst_longitud = mysql_query($query_rst_longitud, $conexion) or die(mysql_error());
$row_rst_longitud = mysql_fetch_assoc($rst_longitud);
$totalRows_rst_longitud = mysql_num_rows($rst_longitud);
	
	$query_detalle_banco = "INSERT INTO mov_banco_caja (TIPO_PAGO, PAGO_DIRECTO, ID_USUARIO, NUMERO_PAGO, ANULADO, DESCRIPCION, ID_CUENTA_BANCARIA, FECHA, COD_PROYECTO) VALUES (11, 1,'".$_SESSION['i']."','".str_pad($_POST['NUMERO_PAGO'], $row_rst_longitud['LONGITUD_NUMERO'], 0, STR_PAD_LEFT)."', 1, 'CHEQUE ANULADO ".$_POST['DESCRIPCION']."', ".$_POST['ID_CUENTA'].", now(), '".$_POST['PROYECTO']."')";
	//echo $query_detalle_banco;
	$detalle_banco = mysql_query($query_detalle_banco, $conexion) or die(mysql_error("aqui"));
		$ids=mysql_insert_id();
   aud($_SESSION['i'],$ids,'Anulacion de cheque en mov_banco_caja con el id ',36);

	mysql_select_db($database_conexion, $conexion);
	$query_CHEQUE = "UPDATE banco_chequeras SET ULTIMO_CHEQUE='".$_POST['NUMERO_PAGO']."' WHERE ID_CHEQUERA = ".$_POST['ID_CHEQUERA'];
	//echo $query_CHEQUE;
	$CHEQUE = mysql_query($query_CHEQUE, $conexion) or die(mysql_error());
		$ids=$_POST['ID_CHEQUERA'];
   aud($_SESSION['i'],$ids,'Modifico registro de banco_chequeras al nuevo ultimo cheque '.$_POST['NUMERO_PAGO'].' con el id chequera',36);

	?>
<script type="text/javascript">
<!--
alert("Proceso Completado con Exito.");
window.location = "../_cheque/list.php?titulo_formulario=Cheque%20Directo&activa=0&CUENTA=&BENEFICIARIO=&cheque=&MONTO=&MONTO_LETRAS=";
//window.location = "../pago_eliminar/del01.php?ID_PAGO=&ID_DOCUMENTO=&PROYECTO=&PROVEEDOR=&TIPO=&NUMERO=&FROM=&TO=&STATUS=0&button=Buscar";
//-->
</script>
<?php } ?>


