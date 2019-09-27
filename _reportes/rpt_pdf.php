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



if(isset($_GET['grupo']) && $_GET['grupo']!= " "){$grupo=$_GET['grupo'];} else {$grupo="";} 

$vista2= "viewtemp3";
mysql_select_db($database_conexion, $conexion);
$query= "DROP VIEW IF EXISTS ".$vista2."";
$rst_todo = mysql_query($query, $conexion) or die(mysql_error());

mysql_select_db($database_conexion, $conexion);
$query= "CREATE
  VIEW ".$vista2."     AS
(SELECT
  `documentos`.`ID_DOCUMENTO`             AS `ID_DOCUMENTO`,
  `doc_tipo`.`MODULO`                     AS `MODULO`,
  `documentos`.`ID_INMUEBLES_MOV`         AS `ID_INMUEBLES_MOV`,
  `documentos`.`FECHA_VENCIMIENTO`        AS `FECHA_VENCIMIENTO_DATE`,
  DATE_FORMAT(`documentos`.`FECHA_VENCIMIENTO`,_utf8'%d/%m/%Y') AS `FECHA_VENCIMIENTO`,
  ((`documentos`.`MONTO_EXENTO` + `documentos`.`MONTO_GRABADO`) + `documentos`.`MONTO_IMPUESTO`) AS `MONTO_DOCUMENTO`,
  IF(ISNULL(`pagos_detalle`.`MONTO_PAGADO`),0,1) AS `TIENE_PAGOS`,
  ROUND(SUM(IFNULL(`pagos_detalle`.`MONTO_PAGADO`,0)),2) AS `MONTO_PAGADO`,
  ROUND(IFNULL((((`documentos`.`MONTO_EXENTO` + `documentos`.`MONTO_GRABADO`) + `documentos`.`MONTO_IMPUESTO`) - SUM(IFNULL(`pagos_detalle`.`MONTO_PAGADO`,0))),0),2) AS `MONTO_PENDIENTE`,
  IF(((((`documentos`.`MONTO_EXENTO` + `documentos`.`MONTO_GRABADO`) + `documentos`.`MONTO_IMPUESTO`) - SUM(IFNULL(`pagos_detalle`.`MONTO_PAGADO`,0))) <= 0),0,1) AS `STATUS_DOCUMENTO`,
  IF((((((`documentos`.`MONTO_EXENTO` + `documentos`.`MONTO_GRABADO`) + `documentos`.`MONTO_IMPUESTO`) - SUM(IFNULL(`pagos_detalle`.`MONTO_PAGADO`,0))) > 0) AND (`documentos`.`FECHA_VENCIMIENTO` < NOW())),1,0) AS `VENCIDO`
  FROM ((((((`documentos`
        JOIN `doc_tipo`
          ON ((`documentos`.`TIPO` = `doc_tipo`.`TIPO`)))
       JOIN `pro_cli_master`
         ON ((`documentos`.`ID_PRO_CLI` = `pro_cli_master`.`ID_PRO_CLI_MASTER`)))
      JOIN `proyectos`
        ON ((CONVERT(`documentos`.`COD_PROYECTO` USING utf8) = `proyectos`.`CODIGO`)))
     LEFT JOIN `pagos_detalle`
       ON ((`documentos`.`ID_DOCUMENTO` = `pagos_detalle`.`ID_DOCUMENTO`)))
    LEFT JOIN `banco_master`
      ON ((`documentos`.`ID_BANCO` = `banco_master`.`ID_BANCO_MASTER`)))
   LEFT JOIN `partidas`
     ON ((`documentos`.`ID_PARTIDA` = `partidas`.`ID`)))
     WHERE   `documentos`.`FECHA_VENCIMIENTO` < NOW()
GROUP BY 1
ORDER BY `documentos`.`FECHA_EMISION`

)";

$rst_todo = mysql_query($query, $conexion) or die(mysql_error());


