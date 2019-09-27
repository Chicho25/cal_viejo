<?php include('../Connections/conexion.php'); ?>
<?php include('../include/_funciones.php'); ?>
<?php
if(isset($_GET['proyecto'])){$proyecto=$_GET['proyecto'];} else {$proyecto='';}
if(isset($_GET['CLIENTES']) && $_GET['CLIENTES']!= " "){$clientes=" AND ID_CLIENTE=".$_GET['CLIENTES'];} else {$clientes='';}
if(isset($_GET['grupo'])){$grupo=$_GET['grupo'];} else {$grupo='';}
if(isset($_GET['inmueble'])){$inmueble=$_GET['inmueble'];} else {$inmueble='';}
if(isset($_GET['VENDEDORES']) && $_GET['VENDEDORES']!= " "){$vendedores=" AND ID_VENDEDOR=".$_GET['VENDEDORES'];} else {$vendedores='';}
if(isset($_GET['DESDE']) && $_GET['DESDE']!='' && isset($_GET['HASTA']) && $_GET['HASTA']!='')
{$fi=DMAtoAMD($_GET['DESDE']); $ff=DMAtoAMD($_GET['HASTA']);
	$fecha=' AND FECHA_VENTA_DATE BETWEEN "'.$fi.'" AND "'.$ff.'"';} else {$fecha='';}


mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT DISTINCT ID_INMUEBLES, CODIGO_INMUEBLE, NOMBRE_GRUPO, FECHA_VENTA, NOMBRE_CLIENTE, MONTO_VENTA FROM vista_ventas_comisiones WHERE ID_PROYECTO <> ''".$proyecto." ".$clientes." ".$grupo." ".$inmueble." ".$vendedores." ".$fecha. " order by FECHA_VENTA_DATE";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
//$row_Recordset1 = mysql_fetch_assoc($Recordset1);
//echo $query_Recordset1;


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
/*
if($row_Recordset2['PROYECTO']=="CRYSTAL PLAZA"){
    $pdf->Image("../img/logoCrystal_plaza.jpg" , 8 ,3, 35 , 35 , "JPG" ,"");
} elseif($row_Recordset2['PROYECTO']=="MARINA GOLF"){
	 $pdf->Image("../img/marina.jpg" , 8 ,3, 35 , 35 , "JPG" ,"");
} elseif($row_Recordset2['PROYECTO']=="ALTAMIRA GARDENS"){
	 $pdf->Image("../img/LOGO (2).jpg" , 8 ,3, 35 , 35 , "JPG" ,"");

} else {
	
	    $pdf->Image("../img/Logo.jpg" , 8 ,3, 35 , 35 , "JPG" ,"");
}*/
    //courier bold 15
    $pdf->SetFont('Arial','B',15);
    //Movernos a la derecha
	$pdf->SetY(20); //posicion de altura
    $pdf->SetX(150); //posicion a lo ancho
    //Título
	$TITULO="Ventas de Inmuebles";
    $pdf->Cell(60,10,$TITULO,0,0,'C');
	 $pdf->Ln(20);
	 $pdf->SetFont('Arial','',10);
	$pdf->SetY(38); //posicion de altura
    $pdf->SetX(10); //posicion a lo ancho
	//$pdf->Cell(20,5,'Proyecto: '.$row_Recordset2['PROYECTO'],0,0,'L');
	/*if(isset($_GET['descripcion']) && $_GET['descripcion']!=''){$pdf->Cell(60,10,"Filtro: ".$_GET['descripcion'],0,0,'L');}
*/	 $pdf->SetFont('Arial','',8);
	 $pdf->SetX(-60); //posicion a lo ancho
	$pdf->Cell(20,10,"FECHA: ".date("d/m/Y"),0,0,'R');
	$pdf->Ln(5);
	 $pdf->SetFont('Arial','',10);
	//$pdf->SetX(111);
	$pdf->Ln(10);

	$pdf->SetDrawColor(0,0,255);
