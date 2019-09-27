 <?php include('../Connections/conexion.php'); ?>

<?php

mysql_select_db($database_conexion, $conexion);
$query_pagos = "SELECT * FROM vista_pagos_partidas WHERE ID_PAGO = ".$_POST['id'];
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
		<!--<tr tr bgcolor="#CCCCCC"  class="ui-widget-header">
			<td colspan="4" align="right">Total:</td>
			<td align="right"><?php echo number_format($total_pagos,2,',','.'); ?></td>
		</tr>-->
	</table>
	
<?php } ?>
<?php
mysql_free_result($pagos);
?>
