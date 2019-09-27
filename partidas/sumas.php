<?php require_once('../Connections/conexion.php'); ?>
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
$query_borrar = "UPDATE contabilidad_cuentas SET MONTO_PAGADO=0, MONTO_ASIGNADO=0";
$borrar = mysql_query($query_borrar, $conexion) or die(mysql_error());


mysql_select_db($database_conexion, $conexion);
$query_nivel_2 = "SELECT ID_CUENTA FROM contabilidad_cuentas WHERE TIPO = 2";
$nivel_2 = mysql_query($query_nivel_2, $conexion) or die(mysql_error());
$row_nivel_2 = mysql_fetch_assoc($nivel_2);
$totalRows_nivel_2 = mysql_num_rows($nivel_2);

mysql_select_db($database_conexion, $conexion);
$query_nivel_5 = "SELECT ID_CUENTA FROM contabilidad_cuentas WHERE NIVEL = 5 AND TIPO = 1";
$nivel_5 = mysql_query($query_nivel_5, $conexion) or die(mysql_error());
$row_nivel_5 = mysql_fetch_assoc($nivel_5);
$totalRows_nivel_5 = mysql_num_rows($nivel_5);

mysql_select_db($database_conexion, $conexion);
$query_nivel_4 = "SELECT ID_CUENTA FROM contabilidad_cuentas WHERE NIVEL = 4 AND TIPO = 1";
$nivel_4 = mysql_query($query_nivel_4, $conexion) or die(mysql_error());
$row_nivel_4 = mysql_fetch_assoc($nivel_4);
$totalRows_nivel_4 = mysql_num_rows($nivel_4);

mysql_select_db($database_conexion, $conexion);
$query_nivel_3 = "SELECT ID_CUENTA FROM contabilidad_cuentas WHERE NIVEL = 3 AND TIPO = 1";
$nivel_3 = mysql_query($query_nivel_3, $conexion) or die(mysql_error());
$row_nivel_3 = mysql_fetch_assoc($nivel_3);
$totalRows_nivel_3 = mysql_num_rows($nivel_3);


mysql_select_db($database_conexion, $conexion);
$query_nivel_2_ = "SELECT ID_CUENTA FROM contabilidad_cuentas WHERE NIVEL = 2 AND TIPO = 1";
$nivel_2_ = mysql_query($query_nivel_2_, $conexion) or die(mysql_error());
$row_nivel_2_ = mysql_fetch_assoc($nivel_2_);
$totalRows_nivel_2_ = mysql_num_rows($nivel_2_);

mysql_select_db($database_conexion, $conexion);
$query_nivel_1 = "SELECT ID_CUENTA FROM contabilidad_cuentas WHERE NIVEL = 1 AND TIPO = 1";
$nivel_1 = mysql_query($query_nivel_1, $conexion) or die(mysql_error());
$row_nivel_1 = mysql_fetch_assoc($nivel_1);
$totalRows_nivel_1 = mysql_num_rows($nivel_1);

mysql_select_db($database_conexion, $conexion);
$query_partidas = "SELECT ID_CUENTA, ID_ALICUOTA, PORCENTAJE_ALICUOTA FROM contabilidad_cuentas WHERE TIPO=13";
$contabilidad_cuentas = mysql_query($query_partidas, $conexion) or die(mysql_error());
$row_partidas = mysql_fetch_assoc($contabilidad_cuentas);
$totalRows_partidas = mysql_num_rows($contabilidad_cuentas);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Untitled Document</title>
<style type="text/css">
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
}
</style>
</head>

<body>

<p>&nbsp;</p><p>&nbsp;</p>
<p>&nbsp;</p>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td width="72%" align="center"><h1><strong>Actualizando Montos</strong></h1>
		<p><strong>(Espere unos segundo por favor)</strong></p></td>
		<td width="28%" align="center" valign="middle"><img src="../image/cargando.gif" width="48" height="48" /></td>
	</tr>
