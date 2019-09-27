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

$colname_principal = "-1";
if (isset($_POST['elegido'])) {
  $colname_principal = $_POST['elegido'];
}
mysql_select_db($database_conexion, $conexion);
$query_principal = sprintf("SELECT * FROM partidas WHERE ID = %s", GetSQLValueString($colname_principal, "int"));
$principal = mysql_query($query_principal, $conexion) or die(mysql_error());
$row_principal = mysql_fetch_assoc($principal);
$totalRows_principal = mysql_num_rows($principal);

$colname_secundario = "-1";
if (isset($_POST['elegido'])) {
  $colname_secundario = $_POST['elegido'];
}
mysql_select_db($database_conexion, $conexion);
$query_secundario = sprintf("SELECT * FROM partidas WHERE ALICUOTA=0 AND ID_GRUPO = %s ORDER BY ORDEN", GetSQLValueString($colname_secundario, "int"));
$secundario = mysql_query($query_secundario, $conexion) or die(mysql_error());
$row_secundario = mysql_fetch_assoc($secundario);
$totalRows_secundario = mysql_num_rows($secundario);
//echo $query_secundario;
mysql_select_db($database_conexion, $conexion);
$query_alicuota = sprintf("SELECT * FROM partidas WHERE ALICUOTA=1 AND ID_GRUPO = %s ORDER BY ORDEN", GetSQLValueString($colname_secundario, "int"));
$alicuota = mysql_query($query_alicuota, $conexion) or die(mysql_error());
$row_alicuota = mysql_fetch_assoc($alicuota);
$totalRows_alicuota = mysql_num_rows($alicuota);
?>
<link href="../css/redmond/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css">
<?php $total_estimado=0; ?>
<table width="1000" border="0" cellspacing="1" cellpadding="2" bgcolor="#999999" align="center">
	<tr class="ui-widget-header">
		<td colspan="2" align="center"><strong>Partida</strong></td>
		<td width="150" align="center"><strong>Estimado</strong></td>
		<!--<td width="150" align="center"><strong>Asignado</strong></td>-->
		<td width="150" align="center"><strong>Pagado</strong></td>
		<td width="150" align="center"><strong>Restante</strong></td>
	</tr>
</table>
<?php
$nombres="";
$estimado="";
?>
<?php if ($totalRows_secundario > 0) { // Show if recordset not empty ?>
<?php do { ?>
<?php 
if($nombres==""){
	$nombres=$row_secundario['DESCRIPCION'];
	$estimado=$row_secundario['MONTO_ESTIMADO'];
}else{
	$nombres=$nombres."|".$row_secundario['DESCRIPCION'];
	$estimado=$estimado."|".$row_secundario['MONTO_ESTIMADO'];
}
?>
<table width="1000" border="0" cellspacing="1" cellpadding="2" bgcolor="#999999" align="center">
	<tr class="textos_form" bgcolor="#FFFFFF">
		<td width="30" align="right" bgcolor="#FFFFFF"><?php echo $row_secundario['ID']; ?></td>
		<td bgcolor="#FFFFFF"><?php echo $row_secundario['DESCRIPCION']; ?></td>
		<!--<td width="150" align="right" bgcolor="#FFFFFF">
	
	
	
	
	<?php echo number_format($row_secundario['MONTO_ASIGNADO'],2,',','.'); ?></td>-->
		<td width="150" align="right" bgcolor="#FFFFFF"><?php echo number_format($row_secundario['MONTO_ESTIMADO'],2); ?></td>
		<td width="150" align="right" bgcolor="#FFFFFF"><?php echo number_format($row_secundario['MONTO_PAGADO'],2); ?></td>
		<?php 
	$monto_restante=$row_secundario['MONTO_ESTIMADO']-$row_secundario['MONTO_PAGADO'];
	?>
		<td width="150" align="right" <?php if($monto_restante<0){ echo "bgcolor='#ffcaca'"; } ?>><?php echo number_format($monto_restante,2);  ?></td>
		<?php $total_estimado=$total_estimado+$row_secundario['MONTO_ESTIMADO'];?>
	</tr>
	<?php } while ($row_secundario = mysql_fetch_assoc($secundario)); ?>
	<?php } // Show if recordset not empty ?>
