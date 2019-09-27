<?php
include('../Connections/conexion.php'); 
if ($_GET['ID_PARTIDA']!=''){
	$id_partida=" AND ID_PARTIDA=".$_GET['ID_PARTIDA'];
	}else
	{
		$id_partida='';
		}
if ($_GET['PROVEEDOR']!=''){
	$id_pro_cli=" AND ID_PRO_CLI=".$_GET['PROVEEDOR'];
	}else
	{
		$id_pro_cli='';
		}
		if ($_GET['CODIGO_PROYECTO']!=''){
	$id_proyecto=" AND CODIGO_PROYECTO='".$_GET['CODIGO_PROYECTO']."'";
	}else
	{
		$id_proyecto='';
		}




$sql1=" SELECT 
 ID_PARTIDA, 
 NOMBRE_PRO_CLI,
 CODIGO_PROYECTO
 FROM vista_edo_cuenta_proveedores WHERE MODULO=1 ". $id_pro_cli.$id_proyecto.$_GET['COMISIONES'].$id_partida;

mysql_select_db($database_conexion, $conexion);
$query_rpt1 = sprintf($sql1);
//echo $query_rpt1;
$rpt1 = mysql_query($query_rpt1, $conexion) or die(mysql_error());
$row_rpt1= mysql_fetch_assoc($rpt1);
$totalRows_rpt1 = mysql_num_rows($rpt1);
//echo $totalRows_rpt1;

$sql="SELECT ID_DOCUMENTO, CONCEPTO, TIPO, NUMERO, ID_PARTIDA, FECHA, FECHA_VENCIMIENTO, DESCRIPCION, DEBITO, CREDITO,  NOMBRE_PRO_CLI  FROM vista_edo_cuenta_proveedores WHERE MODULO=1 ". $id_pro_cli.$id_proyecto.$_GET['COMISIONES'].$id_partida; 
//echo $sql;
mysql_select_db($database_conexion, $conexion);
$query_rpt = sprintf($sql);
$rpt = mysql_query($query_rpt, $conexion) or die(mysql_error());
$totalRows_rpt = mysql_num_rows($rpt);
//echo $totalRows_rpt;
if (isset($_GET['TITULO'])) {$TITULO =$_GET['TITULO'];} else {$TITULO ='Estado de Cuenta Proveedor';}


mysql_select_db($database_conexion, $conexion);
$sql2 = "SELECT SUM(DEBITO) AS DEBITO, SUM(CREDITO) AS CREDITO FROM vista_edo_cuenta_proveedores WHERE MODULO=1 ". $id_pro_cli.$id_proyecto.$_GET['COMISIONES'].$id_partida; 
//echo $sql2; 
//include('../Connections/conexion.php'); 
mysql_select_db($database_conexion, $conexion);
$query_rpt2 = sprintf($sql2);
$rpt2 = mysql_query($query_rpt2, $conexion) or die(mysql_error());
$row_rpt2= mysql_fetch_assoc($rpt2);
$totalRows_rpt2 = mysql_num_rows($rpt2);
//echo $totalRows_rpt2;

require('../include/fpdf.php');

class PDF extends FPDF
{   //Pie de página
   function Footer()
   {  $this->SetY(-15);
      $this->SetFont('Arial','',8);
      $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
   }
   
   }

$pdf=new PDF('L','mm','Legal');

$pdf->AliasNbPages();

$pdf->AddPage();
//$pdf->SetY(60);

    //$pdf->Image("../img/Logo.jpg" , 10 ,8, 25 , 25 , "JPG" ,"http://www.mipagina.com");
    //courier bold 15
    $pdf->SetFont('Arial','B',15);
    //Movernos a la derecha
	$pdf->SetY(20); //posicion de altura
    $pdf->SetX(150); //posicion a lo ancho
    //Título
	
    $pdf->Cell(60,10,$TITULO,0,0,'C');
	 $pdf->Ln(20);
	 $pdf->SetFont('Arial','',10);
	$pdf->SetY(20); //posicion de altura
    $pdf->SetX(10); //posicion a lo ancho

	if(isset($_GET['PROVEEDOR']) && $_GET['PROVEEDOR']!=''){$pdf->Cell(60,10,"PROVEEDOR: ".$row_rpt1['NOMBRE_PRO_CLI'],0,0,'L');}
	 $pdf->SetFont('Arial','',8);
	 $pdf->SetX(-30); //posicion a lo ancho
	$pdf->Cell(20,10,"FECHA: ".date("d/m/Y"),0,0,'R');
	$pdf->Ln(5);
	 $pdf->SetFont('Arial','',10);
	//$pdf->SetX(111);
	if(isset($_GET['CODIGO_PROYECTO']) && $_GET['CODIGO_PROYECTO']!=''){$pdf->Cell(10,10,"PROYECTO: ".$row_rpt1['CODIGO_PROYECTO'],0,0,'L');}
	 $pdf->SetFont('Arial','',8);
	 $pdf->SetX(-30); //posicion a lo ancho
	$pdf->Cell(20,10,"HORA: ".date("h:i:s a"),0,0,'R');
	$pdf->Ln(5);
	 $pdf->SetFont('Arial','',10);
	//$pdf->SetX(143);
	if(isset($_GET['ID_PARTIDA']) && $_GET['ID_PARTIDA']!=''){$pdf->Cell(10,10,"PARTIDA: ".$row_rpt1['ID_PARTIDA'],0,0,'L');}
	$pdf->Ln(5);
	//$pdf->SetX(169);
	if(isset($_GET['COMISIONES']) && $_GET['COMISIONES']!=0){$pdf->Cell(5,10,"COMISIONES: SI",0,0,'L');}
	

    //Salto de línea
    $pdf->Ln(5);
	//$pdf->SetDrawColor(0,0,255);