</table>


	<?php 
	
	if($totalRows_nivel_2 > 0){ do { ?>

		<?php 
		
			
					
			mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT sum(documentos.MONTO_GRABADO) AS SUMA_MONTO_GRABADO, sum(documentos.MONTO_EXENTO) AS SUMA_MONTO_EXENTO, sum(documentos.MONTO_IMPUESTO) AS SUMA_MONTO_IMPUESTO FROM documentos WHERE ID_CUENTA =".$row_nivel_2['ID_CUENTA'];
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error());
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			//echo $query_suma_tipo_2;
			echo $totalRows_suma_tipo_2;
			$query_pagos_partidas="SELECT SUM(MONTO_PAGADO) AS MONTO_PAGADO_PARTIDAS FROM vista_pagos_partidas WHERE ID_CUENTA=".$row_nivel_2['ID_CUENTA'];
			//echo $query_pagos_partidas;

			$vista_pagos_partidas = mysql_query($query_pagos_partidas, $conexion) or die(mysql_error());
			$row_pagos_partidas = mysql_fetch_assoc($vista_pagos_partidas);
		
			
			if($row_pagos_partidas['MONTO_PAGADO_PARTIDAS']!=null){
			$query_actualiza_pagos_partidas = "UPDATE contabilidad_cuentas SET MONTO_PAGADO=".$row_pagos_partidas['MONTO_PAGADO_PARTIDAS']." WHERE ID_CUENTA=".$row_nivel_2['ID_CUENTA'] ;
			
			$actualiza_pagos_partidas = mysql_query($query_actualiza_pagos_partidas, $conexion) or die(mysql_error());
			}

						
			//if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE contabilidad_cuentas SET MONTO_ASIGNADO=".($row_suma_tipo_2['SUMA_MONTO_GRABADO']+$row_suma_tipo_2['SUMA_MONTO_EXENTO']+$row_suma_tipo_2['SUMA_MONTO_GRABADO'])." WHERE ID_CUENTA=".$row_nivel_2['ID_CUENTA'] ;
			//echo $query_suma_2;
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error());

			//}

			
			
			
	
	?>
		<?php } while ($row_nivel_2 = mysql_fetch_assoc($nivel_2));}; ?>
		
		
		
		
		

<?php if($totalRows_nivel_5 > 0){ do { ?>
	<?php
			mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_ESTIMADO) AS SUMA_MONTO FROM contabilidad_cuentas WHERE TIPO=13 AND ID_GRUPO =".$row_nivel_5['ID_CUENTA'];
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error());
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			
			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE contabilidad_cuentas SET MONTO_ESTIMADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID_CUENTA=".$row_nivel_5['ID_CUENTA'] ;
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error());

			}
		
		
		
			mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_ASIGNADO) AS SUMA_MONTO FROM contabilidad_cuentas WHERE TIPO=13 AND ID_GRUPO =".$row_nivel_5['ID_CUENTA'];
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error());
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);

			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE contabilidad_cuentas SET MONTO_ASIGNADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID_CUENTA=".$row_nivel_5['ID_CUENTA'] ;
		
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error());
			//$row_suma_2 = mysql_fetch_assoc($suma_2);
			//$totalRows_suma_2 = mysql_num_rows($suma_2);

			}
			
			mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_PAGADO) AS SUMA_MONTO FROM contabilidad_cuentas WHERE TIPO=13 AND ID_GRUPO =".$row_nivel_5['ID_CUENTA'];
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error());
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			
			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE contabilidad_cuentas SET MONTO_PAGADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID_CUENTA=".$row_nivel_5['ID_CUENTA'] ;
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error());
			//$row_suma_2 = mysql_fetch_assoc($suma_2);
			//$totalRows_suma_2 = mysql_num_rows($suma_2);

			}
			
	
	?>
	<?php } while ($row_nivel_5 = mysql_fetch_assoc($nivel_5)); };?>

<?php if($totalRows_nivel_4 > 0){ do { ?>
	<?php
			mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_ESTIMADO) AS SUMA_MONTO FROM contabilidad_cuentas WHERE TIPO=13 AND ID_GRUPO =".$row_nivel_4['ID_CUENTA'];
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error()."sum_nivel_4");
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			
			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE contabilidad_cuentas SET MONTO_ESTIMADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID_CUENTA=".$row_nivel_4['ID_CUENTA'] ;
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error()."sum_nivel_4");
			//$row_suma_2 = mysql_fetch_assoc($suma_2);
			//$totalRows_suma_2 = mysql_num_rows($suma_2);
			
			}
		
		
		
			mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_ASIGNADO) AS SUMA_MONTO FROM contabilidad_cuentas WHERE TIPO=13 AND ID_GRUPO =".$row_nivel_4['ID_CUENTA'];
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error())."sum_nivel_4";
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE contabilidad_cuentas SET MONTO_ASIGNADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID_CUENTA=".$row_nivel_4['ID_CUENTA'] ;
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error()."sum_nivel_4");
			//$row_suma_2 = mysql_fetch_assoc($suma_2);
			//$totalRows_suma_2 = mysql_num_rows($suma_2);
			
			}
			
			
						mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_PAGADO) AS SUMA_MONTO FROM contabilidad_cuentas WHERE TIPO=13 AND ID_GRUPO =".$row_nivel_4['ID_CUENTA'];
			//echo $query_suma_tipo_2."<br>";
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error()."sum_nivel_4");
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			
			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE contabilidad_cuentas SET MONTO_PAGADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID_CUENTA=".$row_nivel_4['ID_CUENTA'] ;
			//echo $query_suma_2."<br>";
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error()."sum_nivel_4");

			
			}
	
	?>
	<?php } while ($row_nivel_4 = mysql_fetch_assoc($nivel_4)); };?>

