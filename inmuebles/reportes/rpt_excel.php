<?php
include("../include/excelwriter.inc.php");
 
$excel=new ExcelWriter("reporte.xls");
 
if($excel==false) {
echo $excel->error;
}


//Escribimos la primera fila con las cabeceras
$myArr=array("No Apto","Comprador","Precio Venta","Apto. de Contado","Abonos","Por Recibir", "Monto Cesión a Multibank", "Nombre del Banco", "Fecha CPP", "Fecha Vto CCP", "Fecha Minuta Emitida", "Fecha Cheque");
$excel->writeLine($myArr);
 
//REALIZAMOS LA CONSULTA
 include('../Connections/conexion.php');
 mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT codigo_inmueble AS 'No Apto',
nombre_cliente AS 'Comprador',
monto_vendido AS 'Precio Venta',
'' AS 'Apto. de Contado',
'' AS 'Abonos',
monto_por_cobrar AS 'Por Recibir',
'' AS 'Monto Cesión a Multibank',
'' AS 'Nombre del Banco',
'' AS 'Fecha CPP',
'' AS 'Fecha Vto CCP',
'' AS 'Fecha Minuta Emitida',
'' AS 'Fecha Cheque'
FROM vista_rpt_ventas_inmuebles where venta_cerrada=1
".$_GET['proyecto'].$_GET['grupo'];
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());

$totalRows_Recordset1 = mysql_num_rows($Recordset1);
 
//Escribimos todos los registros de la base de datos
//en el fichero EXCEL
while($row_Recordset1 = mysql_fetch_assoc($Recordset1)) {
if($_GET['tipo']=="por"){$result=number_format((($row_Recordset1["Precio Venta"]*$_GET['valor'])/100),2);} else {$result=number_format($_GET['valor'],2);} 
	

$myArr=array(
$row_Recordset1["No Apto"],
$row_Recordset1["Comprador"],
$row_Recordset1["Precio Venta"],
$row_Recordset1["Apto. de Contado"],
$row_Recordset1["Abonos"],
$row_Recordset1["Por Recibir"],
$result,
$row_Recordset1["Nombre del Banco"], 
$row_Recordset1["Fecha CPP"], 
$row_Recordset1["Fecha Vto CCP"], 
$row_Recordset1["Fecha Minuta Emitida"], 
$row_Recordset1["Fecha Cheque"]
);
$excel->writeLine($myArr);
//Otra forma es
//$excel->writeLine($Rs2);
//De este modo volcariamos todos los registros seleccionados
//Sin necesidad de colocarlos/filtrar previamente en $myArr
}
$excel->close();
 
//Abrimos el fichero excel que acabamos de crear
//@header("location:reporte.xls");
?>
<script type="text/javascript">

window.location = "reporte.xls"

</script>