/*$vista1= "viewtemp1";
mysql_select_db($database_conexion, $conexion);
$query= "DROP VIEW IF EXISTS ".$vista1."";
$rst_todo = mysql_query($query, $conexion) or die(mysql_error());

mysql_select_db($database_conexion, $conexion);
$query= "CREATE
    VIEW ".$vista1." 
    AS
(SELECT
  `inmuebles_master`.`ID_INMUEBLES_MASTER` AS `ID_INMUEBLES_MASTER`,
  `inmuebles_mov`.`PRECIO_VENTA`           AS `PRECIO_VENTA`,
  SUM(IFNULL(`pagos_detalle`.`MONTO_PAGADO`,0)) AS `MONTO_PAGADO`,
  `documentos`.`FECHA_VENCIMIENTO`         AS `FECHA_VENCIMIENTO`,
  `inmuebles_master`.`ID_INMUEBLES_GRUPO`  AS `ID_INMUEBLES_GRUPO`,
  IF(`documentos`.`FECHA_VENCIMIENTO` < NOW() AND `inmuebles_mov`.`PRECIO_VENTA` > SUM(IFNULL(`pagos_detalle`.`MONTO_PAGADO`,0)),(documentos.MONTO_EXENTO+documentos.MONTO_GRABADO+documentos.MONTO_IMPUESTO),0) AS `VENCIDO`
FROM ((((`documentos`
      JOIN `pagos_detalle`
        ON ((`documentos`.`ID_DOCUMENTO` = `pagos_detalle`.`ID_DOCUMENTO`)))
     JOIN `inmuebles_mov`
       ON ((`inmuebles_mov`.`ID_INMUEBLES_MOV` = `documentos`.`ID_INMUEBLES_MOV`)))
    JOIN `inmuebles_master`
      ON ((`inmuebles_mov`.`ID_INMUEBLES_MASTER` = `inmuebles_master`.`ID_INMUEBLES_MASTER`)))
   JOIN `pagos`
     ON ((`pagos`.`ID_PAGO` = `pagos_detalle`.`ID_PAGO`)))
GROUP BY 1
)";*/

$vista1= "viewtemp1";
mysql_select_db($database_conexion, $conexion);
$query= "DROP VIEW IF EXISTS ".$vista1."";
$rst_todo = mysql_query($query, $conexion) or die(mysql_error());

mysql_select_db($database_conexion, $conexion);
$query= "CREATE
    VIEW ".$vista1." 
    AS
(SELECT ID_INMUEBLES_MOV, SUM(MONTO_PENDIENTE) AS MONTO_PENDIENTE FROM viewtemp3 WHERE FECHA_VENCIMIENTO < NOW() GROUP BY ID_INMUEBLES_MOV)";

$rst_todo = mysql_query($query, $conexion) or die(mysql_error());

$vista= "viewtemp2";
mysql_select_db($database_conexion, $conexion);
$query= "DROP VIEW IF EXISTS ".$vista."";
$rst_todo = mysql_query($query, $conexion) or die(mysql_error());

mysql_select_db($database_conexion, $conexion);
$query= "CREATE
    VIEW ".$vista." 
    AS
