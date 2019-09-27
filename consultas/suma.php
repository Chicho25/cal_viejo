<?php require_once('../../Connections/conexion.php'); ?>
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
$query_borrar = "UPDATE partidas SET MONTO_PAGADO=0, MONTO_ASIGNADO=0";
$borrar = mysql_query($query_borrar, $conexion) or die(mysql_error());


mysql_select_db($database_conexion, $conexion);
$query_nivel_2 = "SELECT ID FROM partidas WHERE TIPO = 2 AND alicuota=0 ";
$nivel_2 = mysql_query($query_nivel_2, $conexion) or die(mysql_error());
$row_nivel_2 = mysql_fetch_assoc($nivel_2);
$totalRows_nivel_2 = mysql_num_rows($nivel_2);

mysql_select_db($database_conexion, $conexion);
$query_nivel_6 = "SELECT ID FROM partidas WHERE NIVEL = 6 AND TIPO = 1 AND ALICUOTA=0 ";
$nivel_6 = mysql_query($query_nivel_6, $conexion) or die(mysql_error());
$row_nivel_6 = mysql_fetch_assoc($nivel_6);
$totalRows_nivel_6 = mysql_num_rows($nivel_6);


mysql_select_db($database_conexion, $conexion);
$query_nivel_5 = "SELECT ID FROM partidas WHERE NIVEL = 5 AND TIPO = 1 AND ALICUOTA=0 ";
$nivel_5 = mysql_query($query_nivel_5, $conexion) or die(mysql_error());
$row_nivel_5 = mysql_fetch_assoc($nivel_5);
$totalRows_nivel_5 = mysql_num_rows($nivel_5);

mysql_select_db($database_conexion, $conexion);
$query_nivel_4 = "SELECT ID FROM partidas WHERE NIVEL = 4 AND TIPO = 1 AND ALICUOTA=0";
$nivel_4 = mysql_query($query_nivel_4, $conexion) or die(mysql_error());
$row_nivel_4 = mysql_fetch_assoc($nivel_4);
$totalRows_nivel_4 = mysql_num_rows($nivel_4);

mysql_select_db($database_conexion, $conexion);
$query_nivel_3 = "SELECT ID FROM partidas WHERE NIVEL = 3 AND TIPO = 1 AND ALICUOTA=0";
$nivel_3 = mysql_query($query_nivel_3, $conexion) or die(mysql_error());
$row_nivel_3 = mysql_fetch_assoc($nivel_3);
$totalRows_nivel_3 = mysql_num_rows($nivel_3);


mysql_select_db($database_conexion, $conexion);
$query_nivel_2_ = "SELECT ID FROM partidas WHERE NIVEL = 2 AND TIPO = 1 AND ALICUOTA=0";
$nivel_2_ = mysql_query($query_nivel_2_, $conexion) or die(mysql_error());
$row_nivel_2_ = mysql_fetch_assoc($nivel_2_);
$totalRows_nivel_2_ = mysql_num_rows($nivel_2_);

mysql_select_db($database_conexion, $conexion);
$query_nivel_1 = "SELECT ID FROM partidas WHERE NIVEL = 1 AND TIPO = 1 AND ALICUOTA=0";
$nivel_1 = mysql_query($query_nivel_1, $conexion) or die(mysql_error());
$row_nivel_1 = mysql_fetch_assoc($nivel_1);
$totalRows_nivel_1 = mysql_num_rows($nivel_1);

