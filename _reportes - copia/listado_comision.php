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


 include_once('class.ezpdf.php');
$pdf = new Cezpdf('LEGAL','landscape');
 $pdf->selectFont('../fonts/Courier-Bold.afm');
 $pdf->ezSetCmMargins(1,1,1.5,1.5); 
 
 $titulo = "Listado de Comisiones";
 $txttit = "<b>".$titulo."</b>\n";
  $pdf->ezText($txttit, 16,'justification',0);
 
 
 $titles = array(
 'ID_DOCUMENTO'=>'<b>DOCUMENTO</b>',
 'CODIGO_INMUEBLE'=>'<b>INMUEBLE</b>',
 'NOMBRE_VENDEDOR'=>'<b>VENDEDOR</b>',
 'NOMBRE_CLIENTE'=>'<b>CLIENTE</b>',
 'PORCENTAJE_COMISION'=>'<b> % </b>',
 'MONTO_COMISION'=>'<b>COMISION</b>'
 );
 
  $resumen = array(
 'NOMBRE_VENDEDOR'=>'<b>VENDEDOR</b>',
 'COMISIONES'=>'<b>COMISIONES</b>'
 );

 $options = array('shadeCol'=>array(0.9,0.9,0.9,0.9,0.9), 'xOrientation'=>'center', 'width'=>900);



//if ($_GET['detalles']==1){

mysql_select_db($database_conexion, $conexion);
$query_rst_inmuebles = "SELECT 
ID_DOCUMENTO,
CODIGO_INMUEBLE,
NOMBRE_VENDEDOR,
NOMBRE_CLIENTE,
FORMAT(PORCENTAJE_COMISION,2) as PORCENTAJE_COMISION,
FORMAT(MONTO_COMISION,2) as MONTO_COMISION
FROM vista_comisiones_venta
ORDER BY NOMBRE_VENDEDOR";

$rst_inmuebles = mysql_query($query_rst_inmuebles, $conexion) or die(mysql_error());

$totalRows_rst_inmuebles = mysql_num_rows($rst_inmuebles);
while($lista_inmuebles= mysql_fetch_assoc($rst_inmuebles)){$data[] = $lista_inmuebles;}
$pdf->ezTable($data, $titles,'', $options);
//}

 

mysql_select_db($database_conexion, $conexion);
$query_rst_suma = "select NOMBRE_VENDEDOR, FORMAT(sum(MONTO_COMISION),2) as COMISIONES from vista_comisiones_venta GROUP by NOMBRE_VENDEDOR ORDER BY NOMBRE_VENDEDOR";
$rst_suma = mysql_query($query_rst_suma, $conexion) or die(mysql_error());
$totalRows_rst_suma = mysql_num_rows($rst_suma);
if ($totalRows_rst_suma > 0){
while($lista_grupo= mysql_fetch_assoc($rst_suma)){$suma[] = $lista_grupo;}
} else {$suma[]=$row_rst_suma;} 
$pdf->ezText("\n", 0);
$pdf->ezText("Resumen por Vendedores", 16,'justification',0);
$pdf->ezText("\n", 0);
$pdf->ezTable($suma, $resumen,'', $options);
?>
<?php
	$pdf->ezText("\n\n\n", 0);
	$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);
	$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
	$pdf->ezStream();
?>
<?php	
	  
mysql_free_result($rst_inmuebles);

mysql_free_result($rst_suma);
?>
