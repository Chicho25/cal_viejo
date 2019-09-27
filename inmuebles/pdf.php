<?php include('../Connections/conexion.php'); ?>
<?php
if(isset($_GET['proyecto'])){$proyecto=$_GET['proyecto'];} else {$proyecto='';}
if(isset($_GET['area'])){$area=$_GET['area'];} else {$area='';}
if(isset($_GET['grupo'])){$grupo=$_GET['grupo'];} else {$grupo='';}
if(isset($_GET['inmueble'])){$inmueble=$_GET['inmueble'];} else {$inmueble='';}
if(isset($_GET['habitaciones'])){$habitaciones=$_GET['habitaciones'];} else {$habitaciones='';}
if(isset($_GET['sanitarios'])){$sanitarios=$_GET['sanitarios'];} else {$sanitarios='';}
if(isset($_GET['depositos'])){$depositos=$_GET['depositos'];} else {$depositos='';}
if(isset($_GET['estacionamientos'])){$estacionamientos=$_GET['estacionamientos'];} else {$estacionamientos='';}
if(isset($_GET['status'])){$status=$_GET['status'];} else {$status='';}


mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM vista_inmuebles WHERE COD_PROYECTO <> ''".$proyecto." ".$area." ".$grupo." ".$inmueble." ".$habitaciones." ".$sanitarios." ".$depositos." ".$estacionamientos." ".$status;
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
//$row_Recordset1 = mysql_fetch_assoc($Recordset1);


mysql_select_db($database_conexion, $conexion);
$query_Recordset2 = "SELECT * FROM vista_inmuebles WHERE COD_PROYECTO <> ''".$proyecto." ".$area." ".$grupo." ".$inmueble." ".$habitaciones." ".$sanitarios." ".$depositos." ".$estacionamientos." ".$status;
$Recordset2 = mysql_query($query_Recordset2, $conexion) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
//echo $query_Recordset1;
$totalRows_Recordset1 = mysql_num_rows($Recordset1);


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

if($row_Recordset2['NOMBRE_PROYECTO']=="CRYSTAL PLAZA"){
    $pdf->Image("../img/logoCrystal_plaza.jpg" , 8 ,3, 35 , 35 , "JPG" ,"");
} elseif($row_Recordset2['NOMBRE_PROYECTO']=="MARINA GOLF"){
	 $pdf->Image("../img/marina.jpg" , 8 ,3, 35 , 35 , "JPG" ,"");
} elseif($row_Recordset2['NOMBRE_PROYECTO']=="ALTAMIRA GARDENS"){
	 $pdf->Image("../img/LOGO (2).jpg" , 8 ,3, 35 , 35 , "JPG" ,"");

} else {
	
	    $pdf->Image("../img/Logo.jpg" , 8 ,3, 35 , 35 , "JPG" ,"");
}
date_default_timezone_set('UTC');
    //courier bold 15
    $pdf->SetFont('Arial','B',15);
    //Movernos a la derecha
	$pdf->SetY(20); //posicion de altura
    $pdf->SetX(150); //posicion a lo ancho
    //Título
	$TITULO="Listado de Inmuebles";
    $pdf->Cell(60,10,$TITULO,0,0,'C');
	 $pdf->Ln(20);
	 $pdf->SetFont('Arial','',10);
	$pdf->SetY(38); //posicion de altura
    $pdf->SetX(10); //posicion a lo ancho
	$pdf->Cell(20,5,'Proyecto: '.$row_Recordset2['NOMBRE_PROYECTO'],0,0,'L');
	/*if(isset($_GET['descripcion']) && $_GET['descripcion']!=''){$pdf->Cell(60,10,"Filtro: ".$_GET['descripcion'],0,0,'L');}
*/	 $pdf->SetFont('Arial','',8);
	 $pdf->SetX(-30); //posicion a lo ancho
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
$letra=10;
$pdf->SetFont('Arial','B',$letra);
$fill=false;
$alto=7;
if($letra==4) {$cambio=-2;} elseif ($letra==5){$cambio=0;} elseif ($letra==6){$cambio=2;} elseif($letra==8) {$cambio=6;} else {$cambio=12;}
      $pdf->Cell(5+$cambio,$alto,'No.',1,0,'C');
      $pdf->Cell(60+$cambio,$alto,'GRUPO',1,0,'C');
      $pdf->Cell(60+$cambio,$alto,'NOMBRE INMUEBLE',1,0,'C');
      $pdf->Cell(10+$cambio,$alto,'HABIT',1,0,'C');
      $pdf->Cell(10+$cambio,$alto,'SANIT',1,0,'C');
