<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td width="72%" align="center"><h1><strong>Actualizando Montos</strong></h1>
		<p><strong>(Espere unos segundo por favor)</strong></p></td>
		<td width="28%" align="center" valign="middle"><img src="../image/cargando.gif" width="48" height="48" /></td>
	</tr>
</table>

<?php require_once('../Connections/conexion.php'); ?>
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



mysql_select_db($database_conexion, $conexion);
//$query_borrar = "UPDATE contabilidad_cuentas SET MONTO_PAGADO=0, MONTO_ASIGNADO=0, MONTO_DISPONIBLE=0 WHERE TIPO BETWEEN 11 AND 20";
//$borrar = mysql_query($query_borrar, $conexion) or die(mysql_error());

//echo "borro";

/*mysql_select_db($database_conexion, $conexion);
$query_rst_niveles = "SELECT id_partida AS ID_CUENTA,
ROUND(SUM(monto_documento),2) AS MONTO_ASIGNADO,
ROUND(SUM(monto_pagado),2) AS MONTO_PAGADO,
ROUND(SUM(monto_documento)-SUM(monto_pagado),2) AS MONTO_DISPONIBLE,
COUNT(*) AS CANTIDAD_CUENTAS
FROM vista_contabilidad_partidas_pagos
GROUP BY id_cuenta
";*/

$query_rst_niveles = "select 
    `documentos_partidas`.`ID_PARTIDA` AS ID_CUENTA,
    ROUND(SUM((`documentos`.`MONTO_EXENTO` + `documentos`.`MONTO_GRABADO`) + `documentos`.`MONTO_IMPUESTO`),2)  AS MONTO_ASIGNADO,
    ROUND(SUM(`documentos_pagos`.`MONTO_PAGADO`),2) AS MONTO_PAGADO,
    ROUND(SUM((`documentos`.`MONTO_EXENTO` + `documentos`.`MONTO_GRABADO`) + `documentos`.`MONTO_IMPUESTO`)-SUM(`documentos_pagos`.`MONTO_PAGADO`),2) AS MONTO_DISPONIBLE
         from 
    ((((((((`documentos` 
    join `documentos_pagos` on((`documentos`.`ID_DOCUMENTO` = `documentos_pagos`.`ID_DOCUMENTO`))) 
    join `pagos` on((`documentos_pagos`.`ID_PAGO` = `pagos`.`ID_PAGO`))) 
    join `documentos_partidas` on((`documentos`.`ID_DOCUMENTO` = `documentos_partidas`.`ID_DOCUMENTO`))) 
    join `contabilidad_cuentas` on((`documentos_partidas`.`ID_PARTIDA` = `contabilidad_cuentas`.`ID_CUENTA`))) 
    join `tesoreria_mov` on((`pagos`.`ID_PAGO` = `tesoreria_mov`.`ID_PAGO`))) 
    join `tesoreria_tipo_mov` on((`tesoreria_mov`.`ID_TESORERIA_TIPO_MOV` = `tesoreria_tipo_mov`.`ID_TESORERIA_TIPO_MOV`))) 
    join `terceros_master` on((`terceros_master`.`ID_TERCEROS_MASTER` = `documentos`.`ID_TERCEROS`))) 
    join `empresas_sucursales` on((`empresas_sucursales`.`ID_EMPRESA` = `documentos`.`ID_EMPRESA`))) 
  group by 
    `documentos_partidas`.`ID_PARTIDA`
";

$rst_niveles = mysql_query($query_rst_niveles, $conexion) or die(mysql_error());
$totalRows_rst_niveles = mysql_num_rows($rst_niveles);

