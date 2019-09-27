
<?php include('../Connections/conexion.php'); ?>
<?php

mysql_select_db($database_conexion, $conexion);
$query_rst_niveles = "SELECT NIVEL FROM usuarios_menu WHERE ID_MENU =".$_POST['ID_GRUPOS'];
//echo $query_rst_niveles;
$rst_niveles = mysql_query($query_rst_niveles, $conexion) or die(mysql_error());
$row_rst_niveles = mysql_fetch_assoc($rst_niveles);
$totalRows_rst_niveles = mysql_num_rows($rst_niveles);
?>
  <input name="NIVEL" type="text" id="NIVEL" value="<?php echo $row_rst_niveles['NIVEL']+1; ?>" size="3" readonly>