/*      $pdf->Cell(10+$cambio,$alto,'DEPOS',1,0,'C');
      $pdf->Cell(10+$cambio,$alto,'ESTAC',1,0,'C');
      $pdf->Cell(30+$cambio,$alto,'TIPO',1,0,'C');
*/      $pdf->Cell(10+$cambio,$alto,'MODELO',1,0,'C');
      $pdf->Cell(20+$cambio,$alto,'AREA',1,0,'C');
      $pdf->Cell(25+$cambio,$alto,'PRECIO',1,0,'C');
	  //$pdf->Cell(25+$cambio,$alto,'PRECIO X MTS 2',1,0,'C');
  $pdf->Ln();
$pdf->SetFillColor(0);
$pdf->SetTextColor(0);
$pdf->SetFont('Courier','',$letra);
$saldo=0;
//$id=$rpt['ID_DOCUMENTO'];

 while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)){
	 
	/* if ($row_rpt['ID_DOCUMENTO']!=$id){$id=$row_rpt['ID_DOCUMENTO']; 
	 $pdf->SetTextColor(0,0,255); 
	 	 $pdf->setFillColor(0,0,0); } 
	 else {
	 $pdf->SetTextColor(0,0,0); 
	 	 $pdf->setFillColor(0,0,255); } */
		 $saldo=$saldo+1;
      $pdf->Cell(5+$cambio,$alto,$saldo,1,0,'C');
      $pdf->Cell(60+$cambio,$alto,$row_Recordset1['NOMBRE_GRUPO'],1,0,'L');
      $pdf->Cell(60+$cambio,$alto,$row_Recordset1['NOMBRE_INMUEBLE'],1,0,'L');
      $pdf->Cell(10+$cambio,$alto,$row_Recordset1['HABITACIONES'],1,0,'C');
      $pdf->Cell(10+$cambio,$alto,$row_Recordset1['SANITARIOS'],1,0,'C');
/*      $pdf->Cell(10+$cambio,$alto,$row_Recordset1['DEPOSITOS'],1,0,'C');
      $pdf->Cell(10+$cambio,$alto,$row_Recordset1['ESTACIONAMIENTOS'],1,0,'C');
      $pdf->Cell(30+$cambio,$alto,$row_Recordset1['NOMBRE_TIPO'],1,0,'C');
*/      $pdf->Cell(10+$cambio,$alto,$row_Recordset1['MODELO'],1,0,'C');
      $pdf->Cell(20+$cambio,$alto,$row_Recordset1['AREA'],1,0,'R');
      $pdf->Cell(25+$cambio,$alto,$row_Recordset1['PRECIO_REAL'],1,0,'R');
//$pdf->Cell(25+$cambio,$alto,round(($row_Recordset1['PRECIO_REAL']/$row_Recordset1['AREA']),2),1,0,'R');
 
 $pdf->Ln();
 
}
$pdf->SetFillColor(0);
$pdf->SetTextColor(0);
$pdf->SetFont('Courier','B',12);

$pdf->Cell(25+$cambio,$alto,"RESERVA:  $5000.00",0,0,'L');
$pdf->Ln();
$pdf->Cell(25+$cambio,$alto,"ABONO INICIAL:",0,0,'L');
$pdf->Ln();
/*$pdf->Cell(25+$cambio,$alto,"PARA CLIENTES QUE NO GENERAN INGRESOS EN PANAMA SE RECOMIENDA CALCULAR SU ABONO EN BASE AL 40% Y EL 60% CREDITO BANCARIO",0,0,'L');
$pdf->Ln();
$pdf->Cell(25+$cambio,$alto,"COMPLETAR 10% EN MAXIMO 30 DIAS CUOTAS BIMENSUALES DE 10% CADA UNA A PARTIR DE LA FECHA DE RESERVA",0,0,'L');
$pdf->Ln();
$pdf->Cell(25+$cambio,$alto,"FECHA DE ENTREGA ESTIMADA 18 MESES (IER TRIMESTRE  DE 2014)",0,0,'L');
$pdf->Ln();
*/$pdf->Cell(25+$cambio,$alto,"ESTOS PRECIOS ESTAN SUJETOS A CAMBIO SIN PREVIO AVISO",0,0,'L');
$pdf->Ln();



$pdf->Output();
 
?>
