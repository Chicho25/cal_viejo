<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td width="72%" align="center"><h1><strong>Actualizando Montos</strong></h1>
		<p><strong>(Espere unos segundos por favor)</strong></p></td>
		<td width="28%" align="center" valign="middle"><img src="../image/cargando.gif" width="48" height="48" /></td>
	</tr>
</table>

<?php include('../Connections/conexion.php'); 


mysql_select_db($database_conexion, $conexion);
$query_borrar = "UPDATE contabilidad_cuentas SET  MONTO_PAGADO=0, MONTO_ASIGNADO=0, MONTO_DISPONIBLE=0";
  $Result1 = mysql_query($query_borrar, $conexion) or die(mysql_error());

$query_borrar = "UPDATE contabilidad_cuentas SET  MONTO_ESTIMADO=0 WHERE TIPO= 11";
  $Result1 = mysql_query($query_borrar, $conexion) or die(mysql_error());

$query_borrar = "UPDATE contabilidad_cuentas SET MONTO_ESTIMADO=0, MONTO_PAGADO=0, MONTO_ASIGNADO=0, MONTO_DISPONIBLE=0 WHERE TIPO= 13";
  $Result1 = mysql_query($query_borrar, $conexion) or die(mysql_error());


$sql="UPDATE contabilidad_cuentas A, vista_monto_partidas B SET 
A.MONTO_ASIGNADO=B.MONTO_ASIGNADO,
A.MONTO_DISPONIBLE=B.MONTO_DISPONIBLE,
A.MONTO_PAGADO=B.MONTO_PAGADO
WHERE  
    B.ID_PARTIDA= A.ID_CUENTA"; 


mysql_select_db($database_conexion, $conexion);
//echo $sql;
$Result1 = mysql_query($sql, $conexion) or die(mysql_error());
 

mysql_select_db($database_conexion, $conexion);
$query_rst_nivel_max ="SELECT DISTINCT NIVEL FROM contabilidad_cuentas  WHERE TIPO BETWEEN 11 AND 20 ORDER BY NIVEL DESC";
$rst_nivel_max = mysql_query($query_rst_nivel_max, $conexion) or die(mysql_error());
$totalRows_rst_nivel_max = mysql_num_rows($rst_nivel_max);	

while($row_rst_nivel_max = mysql_fetch_assoc($rst_nivel_max)){
$NIVEL_MAX=($row_rst_nivel_max['NIVEL']-1);

$sql="UPDATE contabilidad_cuentas A, `vista_montos_partidas_grupo` B SET 
A.`MONTO_ESTIMADO`=B.`MONTO_ESTIMADO`,
A.`MONTO_ASIGNADO`=B.`MONTO_ASIGNADO`,
A.`MONTO_DISPONIBLE`=B.`MONTO_DISPONIBLE`,
A.`MONTO_PAGADO`=B.`MONTO_PAGADO`
WHERE 
    B.`ID_GRUPO`= A.ID_CUENTA
	AND A.NIVEL =".$NIVEL_MAX;
	mysql_select_db($database_conexion, $conexion);
//echo $sql;
$Result1 = mysql_query($sql, $conexion) or die(mysql_error());


}

/*ALICUOTAS*/


mysql_select_db($database_conexion, $conexion);
$sql ="SELECT a.ID_CUENTA, a.ID_ALICUOTA, a.PORCENTAJE_ALICUOTA FROM contabilidad_cuentas a WHERE a.TIPO=13";
$rst_ali = mysql_query($sql, $conexion) or die(mysql_error());
$totalRows_rst_ali = mysql_num_rows($rst_ali);	

while($a = mysql_fetch_assoc($rst_ali)){
	
	mysql_select_db($database_conexion, $conexion);
$sql1 ="SELECT b.ID_CUENTA, b.MONTO_ASIGNADO, b.MONTO_DISPONIBLE, b.MONTO_ESTIMADO, b.MONTO_PAGADO FROM contabilidad_cuentas b WHERE b.ID_CUENTA=".$a['ID_ALICUOTA'];
$rst_part = mysql_query($sql1, $conexion) or die(mysql_error());
$b = mysql_fetch_assoc($rst_part);
$totalRows_rst_part = mysql_num_rows($rst_part);	

$sql2 ="UPDATE contabilidad_cuentas b SET 
b.MONTO_ASIGNADO = ((".$b['MONTO_ASIGNADO']." * ".$a['PORCENTAJE_ALICUOTA'].")/100) , 
b.MONTO_DISPONIBLE = ((".$b['MONTO_DISPONIBLE']." * ".$a['PORCENTAJE_ALICUOTA'].")/100) , 
b.MONTO_ESTIMADO = ((".$b['MONTO_ESTIMADO']." * ".$a['PORCENTAJE_ALICUOTA'].")/100) , 
b.MONTO_PAGADO = ((".$b['MONTO_PAGADO']." * ".$a['PORCENTAJE_ALICUOTA'].")/100)  WHERE b.ID_CUENTA=".$a['ID_CUENTA'];
	mysql_select_db($database_conexion, $conexion);
$Result1 = mysql_query($sql2, $conexion) or die(mysql_error());
	
}


?> 
<script type="text/javascript">

//alert('Los monto fueron actualizados correctamente');
window.location = "index.php?titulo_formulario=<?php echo $_GET['titulo_formulario']; ?>&id_menu=<?php echo $_GET['id_menu'] ?>"
</script>
<?php
mysql_free_result($rst_nivel_max);

?>
