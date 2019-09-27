<?php 
include('../include/header.php'); 

?>

<?php 
if($_GET['MODULO']==1){$menu=13;}else{$menu=21;}

if(isset($_GET['descripcion']) && $_GET['descripcion']==''){ ?> <script type="text/javascript">alert("Debe colocar una descripcion para realizar este pago..."); window.location="list.php?modulo=1&titulo_formulario=<?php echo $_GET['titulo_formulario']; ?>";</script><?php } else {
	
	 if(isset($_GET['id_cuenta_bancaria']) && $_GET['id_cuenta_bancaria']==''){ ?> <script type="text/javascript">alert("Debe seleccionar el numero de cuenta con el cual se va a generar el pago..."); window.location="list.php?modulo=1&titulo_formulario=<?php echo $_GET['titulo_formulario']; ?>";</script><?php } else {

	/*	echo  $_GET['numero'];
 if (existe_cheque($_GET['id_cuenta_bancaria'],$_GET['numero'])=='Verdadero'){ ?>
 <script type="text/javascript">alert("Este numero de cheque ya existe por favor revise e intente de nuevo..."); window.location="list.php?modulo=1";</script> ; <?php }	*/
	 
		 
/*$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
*/
		$query_rst_tabla = "DROP TABLE IF EXISTS temp".$_SESSION['i'];
		$rst_tabla = mysql_query($query_rst_tabla, $conexion) or die(mysql_error());
		$query_rst_tabla = "CREATE TABLE temp".$_SESSION['i']." (
						  `ID_DOCUMENTO` int(11) NOT NULL DEFAULT '0',
						  `MONTO_PAGADO` double DEFAULT NULL,
						  `ID_USUARIO` int(11) NOT NULL
							) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
				$rst_tabla = mysql_query($query_rst_tabla, $conexion) or die(mysql_error());
				
				for($i=1; $i<=$_GET['CANT']; $i++){
					if ($_GET['monto'.$i] > 0){
					$sql="INSERT INTO temp".$_SESSION['i']. "(ID_DOCUMENTO, MONTO_PAGADO, ID_USUARIO) values
					('".$_GET['ID_DOCUMENTO_'.$i]."', '".$_GET['monto'.$i]."', '".$_SESSION['i']."')";
					$rst_tabla = mysql_query($sql, $conexion) or die(mysql_error());
					$ids=mysql_insert_id();
   aud($_SESSION['i'],$ids,'Creo tabla temporal ',$menu);
				}}
				 
				
					$tabla="temp".$_SESSION['i'];
					$fechas= DMAtoAMD($_GET['fecha']);
					$descripciones=$_GET['descripcion'];
					$anulado=0;
					$usuarios=$_SESSION['i'];
					$cantidades=$_GET['CANT'];
					$tablas=$tabla;
					$pagos=$_GET['Tpago'];
					$numeros=$_GET['numero'];
					$id_banco=$_GET['id_cuenta_bancaria'];
					$montos= str_replace(",","", $_GET['total_quantity']);
					$proyectos=$_GET['proyecto'];

 				
					
$sql1="INSERT INTO pagos
  (FECHA,
   ANULADO,
  ID_USUARIO,
  DESCRIPCION)
  VALUES
  ('".$fechas."',
   ".$anulado.",
  '".$usuarios."',
  '".$descripciones."')";
  $rst_tabla = mysql_query($sql1, $conexion) or die(mysql_error());
  $V_ID_PAGO=mysql_insert_id();
//echo $V_ID_PAGO;
$ids=mysql_insert_id();
   aud($_SESSION['i'],$ids,'Creo registro en pago con id ',$menu);
//SET V_TABLA=P_TABLA;
$sql2="INSERT INTO pagos_detalle (ID_PAGO, ID_DOCUMENTO, MONTO_PAGADO)
 SELECT ".$V_ID_PAGO." AS ID_PAGO, B.ID_DOCUMENTO as ID_DOCUMENTO, B.MONTO_PAGADO as MONTO_PAGADO FROM ".$tabla." AS B";
//echo $sql2;
 $rst_tabla = mysql_query($sql2, $conexion) or die(mysql_error());
$ids=mysql_insert_id();
   aud($_SESSION['i'],$ids,'Creo registro en pagos_detalle con id ',$menu);




$sql3="INSERT INTO mov_banco_caja (
  ID_PAGO,
  TIPO_PAGO,
  NUMERO_PAGO,
  FECHA,
  DESCRIPCION,
  MONTO,
  ID_CUENTA_BANCARIA,
  ID_USUARIO,
  COD_PROYECTO)
  VALUES
  (".$V_ID_PAGO.",
  ".$pagos.",
  '".$numeros."',
  '".$fechas."',
  '".$descripciones."',
  ".$montos.",
  ".$id_banco.",
  ".$usuarios.",
  '".$proyectos."')";
// echo $sql3;
  $rst_tabla = mysql_query($sql3, $conexion) or die(mysql_error());
 $ids=mysql_insert_id();
   aud($_SESSION['i'],$ids,'Creo registro en movimiento banco caja con id ',$menu);

   ?>
   
 <script type="text/javascript">
 alert("Se realizo con exito la operacion...");
  window.location="list.php?titulo_formulario=<?php echo $_GET['titulo_formulario']; ?>&modulo=<?php echo $_GET['MODULO']; ?>"; </script>

	<?php
	 }}
									 	
/*$mysqli = new mysqli("localhost", "grupocal_root", "compaq12", "grupocal_calpe");
if (mysqli_connect_errno()) {printf("Connect failed: %s\n", mysqli_connect_error()); exit();}

$query = "CALL sp_pagos('$fechas', '$descripciones', '$anulado', $usuarios, $cantidades, '$tablas', $pagos, '$numeros', $id_banco, $montos, $id_banco, '$proyectos')";

//echo $query;
	
if ($result = $mysqli->query($query)) {echo '<script language="javascript">alert("El procedimiento se ejecuto correctamente.");location.href="../pagos/list.php?titulo_menu=Pagos";</script>';}
	/*}
} else {echo  '<script language="javascript">alert("No se ingreso un monto a ninguno de los documentos.");  history.go(-1);</script>';}*/
?>