mysql_select_db($database_conexion, $conexion);
$query_partidas = "SELECT ID, ID_ALICUOTA, PORCENTAJE_ALICUOTA FROM partidas WHERE ALICUOTA = 1";
$partidas = mysql_query($query_partidas, $conexion) or die(mysql_error());
$row_partidas = mysql_fetch_assoc($partidas);
$totalRows_partidas = mysql_num_rows($partidas);


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
	
	do { ?>

		<?php 
		
			
					
			mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT sum(documentos.MONTO_GRABADO) AS SUMA_MONTO_GRABADO, sum(documentos.MONTO_EXENTO) AS SUMA_MONTO_EXENTO, sum(documentos.MONTO_IMPUESTO) AS SUMA_MONTO_IMPUESTO FROM documentos WHERE ID_PARTIDA =".$row_nivel_2['ID'];
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error()."yo");
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			
			$query_pagos_partidas="SELECT SUM(MONTO_PAGADO) AS MONTO_PAGADO_PARTIDAS FROM pagos_partidas WHERE ID_PARTIDA=".$row_nivel_2['ID'];
			//echo $query_pagos_partidas;

			$pagos_partidas = mysql_query($query_pagos_partidas, $conexion) or die(mysql_error()."yo");
			$row_pagos_partidas = mysql_fetch_assoc($pagos_partidas);
		
			
			if($row_pagos_partidas['MONTO_PAGADO_PARTIDAS']!=null){
			$query_actualiza_pagos_partidas = "UPDATE partidas SET MONTO_PAGADO=".$row_pagos_partidas['MONTO_PAGADO_PARTIDAS']." WHERE ID=".$row_nivel_2['ID'] ;
			
			$actualiza_pagos_partidas = mysql_query($query_actualiza_pagos_partidas, $conexion) or die(mysql_error());
			}

						
			//if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE partidas SET MONTO_ASIGNADO=".($row_suma_tipo_2['SUMA_MONTO_GRABADO']+$row_suma_tipo_2['SUMA_MONTO_EXENTO']+$row_suma_tipo_2['SUMA_MONTO_GRABADO'])." WHERE ID=".$row_nivel_2['ID'] ;
			//echo $query_suma_2;
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error());

			//}

			
			
			
	
	?>
		<?php } while ($row_nivel_2 = mysql_fetch_assoc($nivel_2)); ?>
		
		
		
		
	<?php do { ?>
	<?php
			mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_ESTIMADO) AS SUMA_MONTO FROM partidas WHERE ALICUOTA=0 AND ID_GRUPO =".$row_nivel_6['ID'];
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error()."sum_tipo_2");
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			
			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE partidas SET MONTO_ESTIMADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID=".$row_nivel_6['ID'] ;
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error())."sum_tipo_2";

			}
		
		
		
			mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_ASIGNADO) AS SUMA_MONTO FROM partidas WHERE ALICUOTA=0 AND ID_GRUPO =".$row_nivel_6['ID'];
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error()."sum_tipo_2");
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);

			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE partidas SET MONTO_ASIGNADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID=".$row_nivel_6['ID'] ;
		
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error()."sum_tipo_2");
			}
			
			mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_PAGADO) AS SUMA_MONTO FROM partidas WHERE ALICUOTA=0 AND ID_GRUPO =".$row_nivel_6['ID'];
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error()."sum_tipo_2");
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			
			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE partidas SET MONTO_PAGADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID=".$row_nivel_6['ID'] ;
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error()."sum_tipo_2");
			}
			
	
	?>
	<?php } while ($row_nivel_6 = mysql_fetch_assoc($nivel_6)); ?>
    	

<?php do { ?>
	<?php
			mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_ESTIMADO) AS SUMA_MONTO FROM partidas WHERE ALICUOTA=0 AND ID_GRUPO =".$row_nivel_5['ID'];
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error()."sum_tipo_2");
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			
			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE partidas SET MONTO_ESTIMADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID=".$row_nivel_5['ID'] ;
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error())."sum_tipo_2";

			}
		
		
		
			mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_ASIGNADO) AS SUMA_MONTO FROM partidas WHERE ALICUOTA=0 AND ID_GRUPO =".$row_nivel_5['ID'];
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error()."sum_tipo_2");
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);

			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE partidas SET MONTO_ASIGNADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID=".$row_nivel_5['ID'] ;
		
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error()."sum_tipo_2");
			//$row_suma_2 = mysql_fetch_assoc($suma_2);
			//$totalRows_suma_2 = mysql_num_rows($suma_2);

			}
			
			mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_PAGADO) AS SUMA_MONTO FROM partidas WHERE ALICUOTA=0 AND ID_GRUPO =".$row_nivel_5['ID'];
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error()."sum_tipo_2");
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			
			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE partidas SET MONTO_PAGADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID=".$row_nivel_5['ID'] ;
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error()."sum_tipo_2");
			//$row_suma_2 = mysql_fetch_assoc($suma_2);
			//$totalRows_suma_2 = mysql_num_rows($suma_2);

			}
			
	
	?>
	<?php } while ($row_nivel_5 = mysql_fetch_assoc($nivel_5)); ?>