SELECT 
   `inmuebles_master`.ID_INMUEBLES_MASTER             AS `ID_INMUEBLE`,
   `inmuebles_mov`.ID_TIPO,
  `inmuebles_grupo`.`NOMBRE`               AS `NOMBRE_GRUPO`,
    `inmuebles_grupo`.ID_INMUEBLES_GRUPO   AS `ID_GRUPO`,
  `inmuebles_master`.`CODIGO`              AS `CODIGO_INMUEBLE`,
  `inmuebles_master`.`NOMBRE`              AS `NOMBRE_INMUEBLE`,
  `pro_cli_master`.`NOMBRE`                AS `NOMBRE_CLIENTE`,
  `inmuebles_grupo`.`COD_PROYECTOS_MASTER` AS COD_PROYECTOS_MASTER,
  `inmuebles_grupo`.`COD_PROYECTOS_MASTER` AS `CODIGO_PROYECTO`,
  `inmuebles_mov`.`PRECIO_VENTA`           AS `MONTO_VENDIDO2`,
  IF(`inmuebles_mov`.ID_TIPO = 2,0, `inmuebles_mov`.`PRECIO_VENTA`) AS MONTO_VENDIDO,
   IFNULL( IF(`inmuebles_mov`.ID_TIPO <> 2,0, `inmuebles_mov`.`PRECIO_VENTA`),IF((`inmuebles_mov`.`PRECIO_VENTA` > 0),0,`inmuebles_master`.`PRECIO_REAL`) ) AS MONTO_POR_VENDER,

    IF((`inmuebles_mov`.`PRECIO_VENTA` > 0),0,`inmuebles_master`.`PRECIO_REAL`) AS `MONTO_POR_VENDER2`,
  ROUND(SUM(IFNULL(`pagos_detalle`.`MONTO_PAGADO`,0)),2) AS `MONTO_COBRADO`,
        IF(`inmuebles_mov`.ID_TIPO = 2,0, ROUND(`inmuebles_mov`.`PRECIO_VENTA` - SUM(IFNULL(`pagos_detalle`.`MONTO_PAGADO`,0)),2)) AS `MONTO_POR_COBRAR`,
     IF(`inmuebles_mov`.ID_TIPO = 2,0, ROUND(`inmuebles_mov`.`PRECIO_VENTA` - SUM(IFNULL(`pagos_detalle`.`MONTO_PAGADO`,0)),2)) AS MONTO_POR_COBRAR_RESULTADO,
  IF((((((`documentos`.`MONTO_EXENTO` + `documentos`.`MONTO_GRABADO`) + 
    `documentos`.`MONTO_IMPUESTO`) - 
    SUM(IFNULL(`pagos_detalle`.`MONTO_PAGADO`,0))) > 0) AND (`documentos`.`FECHA_VENCIMIENTO` < NOW())),1,0) AS `MONTO_VENCIDO`
FROM `inmuebles_master`
  INNER JOIN `inmuebles_grupo`
    ON (`inmuebles_master`.`ID_INMUEBLES_GRUPO` = `inmuebles_grupo`.`ID_INMUEBLES_GRUPO`)
  LEFT JOIN `inmuebles_mov`
    ON (`inmuebles_mov`.`ID_INMUEBLES_MASTER` = `inmuebles_master`.`ID_INMUEBLES_MASTER`)
  LEFT JOIN `pro_cli_master`
    ON (`inmuebles_mov`.`ID_PRO_CLI_MASTER` = `pro_cli_master`.`ID_PRO_CLI_MASTER`)
  LEFT JOIN `documentos`
    ON (`inmuebles_mov`.`ID_INMUEBLES_MOV` = `documentos`.`ID_INMUEBLES_MOV`)
  LEFT JOIN `pagos_detalle`
    ON (`documentos`.`ID_DOCUMENTO` = `pagos_detalle`.`ID_DOCUMENTO`)

	WHERE `inmuebles_grupo`.`COD_PROYECTOS_MASTER`  <> 0 ".$_GET['proyecto']."
GROUP BY 1
ORDER BY `inmuebles_master`.ID_INMUEBLES_MASTER";

$rst_todo = mysql_query($query, $conexion) or die(mysql_error());

