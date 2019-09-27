<?php
require('../include/fpdf.php');

$pdf=new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(60,10,'fecha');
$pdf->Cell(20,20,'Nombre');
$pdf->Output();
?>