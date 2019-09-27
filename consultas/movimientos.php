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

$colname_pagos = "-1";
if (isset($_POST['elegido'])) {
  $colname_pagos = $_POST['elegido'];
}
mysql_select_db($database_conexion, $conexion);
$query_pagos = sprintf("SELECT * FROM pagos_partidas WHERE ID_PARTIDA = %s ", GetSQLValueString($colname_pagos, "int"));
$pagos = mysql_query($query_pagos, $conexion) or die(mysql_error());
$row_pagos = mysql_fetch_assoc($pagos);
$totalRows_pagos = mysql_num_rows($pagos);
?>

<?php if ($totalRows_pagos > 0) { // Show if recordset not empty ?>
	<table width="1000px" border="0" cellspacing="2" cellpadding="2" bgcolor="#999999">
		<tr class="ui-widget-header">
			<td width="150" align="center">Forma de Pago</td>
			<td width="150" align="center">N° de Pago</td>
			<td width="150" align="center">Fecha</td>
			<td align="center">Detalles de Pago</td>
			<td width="150" align="center">Monto</td>
			<?php 
			
			$total_pagos=0
			?>
		</tr><?php do { ?>
		<tr bgcolor="#FFFFFF">
			<?php 
			$total_pagos=$total_pagos+$row_pagos['MONTO_PAGADO'];
			?>
				<td width="150"><?php echo $row_pagos['TIPO_PAGO']; ?></td>
				<td><?php echo $row_pagos['NUMERO_PAGO']; ?></td>
				<td><?php echo $row_pagos['FECHA']; ?></td>
				<td style="size:10"><?php echo $row_pagos['DESCRIPCION_PAGO']; ?></td>
				<td align="right"><?php echo number_format($row_pagos['MONTO_PAGADO'],2,',','.'); ?></td>
				<?php } while ($row_pagos = mysql_fetch_assoc($pagos)); ?>
		</tr><?php } // Show if recordset not empty ?>
		<tr bgcolor="#ddecf7" class="ui-state-active">
			<td colspan="4" align="right">Total:</td>
			<td align="right"><?php echo number_format($total_pagos,2,',','.'); ?></td>
		</tr>
	</table>
	

<?php
mysql_free_result($pagos);
?>
