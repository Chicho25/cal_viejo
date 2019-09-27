<?php require_once('../../Connections/conexion.php'); ?>
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
require('../include/fpdf.php');
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

$tope=2;//2 //9
$pdf=new PDF_AutoPrint();
$pdf->AddPage('L','Letter');
$pdf->SetFont('Courier','',12);
//$pdf->Cell(140,28);
$pdf->SetXY(190,15-$tope);
$pdf->Write(0,date("d/m/Y"));

$pdf->SetXY(55,23-$tope);
$pdf->Write(0,$_GET['BENEFICIARIO']);

$pdf->SetXY(220,23-$tope);
$pdf->Write(0,"**".$_GET['MONTO']."**");

$pdf->SetXY(55,30-$tope);
$pdf->Write(0,"**".$_GET['MONTO_LETRAS']."**");

/*$pdf->SetXY(25,73);
$pdf->Write(0,"Proveedor: ".$row_pago['PROVEEDOR']);*/

$fila=87;
$MONTO_TOTAL=0;
$DESCRIPCION_PAGO=$row_pago['DESCRIPCION_PAGO'];
do { 
	$pdf->SetXY(25,$fila-$tope);
	$pdf->Write(0,'ID:'.$row_pago['ID_DOCUMENTO']);
	
	$pdf->SetXY(55,$fila-$tope);
	$pdf->Write(0,substr($row_pago['DESCRIPCION_DOCUMENTO'],0,50));
	
/*	$pdf->SetXY(200,$fila-$tope);
	$pdf->Write(0,"")*/;
	
	$pdf->SetXY(240,$fila-$tope); //245
	$pdf->Write(0,number_format($row_pago['MONTO_PAGADO'],2));
	
	$fila=$fila+5;
	
/*	if(strlen($row_pago['DESCRIPCION_DOCUMENTO'])>51)
	{
		$pdf->SetXY(55,$fila-$tope);
		$pdf->Write(0,substr($row_pago['DESCRIPCION_DOCUMENTO'],50,100));
		$fila=$fila+5;
	}*/
	
	$pdf->SetXY(25,$fila-$tope);
	$pdf->Write(0,'ID:'.$row_pago['ID_PARTIDA']);
	
	$pdf->SetXY(55,$fila-$tope);
	$pdf->Write(0,substr($row_pago['DESCRIPCION_CORTA'],0,52));//$row_pago['DESCRIPCION_CORTA']
	
	$fila=$fila+5;
	
	$MONTO_TOTAL=$MONTO_TOTAL+$row_pago['MONTO_PAGADO'];

	
} while ($row_pago = mysql_fetch_assoc($pago));
$fila=$fila+5;
$pdf->SetXY(25,$fila-$tope);
$pdf->Write(0,'ID:'.$_GET['ID_PAGO']);
$pdf->SetXY(55,$fila-$tope);
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

/*$pdf->SetXY(60,92);
$pdf->Write(0,"DESCRIPCION_PARTIDA");
$pdf->SetXY(200,92);
$pdf->Write(0,"ID_PARTIDA");


$pdf->SetXY(60,97);
$pdf->Write(0,"DOCUMENTO");
$pdf->SetXY(200,97);
$pdf->Write(0,"ID_DOCUMENTO");

$pdf->SetXY(60,102);
$pdf->Write(0,"PROVEEDOR");
$pdf->SetXY(200,102);
$pdf->Write(0,"ID_PROVEEDOR");


$pdf->SetXY(30,139);
$pdf->Write(0,"PREPARADO");
$pdf->SetXY(90,139);
$pdf->Write(0,"APROBADO");
*/

$pdf->AutoPrint(true);
$pdf->Output();
?>
<?php
mysql_free_result($pago);
?>


