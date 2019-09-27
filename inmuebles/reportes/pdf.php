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


if(isset($_GET['descripcion']) && $_GET['descripcion']!=''){
	$where= " AND UPPER(descripcion_completa) LIKE '%".$_GET['descripcion']."%'";
} else {$where= " ";}


mysql_select_db($database_conexion, $conexion);
$query_rst_todo = "SELECT 
  `vista_partidas`.`NOMBRE_PROYECTO`, 
`vista_partidas`.`DESCRIPCION_COMPLETA`, 
format(`vista_partidas`.`MONTO_ESTIMADO`,2) as MONTO_ESTIMADO, 
format(`vista_partidas`.`MONTO_ASIGNADO`,2) as MONTO_ASIGNADO, 
format(`vista_partidas`.`MONTO_PAGADO`,2) as MONTO_PAGADO,
format(`vista_partidas`.`porcentaje_monto_estimado_disponible`,2) as PORCENTAJE
FROM vista_partidas
WHERE tipo=2
AND porcentaje_monto_estimado_disponible<=". $_GET['valor']. $where;
//echo $query_rst_todo;
$rst_todo = mysql_query($query_rst_todo, $conexion) or die(mysql_error());
//$row_rst_todo = mysql_fetch_assoc($rst_todo);
$totalRows_rst_todo = mysql_num_rows($rst_todo);


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
	$TITULO="Reporte de partidas por agotarse";
    $pdf->Cell(60,10,$TITULO,0,0,'C');
	 $pdf->Ln(20);
	 $pdf->SetFont('Arial','',10);
	$pdf->SetY(20); //posicion de altura
    $pdf->SetX(10); //posicion a lo ancho
	if(isset($_GET['descripcion']) && $_GET['descripcion']!=''){$pdf->Cell(60,10,"Filtro: ".$_GET['descripcion'],0,0,'L');}
	 $pdf->SetFont('Arial','',8);
	 $pdf->SetX(-30); //posicion a lo ancho
	$pdf->Cell(20,10,"FECHA: ".date("d/m/Y"),0,0,'R');
	$pdf->Ln(5);
	 $pdf->SetFont('Arial','',10);
	//$pdf->SetX(111);
	if(isset($_GET['valor']) && $_GET['valor']!=''){$pdf->Cell(10,10,"Porcentaje por ejecutarse <=:  ".$_GET['valor']. " %",0,0,'L');}
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
 $pdf->Cell(45+$cambio,5,'PROYECTO',1,0,'C',1); 
 $pdf->Cell(170+$cambio,5,'DESCRIPCION_COMPLETA',1,0,'C',1); 
 $pdf->Cell(20+$cambio,5,'ESTIMADO',1,0,'C',1); 
 $pdf->Cell(20+$cambio,5,'ASIGNADO',1,0,'C',1); 
 $pdf->Cell(20+$cambio,5,'PAGADO',1,0,'C',1);
 $pdf->Cell(10+$cambio,5,'PORC',1,0,'C',1); 
  $pdf->Ln();
$pdf->SetFillColor(0);
$pdf->SetTextColor(0);
$pdf->SetFont('Courier','',$letra);
$saldo=0;
//$id=$rpt['ID_DOCUMENTO'];
$alto=5;
 while ($row_rst_todo = mysql_fetch_assoc($rst_todo)){
	 
	/* if ($row_rpt['ID_DOCUMENTO']!=$id){$id=$row_rpt['ID_DOCUMENTO']; 
	 $pdf->SetTextColor(0,0,255); 
	 	 $pdf->setFillColor(0,0,0); } 
	 else {
	 $pdf->SetTextColor(0,0,0); 
	 	 $pdf->setFillColor(0,0,255); } */
 $pdf->Cell(45+$cambio,$alto,$row_rst_todo['NOMBRE_PROYECTO'],1,0,'C'); 
 $pdf->Cell(170+$cambio,$alto,$row_rst_todo['DESCRIPCION_COMPLETA'],1,0,'L'); 
 $pdf->Cell(20+$cambio,$alto,$row_rst_todo['MONTO_ESTIMADO'],1,0,'R'); 
 $pdf->Cell(20+$cambio,$alto,$row_rst_todo['MONTO_ASIGNADO'],1,0,'R'); 
 $pdf->Cell(20+$cambio,$alto,$row_rst_todo['MONTO_PAGADO'],1,0,'R');
 $pdf->Cell(10+$cambio,$alto,$row_rst_todo['PORCENTAJE'],1,0,'C');
 $pdf->Ln();
 
}



$pdf->Output();
 
?>
