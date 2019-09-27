<?php 
if(isset($_GET['PROVEEDOR']) && $_GET['PROVEEDOR']!=''){
$sql1=" SELECT 
CODIGO_PROYECTO,
 NOMBRE_INMUEBLE, 
 NOMBRE_PRO_CLI 
 FROM vista_edo_cuenta_clientes where CODIGO_PROYECTO='".$_GET['CODIGO_PROYECTO']."' ".$_GET['PROVEEDOR']."  ".$_GET['INMUEBLE'];
include('../Connections/conexion.php'); 
mysql_select_db($database_conexion, $conexion);
$query_rpt1 = sprintf($sql1);
$rpt1 = mysql_query($query_rpt1, $conexion) or die(mysql_error());
$row_rpt1= mysql_fetch_assoc($rpt1);
$totalRows_rpt1 = mysql_num_rows($rpt1);}

$sql=" SELECT 
 CODIGO_PROYECTO,
 CONCEPTO, 
 TIPO, 
 NUMERO, 
 CODIGO_INMUEBLE, 
 FECHA,
 FECHA_VENCIMIENTO, 
 DESCRIPCION, 
 DEBITO, 
 CREDITO,
 ID_DOCUMENTO, 
 NOMBRE_PRO_CLI 
 FROM vista_edo_cuenta_clientes where MODULO =2 AND CODIGO_PROYECTO='".$_GET['CODIGO_PROYECTO']."' ".$_GET['PROVEEDOR']."  ".$_GET['INMUEBLE'];
include('../Connections/conexion.php'); 
mysql_select_db($database_conexion, $conexion);
$query_rpt = sprintf($sql);
$rpt = mysql_query($query_rpt, $conexion) or die(mysql_error());
$totalRows_rpt = mysql_num_rows($rpt);

//echo $sql;

$sql=" SELECT 
 SUM(DEBITO) AS SUMA_DEBITO, 
 SUM(CREDITO) AS SUMA_CREDITO 
 FROM vista_edo_cuenta_clientes where CODIGO_PROYECTO='".$_GET['CODIGO_PROYECTO']."' ".$_GET['PROVEEDOR']."  ".$_GET['INMUEBLE'];
include('../Connections/conexion.php'); 
mysql_select_db($database_conexion, $conexion);
$query_rpts = sprintf($sql);
$rpts = mysql_query($query_rpts, $conexion) or die(mysql_error());
$row_rpts= mysql_fetch_assoc($rpts);
$totalRows_rpts = mysql_num_rows($rpts);
if (isset($_GET['TITULO'])) {$TITULO =$_GET['TITULO'];} else {$TITULO ='Estado de Cuenta Cliente';}

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
	if(isset($_GET['PROVEEDOR']) && $_GET['PROVEEDOR']!=''){$pdf->Cell(60,10,"CLIENTE: ".$row_rpt1['NOMBRE_PRO_CLI'],0,0,'L');}
	 $pdf->SetFont('Arial','',8);
	 $pdf->SetX(-30); //posicion a lo ancho
	$pdf->Cell(20,10,"FECHA: ".date("d/m/Y"),0,0,'R');
	$pdf->Ln(5);
	 $pdf->SetFont('Arial','',10);
	//$pdf->SetX(111);
	//if(isset($_GET['CODIGO_PROYECTO']) && $_GET['CODIGO_PROYECTO']!=''){$pdf->Cell(10,10,"PROYECTO: ".$row_rpt1['CODIGO_PROYECTO'],0,0,'L');}
	 $pdf->SetFont('Arial','',8);
	 $pdf->SetX(-30); //posicion a lo ancho
	$pdf->Cell(20,10,"HORA: ".date("h:i:s a"),0,0,'R');
	$pdf->Ln(5);
	 $pdf->SetFont('Arial','',10);
	//$pdf->SetX(143);
	//if(isset($_GET['INMUEBLE']) && $_GET['INMUEBLE']!=''){$pdf->Cell(10,10,"INMUEBLE: ".$row_rpt1['NOMBRE_INMUEBLE'],0,0,'L');}
	$pdf->Ln(10);

	$pdf->SetDrawColor(0,0,255);
