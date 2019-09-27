<?php require_once('../Connections/conexion.php'); 

mysql_select_db($database_conexion, $conexion);
$query_rst_centro_costo = "SELECT ID_CUENTA, DESCRIPCION FROM contabilidad_cuentas WHERE TIPO= 11 AND ID_SUCURSAL=".$_POST['ID_SUCURSAL'];
$rst_centro_costo = mysql_query($query_rst_centro_costo, $conexion) or die(mysql_error());
$row_rst_centro_costo = mysql_fetch_assoc($rst_centro_costo);
$totalRows_rst_centro_costo = mysql_num_rows($rst_centro_costo);
?>
        <label for="SUCURSAL"></label>
        <select name="ID_GRUPO" id="ID_GRUPO">
          <option value="0">Principal...</option>
          <?php
do {  
?>
          <option value="<?php echo $row_rst_centro_costo['ID_CUENTA']?>"><?php echo $row_rst_centro_costo['DESCRIPCION']?></option>
          <?php
} while ($row_rst_centro_costo = mysql_fetch_assoc($rst_centro_costo));
  $rows = mysql_num_rows($rst_centro_costo);
  if($rows > 0) {
      mysql_data_seek($rst_centro_costo, 0);
	  $row_rst_centro_costo = mysql_fetch_assoc($rst_centro_costo);
  }
?>
        </select>