mysql_select_db($database_conexion, $conexion);
/*$query_rst_todo = "SELECT
   `inmuebles_master`.ID_INMUEBLES_MASTER             AS `ID_INMUEBLE`,
  `inmuebles_grupo`.`NOMBRE`               AS `NOMBRE_GRUPO`,
    `inmuebles_grupo`.ID_INMUEBLES_GRUPO   AS `ID_GRUPO`,
  `inmuebles_master`.`CODIGO`              AS `CODIGO_INMUEBLE`,
  `inmuebles_master`.`NOMBRE`              AS `NOMBRE_INMUEBLE`,
  `pro_cli_master`.`NOMBRE`                AS `NOMBRE_CLIENTE`,
  `inmuebles_grupo`.`COD_PROYECTOS_MASTER` AS `CODIGO_PROYECTO`,
  `inmuebles_mov`.`PRECIO_VENTA`           AS `MONTO_VENDIDO`,
  IF((`inmuebles_mov`.`PRECIO_VENTA` > 0),0,`inmuebles_master`.PRECIO_REAL ) AS `MONTO_POR_VENDER`,
  ROUND(SUM(IFNULL(`pagos_detalle`.`MONTO_PAGADO`,0)),2) AS `MONTO_COBRADO`,
  ROUND(`inmuebles_mov`.`PRECIO_VENTA` - SUM(IFNULL(`pagos_detalle`.`MONTO_PAGADO`,0)),2) AS `MONTO_POR_COBRAR`,
  IF((((((`documentos`.`MONTO_EXENTO` + `documentos`.`MONTO_GRABADO`) + `documentos`.`MONTO_IMPUESTO`) - 
    SUM(IFNULL(`pagos_detalle`.`MONTO_PAGADO`,0))) > 0) AND (`documentos`.`FECHA_VENCIMIENTO` < NOW())),1,0) AS `MONTO_VENCIDO`
FROM `inmuebles_master`
  INNER JOIN `inmuebles_grupo`
    ON (`inmuebles_master`.`ID_INMUEBLES_GRUPO` = `inmuebles_grupo`.`ID_INMUEBLES_GRUPO`)
  LEFT JOIN `inmuebles_mov`
    ON (`inmuebles_mov`.`ID_INMUEBLES_MASTER` = `inmuebles_master`.`ID_INMUEBLES_MASTER`)
  LEFT JOIN `pro_cli_master`
    ON (`inmuebles_mov`.`ID_PRO_CLI_MASTER` = `pro_cli_master`.`ID_PRO_CLI_MASTER`)
  LEFT JOIN `documentos`
    ON (`inmuebles_mov`.`ID_INMUEBLES_MOV` = `documentos`.`ID_INMUEBLES_MOV`)
  LEFT JOIN `pagos_detalle`
    ON (`documentos`.`ID_DOCUMENTO` = `pagos_detalle`.`ID_DOCUMENTO`)
	WHERE `inmuebles_grupo`.`COD_PROYECTOS_MASTER`  <> 0 ".$_GET['proyecto'].$grupo."
GROUP BY 1
ORDER BY `inmuebles_master`.`CODIGO`";
*///echo $query_rst_todo;


/*$query_rst_todo = "SELECT
    viewtemp2.`ID_INMUEBLE`
    , viewtemp2.`NOMBRE_GRUPO`
    , viewtemp2.`ID_GRUPO`
    , viewtemp2.`CODIGO_INMUEBLE`
    , viewtemp2.`NOMBRE_INMUEBLE`
    , viewtemp2.`NOMBRE_CLIENTE`
    , viewtemp2.`CODIGO_PROYECTO`
    , viewtemp2.`MONTO_VENDIDO`
    , viewtemp2.`MONTO_POR_VENDER`
    , viewtemp2.`MONTO_COBRADO`
    , viewtemp2.`MONTO_POR_COBRAR`
    , IFNULL(viewtemp1.`VENCIDO`,0) AS VENCIDO
FROM
    viewtemp1
    RIGHT JOIN viewtemp2 
        ON (viewtemp1.`ID_INMUEBLES_MASTER` = viewtemp2.`ID_INMUEBLE`)
			WHERE `COD_PROYECTOS_MASTER`  <> 0 ".$_GET['proyecto'].$grupo."
			ORDER BY CODIGO_INMUEBLE
";*/
$query_rst_todo = "SELECT
    `viewtemp2`.`ID_INMUEBLE`
    , `viewtemp2`.`NOMBRE_GRUPO`
    , `viewtemp2`.`ID_GRUPO`
    , `viewtemp2`.`CODIGO_INMUEBLE`
    , `viewtemp2`.`NOMBRE_INMUEBLE`
    , `viewtemp2`.`NOMBRE_CLIENTE`
    , `viewtemp2`.`COD_PROYECTOS_MASTER`
    , `viewtemp2`.`MONTO_VENDIDO`
    , `viewtemp2`.`MONTO_POR_VENDER`
    , `viewtemp2`.`MONTO_COBRADO`
    , `viewtemp2`.`MONTO_POR_COBRAR`
    , `viewtemp2`.`MONTO_VENCIDO` 
    , IFNULL(SUM(`viewtemp1`.`MONTO_PENDIENTE`),0) AS VENCIDO
