<?php include('../Connections/conexion.php'); ?>
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
$query_rst_grupos = "SELECT DISTINCT ID_GRUPO FROM vista_rpt_ventas_inmuebles WHERE CODIGO_PROYECTO=0002";
$rst_grupos = mysql_query($query_rst_grupos, $conexion) or die(mysql_error());
$row_rst_grupos = mysql_fetch_assoc($rst_grupos);
$totalRows_rst_grupos = mysql_num_rows($rst_grupos);

mysql_select_db($database_conexion, $conexion);
$query_rst_todo = "SELECT NOMBRE_PROYECTO, NOMBRE_GRUPO FROM vista_rpt_ventas_inmuebles WHERE CODIGO_PROYECTO <>'' ". $_GET['proyecto']. $_GET['grupo'];
$rst_todo = mysql_query($query_rst_todo, $conexion) or die(mysql_error());
$row_rst_todo = mysql_fetch_assoc($rst_todo);
$totalRows_rst_todo = mysql_num_rows($rst_todo);
$val[]=$row_rst_grupos;
$i=0;


 include_once('class.ezpdf.php');
// $pdf = new Cezpdf('A2','landscape');
$pdf = new Cezpdf('LEGAL','landscape');
 $pdf->selectFont('../fonts/Courier-Bold.afm');
 $pdf->ezSetCmMargins(1,1,1.5,1.5); 
 $titulo = "Listado de Venta de Inmuebles con Clientes";
 $txttit = "<b>".$titulo."</b>\n";
 $txttit.= "Filtro usado: Proyecto: ".$row_rst_todo['NOMBRE_PROYECTO']. " Grupo: ".$row_rst_todo['NOMBRE_GRUPO']." \n";

 $pdf->ezText($txttit, 12);
 
 
 $titles = array(
 'CODIGO_INMUEBLE'=>'<b>CODIGO INMUEBLE</b>',
 'NOMBRE_INMUEBLE'=>'<b>NOMBRE INMUEBLE</b>',
 'NOMBRE_CLIENTE'=>'<b>NOMBRE CLIENTE</b>',
 'MONTO_VENDIDO'=>'<b>MONTO VENDIDO</b>',
 'MONTO_POR_VENDER'=>'<b>MONTO POR VENDER</b>',
 'MONTO_COBRADO'=>'<b>MONTO COBRADO</b>',
 'MONTO_POR_COBRAR'=>'<b>MONTO POR COBRAR</b>',
 'MONTO_VENCIDO'=>'<b>MONTO VENCIDO</b>'
 );
 
  $resumen = array(
 //'CODIGO_INMUEBLE'=>'<b>CODIGO INMUEBLE</b>',
 'NOMBRE_INMUEBLE'=>'<b>NOMBRE INMUEBLE</b>',
 //'NOMBRE_CLIENTE'=>'<b>NOMBRE_CLIENTE</b>',
 'MONTO_VENDIDO'=>'<b>MONTO VENDIDO</b>',
 'MONTO_POR_VENDER'=>'<b>MONTO POR VENDER</b>',
 'MONTO_COBRADO'=>'<b>MONTO COBRADO</b>',
 'MONTO_POR_COBRAR'=>'<b>MONTO POR COBRAR</b>',
 'MONTO_VENCIDO'=>'<b>MONTO VENCIDO</b>'
 );

 //$options = array('shadeCol'=>array(0.9,0.9,0.9,0.9,0.9), 'xOrientation'=>'center', 'width'=>1200);

$options = array('shadeCol'=>array(0.9,0.9,0.9,0.9,0.9), 'xOrientation'=>'center', 'width'=>900);



//echo $row_rst_grupos['ID_GRUPO'];
mysql_select_db($database_conexion, $conexion);
$query_rst_inmuebles = "SELECT  CODIGO_INMUEBLE, NOMBRE_INMUEBLE, NOMBRE_CLIENTE, FORMAT(MONTO_VENDIDO,2) AS MONTO_VENDIDO, FORMAT(MONTO_POR_VENDER,2) AS MONTO_POR_VENDER, FORMAT(MONTO_COBRADO,2) AS MONTO_COBRADO,  FORMAT(MONTO_POR_COBRAR,2) AS MONTO_POR_COBRAR,  FORMAT(MONTO_VENCIDO,2) AS MONTO_VENCIDO  FROM vista_rpt_ventas_inmuebles  
WHERE CODIGO_PROYECTO <>'' ". $_GET['proyecto']. $_GET['grupo'];
//echo $i;

$rst_inmuebles = mysql_query($query_rst_inmuebles, $conexion) or die(mysql_error());

$totalRows_rst_inmuebles = mysql_num_rows($rst_inmuebles);
while($lista_inmuebles= mysql_fetch_assoc($rst_inmuebles))
{$data[] = $lista_inmuebles;}
$pdf->ezTable($data, '',$titles, $options);
$i++;
 

mysql_select_db($database_conexion, $conexion);
$query_rst_suma = "SELECT  CONCAT('Total ',NOMBRE_GRUPO) as NOMBRE_INMUEBLE,  FORMAT(SUM(MONTO_VENDIDO),2) as MONTO_VENDIDO,   FORMAT(SUM(MONTO_POR_VENDER),2)as MONTO_POR_VENDER,   FORMAT(SUM(MONTO_COBRADO),2) as MONTO_COBRADO,  FORMAT(SUM(MONTO_POR_COBRAR),2) as MONTO_POR_COBRAR,   FORMAT(SUM(MONTO_VENCIDO),2) as MONTO_VENCIDO   FROM vista_rpt_ventas_inmuebles WHERE CODIGO_PROYECTO <>'' ". $_GET['proyecto']. $_GET['grupo'];
$rst_suma = mysql_query($query_rst_suma, $conexion) or die(mysql_error());
$row_rst_suma = mysql_fetch_assoc($rst_suma);
$totalRows_rst_suma = mysql_num_rows($rst_suma);
$suma[]=$row_rst_suma; 
$pdf->ezTable($suma,'', $resumen, $options);
?>
<?php
  

     $pdf->ezText("\n\n\n", 0);
 
      $pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);
   
      $pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
  
      $pdf->ezStream();
?>
<?php	
	  
mysql_free_result($rst_grupos);

mysql_free_result($rst_todo);

mysql_free_result($rst_inmuebles);

mysql_free_result($rst_suma);
?>