//$pdf->Line(20,20,100,20);
//$pdf->SetFillColor(100,100,250);
$pdf->SetFillColor(250);
$pdf->SetTextColor(0); //combinacion de colores mediante RGB
$pdf->SetDrawColor(0);
$pdf->SetLineWidth(.3);
$letra=8;
$pdf->SetFont('Arial','B',$letra);
$fill=false;
if($letra==4) {$cambio=-2;} elseif ($letra==5){$cambio=0;} elseif ($letra==6){$cambio=2;} elseif($letra==8) {$cambio=6;} else {$cambio=12;}
 $pdf->Cell(14+$cambio,5,'CONCEPTO',1,0,'C',1); 
 $pdf->Cell(18+$cambio,5,'TIPO',1,0,'C',1); 
 $pdf->Cell(9+$cambio,5,'NUMERO',1,0,'C',1); 
 $pdf->Cell(11+$cambio,5,'INMUEBLE',1,0,'C',1); 
 $pdf->Cell(15+$cambio,5,'EMISION',1,0,'C',1);
 $pdf->Cell(15+$cambio,5,'VENCIMIENTO',1,0,'C',1); 
 $pdf->Cell(140+$cambio,5,'DESCRIPCION',1,0,'C',1); 
 $pdf->Cell(18+$cambio,5,'DEBITO',1,0,'C',1); 
 $pdf->Cell(18+$cambio,5,'CREDITO',1,0,'C',1);
 $pdf->Cell(18+$cambio,5,'SALDO',1,0,'C',1);
 $pdf->Ln();
$pdf->SetFillColor(0);
$pdf->SetTextColor(0);
$pdf->SetFont('Courier','',$letra);
$saldo=0;
$id=$rpt['ID_DOCUMENTO'];
$alto=5;
 while ($row_rpt= mysql_fetch_assoc($rpt)){
	 
	/* if ($row_rpt['ID_DOCUMENTO']!=$id){$id=$row_rpt['ID_DOCUMENTO']; 
	 $pdf->SetTextColor(0,0,255); 
	 	 $pdf->setFillColor(0,0,0); } 
	 else {
	 $pdf->SetTextColor(0,0,0); 
	 	 $pdf->setFillColor(0,0,255); } */
 $pdf->Cell(14+$cambio,$alto,$row_rpt['CONCEPTO'],1,0,'L'); 
 $pdf->Cell(18+$cambio,$alto,$row_rpt['TIPO'],1,0,'C'); 
 $pdf->Cell(9+$cambio,$alto,$row_rpt['NUMERO'],1,0,'C'); 
 $pdf->Cell(11+$cambio,$alto,$row_rpt['CODIGO_INMUEBLE'],1,0,'C'); 
 $pdf->Cell(15+$cambio,$alto,$row_rpt['FECHA'],1,0,'C');
 $pdf->Cell(15+$cambio,$alto,$row_rpt['FECHA_VENCIMIENTO'],1,0,'C'); 
 $pdf->Cell(140+$cambio,$alto,substr($row_rpt['DESCRIPCION'], 0, 85),1,0,'L'); 
 $pdf->Cell(18+$cambio,$alto,number_format($row_rpt['DEBITO'],2, ",", "."),1,0,'R'); 
 $pdf->Cell(18+$cambio,$alto,number_format($row_rpt['CREDITO'],2, ",", "."),1,0,'R');
 $saldo=($saldo+$row_rpt['DEBITO'])-$row_rpt['CREDITO'];
 $pdf->Cell(18+$cambio,$alto,number_format($saldo,2, ",", "."),1,0,'R');
 $pdf->Ln();
 
}
$pdf->SetFillColor(250);
$pdf->SetTextColor(0); //combinacion de colores mediante RGB
$pdf->SetDrawColor(0);
$pdf->SetLineWidth(.3);
$letra=10;
$pdf->SetFont('Arial','B',$letra);
 $pdf->Cell(14+$cambio,$alto,'',1,0,'L'); 
 $pdf->Cell(18+$cambio,$alto,'',1,0,'C'); 
 $pdf->Cell(9+$cambio,$alto,'',1,0,'C'); 
 $pdf->Cell(11+$cambio,$alto,'',1,0,'C'); 
 $pdf->Cell(15+$cambio,$alto,'',1,0,'C');
 $pdf->Cell(15+$cambio,$alto,'',1,0,'C'); 
 $pdf->Cell(140+$cambio,$alto,'TOTALES',1,0,'R');
 $pdf->Cell(18+$cambio,$alto,number_format($row_rpts['SUMA_DEBITO'],2, ",", "."),1,0,'R'); 
 $pdf->Cell(18+$cambio,$alto,number_format($row_rpts['SUMA_CREDITO'],2, ",", "."),1,0,'R');
 $saldos=($row_rpts['SUMA_DEBITO'])-$row_rpts['SUMA_CREDITO'];
 $pdf->Cell(18+$cambio,$alto,number_format($saldos,2, ",", "."),1,0,'R');
 $pdf->Ln();

$pdf->Output();
 
?>
