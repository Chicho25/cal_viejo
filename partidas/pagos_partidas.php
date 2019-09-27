 <?php include('../Connections/conexion.php'); ?>
<?php 

$colname_pagos = "-1";
if (isset($_POST['id_grupo'])) {
  $colname_pagos = $_POST['id_grupo'];
}



mysql_select_db($database_conexion, $conexion);
$query_rst_doc_partidas = "SELECT `documentos`.`ID_DOCUMENTO`     , `documentos`.`NUMERO`     , `pro_cli_master`.`NOMBRE`     ,   DATE_FORMAT(`documentos`.`FECHA_EMISION`,_utf8'%d/%m/%Y') AS `FECHA_DOCUMENTO`     ,   DATE_FORMAT(`documentos`.`FECHA_VENCIMIENTO`,_utf8'%d/%m/%Y') AS `FECHA_VENCIMIENTO`     , `documentos`.`DESCRIPCION`     , `documentos`.`ID_PARTIDA`     , `pagos_detalle`.`ID_PAGO`     , `pagos_detalle`.`MONTO_PAGADO`     ,   ((`documentos`.`MONTO_EXENTO` + `documentos`.`MONTO_GRABADO`) + `documentos`.`MONTO_IMPUESTO`) AS `MONTO_DOCUMENTO`     ,   IF(ISNULL(`pagos_detalle`.`MONTO_PAGADO`),0,1) AS `TIENE_PAGOS`     ,   ROUND(SUM(IFNULL(`pagos_detalle`.`MONTO_PAGADO`,0)),2) AS `MONTO_PAGADO`     ,   ROUND(IFNULL((((`documentos`.`MONTO_EXENTO` + `documentos`.`MONTO_GRABADO`) + `documentos`.`MONTO_IMPUESTO`) - SUM(IFNULL(`pagos_detalle`.`MONTO_PAGADO`,0))),0),2) AS `MONTO_PENDIENTE`     ,   IF(((((`documentos`.`MONTO_EXENTO` + `documentos`.`MONTO_GRABADO`) + `documentos`.`MONTO_IMPUESTO`) - SUM(IFNULL(`pagos_detalle`.`MONTO_PAGADO`,0))) <= 0),0,1) AS `STATUS_DOCUMENTO`     ,   IF((((((`documentos`.`MONTO_EXENTO` + `documentos`.`MONTO_GRABADO`) + `documentos`.`MONTO_IMPUESTO`) - SUM(IFNULL(`pagos_detalle`.`MONTO_PAGADO`,0))) > 0) AND (`documentos`.`FECHA_VENCIMIENTO` < NOW())),1,0) AS `VENCIDO` FROM `grupocal_calpe`.`documentos`     INNER JOIN `grupocal_calpe`.`pro_cli_master`          ON (`documentos`.`ID_PRO_CLI` = `pro_cli_master`.`ID_PRO_CLI_MASTER`)     LEFT JOIN `grupocal_calpe`.`pagos_detalle`          ON (`pagos_detalle`.`ID_DOCUMENTO` = `documentos`.`ID_DOCUMENTO`) WHERE documentos.ID_PARTIDA=".$colname_pagos." GROUP BY `documentos`.`ID_DOCUMENTO` ORDER BY `documentos`.`ID_DOCUMENTO` ASC";
$rst_doc_partidas = mysql_query($query_rst_doc_partidas, $conexion) or die(mysql_error());
$row_rst_doc_partidas = mysql_fetch_assoc($rst_doc_partidas);
$totalRows_rst_doc_partidas = mysql_num_rows($rst_doc_partidas);


?>
<?php if ($totalRows_rst_doc_partidas > 0) {  ?>
<h1 align="center">Documentos</h1>
<table align="center" width="790" bgcolor="#CCCCCC">
	<tr bgcolor="#CCCCCC"  class="ui-widget-header">
			<td width="30" align="center">Id Doc.</td>
			<td width="30" align="center">No. de Doc</td>
			<td width="30" align="center">Fecha del Doc</td>
			<td align="center">Descripción del Doc.</td>
			<td width="150" align="center">Proveedor</td>
			<td width="50" align="center">Id del Pago</td>
			<td width="100" align="center">Monto del documento</td>
			<td width="100" align="center">Monto Pagado</td>
			<td width="100" align="center">Monto Pendiente</td>
			
            </tr>
            <?php
    $doc=0;
	$docpag=0;
	$docpend=0;
?>
	<?php do { ?>
    <tr class="Campos" >
      <td align="center"><?php echo $row_rst_doc_partidas['ID_DOCUMENTO']; ?></td>
      <td align="center"><?php echo $row_rst_doc_partidas['NUMERO']; ?></td>
      <td align="center"><?php echo $row_rst_doc_partidas['FECHA_DOCUMENTO']; ?></td>
      <td align="center"><?php echo htmlentities($row_rst_doc_partidas['DESCRIPCION']); ?></td>
      <td align="center"><?php echo htmlentities($row_rst_doc_partidas['NOMBRE']); ?></td>
      <td align="center"><a onClick="javascript:cesta2('<?php echo $row_rst_doc_partidas['ID_PAGO']; ?>')"><?php echo $row_rst_doc_partidas['ID_PAGO']; ?></td>
      <td align="center"><?php echo number_format ($row_rst_doc_partidas['MONTO_DOCUMENTO'],2); ?></td>
      <td align="center"><?php echo number_format ($row_rst_doc_partidas['MONTO_PAGADO'],2); ?></td>
      <td align="center"><?php echo number_format ($row_rst_doc_partidas['MONTO_PENDIENTE'],2); ?></td>
    
    </tr>
    
    <?php
	$doc=$doc+$row_rst_doc_partidas['MONTO_DOCUMENTO'];
	$docpag=$docpag+$row_rst_doc_partidas['MONTO_PAGADO'];
	$docpend=$docpend+$row_rst_doc_partidas['MONTO_PENDIENTE'];
	?>
    	  <?php } while ($row_rst_doc_partidas = mysql_fetch_assoc($rst_doc_partidas)); ?>

    <tr bgcolor="#CCCCCC"  class="ui-widget-header">
      <td colspan="6" align="right">Total:</td>
      <td align="center"><?php echo number_format ($doc, 2); ?></td>
      <td align="center"><?php echo number_format ($docpag,2); ?></td>
      <td align="center"><?php echo number_format ($docpend,2); ?></td>
    </tr>
    </table>
    <?php } else
	{?><h1 align="center">Esta Partida es de grupo no posee documentos directos &Oacute; No tiene documentos asociados</h1><?php };
mysql_free_result($rst_doc_partidas);
?>
