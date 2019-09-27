<?php include('../include/header.php'); 

$query_cerrados = "SELECT * FROM mov_banco_caja WHERE ID_MOV_BANCO_CAJA = ".$_GET['ID_MOV_BANCO_CAJA'];
$cerrados = mysql_query($query_cerrados, $conexion) or die(mysql_error());
$row_cerrados = mysql_fetch_assoc($cerrados);
$totalRows_cerrados = mysql_num_rows($cerrados);
/*	if ($row_cerrados['NUMERO_PAGO']!="" && $row_cerrados['TIPO_PAGO']==11){
*/		//$query_detalle_bancos = "INSERT INTO mov_banco_caja (TIPO_PAGO, NUMERO_PAGO, ANULADO, DESCRIPCION, ID_CUENTA_BANCARIA, FECHA, COD_PROYECTO) VALUES (11,'".$row_cerrados['NUMERO_PAGO']."', 1, 'CHEQUE ANULADO Eliminacion del cheque por el banco', ".$row_cerrados['ID_CUENTA_BANCARIA'].", now(), '".$row_cerrados['COD_PROYECTO']."')";
	//echo $query_detalle_banco;
		if ($row_cerrados['PAGO_DIRECTO']==1){

	$query_detalle_bancos = "UPDATE mov_banco_caja SET ID_USUARIO=".$_SESSION['i'].", ANULADO=1, DESCRIPCION='CHEQUE ANULADO Eliminacion del movimiento bancario', MONTO=0 WHERE ID_MOV_BANCO_CAJA=".$_GET['ID_MOV_BANCO_CAJA'];
	$detalle_banco = mysql_query($query_detalle_bancos, $conexion) or die(mysql_error());
	$ids=mysql_insert_id();
   aud($_SESSION['i'],$ids,'Anulacion de cheque en mov_banco_caja con el id ',24);

	} else {
	
/*if ((isset($_GET['ID_MOV_BANCO_CAJA'])) && ($_GET['ID_MOV_BANCO_CAJA'] != "")) {*/
  $deleteSQL = sprintf("DELETE FROM mov_banco_caja WHERE ID_MOV_BANCO_CAJA=%s",
                       GetSQLValueString($_GET['ID_MOV_BANCO_CAJA'], "int"));
					   //echo $deleteSQL;

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($deleteSQL, $conexion) or die(mysql_error());
 $ids=$_GET['ID_MOV_BANCO_CAJA'];
aud($_SESSION['i'], $ids,'Elimino registro en mov_banco_caja con el id ',24);
}
?>
 <script type="text/javascript">
alert("Proceso Completado con Exito.");
 window.location="../_mov_bancarios/index.php?titulo_formulario=Movimientos%20Bancarios";

</script>
