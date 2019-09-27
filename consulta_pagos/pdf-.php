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


 include_once('../include/class.ezpdf.php');
// $pdf = new Cezpdf('A2','landscape');
$pdf = new Cezpdf('LEGAL','landscape');
 $pdf->selectFont('../fonts/Courier-Bold.afm');
 $pdf->ezSetCmMargins(1,1,1.5,1.5); 
 
$titulo = "Reporte de Pagos por Partidas";
 $txttit = "<b>".$titulo."</b>\n";
 //$titulo1 = "Filtros: Proyecto: ".$row_rst_todo['NOMBRE_PROYECTO']. "        Partida: ".$row_rst_todo['DESCRIPCION_COMPLETA'];
 //$txttit1 = ("<b>".$titulo1."</b>\n");
 
 $pdf->ezText($titulo, 16);
//$pdf->ezText($txttit1, 14);
 
 $titles = array(
 'DESCRIPCION_DOCUMENTO'=>'<b>Descripcion de Documento</b>',
 'TIPO_PAGO'=>'<b>Tipo de Pago</b>',
 'NUMERO_PAGO'=>'<b>Numero de Pago</b>',
 'FECHA'=>'<b>Fecha</b>',
 'MONTO_DOCUMENTO'=>'<b>Monto de Documento</b>',
 'MONTO_PAGADO'=>'<b>Monto Pagado</b>'
 );
 
 $resumen = array(
 'valor'=>'<b> </b>',
 'Monto_documento'=>'<b>Total Documentos</b>',
 'Monto_pagado'=>'<b>Total Pagado</b>'
 );
 $options = array('shadeCol'=>array(0.9,0.9,0.9,0.9,0.9), 'xOrientation'=>'center', 'width'=>950);

mysql_select_db($database_conexion, $conexion);
if (isset($_POST['partida']) && $_POST['partida']!='' && isset($_POST['proyecto']) && $_POST['proyecto']!='') {
$query_todos = "SELECT DISTINCT ID_PARTIDA, DESCRIPCION_COMPLETA FROM pagos_partidas " .$_POST['proyecto'].$_POST['partida']. " ORDER BY DESCRIPCION_COMPLETA";} else {$query_todos = "SELECT DISTINCT ID_PARTIDA, DESCRIPCION_COMPLETA FROM pagos_partidas ORDER BY DESCRIPCION_COMPLETA";}
$todos = mysql_query($query_todos, $conexion) or die(mysql_error());
$totalRows_todos = mysql_num_rows($todos);



 while ($row_todos = mysql_fetch_assoc($todos)){
mysql_select_db($database_conexion, $conexion);
$query_rst_suma = "SELECT concat('Partida: ', `pagos_partidas`.`DESCRIPCION_COMPLETA`) as valor, FORMAT(SUM(`pagos_partidas`.`MONTO_DOCUMENTO`),2) as Monto_documento, 
FORMAT(sum(`pagos_partidas`.`MONTO_PAGADO`),2) as Monto_pagado, 
FORMAT((SUM(`pagos_partidas`.`MONTO_DOCUMENTO`) - sum(`pagos_partidas`.`MONTO_PAGADO`)),2) as SALDO 
FROM pagos_partidas where id_partida=".$row_todos['ID_PARTIDA'];

$rst_suma = mysql_query($query_rst_suma, $conexion) or die(mysql_error());
//$row_rst_suma = mysql_fetch_assoc($rst_suma);
$totalRows_rst_suma = mysql_num_rows($rst_suma);

mysql_select_db($database_conexion, $conexion);
$query_rst_inmuebles = "SELECT DESCRIPCION_DOCUMENTO, TIPO_PAGO, DESCRIPCION_COMPLETA, FECHA, NUMERO_PAGO, FORMAT(MONTO_DOCUMENTO, 2) AS MONTO_DOCUMENTO, FORMAT(MONTO_PAGADO, 2) AS MONTO_PAGADO FROM pagos_partidas where id_partida= ".$row_todos['ID_PARTIDA']. " order by  DESCRIPCION_COMPLETA, FECHA";

$rst_inmuebles = mysql_query($query_rst_inmuebles, $conexion) or die(mysql_error());

$totalRows_rst_inmuebles = mysql_num_rows($rst_inmuebles);
while($lista_inmuebles= mysql_fetch_assoc($rst_inmuebles)){$data[] = $lista_inmuebles;}

if ($totalRows_rst_suma > 0){
while($lista_grupo= mysql_fetch_assoc($rst_suma)){$suma[] = $lista_grupo;}
} else {$suma[]=$row_rst_suma;} 
$pdf->ezText("\n", 0);
$pdf->ezText( $row_todos['DESCRIPCION_COMPLETA'], 14);
$pdf->ezText("\n", 0);
$pdf->ezTable($data, $titles,'', $options);
$pdf->ezTable($suma, $resumen,'', $options);
$data ="";
$suma ="";
$pdf->ezText("\n", 0);
//$pdf->ezText("Total Documentos: " . $row_rst_suma['Monto_documento'], 12);
//$pdf->ezText("Total Pagados: " . $row_rst_suma['Monto_pagado'], 12);
$pdf->ezText("\n", 0);

 };

?>
<?php
	$pdf->ezText("\n\n\n", 0);
	$pdf->ezText("<b>Fecha:</b> ".date("d/M/Y"), 10);
	$pdf->ezText("<b>Hora:</b> ".date("h:i:s")."\n\n", 10);
	$pdf->ezStream();
?>
<?php	
	  


mysql_free_result($rst_todo);

mysql_free_result($rst_inmuebles);

mysql_free_result($rst_suma);

mysql_free_result($todos);
?>
