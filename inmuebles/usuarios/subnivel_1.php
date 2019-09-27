<?php include('../Connections/conexion.php'); 

mysql_select_db($database_conexion, $conexion);
$query_Recordset3 = "SELECT * FROM usuarios_menu WHERE ID_GRUPO = ".$_POST['GRUPO'];
//echo $query_Recordset3;
$Recordset3 = mysql_query($query_Recordset3, $conexion) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
?>

      <select name="NIVEL_1" id="NIVEL_1">
        <option value="-1">Seleccione...</option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset3['ID_MENU']?>"><?php echo htmlentities($row_Recordset3['DESCRIPCION'])?></option>
        <?php
} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
  $rows = mysql_num_rows($Recordset3);
  if($rows > 0) {
      mysql_data_seek($Recordset3, 0);
	  $row_Recordset3 = mysql_fetch_assoc($Recordset3);
  }
?>
      </select>
  