FROM
    `grupocal_calpe`.`viewtemp2`
    LEFT JOIN `grupocal_calpe`.`inmuebles_mov` 
        ON (`viewtemp2`.`ID_INMUEBLE` = `inmuebles_mov`.`ID_INMUEBLES_MASTER`)
    LEFT JOIN `grupocal_calpe`.`viewtemp1` 
        ON (`inmuebles_mov`.`ID_INMUEBLES_MOV` = `viewtemp1`.`ID_INMUEBLES_MOV`)
					WHERE `COD_PROYECTOS_MASTER`  <> 0 ".$_GET['proyecto'].$grupo."

       GROUP BY 1
ORDER BY CODIGO_INMUEBLE";
/*$query_rst_todo = "SELECT  CONCAT('TOTAL ',NOMBRE_GRUPO) AS NOMBRE_INMUEBLE
    , SUM(viewtemp2.`MONTO_VENDIDO`) AS MONTO_VENDIDO
    , SUM(viewtemp2.`MONTO_POR_VENDER`) AS MONTO_POR_VENDER
    , SUM(viewtemp2.`MONTO_COBRADO`) AS MONTO_COBRADO
    , SUM(viewtemp2.`MONTO_POR_COBRAR`) AS MONTO_POR_COBRAR
    , SUM(IFNULL(viewtemp1.`VENCIDO`,0)) AS MONTO_VENCIDO
FROM
    viewtemp1
    RIGHT JOIN viewtemp2 
        ON (viewtemp1.`ID_INMUEBLES_MASTER` = viewtemp2.`ID_INMUEBLE`)
        GROUP BY viewtemp2.ID_GRUPO";
		
*/$rst_todo = mysql_query($query_rst_todo, $conexion) or die(mysql_error());
$row_rst_todo = mysql_fetch_assoc($rst_todo);
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
date_default_timezone_set('UTC');

