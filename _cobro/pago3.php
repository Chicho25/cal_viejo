<?php require_once('../../Connections/conexion.php'); ?>
<?php function changueFormatDate($cdate){
    list($day,$month,$year)=explode("/",$cdate);
    return $year."-".$month."-".$day;
}?>
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

 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<style type="text/css">
.texto {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 16px;
	color: #444;
}
</style>
<script>//alert("Modo Debug")</script>
</head>

<body style="color:#FFF">

<br />
<br />
<br /><center>
<div class="texto" >
Guardando.......</br>
<img src="../image/cargando.gif" width="48" height="48" /></div></center>
<?php mysql_select_db($database_conexion, $conexion);?>

<?php 

//echo $conexion;

//echo $_POST['cantidad'];
$fecha = changueFormatDate($_POST['fecha']); 
mysql_select_db($database_conexion, $conexion);
$query_pago = "INSERT INTO pagos (fecha, descripcion) VALUES ('".$fecha."', '".$_POST['descripcion']."')";
echo "Pago:".$query_pago."</br>";
$pago = mysql_query($query_pago, $conexion) or die(mysql_error());
$id_pago=mysql_insert_id();
//mysql_free_result($pago);

		$query_afecta_banco = "SELECT AFECTA_BANCO FROM tesoreria_tipo_mov WHERE ID_TESORERIA_TIPO_MOV = ".$_POST['TIPO_PAGO'];
		echo $query_afecta_banco;
		$afecta_banco = mysql_query($query_afecta_banco, $conexion) or die(mysql_error());
		$row_afecta_banco = mysql_fetch_assoc($afecta_banco);
		$totalRows_afecta_banco = mysql_num_rows($afecta_banco);

$total=0;
for ($i = 1; $i <= $_POST['cantidad']; $i++) {
	$total=$total+$_POST['monto'.$i];
	//echo $total;
	
	$query_pago_detalle = "INSERT INTO pagos_detalle (ID_DOCUMENTO,  ID_PAGO, MONTO_PAGADO) VALUES ('".$_POST['id_documento_'.$i]."', '".$id_pago."', '".$_POST['monto'.$i]."')";
	echo "Pago detalle:".$query_pago_detalle."</br>";
	if($_POST['monto'.$i]>0){
	$pago_detalle = mysql_query($query_pago_detalle, $conexion) or die(mysql_error());
	}
	
	
		mysql_select_db($database_conexion, $conexion);
		$query_monto_pagado = "SELECT SUM(MONTO_PAGADO) as TOTAL_PAGADO FROM pagos_detalle WHERE ID_DOCUMENTO = ".$_POST['id_documento_'.$i];
		$monto_pagado = mysql_query($query_monto_pagado, $conexion) or die(mysql_error());
		$row_monto_pagado = mysql_fetch_assoc($monto_pagado);
		$totalRows_monto_pagado = mysql_num_rows($monto_pagado);
		
		$query_monto_documentos = "SELECT * FROM documentos WHERE ID_DOCUMENTO = ".$_POST['id_documento_'.$i];
		$monto_documentos = mysql_query($query_monto_documentos, $conexion) or die(mysql_error());
		$row_monto_documentos = mysql_fetch_assoc($monto_documentos);
		$totalRows_monto_documentos = mysql_num_rows($monto_documentos);
		

		
		mysql_select_db($database_conexion, $conexion);
		$query_documentos_montos = "SELECT * FROM documentos WHERE ID_DOCUMENTO =".$_POST['id_documento_'.$i];
		$documentos_montos = mysql_query($query_documentos_montos, $conexion) or die(mysql_error());
		$row_documentos_montos = mysql_fetch_assoc($documentos_montos);
		$totalRows_documentos_montos = mysql_num_rows($documentos_montos);
		
		//echo $row_documentos_montos['MONTO_EXENTO']; ?><?php echo $row_documentos_montos['MONTO_GRABADO']; ?><?php echo $row_documentos_montos['MONTO_IMPUESTO'];
		echo $row_monto_pagado['TOTAL_PAGADO']."/".($row_documentos_montos['MONTO_EXENTO']+$row_documentos_montos['MONTO_GRABADO']+$row_documentos_montos['MONTO_IMPUESTO'])."</br>"."</br>"."</br>"."</br>";
		
		
		if($row_monto_pagado['TOTAL_PAGADO']==($row_documentos_montos['MONTO_EXENTO']+$row_documentos_montos['MONTO_GRABADO']+$row_documentos_montos['MONTO_IMPUESTO'])){
		$query_documentos = "UPDATE documentos SET STATUS_PENDIENTE=0 WHERE ID_DOCUMENTO = ".$_POST['id_documento_'.$i];
		echo $query_documentos;
		
		echo "wwwwwwwwww";
		}

	
	

}
	
	if($row_afecta_banco['AFECTA_BANCO']==0)
	{
		$query_detalle_banco = "INSERT INTO mov_banco_caja (ID_PAGO, TIPO_PAGO, MONTO,FECHA, DESCRIPCION, COD_PROYECTO, NUMERO_PAGO) VALUES ('".$id_pago."', '".$_POST['TIPO_PAGO']."', ".$total.",'".$fecha."', '".$_POST['descripcion']."', '".$_POST['CODIGO']."', '".$_POST['numero_nobanco']."')";
		echo $query_detalle_banco."<br>";
		
	}
	else //if ($_POST['TIPO_PAGO']==2||$_POST['TIPO_PAGO']==27)
	{
		$query_detalle_banco = "INSERT INTO mov_banco_caja (ID_PAGO, TIPO_PAGO, MONTO,ID_CUENTA_BANCARIA,NUMERO_PAGO,FECHA, COD_PROYECTO, DESCRIPCION) VALUES ('".$id_pago."', '".$_POST['TIPO_PAGO']."', '".$total."', '".$_POST['id_cuenta_bancaria']."', '".$_POST['numero_banco']."', '".$fecha."', '".$_POST['CODIGO']."', '".$_POST['descripcion']."')";
		echo $query_detalle_banco."<br>";
	
	}
	/*else if ($_POST['TIPO_PAGO']==4)
	{
		$query_detalle_banco = "INSERT INTO mov_banco_caja (ID_PAGO, TIPO_PAGO, MONTO,ID_CUENTA_BANCARIA, FECHA, COD_PROYECTO, DESCRIPCION) VALUES ('".$id_pago."', '".$_POST['TIPO_PAGO']."', '".$total."', '".$_POST['id_cuenta_bancaria_cheque']."', '".$fecha."', '".$_POST['CODIGO']."', '".$_POST['descripcion']."')";
		echo $query_detalle_banco."<br>";
	
	}*/
