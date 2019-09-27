<?php /*?><?php 
$tabla="vista_contabilidad_partidas";

mysql_select_db($database_conexion, $conexion);
$query_secundario = "SELECT * FROM ".$tabla." WHERE ID_GRUPO = 0 ORDER BY ID";
//$query_secundario = "SELECT * FROM ".$tabla." ORDER BY ID";
$secundario = mysql_query($query_secundario, $conexion) or die(mysql_error());
$row_secundario = mysql_fetch_assoc($secundario);
$totalRows_secundario = mysql_num_rows($secundario);


$colname_secundario = "-1";
if (isset($_GET['id_grupo'])) {
  $colname_secundario = $_GET['id_grupo'];

mysql_select_db($database_conexion, $conexion);
//$query_secundario = sprintf("SELECT * FROM ". $tabla. " WHERE ALICUOTA=0 AND ID_GRUPO = %s", GetSQLValueString($colname_secundario, "int"));
$query_secundario = sprintf("SELECT * FROM ". $tabla. " WHERE ID_GRUPO =%s", GetSQLValueString($colname_secundario, "int"));
//echo $query_secundario;
$secundario = mysql_query($query_secundario, $conexion) or die(mysql_error());
$row_secundario = mysql_fetch_assoc($secundario);
$totalRows_secundario = mysql_num_rows($secundario);


mysql_select_db($database_conexion, $conexion);
$query_totales = sprintf("SELECT DESCRIPCION, SUM(MONTO_ESTIMADO) AS MONTO_ESTIMADO, SUM(MONTO_PAGADO) AS MONTO_PAGADO, SUM(MONTO_ASIGNADO) AS MONTO_ASIGNADO FROM ".$tabla." WHERE ID_GRUPO =%s", GetSQLValueString($colname_secundario, "int"));
$totales = mysql_query($query_totales, $conexion) or die(mysql_error());
$row_totales = mysql_fetch_assoc($totales);
$totalRows_totales = mysql_num_rows($totales);

mysql_select_db($database_conexion, $conexion);
//$query_alicuota = sprintf("SELECT * FROM ". $tabla. " WHERE ALICUOTA=1 AND ID_GRUPO = %s", GetSQLValueString($colname_secundario, "int"));
$query_alicuota = sprintf("SELECT * FROM ". $tabla. " WHERE ID_GRUPO = %s", GetSQLValueString($colname_secundario, "int"));

$alicuota = mysql_query($query_alicuota, $conexion) or die(mysql_error());
$row_alicuota = mysql_fetch_assoc($alicuota);
$totalRows_alicuota = mysql_num_rows($alicuota);

}
?>

<?php if ($totalRows_secundario > 0) { // Show if recordset not empty ?>
<?php $total_estimado=0; ?>
<!--<table align="center" width="790" bgcolor="#CCCCCC">
	<tr bgcolor="#CCCCCC"  class="ui-widget-header">
		<td colspan="2" align="center"><strong>Partida</strong></td>
		<td width="150" align="center"><strong>Estimado</strong></td>
		<td width="150" align="center"><strong>Pagado</strong></td>
		<td width="150" align="center"><strong>Restante</strong></td>
       
	</tr>
</table>
-->



<table align="center" width="790" bgcolor="#CCCCCC">
	<tr bgcolor="#CCCCCC"  class="ui-widget-header">
		<td colspan="2" align="center"><strong>Partida</strong></td>
		<td width="150" align="center"><strong>Estimado</strong></td>
		<!--<td width="150" align="center"><strong>Asignado</strong></td>-->
		<td width="150" align="center"><strong>Pagado</strong></td>
		<td width="150" align="center"><strong>Restante</strong></td>
        <?php if (validador($menu,$_SESSION['i'],"edi")==1 || validador($menu,$_SESSION['i'],"eli")==1){?><td colspan="2" width="60" align="center">Opciones</td><?php } ?>
       
	</tr>
    <?php do { ?>
	<tr class="Campos" >
		<td align="center"><?php echo $row_secundario['ID']; ?></td>
	  <td ><?php echo $row_secundario['DESCRIPCION']; ?></td>
		<td align="right" ><?php echo number_format($row_secundario['MONTO_ESTIMADO'],2); ?></td>
		<td align="right" ><?php echo number_format($row_secundario['MONTO_PAGADO'],2); ?></td>
		<?php 
	$monto_restante=$row_secundario['MONTO_ESTIMADO']-$row_secundario['MONTO_PAGADO'];
	?>
		<td align="right" <?php if($monto_restante<0){ echo "bgcolor='#ffcaca'"; } ?>><?php echo number_format($monto_restante,2);  ?></td>
         <?php if (validador($menu,$_SESSION['i'],"edi")==1){?><td valign="middle"  width="30" align="center"><a href="index.php?titulo_formulario=<?php echo $_GET['titulo_formulario'] ?>&ID=<?php echo $row_secundario['ID']; ?>"><img src="../img/write.png" width="24" height="24" /></a></td><?php } ?>
            <?php if (validador($menu,$_SESSION['i'],"eli")==1){?><td valign="middle" width="30" align="center"><?php if($row_secundario['TIENE_HIJOS']==0){ ?><?php if($row_secundario['TIENE_DOCUMENTOS']==0){ ?><a href="del.php?titulo_formulario=<?php echo $_GET['titulo_formulario'] ?>&menu=<?php echo $menu; ?>&ID=<?php echo $row_secundario['ID']; ?>"><img src="../image/Delete-icon.png" width="24" height="24" /></a></td> <?php } ?><?php  } ?><?php  } ?>
		<?php $total_estimado=$total_estimado+$row_secundario['MONTO_ESTIMADO'];?>
	</tr>
	<?php } while ($row_secundario = mysql_fetch_assoc($secundario)); ?>
	
</table>
<?php if (isset($_GET['id_grupo'])) { ?>
<table align="center" width="790" bgcolor="#CCCCCC">
	<tr bgcolor="#CCCCCC"  class="ui-widget-header">
	<td colspan="2" width="230"><strong>Total: </strong></td>
		<td width="150" align="right"><strong>
			<?php 
	    echo number_format($row_totales['MONTO_ESTIMADO'],2);

     ?>
			</strong></td>

		<td width="150" align="right"><?php echo number_format($row_totales['MONTO_PAGADO'],2); ?></td>
		<?php $monto_restante_total=$row_totales['MONTO_ESTIMADO']-$row_totales['MONTO_PAGADO'];?>
		<td width="150" align="right"<?php if($monto_restante_total<0){ echo " bgcolor='#ffcaca'"; } ?>><?php echo number_format($monto_restante_total,2);  ?></td>
         <?php if (validador($menu,$_SESSION['i'],"edi")==1 || validador($menu,$_SESSION['i'],"eli")==1){?><td colspan="2" align="right" width="60"></td><?php } ?>
           
	</tr>
</table>
<?php } ?>


	<?php
mysql_free_result($secundario);

//mysql_free_result($alicuota);

?>
<?php } else {


$colname_pagos = "-1";
if (isset($_GET['id_grupo'])) {
  $colname_pagos = $_GET['id_grupo'];
}
mysql_select_db($database_conexion, $conexion);
$query_pagos = sprintf("SELECT * FROM vista_contabilidad_partidas_pagos WHERE ID_PARTIDA = %s ", GetSQLValueString($colname_pagos, "int"));
$pagos = mysql_query($query_pagos, $conexion) or die(mysql_error());
$row_pagos = mysql_fetch_assoc($pagos);
$totalRows_pagos = mysql_num_rows($pagos);
?>

<?php if ($totalRows_pagos > 0) {  ?>
<h1 align="center">Pagos Realizados</h1>
	<table align="center" width="790" bgcolor="#CCCCCC">
	<tr bgcolor="#CCCCCC"  class="ui-widget-header">
			<td width="80" align="center">Forma de Pago</td>
			<td width="80" align="center">No. de Pago</td>
			<td width="80" align="center">Fecha</td>
			<td align="center">Detalles de Pago</td>
			<td width="100" align="center">Monto</td>
             
			<?php 
			
			$total_pagos=0
			?>
		</tr><?php do { ?>
		<tr class="Campos" >
			<?php 
			$total_pagos=$total_pagos+$row_pagos['MONTO_PAGADO'];
			?>
				<td align="center"><?php echo $row_pagos['TIPO_PAGO']; ?></td>
				<td align="center"><?php echo $row_pagos['NUMERO_MOVIMIENTO']; ?></td>
				<td align="center"><?php echo $row_pagos['FECHA']; ?></td>
				<td ><?php echo htmlentities($row_pagos['DESCRIPCION_DOCUMENTO']); ?></td>
				<td align="right"><?php echo number_format($row_pagos['MONTO_PAGADO'],2,',','.'); ?></td>
				<?php } while ($row_pagos = mysql_fetch_assoc($pagos)); ?>
		</tr>
		<tr tr bgcolor="#CCCCCC"  class="ui-widget-header">
			<td colspan="4" align="right">Total:</td>
			<td align="right"><?php echo number_format($total_pagos,2,',','.'); ?></td>
		</tr>
	</table>
	
<?php } ?>
<?php
mysql_free_result($pagos);
} ?>
<?php */?>

