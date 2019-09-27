<?php
include("../include/excelwriter.inc.php");
 
$excel=new ExcelWriter("reporte.xls");
 
if($excel==false) {
echo $excel->error;
}

if ($_GET['detalles']==1){
//Escribimos la primera fila con las cabeceras
$myArr=array("CODIGO INMUEBLE",
"NOMBRE INMUEBLE",
"NOMBRE CLIENTE",
"MONTO VENDIDO",
"MONTO POR VENDER",
"MONTO COBRADO",
"MONTO POR COBRAR",
"MONTO VENCIDO");



$excel->writeLine($myArr);
 
//REALIZAMOS LA CONSULTA
 include('../Connections/conexion.php');
 mysql_select_db($database_conexion, $conexion);
//$query_Recordset1 =  "SELECT  CODIGO_INMUEBLE, NOMBRE_INMUEBLE, NOMBRE_CLIENTE, FORMAT(MONTO_VENDIDO,2) AS MONTO_VENDIDO, FORMAT(MONTO_POR_VENDER,2) AS MONTO_POR_VENDER, FORMAT(MONTO_COBRADO,2) AS MONTO_COBRADO,  FORMAT(MONTO_POR_COBRAR,2) AS MONTO_POR_COBRAR,  FORMAT(MONTO_VENCIDO,2) AS MONTO_VENCIDO  FROM vista_rpt_ventas_inmuebles  WHERE CODIGO_PROYECTO <>'' ". $_GET['proyecto']. $_GET['grupo'];
$query_Recordset1 =  "SELECT  CODIGO_INMUEBLE, NOMBRE_INMUEBLE, NOMBRE_CLIENTE, MONTO_VENDIDO, MONTO_POR_VENDER, MONTO_COBRADO,  MONTO_POR_COBRAR,  MONTO_VENCIDO FROM vista_rpt_ventas_inmuebles  
WHERE CODIGO_PROYECTO <>'' ". $_GET['proyecto']. $_GET['grupo'];

$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());

$totalRows_Recordset1 = mysql_num_rows($Recordset1);
 
//Escribimos todos los registros de la base de datos
//en el fichero EXCEL
while($row_Recordset1 = mysql_fetch_assoc($Recordset1)) {
//if($_GET['tipo']=="por"){$result=number_format((($row_Recordset1["Precio Venta"]*$_GET['valor'])/100),2);} else {$result=number_format($_GET['valor'],2);} 
	

$myArr=array(
$row_Recordset1["CODIGO_INMUEBLE"],
$row_Recordset1["NOMBRE_INMUEBLE"],
$row_Recordset1["NOMBRE_CLIENTE"],
$row_Recordset1["MONTO_VENDIDO"],
$row_Recordset1["MONTO_POR_VENDER"],
$row_Recordset1["MONTO_COBRADO"],
$row_Recordset1["MONTO_POR_COBRAR"],
$row_Recordset1["MONTO_VENCIDO"]
);

$excel->writeLine($myArr);

}
$excel->close();
 } else {
	 //Escribimos la primera fila con las cabeceras
$myArr=array( "NOMBRE_INMUEBLE",
 number_format("MONTO_VENDIDO"),
 number_format("MONTO_POR_VENDER"),
number_format("MONTO_COBRADO"),
 number_format("MONTO_POR_COBRAR"),
 number_format("MONTO_VENCIDO"));



$excel->writeLine($myArr);
 
//REALIZAMOS LA CONSULTA
 include('../Connections/conexion.php');
 mysql_select_db($database_conexion, $conexion);
$query_Recordset1 =  "SELECT  CONCAT('Total ',NOMBRE_GRUPO) as NOMBRE_INMUEBLE,  FORMAT(SUM(MONTO_VENDIDO),2) as MONTO_VENDIDO,   FORMAT(SUM(MONTO_POR_VENDER),2)as MONTO_POR_VENDER,   FORMAT(SUM(MONTO_COBRADO),2) as MONTO_COBRADO,  FORMAT(SUM(MONTO_POR_COBRAR),2) as MONTO_POR_COBRAR,   FORMAT(SUM(MONTO_VENCIDO),2) as MONTO_VENCIDO   FROM vista_rpt_ventas_inmuebles WHERE CODIGO_PROYECTO <>'' ". $_GET['proyecto']. $_GET['grupo']." GROUP BY ID_GRUPO";

$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());

$totalRows_Recordset1 = mysql_num_rows($Recordset1);
 
//Escribimos todos los registros de la base de datos
//en el fichero EXCEL
while($row_Recordset1 = mysql_fetch_assoc($Recordset1)) {
//if($_GET['tipo']=="por"){$result=number_format((($row_Recordset1["Precio Venta"]*$_GET['valor'])/100),2);} else {$result=number_format($_GET['valor'],2);} 
	

$myArr=array(
$row_Recordset1["NOMBRE_INMUEBLE"],
$row_Recordset1["MONTO_VENDIDO"],
$row_Recordset1["MONTO_POR_VENDER"],
$row_Recordset1["MONTO_COBRADO"],
$row_Recordset1["MONTO_POR_COBRAR"],
$row_Recordset1["MONTO_VENCIDO"]

);

$excel->writeLine($myArr);

}
$excel->close(); }
//Abrimos el fichero excel que acabamos de crear
//@header("location:reporte.xls");
?>
<script type="text/javascript">

window.location = "reporte.xls"

</script>