//$pdf->Line(20,20,100,20);
//$pdf->SetFillColor(100,100,250);
//$pdf->SetFillColor(250);
//$pdf->SetTextColor(0); //combinacion de colores mediante RGB
//$pdf->SetDrawColor(0);
$pdf->SetLineWidth(.3);
$letra=8;
$pdf->SetFont('Arial','B',$letra);
$fill=false;
if($letra==4) {$cambio=-2;} elseif ($letra==5){$cambio=0;} elseif ($letra==6){$cambio=2;} elseif($letra==8) {$cambio=6;} else {$cambio=12;}
 $pdf->Cell(14+$cambio,5,'CONCEPTO',1,0,'C'); 
 $pdf->Cell(18+$cambio,5,'TIPO',1,0,'C'); 
 $pdf->Cell(9+$cambio,5,'NUMERO',1,0,'C'); 
 $pdf->Cell(11+$cambio,5,'PARTIDA',1,0,'C'); 
 $pdf->Cell(15+$cambio,5,'EMISION',1,0,'C');
 $pdf->Cell(15+$cambio,5,'VENCIMIENTO',1,0,'C'); 
 $pdf->Cell(140+$cambio,5,'DESCRIPCION',1,0,'C'); 
 $pdf->Cell(18+$cambio,5,'DEBITO',1,0,'C'); 
 $pdf->Cell(18+$cambio,5,'CREDITO',1,0,'C');
 $pdf->Cell(18+$cambio,5,'SALDO',1,0,'C');
 $pdf->Ln();
//$pdf->SetFillColor(0);
//$pdf->SetTextColor(0);
$pdf->SetFont('Courier','',$letra);
$saldo=0;
$id=$rpt['ID_DOCUMENTO'];
$alto=5;
$row_rpt= mysql_fetch_assoc($rpt);
do {
	 

 $pdf->Cell(14+$cambio,$alto,$row_rpt['CONCEPTO'],1,0,'L'); 
 $pdf->Cell(18+$cambio,$alto,$row_rpt['TIPO'],1,0,'C'); 
 $pdf->Cell(9+$cambio,$alto,$row_rpt['NUMERO'],1,0,'C'); 
 $pdf->Cell(11+$cambio,$alto,$row_rpt['ID_PARTIDA'],1,0,'C'); 
 $pdf->Cell(15+$cambio,$alto,$row_rpt['FECHA'],1,0,'C');
 $pdf->Cell(15+$cambio,$alto,$row_rpt['FECHA_VENCIMIENTO'],1,0,'C'); 
 $pdf->Cell(140+$cambio,$alto,substr($row_rpt['DESCRIPCION'], 0, 85),1,0,'L'); 
 $pdf->Cell(18+$cambio,$alto,number_format($row_rpt['DEBITO'],2, ",", "."),1,0,'R'); 
 $pdf->Cell(18+$cambio,$alto,number_format($row_rpt['CREDITO'],2, ",", "."),1,0,'R');
 $saldo=($saldo+$row_rpt['DEBITO'])-$row_rpt['CREDITO'];
 $pdf->Cell(18+$cambio,$alto,number_format($saldo,2, ",", "."),1,0,'R');
 $pdf->Ln();
 
} while ($row_rpt= mysql_fetch_assoc($rpt));

$pdf->SetFont('Arial','B',$letra+2);

 $pdf->Cell(258+$cambio,$alto,"Totales",1,0,'L'); 
 $pdf->Cell(18+$cambio,$alto,number_format($row_rpt2['DEBITO'],2, ",", "."),1,0,'R'); 
 $pdf->Cell(18+$cambio,$alto,number_format($row_rpt2['CREDITO'],2, ",", "."),1,0,'R');
 $saldo=(($saldo+$row_rpt['DEBITO'])-$row_rpt['CREDITO']); 
 $pdf->Cell(18+$cambio,$alto,number_format($saldo,2, ",", "."),1,0,'R'); 
//echo $saldo;
// EJEMPLO PARA LOS TORTALES////////


/* $pdf->Cell(258+$cambio,$alto,'TOTAL',1,0,'L'); 
 $pdf->Cell(18+$cambio,$alto,number_format($row_rpt2['DEBITO'],2, ",", "."),1,0,'R'); 
 $pdf->Cell(18+$cambio,$alto,number_format($row_rpt2['CREDITO'],2, ",", "."),1,0,'R'); 
 $SALDO=$row_rpt2['DEBITO']-$row_rpt2['CREDITO'];
 $pdf->Cell(18+$cambio,$alto,number_format($SALDO,2, ",", "."),1,0,'R'); 
*/
$pdf->Output(); 
 
?>
