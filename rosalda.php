<?php include('include/_funciones.php'); ?>
<?php
$sql1="SELECT DISTINCT  
 pro_cli_master.ID_PRO_CLI_MASTER,
  pro_cli_master.NOMBRE,
  pro_cli_master.PROFESION,
  terceros_estado_civil.DESCRIPCION AS EDO_CIVIL,
  terceros_relacion_laborar.DESCRIPCION AS LABORAL,
  pro_cli_master.CONTACTO,
  pro_cli_master.ID_TRIBUTARIA_CEDULA,
  pro_cli_master.CODIGO,
  pro_cli_master.DIRECCION,
  pro_cli_master.TELEFONO_FIJO_1,
  pro_cli_master.TELEFONO_FIJO_2,
  pro_cli_master.TELEFONO_MOVIL_1,
  pro_cli_master.TELEFONO_MOVIL_2,
  pro_cli_master.EMAIL_1,
  pro_cli_master.EMAIL_2,
  pro_cli_master.OBSERVACIONES,
  terceros_nacionalidad.DESCRIPCION AS NACIONALIDAD
FROM
  pro_cli_master
  LEFT JOIN terceros_relacion_laborar ON (pro_cli_master.ID_RELACION_LABORAR = terceros_relacion_laborar.ID_TERCEROS_RELACION_LABORAR)
  LEFT JOIN terceros_estado_civil ON (pro_cli_master.ID_ESTADO_CIVIL = terceros_estado_civil.ID_TERCEROS_ESTADO_CIVIL)
  LEFT JOIN terceros_nacionalidad ON (pro_cli_master.ID_NACIONALIDAD = terceros_nacionalidad.ID_TERCEROS_NACIONALIDAD)
  INNER JOIN vista_documentos_ventas ON (pro_cli_master.ID_PRO_CLI_MASTER = vista_documentos_ventas.ID_PRO_CLI)
  WHERE vista_documentos_ventas.COD_PROYECTO='".$_GET['PROYECTO']."' AND vista_documentos_ventas.ID_GRUPO='".$_GET['GRUPO']."' ORDER BY vista_documentos_ventas.CODIGO_INMUEBLE";//where ID_PRO_CLI_MASTER in (72, 57, 29)
  
include('../Connections/conexion.php'); 
mysql_select_db($database_conexion, $conexion);
$query_rpt1 = sprintf($sql1);
$rpt1 = mysql_query($query_rpt1, $conexion) or die(mysql_error());
$totalRows_rpt1 = mysql_num_rows($rpt1);



require('include/fpdf.php');

class PDF extends FPDF
{   //Pie de página
   function Footer()
   {  $this->SetY(-15);
      $this->SetFont('Arial','',8);
      $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
   }
   
   }

$pdf=new PDF('L','mm','LETTER');

$pdf->AliasNbPages();

$pdf->AddPage();
//$pdf->SetY(60);

    //$pdf->Image("../img/Logo.jpg" , 10 ,8, 25 , 25 , "JPG" ,"http://www.mipagina.com");
    //courier bold 15
    $pdf->SetFont('Arial','B',15);
    //Movernos a la derecha
	$pdf->SetY(20); //posicion de altura
    $pdf->SetX(120); //posicion a lo ancho
    //Título
	$TITULO='REPORTE';
    $pdf->Cell(40,10,$TITULO,0,0,'C');
	 $pdf->Ln(10);
	 $pdf->SetFont('Arial','',10);
	//$pdf->SetY(20); //posicion de altura
   // $pdf->SetX(10); //posicion a lo ancho

	

    //Salto de línea
    $pdf->Ln(5);
	$pdf->SetDrawColor(0,0,255);