//$pdf->SetY(60);

    //$pdf->Image("../img/Logo.jpg" , 10 ,8, 25 , 25 , "JPG" ,"http://www.mipagina.com");
    //courier bold 15
    $pdf->SetFont('Arial','B',15);
    //Movernos a la derecha
	$pdf->SetY(20); //posicion de altura
    $pdf->SetX(150); //posicion a lo ancho
    //Título
	$TITULO="Listado de Ventas de inmuebles";
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
$letra=10;
$MO=20;
$pdf->SetFont('Courier','',$letra);
$fill=false;
if($letra==4) {$cambio=-2;} elseif ($letra==5){$cambio=0;} elseif ($letra==6){$cambio=2;} elseif($letra==8) {$cambio=6;} else {$cambio=10;}
$alto=5;
if ($_GET['detalles']==1){
$pdf->Cell(15+$cambio,5,$totalRows_rst_todo,1,0,'C',1); 
$pdf->Ln();
 $pdf->Cell(15+$cambio,5,'INMUEBLE',1,0,'C',1); 
 $pdf->Cell(50+$cambio,5,'NOMBRE',1,0,'C',1); 
//$pdf->Cell(30+$cambio,5,'GRUPO',1,0,'C',1); 
 $pdf->Cell(90+$cambio,5,'NOMBRE CLIENTE',1,0,'C',1); 
 $pdf->Cell($MO+$cambio,5,'VENDIDO',1,0,'C',1); 
 $pdf->Cell($MO+$cambio,5,'POR VENDER',1,0,'C',1); 
 $pdf->Cell($MO+$cambio,5,'COBRADO',1,0,'C',1); 
 $pdf->Cell($MO+$cambio,5,'POR COBRAR',1,0,'C',1); 
$pdf->Cell($MO+$cambio,5,'VENCIDO',1,0,'C',1); 
  $pdf->Ln();
$saldo=0;

//$id=$rpt['ID_DOCUMENTO'];

$valor1=0;
$valor2=0;
$valor3=0;
$valor4=0;
$valor5=0;
 
	  do { 
$pdf->Cell(15+$cambio,$alto,$row_rst_todo['CODIGO_INMUEBLE'],1,0,'C'); 
$pdf->Cell(50+$cambio,$alto,$row_rst_todo['NOMBRE_INMUEBLE'],1,0,'L');  
//$pdf->Cell(30+$cambio,$alto,$row_rst_todo['NOMBRE_GRUPO'],1,0,'L'); 
$pdf->Cell(90+$cambio,$alto,$row_rst_todo['NOMBRE_CLIENTE'],1,0,'L'); 
$pdf->Cell($MO+$cambio,$alto,number_format($row_rst_todo['MONTO_VENDIDO'],2),1,0,'R');
$pdf->Cell($MO+$cambio,$alto,number_format($row_rst_todo['MONTO_POR_VENDER'],2),1,0,'R');
$pdf->Cell($MO+$cambio,$alto,number_format($row_rst_todo['MONTO_COBRADO'],2),1,0,'R');
$pdf->Cell($MO+$cambio,$alto,number_format($row_rst_todo['MONTO_POR_COBRAR'],2),1,0,'R');
$pdf->Cell($MO+$cambio,$alto,number_format($row_rst_todo['VENCIDO'],2),1,0,'R');


 $pdf->Ln();
 
 $valor1= $valor1+ $row_rst_todo['MONTO_VENDIDO'];
 $valor2= $valor2+ $row_rst_todo['MONTO_POR_VENDER'];
 $valor3= $valor3+ $row_rst_todo['MONTO_COBRADO'];
 $valor4= $valor4+ $row_rst_todo['MONTO_POR_COBRAR'];
 $valor5= $valor5+ $row_rst_todo['VENCIDO'];
} while ($row_rst_todo = mysql_fetch_assoc($rst_todo));
$letra=9;
$pdf->SetFont('Courier','B',$letra);

/*$pdf->Cell(183+$MO+$cambio,$alto,"Totales: ",1,0,'L');
$pdf->Cell($MO+$cambio,$alto,number_format($valor1,2),1,0,'R');
$pdf->Cell($MO+$cambio,$alto,number_format($valor2,2),1,0,'R');
$pdf->Cell($MO+$cambio,$alto,number_format($valor3,2),1,0,'R');
$pdf->Cell($MO+$cambio,$alto,number_format($valor4,2),1,0,'R');
$pdf->Cell($MO+$cambio,$alto,number_format($valor5,2),1,0,'R');
$pdf->Ln();
*/
}
$letra=10;
//$pdf->SetFillColor(0);
//$pdf->SetTextColor(0);
$pdf->SetFont('Courier','',$letra);
if($letra==4) {$cambio=-2;} elseif ($letra==5){$cambio=0;} elseif ($letra==6){$cambio=2;} elseif($letra==8) {$cambio=6;} else {$cambio=12;}

 if ($_GET['detalles']==1){
}