<?php do { ?>
	<?php
			mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_ESTIMADO) AS SUMA_MONTO FROM partidas WHERE ALICUOTA=0 AND ID_GRUPO =".$row_nivel_4['ID'];
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error()."sum_nivel_4");
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			
			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE partidas SET MONTO_ESTIMADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID=".$row_nivel_4['ID'] ;
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error()."sum_nivel_4");
			//$row_suma_2 = mysql_fetch_assoc($suma_2);
			//$totalRows_suma_2 = mysql_num_rows($suma_2);
			
			}
		
		
		
			mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_ASIGNADO) AS SUMA_MONTO FROM partidas WHERE ALICUOTA=0 AND ID_GRUPO =".$row_nivel_4['ID'];
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error())."sum_nivel_4";
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE partidas SET MONTO_ASIGNADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID=".$row_nivel_4['ID'] ;
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error()."sum_nivel_4");
			//$row_suma_2 = mysql_fetch_assoc($suma_2);
			//$totalRows_suma_2 = mysql_num_rows($suma_2);
			
			}
			
			
						mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_PAGADO) AS SUMA_MONTO FROM partidas WHERE ALICUOTA=0 AND ID_GRUPO =".$row_nivel_4['ID'];
			//echo $query_suma_tipo_2."<br>";
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error()."sum_nivel_4");
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			
			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE partidas SET MONTO_PAGADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID=".$row_nivel_4['ID'] ;
			//echo $query_suma_2."<br>";
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error()."sum_nivel_4");

			
			}
	
	?>
	<?php } while ($row_nivel_4 = mysql_fetch_assoc($nivel_4)); ?>

<?php do { ?>
	<?php
			mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_ESTIMADO) AS SUMA_MONTO FROM partidas WHERE ALICUOTA=0 AND ID_GRUPO =".$row_nivel_3['ID'];

			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error()."sum_nivel_3");
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			

			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE partidas SET MONTO_ESTIMADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID=".$row_nivel_3['ID'] ;
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error()."sum_nivel_3");
			//$row_suma_2 = mysql_fetch_assoc($suma_2);
			//$totalRows_suma_2 = mysql_num_rows($suma_2);
			
			}
		
		
			mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_ASIGNADO) AS SUMA_MONTO FROM partidas WHERE ALICUOTA=0 AND ID_GRUPO =".$row_nivel_3['ID'];
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error()."sum_nivel_3");
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			
			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE partidas SET MONTO_ASIGNADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID=".$row_nivel_3['ID'] ;
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error()."sum_nivel_3");
			//$row_suma_2 = mysql_fetch_assoc($suma_2);
			//$totalRows_suma_2 = mysql_num_rows($suma_2);
			
			}
			
			mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_PAGADO) AS SUMA_MONTO FROM partidas WHERE ALICUOTA=0 AND ID_GRUPO =".$row_nivel_3['ID'];
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error()."sum_nivel_3");
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			//echo $query_suma_tipo_2."<br>";
			
			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE partidas SET MONTO_PAGADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID=".$row_nivel_3['ID'] ;
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error()."sum_nivel_3");
			//echo $query_suma_2."<br>";
			//$row_suma_2 = mysql_fetch_assoc($suma_2);
			//$totalRows_suma_2 = mysql_num_rows($suma_2);
			
			}
	
	?>
	<?php } while ($row_nivel_3 = mysql_fetch_assoc($nivel_3)); ?>