$detalle_banco = mysql_query($query_detalle_banco, $conexion) or die(mysql_error());


//mysql_select_db($database_conexion, $conexion);
//$query_detalle_banco = "INSERT INTO mov_banco_caja (ID_PAGO, TIPO_PAGO, NUMERO_PAGO, FECHA, DESCRIPCION, MONTO, ID_CUENTA_BANCARIA) VALUES ('".$id_pago."', '".$_POST['tipo_pago'].",'".$_POST['tipo_pago']."', '".$_POST['tipo_numero_pago']."' , '".$_POST['fecha']."', '".$_POST['descripcion']."', '".$_POST['monto']."', '".$_POST['id_cuenta_bancaria']."')";
//echo $query_detalle_banco;
//$pago = mysql_query($query_pago, $conexion) or die(mysql_error());
//$id_pago=mysql_insert_id();
//mysql_free_result($pago);




?>-->
<?php 

		$query_pago = "SELECT * FROM pagos_partidas WHERE ID_PAGO = ".$id_pago;
		$pago = mysql_query($query_pago, $conexion) or die(mysql_error());
		$row_pago = mysql_fetch_assoc($pago);
		$totalRows_pago = mysql_num_rows($pago);
		
		if($totalRows_pago>=1){
?>

<script type="text/javascript">
<!--
alert("Proceso Completado con Exito.");
window.location = "pago_proyecto.php";
//-->
</script>
<?php 
		}else{
?> 
<script type="text/javascript">
<!--
alert("Pago #<?php echo $id_pago ?> no guardado correctamente.");
window.location = "pago_proyecto.php";
//-->
</script><?php
			
			
			}
		
?>
</body>
</html>
<?php
mysql_free_result($documentos_montos);

mysql_free_result($Recordset1);

mysql_free_result($monto_pagado);
?>