/*$vista= "prueba3";
mysql_select_db($database_conexion, $conexion);
$query= "DROP VIEW IF EXISTS ".$vista."";
$rst_todo = mysql_query($query, $conexion) or die(mysql_error());

mysql_select_db($database_conexion, $conexion);
$query= "CREATE
    VIEW ".$vista." 
    AS
 SELECT 
   `inmuebles_master`.ID_INMUEBLES_MASTER             AS `ID_INMUEBLE`,
  `inmuebles_grupo`.`NOMBRE`               AS `NOMBRE_GRUPO`,
    `inmuebles_grupo`.ID_INMUEBLES_GRUPO   AS `ID_GRUPO`,
  `inmuebles_master`.`CODIGO`              AS `CODIGO_INMUEBLE`,
  `inmuebles_master`.`NOMBRE`              AS `NOMBRE_INMUEBLE`,
  `pro_cli_master`.`NOMBRE`                AS `NOMBRE_CLIENTE`,
  `inmuebles_grupo`.`COD_PROYECTOS_MASTER` AS `CODIGO_PROYECTO`,
  `inmuebles_mov`.`PRECIO_VENTA`           AS `MONTO_VENDIDO`,
  IF((`inmuebles_mov`.`PRECIO_VENTA` > 0),0,`inmuebles_master`.PRECIO_REAL ) AS `MONTO_POR_VENDER`,
  ROUND(SUM(IFNULL(`pagos_detalle`.`MONTO_PAGADO`,0)),2) AS `MONTO_COBRADO`,
  ROUND(`inmuebles_mov`.`PRECIO_VENTA` - SUM(IFNULL(`pagos_detalle`.`MONTO_PAGADO`,0)),2) AS `MONTO_POR_COBRAR`,
  IF((((((`documentos`.`MONTO_EXENTO` + `documentos`.`MONTO_GRABADO`) + 
    `documentos`.`MONTO_IMPUESTO`) - 
    SUM(IFNULL(`pagos_detalle`.`MONTO_PAGADO`,0))) > 0) AND (`documentos`.`FECHA_VENCIMIENTO` < NOW())),1,0) AS `MONTO_VENCIDO`
FROM `inmuebles_master`
  INNER JOIN `inmuebles_grupo`
    ON (`inmuebles_master`.`ID_INMUEBLES_GRUPO` = `inmuebles_grupo`.`ID_INMUEBLES_GRUPO`)
  LEFT JOIN `inmuebles_mov`
    ON (`inmuebles_mov`.`ID_INMUEBLES_MASTER` = `inmuebles_master`.`ID_INMUEBLES_MASTER`)
  LEFT JOIN `pro_cli_master`
    ON (`inmuebles_mov`.`ID_PRO_CLI_MASTER` = `pro_cli_master`.`ID_PRO_CLI_MASTER`)
  LEFT JOIN `documentos`
    ON (`inmuebles_mov`.`ID_INMUEBLES_MOV` = `documentos`.`ID_INMUEBLES_MOV`)
  LEFT JOIN `pagos_detalle`
    ON (`documentos`.`ID_DOCUMENTO` = `pagos_detalle`.`ID_DOCUMENTO`)
	WHERE `inmuebles_grupo`.`COD_PROYECTOS_MASTER`  <> 0 ".$_GET['proyecto']."
GROUP BY 1
ORDER BY `inmuebles_master`.ID_INMUEBLES_MASTER";

$rst_todo = mysql_query($query, $conexion) or die(mysql_error());
*/
/*mysql_select_db($database_conexion, $conexion);
$query= "SELECT  CONCAT('TOTAL ',NOMBRE_GRUPO) AS NOMBRE_INMUEBLE, 
FORMAT(IFNULL(SUM(MONTO_VENDIDO),0),2) AS MONTO_VENDIDO, 
FORMAT(IFNULL(SUM(MONTO_POR_VENDER),0),2) AS MONTO_POR_VENDER, 
FORMAT(IFNULL(SUM(MONTO_COBRADO),0),2) AS MONTO_COBRADO,  
FORMAT(IFNULL(SUM(MONTO_POR_COBRAR),0),2) AS MONTO_POR_COBRAR,   
FORMAT(IFNULL(SUM(MONTO_VENCIDO),0),2) AS MONTO_VENCIDO   
FROM ".$vista." 
GROUP BY ID_GRUPO";
*/

mysql_select_db($database_conexion, $conexion);

/* "SELECT  CONCAT('TOTAL ',NOMBRE_GRUPO) AS NOMBRE_INMUEBLE
    , SUM(".$vista.".`MONTO_VENDIDO`) AS MONTO_VENDIDO
    , SUM(".$vista.".`MONTO_POR_VENDER`) AS MONTO_POR_VENDER
    , SUM(".$vista.".`MONTO_COBRADO`) AS MONTO_COBRADO
    , SUM(".$vista.".`MONTO_POR_COBRAR`) AS MONTO_POR_COBRAR
    , SUM(IFNULL(".$vista1.".`VENCIDO`,0)) AS MONTO_VENCIDO
FROM
    ".$vista1.".
    RIGHT JOIN ".$vista.". 
        ON (".$vista1.".`ID_INMUEBLES_MASTER` = ".$vista.".`ID_INMUEBLE`)
        GROUP BY ".$vista.".ID_GRUPO";*/