//$pdf->Line(20,20,100,20);
//$pdf->SetFillColor(100,100,250);
$pdf->SetFillColor(200);
$pdf->SetTextColor(0); //combinacion de colores mediante RGB
$pdf->SetDrawColor(0);
$pdf->SetLineWidth(.3);
$letra=8;
$pdf->SetFont('Arial','B',$letra);
$fill=false;
if($letra==4) {$cambio=-2;} elseif ($letra==5){$cambio=0;} elseif ($letra==6){$cambio=2;} elseif($letra==8) {$cambio=6;} else {$cambio=12;}
while ($row_rpt= mysql_fetch_assoc($rpt1)){

$pdf->Cell(70+$cambio,5,'NOMBRE',1,0,'C',1); 
$pdf->Cell(40+$cambio,5,'PROFESION',1,0,'C',1); 
$pdf->Cell(20+$cambio,5,'EDO_CIVIL',1,0,'C',1); 
$pdf->Cell(20+$cambio,5,'R LABORAL',1,0,'C',1);
$pdf->Cell(38+$cambio,5,'CEDULA',1,0,'C',1);
$pdf->Cell(38+$cambio,5,'RUC',1,0,'C',1);
 
$pdf->Ln();

$pdf->Cell(70+$cambio,5,$row_rpt['NOMBRE'],1,0,'L'); 
$pdf->Cell(40+$cambio,5,$row_rpt['PROFESION'],1,0,'L'); 
$pdf->Cell(20+$cambio,5,$row_rpt['EDO_CIVIL'],1,0,'L'); 
$pdf->Cell(20+$cambio,5,$row_rpt['LABORAL'],1,0,'L'); 
$pdf->Cell(38+$cambio,5,$row_rpt['CODIGO'],1,0,'L'); 
$pdf->Cell(38+$cambio,5,$row_rpt['ID_TRIBUTARIA_CEDULA'],1,0,'L'); 

$pdf->Ln();
$pdf->Cell(58+$cambio,5,'CONTACTO',1,0,'C',1); 
$pdf->Cell(27+$cambio,5,'TELEFONO_FIJO_1',1,0,'C',1); 
$pdf->Cell(27+$cambio,5,'TELEFONO_FIJO_2',1,0,'C',1);
$pdf->Cell(27+$cambio,5,'TELEFONO_MOVIL_1',1,0,'C',1);
$pdf->Cell(27+$cambio,5,'TELEFONO_MOVIL_2',1,0,'C',1);
$pdf->Cell(60+$cambio,5,'EMAIL_1',1,0,'C',1); 

$pdf->Ln();

$pdf->Cell(58+$cambio,5,$row_rpt['CONTACTO'],1,0,'L'); 
$pdf->Cell(27+$cambio,5,$row_rpt['TELEFONO_FIJO_1'],1,0,'L'); 
$pdf->Cell(27+$cambio,5,$row_rpt['TELEFONO_FIJO_2'],1,0,'L');
$pdf->Cell(27+$cambio,5,$row_rpt['TELEFONO_MOVIL_1'],1,0,'L');
$pdf->Cell(27+$cambio,5,$row_rpt['TELEFONO_MOVIL_2'],1,0,'L');
$pdf->Cell(60+$cambio,5,$row_rpt['EMAIL_1'],1,0,'L'); 	 
$pdf->SetFont('Arial','B',$letra);

 $pdf->Ln(5);
 
  $sql3="SELECT DISTINCT 
  vista_documentos_ventas.CODIGO_INMUEBLE
FROM
  vista_documentos_ventas
WHERE vista_documentos_ventas.COD_PROYECTO='".$_GET['PROYECTO']."' AND vista_documentos_ventas.ID_GRUPO='".$_GET['GRUPO']."' and vista_documentos_ventas.ID_PRO_CLI = ".$row_rpt['ID_PRO_CLI_MASTER'];
  

mysql_select_db($database_conexion, $conexion);
$query_rpt3 = sprintf($sql3);
$rpt3 = mysql_query($query_rpt3, $conexion) or die(mysql_error());
$totalRows_rpt3 = mysql_num_rows($rpt3);


while ($row_rpt3= mysql_fetch_assoc($rpt3))
{
			 $sql2="SELECT 
			  vista_documentos_ventas.CODIGO_INMUEBLE,
			  vista_documentos_ventas.MONTO_VENTA,
			  vista_documentos_ventas.TIPO_DOCUMENTO,
			  vista_documentos_ventas.NUMERO_DOCUMENTO,
			  vista_documentos_ventas.FECHA_DOCUMENTO_DATE,
			  vista_documentos_ventas.FECHA_VENCIMIENTO_DATE,
			  vista_documentos_ventas.FECHA_DOCUMENTO,
			  vista_documentos_ventas.FECHA_VENCIMIENTO,
			  vista_documentos_ventas.MONTO_DOCUMENTO,
			  vista_documentos_ventas.MONTO_PAGADO,
			  vista_documentos_ventas.MONTO_PENDIENTE,
			  vista_documentos_ventas.VENCIDO,
			  vista_documentos_ventas.NOMBRE_BANCO,
			  vista_documentos_ventas.STATUS_APROBADO,
			  vista_documentos_ventas.DESCRIPCION_DOCUMENTO,
			  pagos_detalle.MONTO_PAGADO,
			  pagos.FECHA

			FROM
			vista_documentos_ventas
			INNER JOIN pagos_detalle ON (vista_documentos_ventas.ID_DOCUMENTO = pagos_detalle.ID_DOCUMENTO)
  			INNER JOIN pagos ON (pagos_detalle.ID_PAGO = pagos.ID_PAGO)
			WHERE vista_documentos_ventas.CODIGO_INMUEBLE= '".$row_rpt3['CODIGO_INMUEBLE']."' ORDER BY FECHA_VENCIMIENTO_DATE, FECHA";
			  
			
			mysql_select_db($database_conexion, $conexion);
			$query_rpt2 = sprintf($sql2);
			$rpt2 = mysql_query($query_rpt2, $conexion) or die(mysql_error());
			$totalRows_rpt2 = mysql_num_rows($rpt2);
					
			 $pdf->Cell(16+$cambio,5,'INMUEBLE',1,0,'C'); 
			 $pdf->Cell(74+$cambio,5,'PLANIFICACION',1,0,'C'); 
			 $pdf->Cell(15+$cambio,5,'EMISION',1,0,'C'); 
			 $pdf->Cell(15+$cambio,5,'VENCIMIENTO',1,0,'C'); 
			 $pdf->Cell(16+$cambio,5,'PAGADO',1,0,'C');
			 $pdf->Cell(26+$cambio,5,'MONTO DOCUMENTO',1,0,'C');
			 $pdf->Cell(26+$cambio,5,'MONTO PAGADO',1,0,'C'); 
			 $pdf->Cell(26+$cambio,5,'MONTO PENDIENTE',1,0,'C'); 
			 
			 $pdf->Ln();
			$alto=5;
			 while ($row_rpt2= mysql_fetch_assoc($rpt2))
			 {
				 $pdf->Cell(16+$cambio,$alto,$row_rpt2['CODIGO_INMUEBLE'],1,0,'C'); 
				 $pdf->Cell(74+$cambio,$alto,$row_rpt2['DESCRIPCION_DOCUMENTO'],1,0,'L'); 
				 $pdf->Cell(15+$cambio,$alto,$row_rpt2['FECHA_DOCUMENTO'],1,0,'C'); 
				 $pdf->Cell(15+$cambio,$alto,$row_rpt2['FECHA_VENCIMIENTO'],1,0,'C'); 
				 $pdf->Cell(16+$cambio,$alto,AMDtoDMA($row_rpt2['FECHA']),1,0,'C'); 
				 $pdf->Cell(26+$cambio,$alto,number_format($row_rpt2['MONTO_DOCUMENTO'],2, ",", "."),1,0,'R');
				 $pdf->Cell(26+$cambio,$alto,number_format($row_rpt2['MONTO_PAGADO'],2, ",", "."),1,0,'R');
				 $pdf->Cell(26+$cambio,$alto,number_format($row_rpt2['MONTO_PENDIENTE'],2, ",", "."),1,0,'R');
				 $pdf->Ln(); 
			}
			 $sql4="SELECT vista_documentos_ventas.CODIGO_INMUEBLE, 
			 SUM(vista_documentos_ventas.MONTO_DOCUMENTO) AS MONTO_DOCUMENTO,  
			 SUM(vista_documentos_ventas.MONTO_PAGADO) AS MONTO_PAGADO,  
			 SUM(vista_documentos_ventas.MONTO_PENDIENTE) AS MONTO_PENDIENTE  
			 FROM  vista_documentos_ventas WHERE   
			 vista_documentos_ventas.CODIGO_INMUEBLE= '".$row_rpt3['CODIGO_INMUEBLE']."'";
			  			
			mysql_select_db($database_conexion, $conexion);
			$query_rpt4 = sprintf($sql4);
			$rpt4 = mysql_query($query_rpt4, $conexion) or die(mysql_error());
			$row_rpt4= mysql_fetch_assoc($rpt4);
			$totalRows_rpt4 = mysql_num_rows($rpt4);
			
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(160+$cambio,$alto,"Inmueble: ".$row_rpt4['CODIGO_INMUEBLE'],1,0,'L',1); 
			$pdf->Cell(26+$cambio,$alto,number_format($row_rpt4['MONTO_DOCUMENTO'],2, ",", "."),1,0,'R',1);
			$pdf->Cell(26+$cambio,$alto,number_format($row_rpt4['MONTO_PAGADO'],2, ",", "."),1,0,'R',1);
			$pdf->Cell(26+$cambio,$alto,number_format($row_rpt4['MONTO_PENDIENTE'],2, ",", "."),1,0,'R',1);
			$pdf->Ln(); 
			$pdf->SetFont('Arial','B',$letra);
			$pdf->Cell(22+$cambio,$alto,"OBSERVACIONES: ",1,0,'L'); 
			$pdf->MultiCell(228+$cambio,$alto,"AQUI VAN LAS OBSERVACIONES QUE TENGAN A BIEN COLOCAR CUANDO SE CONTACTE AL CLIENTE",1,'L');
$pdf->Ln(5);
			}
			 }
$pdf->SetFont('Arial','B',$letra+2);
$pdf->Output();
 
?>