<?php 
$tabla="partidas";

mysql_select_db($database_conexion, $conexion);
$query_secundario =  "SELECT 
  b.ID,
  b.DESCRIPCION,
  b.MONTO_ESTIMADO,
  b.MONTO_PAGADO,
  b.MONTO_DISPONIBLE
FROM
  partidas b
where (`b`.`TIPO` between 1
       and 2)
and b.ID_GRUPO = 0 ORDER BY b.ID";
$secundario = mysql_query($query_secundario, $conexion) or die(mysql_error());
$row_secundario = mysql_fetch_assoc($secundario);
$totalRows_secundario = mysql_num_rows($secundario);


$colname_secundario = "-1";
if (isset($_GET['id_grupo'])) {
  $colname_secundario = $_GET['id_grupo'];

mysql_select_db($database_conexion, $conexion);

$query_secundario = sprintf("SELECT 
  b.ID,
  b.DESCRIPCION,
  b.MONTO_ESTIMADO,
  b.MONTO_PAGADO,
  b.MONTO_DISPONIBLE
FROM
  partidas b
where (`b`.`TIPO` between 1 and 2)
and b.ID_GRUPO =%s", GetSQLValueString($colname_secundario, "int"));
$secundario = mysql_query($query_secundario, $conexion) or die(mysql_error());
$row_secundario = mysql_fetch_assoc($secundario);
$totalRows_secundario = mysql_num_rows($secundario);


mysql_select_db($database_conexion, $conexion);
$query_totales = sprintf("SELECT DESCRIPCION, SUM(MONTO_ESTIMADO) AS MONTO_ESTIMADO, SUM(MONTO_PAGADO) AS MONTO_PAGADO, SUM(MONTO_ASIGNADO) AS MONTO_ASIGNADO FROM ".$tabla." WHERE ID_GRUPO =%s", GetSQLValueString($colname_secundario, "int"));
$totales = mysql_query($query_totales, $conexion) or die(mysql_error());
$row_totales = mysql_fetch_assoc($totales);
$totalRows_totales = mysql_num_rows($totales);

mysql_select_db($database_conexion, $conexion);
$query_alicuota = sprintf("SELECT
  b.ID,
  b.DESCRIPCION,
  b.MONTO_ESTIMADO,
  b.MONTO_PAGADO,
  b.MONTO_DISPONIBLE
FROM
  partidas b
where (`b`.`TIPO` between 1 and 2)
and  b.ID_GRUPO = %s", GetSQLValueString($colname_secundario, "int"));

$alicuota = mysql_query($query_alicuota, $conexion) or die(mysql_error());
$row_alicuota = mysql_fetch_assoc($alicuota);
$totalRows_alicuota = mysql_num_rows($alicuota);

}
?>

<?php if ($totalRows_secundario > 0) { // Show if recordset not empty ?>
<?php $total_estimado=0; ?>
<table align="center" width="790" bgcolor="#CCCCCC">
	<tr bgcolor="#CCCCCC"  class="ui-widget-header">
		<td colspan="2" align="center"><strong>Partida</strong></td>
		<td width="150" align="center"><strong>Estimado</strong></td>
		<!--<td width="150" align="center"><strong>Asignado</strong></td>-->
		<td width="150" align="center"><strong>Pagado</strong></td>
		<td width="150" align="center"><strong>Restante</strong></td>
        <?php if (validador($menu,$_SESSION['i'],"edi")==1 || validador($menu,$_SESSION['i'],"eli")==1){?><td colspan="2" width="60" align="center">Opciones</td><?php } ?>
       
	</tr>
    <?php do { ?>
	<tr class="Campos" >
		<td align="center"><?php echo $row_secundario['ID']; ?></td>
	  <td ><?php echo $row_secundario['DESCRIPCION']; ?></td>
		<td align="right" ><?php echo number_format($row_secundario['MONTO_ESTIMADO'],2); ?></td>
		<td align="right" ><?php echo number_format($row_secundario['MONTO_PAGADO'],2); ?></td>
		<?php 
	$monto_restante=$row_secundario['MONTO_ESTIMADO']-$row_secundario['MONTO_PAGADO'];
	?>
		<td align="right" <?php if($monto_restante<0){ echo "bgcolor='#ffcaca'"; } ?>><?php echo number_format($monto_restante,2);  ?></td>
         <?php if (validador($menu,$_SESSION['i'],"edi")==1){?><td valign="middle"  width="30" align="center"><a href="index.php?titulo_formulario=<?php echo $_GET['titulo_formulario'] ?>&id_menu=<?php echo $_GET['id_menu'] ?>&ID=<?php echo $row_secundario['ID']; ?>"><img src="../img/write.png" width="24" height="24" /></a></td><?php } ?>
            <?php if (validador($menu,$_SESSION['i'],"eli")==1){?><td valign="middle" width="30" align="center"><?php /*?><?php if($row_secundario['TIENE_HIJOS']==0){ ?><?php if($row_secundario['TIENE_DOCUMENTOS']==0){ ?><a href="del.php?titulo_formulario=<?php echo $_GET['titulo_formulario'] ?>&id_menu=<?php echo $_GET['id_menu'] ?>&ID=<?php echo $row_secundario['ID']; ?>"><img src="../image/Delete-icon.png" width="24" height="24" /></a> <?php } ?><?php  } ?><?php */?></td><?php  } ?>
		<?php $total_estimado=$total_estimado+$row_secundario['MONTO_ESTIMADO'];?>
	</tr>
	<?php } while ($row_secundario = mysql_fetch_assoc($secundario)); ?>
	
</table>
<?php if (isset($_GET['id_grupo'])) { ?>
<table align="center" width="790" bgcolor="#CCCCCC">
	<tr bgcolor="#CCCCCC"  class="ui-widget-header">
	<td colspan="2" width="230"><strong>Total: </strong></td>
		<td width="150" align="right"><strong>
			<?php 
	    echo number_format($row_totales['MONTO_ESTIMADO'],2);

     ?>
			</strong></td>

		<td width="150" align="right"><?php echo number_format($row_totales['MONTO_PAGADO'],2); ?></td>
		<?php $monto_restante_total=$row_totales['MONTO_ESTIMADO']-$row_totales['MONTO_PAGADO'];?>
		<td width="150" align="right"<?php if($monto_restante_total<0){ echo " bgcolor='#ffcaca'"; } ?>><?php echo number_format($monto_restante_total,2);  ?></td>
         <?php if (validador($menu,$_SESSION['i'],"edi")==1 || validador($menu,$_SESSION['i'],"eli")==1){?><td colspan="2" align="right" width="60"></td><?php } ?>
           
	</tr>
</table>
<?php } ?>


	<?php
mysql_free_result($secundario);


?>
<?php } else {


$colname_pagos = "-1";
if (isset($_GET['id_grupo'])) {
  $colname_pagos = $_GET['id_grupo'];
}

mysql_select_db($database_conexion, $conexion);
$query_pagos = sprintf("SELECT * FROM vista_pagos_partidas WHERE ID_PARTIDA = %s ", GetSQLValueString($colname_pagos, "int"));
$pagos = mysql_query($query_pagos, $conexion) or die(mysql_error());
$row_pagos = mysql_fetch_assoc($pagos);
$totalRows_pagos = mysql_num_rows($pagos);
?>

<?php if ($totalRows_pagos > 0) {  ?>
<h1 align="center">Pagos Realizados</h1>
	<table align="center" width="790" bgcolor="#CCCCCC">
	<tr bgcolor="#CCCCCC"  class="ui-widget-header">
			<td width="80" align="center">Forma de Pago</td>
			<td width="80" align="center">No. de Pago</td>
			<td width="80" align="center">Fecha</td>
			<td align="center">Detalles de Pago</td>
			<td width="100" align="center">Monto</td>
             
			<?php 
			
			$total_pagos=0
			?>
		</tr><?php do { ?>
		<tr class="Campos" >
			<?php 
			$total_pagos=$total_pagos+$row_pagos['MONTO_PAGADO'];
			?>
				<td align="center"><?php echo $row_pagos['TIPO_PAGO']; ?></td>
				<td align="center"><?php echo $row_pagos['NUMERO_PAGO']; ?></td>
				<td align="center"><?php echo $row_pagos['FECHA']; ?></td>
				<td ><?php echo htmlentities($row_pagos['DESCRIPCION_DOCUMENTO']); ?></td>
				<td align="right"><?php echo number_format($row_pagos['MONTO_PAGADO'],2,',','.'); ?></td>
				<?php } while ($row_pagos = mysql_fetch_assoc($pagos)); ?>
		</tr>
		<tr tr bgcolor="#CCCCCC"  class="ui-widget-header">
			<td colspan="4" align="right">Total:</td>
			<td align="right"><?php echo number_format($total_pagos,2,',','.'); ?></td>
		</tr>
	</table>
	
<?php } ?>
<?php
mysql_free_result($pagos);
} ?>
