<?php 
include("../include/header.php");
$colname_rst_proveedores = "-1";
if (isset($_POST['COD_PROYECTO'])) {
  $colname_rst_proveedores = $_POST['COD_PROYECTO'];
  echo $_POST['COD_PROYECTO'];
}
mysql_select_db($database_conexion, $conexion);
$query_rst_proveedores = sprintf("SELECT DISTINCT ID_PRO_CLI, NOMBRE_PRO_CLI FROM vista_documentos WHERE MONTO_PENDIENTE>0 AND COD_PROYECTO = %s", GetSQLValueString($colname_rst_proveedores, "text"));
$rst_proveedores = mysql_query($query_rst_proveedores, $conexion) or die(mysql_error());
$row_rst_proveedores = mysql_fetch_assoc($rst_proveedores);
$totalRows_rst_proveedores = mysql_num_rows($rst_proveedores);
?>

<?php
if ($totalRows_rst_proveedores>0){?>
<option value=" ">Seleccione el Proveedor</option>
<?php do { ?><option value="<?php echo $row_rst_proveedores['ID_PRO_CLI']; ?>">
<?php echo htmlentities($row_rst_proveedores['NOMBRE_PRO_CLI']) ?></option>
<?php } while ($row_rst_proveedores = mysql_fetch_assoc($rst_proveedores)); ?>
<?php } else{?>
<option value=" ">No hay proveedores con saldo pendiente para este proyecto</option>
<?php do { ?><option value="<?php echo $row_rst_proveedores['ID_PRO_CLI']; ?>">
<?php echo htmlentities($row_rst_proveedores['NOMBRE_PRO_CLI']) ?></option>
<?php } while ($row_rst_proveedores = mysql_fetch_assoc($rst_proveedores)); ?>	
<?php }?>
<?php
mysql_free_result($rst_proveedores);
?>