<?php do { ?>
	<?php
			mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_ESTIMADO) AS SUMA_MONTO FROM partidas WHERE ALICUOTA=0 AND ID_GRUPO =".$row_nivel_2_['ID'];
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error()."sum_nivel_2");
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			
			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE partidas SET MONTO_ESTIMADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID=".$row_nivel_2_['ID'] ;
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error()."sum_nivel_2");
			//$row_suma_2 = mysql_fetch_assoc($suma_2);
			//$totalRows_suma_2 = mysql_num_rows($suma_2);
			
			}
		
		
		
			mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_ASIGNADO) AS SUMA_MONTO FROM partidas WHERE ALICUOTA=0 AND ID_GRUPO =".$row_nivel_2_['ID'];
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error()."sum_nivel_2");
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			
			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE partidas SET MONTO_ASIGNADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID=".$row_nivel_2_['ID'] ;
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error()."sum_nivel_2");
			//$row_suma_2 = mysql_fetch_assoc($suma_2);
			//$totalRows_suma_2 = mysql_num_rows($suma_2);
			
			}
			
						mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_PAGADO) AS SUMA_MONTO FROM partidas WHERE ALICUOTA=0 AND ID_GRUPO =".$row_nivel_2_['ID'];
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error()."sum_nivel_2");
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			
			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE partidas SET MONTO_PAGADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID=".$row_nivel_2_['ID'] ;
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error()."sum_nivel_2");
			//$row_suma_2 = mysql_fetch_assoc($suma_2);
			//$totalRows_suma_2 = mysql_num_rows($suma_2);
			
			}
			
	
	?>
	<?php } while ($row_nivel_2_ = mysql_fetch_assoc($nivel_2_)); ?>

	<?php do { ?>
		<?php
			mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_ESTIMADO) AS SUMA_MONTO FROM partidas WHERE ALICUOTA=0 AND ID_GRUPO =".$row_nivel_1['ID'];
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error()."sum_nivel_1");
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			
			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE partidas SET MONTO_ESTIMADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID=".$row_nivel_1['ID'] ;
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error()."sum_nivel_1");
		
			
			}
		
		
		
			mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_ASIGNADO) AS SUMA_MONTO FROM partidas WHERE ALICUOTA=0 AND ID_GRUPO =".$row_nivel_1['ID'];
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error()."sum_nivel_1");
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			
			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE partidas SET MONTO_ASIGNADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID=".$row_nivel_1['ID'] ;
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error()."sum_nivel_1");
			//$row_suma_2 = mysql_fetch_assoc($suma_2);
			//$totalRows_suma_2 = mysql_num_rows($suma_2);
			
			}
			
						mysql_select_db($database_conexion, $conexion);
			$query_suma_tipo_2 = "SELECT SUM(MONTO_PAGADO) AS SUMA_MONTO FROM partidas WHERE ALICUOTA=0 AND ID_GRUPO =".$row_nivel_1['ID'];
			
			$suma_tipo_2 = mysql_query($query_suma_tipo_2, $conexion) or die(mysql_error()."sum_nivel_1");
			$row_suma_tipo_2 = mysql_fetch_assoc($suma_tipo_2);
			$totalRows_suma_tipo_2 = mysql_num_rows($suma_tipo_2);
			
			
			if(($row_suma_tipo_2['SUMA_MONTO'])!=null){
			$query_suma_2 = "UPDATE partidas SET MONTO_PAGADO=".$row_suma_tipo_2['SUMA_MONTO']." WHERE ID=".$row_nivel_1['ID'] ;
			
			$suma_2 = mysql_query($query_suma_2, $conexion) or die(mysql_error()."sum_nivel_1");
			//$row_suma_2 = mysql_fetch_assoc($suma_2);
			//$totalRows_suma_2 = mysql_num_rows($suma_2);
			
			}
			
	
	?>
		<?php } while ($row_nivel_1 = mysql_fetch_assoc($nivel_1)); ?>
		
		




<?php do { ?>
	<?php 

	$query_montos_alicuotas="SELECT MONTO_ASIGNADO,MONTO_DISPONIBLE,MONTO_ESTIMADO,MONTO_PAGADO FROM partidas WHERE ID=".$row_partidas['ID_ALICUOTA'].";";
	//echo $query_montos_alicuotas;
	$montos_alicuotas = mysql_query($query_montos_alicuotas, $conexion) or die(mysql_error()."sum_nivel_0.1 partida".$row_partidas['ID']);
	
	$row_montos_alicuotas = mysql_fetch_assoc($montos_alicuotas);
	
	$v_monto_asignado=$row_montos_alicuotas['MONTO_ASIGNADO']*$row_partidas['PORCENTAJE_ALICUOTA']/100;
	$v_monto_disponible=$row_montos_alicuotas['MONTO_DISPONIBLE']*$row_partidas['PORCENTAJE_ALICUOTA']/100;
	$v_monto_estimado=$row_montos_alicuotas['MONTO_ESTIMADO']*$row_partidas['PORCENTAJE_ALICUOTA']/100;
	$v_monto_pagado=$row_montos_alicuotas['MONTO_PAGADO']*$row_partidas['PORCENTAJE_ALICUOTA']/100;
	
	$query_calcula_alicuotas="UPDATE partidas SET MONTO_ASIGNADO=".$v_monto_asignado." , MONTO_DISPONIBLE=".$v_monto_disponible." , MONTO_ESTIMADO=".$v_monto_estimado." , MONTO_PAGADO=".$v_monto_pagado." WHERE ID=".$row_partidas['ID'].";";
	
	$calcula_alicuotas = mysql_query($query_calcula_alicuotas, $conexion) or die(mysql_error()."sum_nivel_0");
	?>
	<?php } while ($row_partidas = mysql_fetch_assoc($partidas)); ?>
<script type="text/javascript">
<!--

window.location = "consultas2.php";
//-->
</script>

</body>
</html>
<?php
mysql_free_result($nivel_2);

mysql_free_result($nivel_5);

mysql_free_result($nivel_4);

mysql_free_result($partidas);

mysql_free_result($suma_tipo_2);
?>