$query="SELECT  CONCAT('TOTAL ',NOMBRE_GRUPO) AS NOMBRE_INMUEBLE
    , SUM(viewtemp2.`MONTO_VENDIDO`) AS MONTO_VENDIDO
    , SUM(viewtemp2.`MONTO_POR_VENDER`) AS MONTO_POR_VENDER
    , SUM(viewtemp2.`MONTO_COBRADO`) AS MONTO_COBRADO
    , SUM(viewtemp2.`MONTO_POR_COBRAR`) AS MONTO_POR_COBRAR
    , SUM(IFNULL(viewtemp1.`MONTO_PENDIENTE`,0)) AS MONTO_VENCIDO
FROM
    `grupocal_calpe`.`viewtemp2`
    LEFT JOIN `grupocal_calpe`.`inmuebles_mov` 
        ON (`viewtemp2`.`ID_INMUEBLE` = `inmuebles_mov`.`ID_INMUEBLES_MASTER`)
    LEFT JOIN `grupocal_calpe`.`viewtemp1` 
        ON (`inmuebles_mov`.`ID_INMUEBLES_MOV` = `viewtemp1`.`ID_INMUEBLES_MOV`)
					WHERE `COD_PROYECTOS_MASTER`  <> 0 ".$_GET['proyecto']."
        GROUP BY viewtemp2.ID_GRUPO";
		
$rst_todos = mysql_query($query, $conexion) or die(mysql_error());
$row_rst_todos = mysql_fetch_assoc($rst_todos);
 $pdf->Ln(10);
 
 $pdf->Cell(170+$cambio,$alto,'GRUPO',1,0,'C',1); 
 $pdf->Cell($MO+$cambio,$alto,'VENDIDO',1,0,'C',1); 
 $pdf->Cell($MO+$cambio,$alto,'POR VENDER',1,0,'C',1); 
 $pdf->Cell($MO+$cambio,$alto,'COBRADO',1,0,'C',1); 
 $pdf->Cell($MO+$cambio,$alto,'POR COBRAR',1,0,'C',1); 
 $pdf->Cell($MO+$cambio,$alto,'VENCIDO',1,0,'C',1); 
$pdf->Ln();
 
do {
$pdf->Cell(170+$cambio,$alto,$row_rst_todos['NOMBRE_INMUEBLE'],1,0,'L');
$pdf->Cell($MO+$cambio,$alto,number_format($row_rst_todos['MONTO_VENDIDO'],2),1,0,'R');
$pdf->Cell($MO+$cambio,$alto,number_format($row_rst_todos['MONTO_POR_VENDER'],2),1,0,'R');
$pdf->Cell($MO+$cambio,$alto,number_format($row_rst_todos['MONTO_COBRADO'],2),1,0,'R');
$pdf->Cell($MO+$cambio,$alto,number_format($row_rst_todos['MONTO_POR_COBRAR'],2),1,0,'R');
$pdf->Cell($MO+$cambio,$alto,number_format($row_rst_todos['MONTO_VENCIDO'],2),1,0,'R');
 $pdf->Ln();
 }  while ($row_rst_todos = mysql_fetch_assoc($rst_todos));
 

/* 
 mysql_select_db($database_conexion, $conexion);
$query= "DROP VIEW IF EXISTS ".$vista."";
$rst_todo = mysql_query($query, $conexion) or die(mysql_error());

 mysql_select_db($database_conexion, $conexion);
$query= "DROP VIEW IF EXISTS ".$vista1."";
$rst_todo = mysql_query($query, $conexion) or die(mysql_error());

 mysql_select_db($database_conexion, $conexion);
$query= "DROP VIEW IF EXISTS ".$vista2."";
$rst_todo = mysql_query($query, $conexion) or die(mysql_error());

*/

$pdf->Output();
 
?>