if ($totalRows_rst_niveles > 0) {
	while($row_rst_niveles = mysql_fetch_assoc($rst_niveles)){
		
$sql="UPDATE contabilidad_cuentas SET MONTO_PAGADO=".$row_rst_niveles['MONTO_PAGADO'].", MONTO_ASIGNADO=".$row_rst_niveles['MONTO_ASIGNADO'].", MONTO_DISPONIBLE=".$row_rst_niveles['MONTO_DISPONIBLE']." WHERE ID_CUENTA=". $row_rst_niveles['ID_CUENTA'];
mysql_select_db($database_conexion, $conexion);
echo $sql;
$Result1 = mysql_query($sql, $conexion) or die(mysql_error());


	}
	}
	
mysql_select_db($database_conexion, $conexion);
//$query_rst_nivel_max = "SELECT MAX(NIVEL) AS NIVEL_MAXIMO FROM contabilidad_cuentas  WHERE TIPO BETWEEN 11 AND 20";
$query_rst_nivel_max ="SELECT DISTINCT NIVEL FROM contabilidad_cuentas  WHERE TIPO BETWEEN 11 AND 20 ORDER BY NIVEL DESC";
$rst_nivel_max = mysql_query($query_rst_nivel_max, $conexion) or die(mysql_error());
//$row_rst_nivel_max = mysql_fetch_assoc($rst_nivel_max);
$totalRows_rst_nivel_max = mysql_num_rows($rst_nivel_max);	


//for ( $i = $NIVEL_MAX ; $i >= 0 ; $i--) {
while($row_rst_nivel_max = mysql_fetch_assoc($rst_nivel_max)){
//echo "For ".$i;
$NIVEL_MAX=($row_rst_nivel_max['NIVEL']-1);
$sql="SELECT ID_CUENTA FROM contabilidad_cuentas WHERE TIPO BETWEEN 11 AND 20 AND NIVEL=".$NIVEL_MAX;
$rst_sql = mysql_query($sql, $conexion) or die(mysql_error());
//$row_rst_sql = mysql_fetch_assoc($rst_sql);
$totalRows_rst_sql = mysql_num_rows($rst_sql);

while($row_rst_sql = mysql_fetch_assoc($rst_sql)){
	
mysql_select_db($database_conexion, $conexion);
$query_rst_sumas = "select IFNULL(SUM(MONTO_ESTIMADO),0) as MONTO_ESTIMADO, IFNULL(SUM(MONTO_ASIGNADO),0) as MONTO_ASIGNADO, 
IFNULL(SUM(MONTO_PAGADO),0) as MONTO_PAGADO, IFNULL(SUM(MONTO_ESTIMADO),0)-IFNULL(SUM(MONTO_PAGADO),0) as MONTO_DISPONIBLE 
from `contabilidad_cuentas` where ID_GRUPO=".$row_rst_sql['ID_CUENTA'];
echo "Nivel Maximo=" .$NIVEL_MAX;
//echo " Cuenta ".$row_rst_sql['ID_CUENTA'];

$rst_sumas = mysql_query($query_rst_sumas, $conexion) or die(mysql_error());
$row_rst_sumas = mysql_fetch_assoc($rst_sumas);
$totalRows_rst_sumas = mysql_num_rows($rst_sumas);

	
$sql="UPDATE contabilidad_cuentas SET MONTO_ESTIMADO=".$row_rst_sumas['MONTO_ESTIMADO'].", MONTO_ASIGNADO=".$row_rst_sumas['MONTO_ASIGNADO'].", 
MONTO_PAGADO=".$row_rst_sumas['MONTO_PAGADO'].", MONTO_DISPONIBLE=".$row_rst_sumas['MONTO_DISPONIBLE']." WHERE ID_CUENTA=".$row_rst_sql['ID_CUENTA'];;
mysql_select_db($database_conexion, $conexion);
//echo $sql;
?>
</br>
<?php
$Result1 = mysql_query($sql, $conexion) or die(mysql_error());
	
}

}

 
?>
<script type="text/javascript">

//alert('Los monto fueron actualizados correctamente');
window.location = "index.php?titulo_formulario=Partidas"
</script>
<?php
mysql_free_result($rst_nivel_max);

mysql_free_result($rst_sumas);
?>
