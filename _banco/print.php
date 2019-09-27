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

$colname_pago = "-1";
if (isset($_GET['ID_PAGO'])) {
  $colname_pago = $_GET['ID_PAGO'];
}
mysql_select_db($database_conexion, $conexion);
$query_pago = sprintf("SELECT * FROM vista_pagos_partidas WHERE ID_PAGO = %s", GetSQLValueString($colname_pago, "int"));
$pago = mysql_query($query_pago, $conexion) or die(mysql_error());
$row_pago = mysql_fetch_assoc($pago);
$totalRows_pago = mysql_num_rows($pago);
?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_tope = "SELECT * FROM vista_banco_chequeras WHERE ID_CHEQUERA = 1";
$tope = mysql_query($query_tope, $conexion) or die(mysql_error());
$row_tope = mysql_fetch_assoc($tope);
$totalRows_tope = mysql_num_rows($tope);
?>
<?php require('../include/fpdf.php');

//require('fpdf.php');
class PDF_JavaScript extends FPDF {

	var $javascript;
	var $n_js;

	function IncludeJS($script) {
		$this->javascript=$script;
	}

	function _putjavascript() {
		$this->_newobj();
		$this->n_js=$this->n;
		$this->_out('<<');
		$this->_out('/Names [(EmbeddedJS) '.($this->n+1).' 0 R]');
		$this->_out('>>');
		$this->_out('endobj');
		$this->_newobj();
		$this->_out('<<');
		$this->_out('/S /JavaScript');
		$this->_out('/JS '.$this->_textstring($this->javascript));
		$this->_out('>>');
		$this->_out('endobj');
	}

	function _putresources() {
		parent::_putresources();
		if (!empty($this->javascript)) {
			$this->_putjavascript();
		}
	}

	function _putcatalog() {
		parent::_putcatalog();
		if (!empty($this->javascript)) {
			$this->_out('/Names <</JavaScript '.($this->n_js).' 0 R>>');
		}
	}
}

class PDF_AutoPrint extends PDF_JavaScript
{
function AutoPrint($dialog=false)
{
    //Open the print dialog or start printing immediately on the standard printer
    $param=($dialog ? 'true' : 'false');
    $script="print($param);";
    $this->IncludeJS($script);
}


function AutoPrintToPrinter($server, $printer, $dialog=false)
{
    //Print on a shared printer (requires at least Acrobat 6)
    $script = "var pp = getPrintParams();";
    if($dialog)
        $script .= "pp.interactive = pp.constants.interactionLevel.full;";
    else
        $script .= "pp.interactive = pp.constants.interactionLevel.automatic;";
    $script .= "pp.printerName = '\\\\\\\\".$server."\\\\".$printer."';";
    $script .= "print(pp);";
    $this->IncludeJS($script);
}
}

$tope=$row_tope['MARGEN_TOPE'];


$pdf=new PDF_AutoPrint();
$pdf->AddPage('L','Letter');
$pdf->SetFont('Courier','',12);
$pdf->SetXY(190,$tope);

$fecha = date("d/m/Y");

$dia1 = $fecha[0]; 
$dia2 = $fecha[1]; 
$mes1 = $fecha[3]; 
$mes2 = $fecha[4]; 
$ano1 = $fecha[6]; 
$ano2 = $fecha[7]; 
$ano3 = $fecha[8]; 
$ano4 = $fecha[9]; 

$fecha_total = $dia1.' '.' '.' '.$dia2.' '.' '.' '.$mes1.' '.' '.' '.$mes2.' '.' '.' '.$ano1.' '.' '.$ano2.' '.' '.' '.$ano3.' '.' '.' '.$ano4;
 

$pdf->Write(0,$fecha_total);

$pdf->SetXY(65,15+$tope);
$pdf->Write(0,$_GET['BENEFICIARIO']);
$pdf->SetXY(225,16+$tope);
$pdf->Write(0,"**".$_GET['MONTO']."**");
$pdf->SetXY(30,23+$tope);
$pdf->Write(0,"**".$_GET['MONTO_LETRAS']."**");
$pdf->SetXY(25,83);
$pdf->Write(0,"Proveedor: ".$row_pago['PROVEEDOR']);

$pdf->SetXY(30,93);
$pdf->Write(0,"ID ");

$pdf->SetXY(80,93);
$pdf->Write(0,"DETALLE ");

$pdf->SetXY(240,93);
$pdf->Write(0,"MONTO ");
$pdf->SetXY(20,94);
$pdf->Write(0,"_______________________________________________________________________________________________");

$fila=$tope+101;
$MONTO_TOTAL=0;
$DESCRIPCION_PAGO=$row_pago['DESCRIPCION_PAGO'];
do { 
	$pdf->SetXY(25,$fila-$tope);
	$pdf->Write(0,$row_pago['ID_DOCUMENTO']);
	$pdf->SetXY(60,$fila-$tope);
	$pdf->Write(0,substr($row_pago['DESCRIPCION_DOCUMENTO'],0,50));
	$pdf->SetXY(240,$fila-$tope);
	$pdf->Write(0,number_format($row_pago['MONTO_PAGADO'],2));
	$fila=$fila+5;
	$pdf->SetXY(25,$fila-$tope);
	$pdf->Write(0,$row_pago['ID_PARTIDA']);
	$pdf->SetXY(60,$fila-$tope);
	$pdf->Write(0,substr($row_pago['DESCRIPCION_CORTA'],0,52));
	$fila=$fila+5;
	$MONTO_TOTAL=$MONTO_TOTAL+$row_pago['MONTO_PAGADO'];

} while ($row_pago = mysql_fetch_assoc($pago));

$fila=$fila+5;
$pdf->SetXY(25,$fila-$tope);
$pdf->Write(0,$_GET['ID_PAGO']);
$pdf->SetXY(60,$fila-$tope);
$pdf->Write(0,substr($DESCRIPCION_PAGO,0,50));
$pdf->SetXY(200,$fila-$tope);
$pdf->Write(0,"Total----->");
$pdf->SetXY(240,$fila-$tope);
$pdf->Write(0,number_format($MONTO_TOTAL,2));
$fila=$fila+5;
if(strlen($DESCRIPCION_PAGO)>51)
{
	$pdf->SetXY(55,$fila-$tope);
	$pdf->Write(0,substr($DESCRIPCION_PAGO,50,100));
	$fila=$fila+5;
}

$fila=$fila+10;

$pdf->SetXY(15,$fila-$tope);
$pdf->Write(0,"Preparado por: _____________________________    Aprobado por: _____________________________");

$fila=$fila+10;
$pdf->SetXY(15,$fila-$tope);
$pdf->Write(0,"Recibido por: ___________________    Nombre:___________________  Cedula:___________________");



$pdf->AutoPrint(true);
$pdf->Output();

?>
