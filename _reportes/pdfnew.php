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

if($_GET['formato']=='01'){ ?>
<script type="text/javascript">

window.location = "rpt_excel.php?<?php echo 'proyecto='.$_GET['proyecto']. '&grupo='. $_GET['grupo'].'&detalles='.$_GET['detalles'] ?>"

</script>
<?php } else {


mysql_select_db($database_conexion, $conexion);
$query_rst_todo = "SELECT
    `proyectos`.`NOMBRE` AS NOMBRE_PROYECTO
    , `inmuebles_grupo`.`NOMBRE`
FROM
    `grupocal_calpe`.`proyectos`
    INNER JOIN `grupocal_calpe`.`inmuebles_grupo` 
        ON (`proyectos`.`CODIGO` = `inmuebles_grupo`.`COD_PROYECTOS_MASTER`)
WHERE (`proyectos`.`CODIGO` <> 0) ".$_GET['proyecto'];
//$query_rst_todo = "SELECT NOMBRE_PROYECTO, NOMBRE_GRUPO FROM vista_rpt_ventas_inmuebles WHERE CODIGO_PROYECTO <>'' ". $_GET['proyecto'];
$rst_todo = mysql_query($query_rst_todo, $conexion) or die(mysql_error());
$row_rst_todo = mysql_fetch_assoc($rst_todo);
$totalRows_rst_todo = mysql_num_rows($rst_todo);


 include_once('../include/class.ezpdf.php');
// $pdf = new Cezpdf('A2','landscape');
$pdf = new Cezpdf('LEGAL','landscape');
 $pdf->selectFont('../fonts/Courier-Bold.afm');
 $pdf->ezSetCmMargins(1,1,1.5,1.5); 
 
 $titulo = "Listado de Venta de Inmuebles con Clientes";
 $txttit = "<b>".$titulo."</b>\n";
 $titulo1 = "Proyecto: ".$row_rst_todo['NOMBRE_PROYECTO'];
 $txttit1 = ("<b>".$titulo1."</b>\n");
 
$pdf->ezText($txttit1, 14);
 $pdf->ezText($txttit, 10,'justification',0);
 
 
 $titles = array(
 'CODIGO_INMUEBLE'=>'<b>CODIGO INMUEBLE</b>',
 'NOMBRE_INMUEBLE'=>'<b>NOMBRE INMUEBLE</b>',
 'NOMBRE_GRUPO'=>'<b>NOMBRE GRUPO</b>',
 'NOMBRE_CLIENTE'=>'<b>NOMBRE CLIENTE</b>',
 'MONTO_VENDIDO'=>'<b>MONTO VENDIDO</b>',
 'MONTO_POR_VENDER'=>'<b>MONTO POR VENDER</b>',
 'MONTO_COBRADO'=>'<b>MONTO COBRADO</b>',
 'MONTO_POR_COBRAR'=>'<b>MONTO POR COBRAR</b>',
 'MONTO_VENCIDO'=>'<b>MONTO VENCIDO</b>'
 );
 
  $resumen = array(
 //'CODIGO_INMUEBLE'=>'<b>CODIGO INMUEBLE</b>',
 'NOMBRE_INMUEBLE'=>'<b>TIPO DE INMUEBLE</b>',
 //'NOMBRE_CLIENTE'=>'<b>NOMBRE_CLIENTE</b>',
 'MONTO_VENDIDO'=>'<b>MONTO VENDIDO</b>',
 'MONTO_POR_VENDER'=>'<b>MONTO POR VENDER</b>',
 'MONTO_COBRADO'=>'<b>MONTO COBRADO</b>',
 'MONTO_POR_COBRAR'=>'<b>MONTO POR COBRAR</b>',
 'MONTO_VENCIDO'=>'<b>MONTO VENCIDO</b>'
 );

  $resumens = array(
 //'CODIGO_INMUEBLE'=>'<b>CODIGO INMUEBLE</b>',
 'NOMBRE_INMUEBLE'=>'<b>                                </b>',
 //'NOMBRE_CLIENTE'=>'<b>NOMBRE_CLIENTE</b>',
 'MONTO_VENDIDO'=>'<b>TOTAL VENDIDO</b>',
 'MONTO_POR_VENDER'=>'<b>TOTAL POR VENDER</b>',
 'MONTO_COBRADO'=>'<b>TOTAL COBRADO</b>',
 'MONTO_POR_COBRAR'=>'<b>TOTAL POR COBRAR</b>',
 'MONTO_VENCIDO'=>'<b>TOTAL VENCIDO</b>'
 );

 $options = array('shadeCol'=>array(0.9,0.9,0.9,0.9,0.9), 'xOrientation'=>'center', 'width'=>900);

if(isset($_GET['grupo']) && $_GET['grupo']!= " "){$grupo=$_GET['grupo'];} else {$grupo="";} 



if ($_GET['detalles']==1){

mysql_select_db($database_conexion, $conexion);
$query_rst_inmuebles = "SELECT
   `inmuebles_master`.ID_INMUEBLES_MASTER             AS `ID_INMUEBLE`,
  `inmuebles_grupo`.`NOMBRE`               AS `NOMBRE_GRUPO`,
    `inmuebles_grupo`.ID_INMUEBLES_GRUPO   AS `ID_GRUPO`,
  `inmuebles_master`.`CODIGO`              AS `CODIGO_INMUEBLE`,
  `inmuebles_master`.`NOMBRE`              AS `NOMBRE_INMUEBLE`,
  `pro_cli_master`.`NOMBRE`                AS `NOMBRE_CLIENTE`,
  `inmuebles_grupo`.`COD_PROYECTOS_MASTER` AS `CODIGO_PROYECTO`,
  FORMAT(`inmuebles_mov`.`PRECIO_VENTA`,2)           AS `MONTO_VENDIDO`,
  FORMAT(IF((`inmuebles_mov`.`PRECIO_VENTA` > 0),0,`inmuebles_master`.PRECIO_REAL ),2) AS `MONTO_POR_VENDER`,
  FORMAT(ROUND(SUM(IFNULL(`pagos_detalle`.`MONTO_PAGADO`,0)),2),2) AS `MONTO_COBRADO`,
  FORMAT(ROUND(`inmuebles_mov`.`PRECIO_VENTA` - SUM(IFNULL(`pagos_detalle`.`MONTO_PAGADO`,0)),2),2) AS `MONTO_POR_COBRAR`,
  FORMAT(IF((((((`documentos`.`MONTO_EXENTO` + `documentos`.`MONTO_GRABADO`) + 
    `documentos`.`MONTO_IMPUESTO`) - 
    SUM(IFNULL(`pagos_detalle`.`MONTO_PAGADO`,0))) > 0) AND (`documentos`.`FECHA_VENCIMIENTO` < NOW())),1,0),2) AS `MONTO_VENCIDO`
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

/*$query_rst_inmuebles = "SELECT  CODIGO_INMUEBLE, NOMBRE_GRUPO, NOMBRE_INMUEBLE, NOMBRE_CLIENTE, FORMAT(MONTO_VENDIDO,2) AS MONTO_VENDIDO, FORMAT(MONTO_POR_VENDER,2) AS MONTO_POR_VENDER, FORMAT(MONTO_COBRADO,2) AS MONTO_COBRADO,  FORMAT(MONTO_POR_COBRAR,2) AS MONTO_POR_COBRAR,  FORMAT(MONTO_VENCIDO,2) AS MONTO_VENCIDO  FROM vista_rpt_ventas_inmuebles  
WHERE CODIGO_PROYECTO <>'' ".$_GET['proyecto'].$grupo;*/
//echo $query_rst_inmuebles;
$rst_inmuebles = mysql_query($query_rst_inmuebles, $conexion) or die(mysql_error());

$totalRows_rst_inmuebles = mysql_num_rows($rst_inmuebles);
while($lista_inmuebles= mysql_fetch_assoc($rst_inmuebles)){$data[] = $lista_inmuebles;}
$pdf->ezTable($data, $titles,'', $options);
}

while($lista_inmuebles= mysql_fetch_assoc($rst_inmuebles))
{ 
	;}
  /*

mysql_select_db($database_conexion, $conexion);
$query_rst_suma = "SELECT  CONCAT('TOTAL ',`inmuebles_grupo`.`NOMBRE`) as NOMBRE_INMUEBLE,  
FORMAT(SUM(`inmuebles_mov`.`PRECIO_VENTA`),2) as MONTO_VENDIDO,   
FORMAT(SUM(IF((`inmuebles_mov`.`PRECIO_VENTA` > 0),0,`inmuebles_master`.PRECIO_REAL )),2)as MONTO_POR_VENDER,   
FORMAT(SUM(IFNULL(`pagos_detalle`.`MONTO_PAGADO`,0)),2) as MONTO_COBRADO,  
FORMAT(SUM(`inmuebles_mov`.`PRECIO_VENTA` - SUM(IFNULL(`pagos_detalle`.`MONTO_PAGADO`,0))),2) as MONTO_POR_COBRAR,   
FORMAT(SUM(IF((((((`documentos`.`MONTO_EXENTO` + `documentos`.`MONTO_GRABADO`) + 
    `documentos`.`MONTO_IMPUESTO`) - 
    SUM(IFNULL(`pagos_detalle`.`MONTO_PAGADO`,0))) > 0) AND (`documentos`.`FECHA_VENCIMIENTO` < NOW())),1,0)),2) as MONTO_VENCIDO   
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
GROUP BY `inmuebles_master`.`ID_INMUEBLES_GRUPO`
ORDER BY `inmuebles_master`.`CODIGO`";
$rst_suma = mysql_query($query_rst_suma, $conexion) or die(mysql_error());
$totalRows_rst_suma = mysql_num_rows($rst_suma);
//echo $query_rst_suma;
if ($totalRows_rst_suma > 0){ 
while($lista_grupo= mysql_fetch_assoc($rst_suma)){$suma[] = $lista_grupo;}
} else {$suma[]=$row_rst_suma;} 
$pdf->ezTable($suma, $resumen,'', $options);

mysql_select_db($database_conexion, $conexion);
$query_rst_sumass = "SELECT 'TOTALES ' as NOMBRE_INMUEBLE,  FORMAT(SUM(MONTO_VENDIDO),2) as MONTO_VENDIDO,   FORMAT(SUM(MONTO_POR_VENDER),2)as MONTO_POR_VENDER,   FORMAT(SUM(MONTO_COBRADO),2) as MONTO_COBRADO,  FORMAT(SUM(MONTO_POR_COBRAR),2) as MONTO_POR_COBRAR,   FORMAT(SUM(MONTO_VENCIDO),2) as MONTO_VENCIDO   FROM vista_rpt_ventas_inmuebles WHERE CODIGO_PROYECTO <>'' ". $_GET['proyecto'].$grupo;
$rst_sumass = mysql_query($query_rst_sumass, $conexion) or die(mysql_error());
$totalRows_rst_sumass = mysql_num_rows($rst_sumass);
if ($totalRows_rst_sumass > 0){
while($lista_gruposs= mysql_fetch_assoc($rst_sumass)){$sumass[] = $lista_gruposs;}
} else {$sumass[]=$row_rst_sumass;} 
$pdf->ezTable($sumass, $resumens,'', $options);*/
?>
<?php
	$pdf->ezText("\n\n\n", 0);
	$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);
	$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
	$pdf->ezStream();
?>
<?php	
	  


mysql_free_result($rst_todo);

mysql_free_result($rst_inmuebles);

mysql_free_result($rst_suma);
}
?>