<?php if($totalRows_nivel_3 > 0){do { ?>
	<?php
			mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_ESTIMADO) AS SUMA_MONTO FROM contabilidad_cuentas WHERE TIPO=13 AND ID_GRUPO =".$row_nivel_3['ID_CUENTA'];

			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error()."sum_nivel_3");
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			

			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE contabilidad_cuentas SET MONTO_ESTIMADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID_CUENTA=".$row_nivel_3['ID_CUENTA'] ;
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error()."sum_nivel_3");
			//$row_suma_2 = mysql_fetch_assoc($suma_2);
			//$totalRows_suma_2 = mysql_num_rows($suma_2);
			
			}
		
		
			mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_ASIGNADO) AS SUMA_MONTO FROM contabilidad_cuentas WHERE TIPO=13 AND ID_GRUPO =".$row_nivel_3['ID_CUENTA'];
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error()."sum_nivel_3");
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			
			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE contabilidad_cuentas SET MONTO_ASIGNADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID_CUENTA=".$row_nivel_3['ID_CUENTA'] ;
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error()."sum_nivel_3");
			//$row_suma_2 = mysql_fetch_assoc($suma_2);
			//$totalRows_suma_2 = mysql_num_rows($suma_2);
			
			}
			
			mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_PAGADO) AS SUMA_MONTO FROM contabilidad_cuentas WHERE TIPO=13 AND ID_GRUPO =".$row_nivel_3['ID_CUENTA'];
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error()."sum_nivel_3");
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			//echo $query_suma_tipo_2."<br>";
			
			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE contabilidad_cuentas SET MONTO_PAGADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID_CUENTA=".$row_nivel_3['ID_CUENTA'] ;
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error()."sum_nivel_3");
			//echo $query_suma_2."<br>";
			//$row_suma_2 = mysql_fetch_assoc($suma_2);
			//$totalRows_suma_2 = mysql_num_rows($suma_2);
			
			}
	
	?>
	<?php } while ($row_nivel_3 = mysql_fetch_assoc($nivel_3));}; ?>