//$pdf->Line(20,20,100,20);
//$pdf->SetFillColor(100,100,250);
$pdf->SetFillColor(250);
$pdf->SetTextColor(0); //combinacion de colores mediante RGB
$pdf->SetDrawColor(0);
$pdf->SetLineWidth(.3);

 while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)){
	  $pdf->SetX(30); //posicion a lo ancho
$letra=10;
$pdf->SetFont('Arial','B',$letra);
$fill=false;
$alto=7;
if($letra==4) {$cambio=-2;} elseif ($letra==5){$cambio=0;} elseif ($letra==6){$cambio=2;} elseif($letra==8) {$cambio=6;} else {$cambio=12;}


      $pdf->Cell(5+$cambio,$alto,'ID',1,0,'C');
	  $pdf->Cell(20+$cambio,$alto,'CODIGO',1,0,'C');
	  $pdf->Cell(70+$cambio,$alto,'GRUPO',1,0,'C');
	  $pdf->Cell(17+$cambio,$alto,'FECHA',1,0,'C');
      $pdf->Cell(90+$cambio,$alto,'CLIENTE',1,0,'C');
      $pdf->Cell(20+$cambio,$alto,'MONTO',1,0,'C');
  $pdf->Ln();
$pdf->SetFillColor(0);
$pdf->SetTextColor(0);
$pdf->SetFont('Courier','',$letra);
$pdf->SetX(30); //posicion a lo ancho
      $pdf->Cell(5+$cambio,$alto,$row_Recordset1['ID_INMUEBLES'],1,0,'L');
	  $pdf->Cell(20+$cambio,$alto,$row_Recordset1['CODIGO_INMUEBLE'],1,0,'C');
	  $pdf->Cell(70+$cambio,$alto,$row_Recordset1['NOMBRE_GRUPO'],1,0,'L');
      $pdf->Cell(17+$cambio,$alto,$row_Recordset1['FECHA_VENTA'],1,0,'C');
      $pdf->Cell(90+$cambio,$alto,$row_Recordset1['NOMBRE_CLIENTE'],1,0,'L');
      $pdf->Cell(20+$cambio,$alto,$row_Recordset1['MONTO_VENTA'],1,0,'R');
 
 $pdf->Ln();
 
 ///////////////////////////////////
 
 
mysql_select_db($database_conexion, $conexion);
$query_Recordset2 = "SELECT NOMBRE_VENDEDOR, PORCENTAJE_COMISION, MONTO_COMISION FROM vista_ventas_comisiones WHERE ID_INMUEBLES = ".$row_Recordset1['ID_INMUEBLES'];
$Recordset2 = mysql_query($query_Recordset2, $conexion) or die(mysql_error());
//$row_Recordset2 = mysql_fetch_assoc($Recordset2);
//echo $query_Recordset1;



 $letra=10;
$pdf->SetFont('Arial','B',$letra);
$fill=false;
$alto=7;
$TOTAL_COMISION=0;
$pdf->SetX(30); //posicion a lo ancho
if($letra==4) {$cambio=-2;} elseif ($letra==5){$cambio=0;} elseif ($letra==6){$cambio=2;} elseif($letra==8) {$cambio=6;} else {$cambio=12;}


      $pdf->Cell(223+$cambio,$alto,'VENDEDOR',1,0,'C');
	  $pdf->Cell(15+$cambio,$alto,'PORCENTAJE',1,0,'C');
	  $pdf->Cell(20+$cambio,$alto,'MONTO',1,0,'C');
  $pdf->Ln();
    while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)){
		$pdf->SetX(30); //posicion a lo ancho
$pdf->SetFillColor(0);
$pdf->SetTextColor(0);
$pdf->SetFont('Courier','',$letra);
      $pdf->Cell(223+$cambio,$alto,$row_Recordset2['NOMBRE_VENDEDOR'],1,0,'L');
	  $pdf->Cell(15+$cambio,$alto,number_format($row_Recordset2['PORCENTAJE_COMISION'],2).' %',1,0,'C');
	  $pdf->Cell(20+$cambio,$alto,number_format($row_Recordset2['MONTO_COMISION'],2),1,0,'R');
 $TOTAL_COMISION=$TOTAL_COMISION+$row_Recordset2['MONTO_COMISION'];
 $pdf->Ln();
  }
   $letra=10;
$pdf->SetFont('Courier','B',$letra);
$fill=false;
$alto=7;
$pdf->SetX(30); //posicion a lo ancho
if($letra==4) {$cambio=-2;} elseif ($letra==5){$cambio=0;} elseif ($letra==6){$cambio=2;} elseif($letra==8) {$cambio=6;} else {$cambio=12;}

  	  $pdf->Cell(250+$cambio,$alto,'TOTAL COMISIONES',1,0,'L');
	  $pdf->Cell(20+$cambio,$alto,number_format($TOTAL_COMISION,2),1,0,'R');
   $pdf->Ln(12);
}
$pdf->SetFillColor(0);
$pdf->SetTextColor(0);
$pdf->SetFont('Courier','B',12);

/*$pdf->Cell(25+$cambio,$alto,"RESERVA:  $5000.00",0,0,'L');
$pdf->Ln();
$pdf->Cell(25+$cambio,$alto,"ABONO INICIAL:",0,0,'L');
$pdf->Ln();
$pdf->Cell(25+$cambio,$alto,"PARA CLIENTES QUE NO GENERAN INGRESOS EN PANAMA SE RECOMIENDA CALCULAR SU ABONO EN BASE AL 40% Y EL 60% CREDITO BANCARIO",0,0,'L');
$pdf->Ln();
$pdf->Cell(25+$cambio,$alto,"COMPLETAR 10% EN MAXIMO 30 DIAS CUOTAS BIMENSUALES DE 10% CADA UNA A PARTIR DE LA FECHA DE RESERVA",0,0,'L');
$pdf->Ln();
$pdf->Cell(25+$cambio,$alto,"FECHA DE ENTREGA ESTIMADA 18 MESES (IER TRIMESTRE  DE 2014)",0,0,'L');
$pdf->Ln();
$pdf->Cell(25+$cambio,$alto,"ESTOS PRECIOS ESTAN SUJETOS A CAMBIO SIN PREVIO AVISO",0,0,'L');*/
$pdf->Ln();



$pdf->Output();
 
?>
