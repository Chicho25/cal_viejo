
<?php require_once('../Connections/conexion.php'); ?>
<?php

$updateSQL = "UPDATE contabilidad_cuentas SET NIVEL=0 where tipo in (1, 2, 3)";
   ?>
</br>
<?php
 echo $updateSQL;
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());

mysql_select_db($database_conexion, $conexion);
$query_rst_nivel_1 = "SELECT * from contabilidad_cuentas where tipo in (1, 2, 3) and id_grupo = 0";
$rst_nivel_1 = mysql_query($query_rst_nivel_1, $conexion) or die(mysql_error());
$totalRows_rst_nivel_1 = mysql_num_rows($rst_nivel_1);

if($totalRows_rst_nivel_1>0){
while ($row_rst_nivel_1 = mysql_fetch_assoc($rst_nivel_1)){
 $updateSQL = "UPDATE contabilidad_cuentas SET NIVEL=1 WHERE ID_CUENTA=".$row_rst_nivel_1['ID_CUENTA'];
   ?>
</br>
<?php
 echo $updateSQL;
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());


  mysql_select_db($database_conexion, $conexion);
$query_rst_nivel_2 = "SELECT * from contabilidad_cuentas where  tipo in (1, 2, 3) and ID_GRUPO=".$row_rst_nivel_1['ID_CUENTA'];
$rst_nivel_2 = mysql_query($query_rst_nivel_2, $conexion) or die(mysql_error());
$totalRows_rst_nivel_2 = mysql_num_rows($rst_nivel_2);

if($totalRows_rst_nivel_2>0){
while ($row_rst_nivel_2 = mysql_fetch_assoc($rst_nivel_2)){
 $updateSQL = "UPDATE contabilidad_cuentas SET NIVEL=2 WHERE ID_CUENTA=".$row_rst_nivel_2['ID_CUENTA'];
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());

  mysql_select_db($database_conexion, $conexion);
$query_rst_nivel_3 = "SELECT * from contabilidad_cuentas where  tipo in (1, 2, 3) and ID_GRUPO=".$row_rst_nivel_2['ID_CUENTA'];
$rst_nivel_3 = mysql_query($query_rst_nivel_3, $conexion) or die(mysql_error());
$totalRows_rst_nivel_3 = mysql_num_rows($rst_nivel_3);

if($totalRows_rst_nivel_3>0){
while ($row_rst_nivel_3 = mysql_fetch_assoc($rst_nivel_3)){
 $updateSQL = "UPDATE contabilidad_cuentas SET NIVEL=3 WHERE ID_CUENTA=".$row_rst_nivel_3['ID_CUENTA'];
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
  
  
  mysql_select_db($database_conexion, $conexion);
$query_rst_nivel_4 = "SELECT * from contabilidad_cuentas where  tipo in (1, 2, 3) and ID_GRUPO=".$row_rst_nivel_3['ID_CUENTA'];
$rst_nivel_4 = mysql_query($query_rst_nivel_4, $conexion) or die(mysql_error());
$totalRows_rst_nivel_4 = mysql_num_rows($rst_nivel_4);

if($totalRows_rst_nivel_4>0){
while ($row_rst_nivel_4 = mysql_fetch_assoc($rst_nivel_4)){
 $updateSQL = "UPDATE contabilidad_cuentas SET NIVEL=4 WHERE ID_CUENTA=".$row_rst_nivel_4['ID_CUENTA'];
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
  
    
  
  mysql_select_db($database_conexion, $conexion);
$query_rst_nivel_5 = "SELECT * from contabilidad_cuentas where  tipo in (1, 2, 3) and ID_GRUPO=".$row_rst_nivel_4['ID_CUENTA'];
$rst_nivel_5 = mysql_query($query_rst_nivel_5, $conexion) or die(mysql_error());
$totalRows_rst_nivel_5 = mysql_num_rows($rst_nivel_5);

if($totalRows_rst_nivel_5>0){
while ($row_rst_nivel_5 = mysql_fetch_assoc($rst_nivel_5)){
 $updateSQL = "UPDATE contabilidad_cuentas SET NIVEL=5 WHERE ID_CUENTA=".$row_rst_nivel_5['ID_CUENTA'];
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
   
  
  mysql_select_db($database_conexion, $conexion);
$query_rst_nivel_6 = "SELECT * from contabilidad_cuentas where  tipo in (1, 2, 3) and ID_GRUPO=".$row_rst_nivel_5['ID_CUENTA'];
$rst_nivel_6 = mysql_query($query_rst_nivel_6, $conexion) or die(mysql_error());
$totalRows_rst_nivel_6 = mysql_num_rows($rst_nivel_6);

if($totalRows_rst_nivel_6>0){
while ($row_rst_nivel_6 = mysql_fetch_assoc($rst_nivel_6)){
 $updateSQL = "UPDATE contabilidad_cuentas SET NIVEL=6 WHERE ID_CUENTA=".$row_rst_nivel_6['ID_CUENTA'];
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
}
}
}
}
}
}
}
}

}
}
}
} 
?>
echo "fin";