<?php if($totalRows_nivel_2_ > 0){do { ?>
	<?php
			mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_ESTIMADO) AS SUMA_MONTO FROM contabilidad_cuentas WHERE TIPO=13 AND ID_GRUPO =".$row_nivel_2_['ID_CUENTA'];
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error()."sum_nivel_2");
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			
			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE contabilidad_cuentas SET MONTO_ESTIMADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID_CUENTA=".$row_nivel_2_['ID_CUENTA'] ;
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error()."sum_nivel_2");
			//$row_suma_2 = mysql_fetch_assoc($suma_2);
			//$totalRows_suma_2 = mysql_num_rows($suma_2);
			
			}
		
		
		
			mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_ASIGNADO) AS SUMA_MONTO FROM contabilidad_cuentas WHERE TIPO=13 AND ID_GRUPO =".$row_nivel_2_['ID_CUENTA'];
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error()."sum_nivel_2");
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			
			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE contabilidad_cuentas SET MONTO_ASIGNADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID_CUENTA=".$row_nivel_2_['ID_CUENTA'] ;
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error()."sum_nivel_2");
			//$row_suma_2 = mysql_fetch_assoc($suma_2);
			//$totalRows_suma_2 = mysql_num_rows($suma_2);
			
			}
			
						mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_PAGADO) AS SUMA_MONTO FROM contabilidad_cuentas WHERE TIPO=13 AND ID_GRUPO =".$row_nivel_2_['ID_CUENTA'];
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error()."sum_nivel_2");
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			
			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE contabilidad_cuentas SET MONTO_PAGADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID_CUENTA=".$row_nivel_2_['ID_CUENTA'] ;
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error()."sum_nivel_2");
			//$row_suma_2 = mysql_fetch_assoc($suma_2);
			//$totalRows_suma_2 = mysql_num_rows($suma_2);
			
			}
			
	
	?>
	<?php } while ($row_nivel_2_ = mysql_fetch_assoc($nivel_2_)); };?>

	<?php if($totalRows_nivel_1 > 0){do { ?>
		<?php
			mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_ESTIMADO) AS SUMA_MONTO FROM contabilidad_cuentas WHERE TIPO=13 AND ID_GRUPO =".$row_nivel_1['ID_CUENTA'];
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error()."sum_nivel_1");
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			
			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE contabilidad_cuentas SET MONTO_ESTIMADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID_CUENTA=".$row_nivel_1['ID_CUENTA'] ;
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error()."sum_nivel_1");
		
			
			}
		
		
		
			mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_ASIGNADO) AS SUMA_MONTO FROM contabilidad_cuentas WHERE TIPO=13 AND ID_GRUPO =".$row_nivel_1['ID_CUENTA'];
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error()."sum_nivel_1");
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			
			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE contabilidad_cuentas SET MONTO_ASIGNADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID_CUENTA=".$row_nivel_1['ID_CUENTA'] ;
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error()."sum_nivel_1");
			//$row_suma_2 = mysql_fetch_assoc($suma_2);
			//$totalRows_suma_2 = mysql_num_rows($suma_2);
			
			}
			
						mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_PAGADO) AS SUMA_MONTO FROM contabilidad_cuentas WHERE TIPO=13 AND ID_GRUPO =".$row_nivel_1['ID_CUENTA'];
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error()."sum_nivel_1");
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			
			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE contabilidad_cuentas SET MONTO_PAGADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID_CUENTA=".$row_nivel_1['ID_CUENTA'] ;
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error()."sum_nivel_1");
			//$row_suma_2 = mysql_fetch_assoc($suma_2);
			//$totalRows_suma_2 = mysql_num_rows($suma_2);
			
			}
			
	
	?>
		<?php } while ($row_nivel_1 = mysql_fetch_assoc($nivel_1));}; ?>
		
		




 <?php if($totalRows_partidas > 0){do { ?>
	<?php 

	$query_montos_alicuotas="SELECT MONTO_ASIGNADO,MONTO_DISPONIBLE,MONTO_ESTIMADO,MONTO_PAGADO FROM contabilidad_cuentas WHERE ID_CUENTA=".$row_partidas['ID_ALICUOTA'].";";
	//echo $query_montos_alicuotas;
	$montos_alicuotas = mysql_query($query_montos_alicuotas, $conexion) or die(mysql_error());
	
	$row_montos_alicuotas = mysql_fetch_assoc($montos_alicuotas);
	
	$v_monto_asignado=$row_montos_alicuotas['MONTO_ASIGNADO']*$row_partidas['PORCENTAJE_ALICUOTA']/100;
	$v_monto_disponible=$row_montos_alicuotas['MONTO_DISPONIBLE']*$row_partidas['PORCENTAJE_ALICUOTA']/100;
	$v_monto_estimado=$row_montos_alicuotas['MONTO_ESTIMADO']*$row_partidas['PORCENTAJE_ALICUOTA']/100;
	$v_monto_pagado=$row_montos_alicuotas['MONTO_PAGADO']*$row_partidas['PORCENTAJE_ALICUOTA']/100;
	
	$query_calcula_alicuotas="UPDATE contabilidad_cuentas SET MONTO_ASIGNADO=".$v_monto_asignado." , MONTO_DISPONIBLE=".$v_monto_disponible." , MONTO_ESTIMADO=".$v_monto_estimado." , MONTO_PAGADO=".$v_monto_pagado." WHERE ID_CUENTA=".$row_partidas['ID_CUENTA'].";";
	
	$calcula_alicuotas = mysql_query($query_calcula_alicuotas, $conexion) or die(mysql_error());
	?>
	<?php } while ($row_partidas = mysql_fetch_assoc($contabilidad_cuentas));}; ?>
<script type="text/javascript">
<!--
alert('Los monto fueron actualizados correctamente');
window.location = "index.php?titulo_formulario=<?php echo $_GET['titulo_formulario'] ?>"//-->
</script>

</body>
</html>
<?php
mysql_free_result($nivel_2);

mysql_free_result($nivel_5);

mysql_free_result($nivel_4);

mysql_free_result($contabilidad_cuentas);

//mysql_free_result($suma_tipo_2);
?>