</table>
<table width="1000" border="0" cellspacing="1" cellpadding="2" bgcolor="#999999" align="center">
	<tr bgcolor="#ddecf7" class="ui-state-active">
		<td colspan="2"><strong>Total <?php echo $row_principal['DESCRIPCION']; ?></strong></td>
		<td width="150" align="right"><strong>
			<?php 
	    echo number_format($row_principal['MONTO_ESTIMADO'],2);

     ?>
			</strong></td>
		<!--<td width="150" align="right"><?php echo number_format($row_principal['MONTO_ASIGNADO'],2); ?></td>-->
		<td width="150" align="right"><?php echo number_format($row_principal['MONTO_PAGADO'],2); ?></td>
		<?php $monto_restante_total=$row_principal['MONTO_ESTIMADO']-$row_principal['MONTO_PAGADO'];?>
		<td width="150" align="right"<?php if($monto_restante_total<0){ echo " bgcolor='#ffcaca'"; } ?>><?php echo number_format($monto_restante_total,2);  ?></td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="1" cellpadding="2" bgcolor="#999999" align="center">
	<?php if ($totalRows_alicuota > 0) { // Show if recordset not empty ?>
		<?php
  			$t_alicuota_estimada=0;
			$t_alicuota_asignada=0;
			$t_alicuota_pagada=0;
			$t_alicuota_disponible=0;
   ?>
		<?php do { ?>
			<?php 
			
			$m_alicuota_disponible=$row_alicuota['MONTO_ESTIMADO']-$row_alicuota['MONTO_PAGADO'];
			$t_alicuota_estimada=$t_alicuota_estimada+$row_alicuota['MONTO_ESTIMADO'];
			$t_alicuota_asignada=$t_alicuota_asignada+$row_alicuota['MONTO_ASIGNADO'];
			$t_alicuota_pagada=$t_alicuota_pagada+$row_alicuota['MONTO_PAGADO'];
			$t_alicuota_disponible=$t_alicuota_disponible+$m_alicuota_disponible;
		
		?>
			<tr class="textos_form">
				<td colspan="2" bgcolor="#e5e5e5" class="textos_form">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row_alicuota['DESCRIPCION']; ?>
					<?php //echo $row_alicuota['PORCENTAJE_ALICUOTA']?></td>
				<td width="150" align="right" bgcolor="#e5e5e5" class="textos_form"><?php echo number_format($row_alicuota['MONTO_ESTIMADO'],2); ?></td>
				<!--<td width="150" align="right" bgcolor="#e5e5e5" class="textos_form"><?php echo number_format($row_alicuota['MONTO_ASIGNADO'],2); ?></td>-->
				<td width="150" align="right" bgcolor="#e5e5e5" class="textos_form"><?php echo number_format($row_alicuota['MONTO_PAGADO'],2); ?></td>
				<td width="150" align="right" bgcolor="#e5e5e5" class="textos_form"><?php echo number_format($m_alicuota_disponible,2); ?></td>
			</tr>
			<?php } while ($row_alicuota = mysql_fetch_assoc($alicuota)); ?>
		<tr class="ui-state-active">
			<td colspan="2" >Total <?php echo $row_principal['DESCRIPCION']; ?> con Alicuota</td>
			<td width="150" align="right" ><?php 
	    echo number_format($row_principal['MONTO_ESTIMADO']+$t_alicuota_estimada,2);

     ?></td>
			<!--<td width="150" align="right" ><?php 
	    echo number_format($row_principal['MONTO_ASIGNADO']+$t_alicuota_asignada,2);

     ?></td>-->
			<td width="150" align="right" ><?php 
	    echo number_format($row_principal['MONTO_PAGADO']+$t_alicuota_pagada,2);

     ?></td>
			<td width="150" align="right" ><?php 
	    //echo number_format($monto_restante_total+$t_alicuota_pagada,2);
  echo number_format(($row_principal['MONTO_ESTIMADO']+$t_alicuota_estimada)-($row_principal['MONTO_PAGADO']+$t_alicuota_pagada),2);
     ?></td>
		</tr>
		<?php } // Show if recordset not empty ?>
	<?php if ($totalRows_secundario == 0) { // Show if recordset empty ?>
		<!-- <br>111111
  <span class="ui-state-active">
  Total Cheques</span> -->
		<?php } // Show if recordset empty ?>
</table>



	<?php
mysql_free_result($secundario);

mysql_free_result($alicuota);

mysql_free_result($principal);
?>

