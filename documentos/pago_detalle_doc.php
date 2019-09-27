<?php 

//Modulo 1=Costos 2=Ventas
$modulo=1;

/////////////////////////////////////////////


$where="WHERE modulo=".$modulo;
if($_GET['elegido']!=""){
$where=$where." AND ID_PRO_CLI=".$_GET['elegido']." ";
}

if($_GET['ID_DOCUMENTO']!=""){
	
	$where=$where." AND ID_DOCUMENTO=".$_GET['ID_DOCUMENTO']." ";
}
if($_GET['ID_PAGO']!=""){
	
	$where=$where." AND EXISTS (SELECT 'x' FROM pagos_detalle b WHERE vista_pagos.id_documento=b.ID_DOCUMENTO AND b.ID_PAGO=".$_GET['ID_PAGO'].") ";
}

if($_GET['TIPO']!="0"){
	
	$where=$where." AND CODIGO_TIPO_PAGO=".$tipo." ";
}
if($_GET['PROYECTO']!="0"){
	
	$where=$where." AND COD_PROYECTO='".$proyecto."' ";
}
if($_GET['STATUS']!="Todos"){
	
		if($_GET['STATUS']==0){
			$where=$where." AND TIENE_PAGOS=0 ";
		};
		if($_GET['STATUS']==1){
			$where=$where." AND STATUS_DOCUMENTO=1 ";
		};
		if($_GET['STATUS']==2){
			$where=$where." AND TIENE_PAGOS=1 AND STATUS_DOCUMENTO=1 ";
		};
		if($_GET['STATUS']==3){
			$where=$where." AND STATUS_DOCUMENTO=0 ";
		};
		
	}
	

?>
<?php 
$ordenar=$_GET['col'];
if($_GET['orden']==1)
{
	$ordenar=$ordenar." ASC";
	$orden=2;
}
else
{
	$ordenar=$ordenar." DESC";
	$orden=1;
}

?>
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_CONSULTA = 10000;
$pageNum_CONSULTA = 0;
if (isset($_GET['pageNum_CONSULTA'])) {
  $pageNum_CONSULTA = $_GET['pageNum_CONSULTA'];
}
$startRow_CONSULTA = $pageNum_CONSULTA * $maxRows_CONSULTA;

mysql_select_db($database_conexion, $conexion);
$query_CONSULTA = "SELECT *
FROM vista_pagos
WHERE id_pago= ".$_GET['ID_PAGO'];
//echo $query_CONSULTA;
$CONSULTA = mysql_query($query_CONSULTA, $conexion) or die(mysql_error());
$row_CONSULTA = mysql_fetch_assoc($CONSULTA);

if (isset($_GET['totalRows_CONSULTA'])) {
  $totalRows_CONSULTA = $_GET['totalRows_CONSULTA'];
} else {
  $all_CONSULTA = mysql_query($query_CONSULTA);
  $totalRows_CONSULTA = mysql_num_rows($all_CONSULTA);
}
$totalPages_CONSULTA = ceil($totalRows_CONSULTA/$maxRows_CONSULTA)-1;

$queryString_CONSULTA = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_CONSULTA") == false && 
        stristr($param, "totalRows_CONSULTA") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_CONSULTA = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_CONSULTA = sprintf("&totalRows_CONSULTA=%d%s", $totalRows_CONSULTA, $queryString_CONSULTA);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<title>Untitled Document</title>
<script src="../js/jquery-1.4.2.min.js" language="javascript"></script>
<script src="../js/jquery-ui-1.8.5.custom.min.js" language="javascript"></script>
<script src="../js/jquery.ui.datepicker-es.js" language="javascript"></script>
<script src="../js/jquery.infieldlabel.min.js" language="javascript"></script>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<title>Untitled Document</title>
<link href="../js/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="../css/form.css" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function(){

        var current_id;

        $("#dialog-confirm").dialog({
            resizable: false,
            height:200,
            modal: true,
            autoOpen:false,
            buttons: {
                'Cancel': function() {
                    $(this).dialog('close');
                },
                'OK': function() {
                    $(this).dialog('close');
                    DoSomething();
                }
            }
        });
            
    });
    
        
        // open dialog, set variable
        function openDialog(id) {
            current_id = id;
            $("#dialog-confirm").dialog('open');
            };
            
         // Do something if OK
        function DoSomething() {
            local_id = current_id;
		var url = "del.php?ID_DOCUMENTO="+local_id;    
		$(location).attr('href',url);
            //alert('Do something with ' + local_id);
        };

</script>


</head>

<body>
<?php $opcion_menu=2; ?>
<?php include("../include/menu.php"); ?>
<?php include("../include/funciones.php"); ?>
<table width="1100" align="center" class="ui-widget-header" >
	<tr>
		<td width="100%" align="center" class="textos_form"><div class="titulo_formulario">PAGOS CON DETALLES DE DOCUMENTOS</div>
	</tr>
</table>

<table width="1100" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#999999">
	<tr class="textos_form">
		<td width="50" align="center" bgcolor="#FFFFFF">
		<table width="100%" border="0" cellspacing="0" cellpadding="4">
			
			</table></td>
				</tr>
		</table>
		</td>
	</tr>
</table>
<?php if ($totalRows_CONSULTA > 0) { // Show if recordset not empty ?>
<table width="1100" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#999999">
 <tr class="menu">
    <td width="60" align="center" bgcolor="#cccccc" class="textos_form">ID PAGO</td>
    <td width="150" align="center" bgcolor="#cccccc" class="textos_form">NOMBRE</td>
    <td width="100" align="center" bgcolor="#cccccc" class="textos_form">FECHA</td>
    <td width="100" align="center" bgcolor="#cccccc" class="textos_form">PAGO NUMERO</td>
    <td width="100" align="center" bgcolor="#cccccc" class="textos_form">TIPO PAGO</td>
    <td width="200" align="center" bgcolor="#cccccc" class="textos_form">BENEFICIARIO</td>
    <td align="center" bgcolor="#cccccc" class="textos_form">DESCRIPCION</td>
    </tr>
  <tr class="menu" bgcolor="#FFFFFF">
    <td align="center"><?php echo $row_CONSULTA['ID_PAGO']; ?></td>
    <td align="center"><?php echo $row_CONSULTA['NOMBRE_PRO_CLI']; ?></td>
    <td align="center"><?php echo $row_CONSULTA['FECHA']; ?></td>
    <td align="center"><?php echo $row_CONSULTA['NUMERO_PAGO']; ?></td>
    <td align="center"><?php echo $row_CONSULTA['TIPO_PAGO']; ?></td>
    <td align="center"><?php echo $row_CONSULTA['BENEFICIARIOS']; ?></td>
    <td align="center"><?php echo $row_CONSULTA['DESCRIPCION_PAGO']; ?></td>
    </tr>
</table>

	<table width="1100" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#999999">
		<tr class="menu">
			<td width="50" align="center" bgcolor="#cccccc"  class="textos_form">ID</td>
			<td width="100" align="center" bgcolor="#cccccc" class="textos_form">TIPO</td>
			<td width="50" align="center" bgcolor="#cccccc" class="textos_form">NUMERO</td>
			<td width="100" align="center" bgcolor="#cccccc" class="textos_form">FECHA</td>
			<td  align="center" bgcolor="#cccccc" class="textos_form">DESCRIPCION DOCUMENTO</td>
			<td width="100" align="center" bgcolor="#cccccc" class="textos_form">MONTO DOCUMENTO</td>
			<td width="100" align="center" bgcolor="#cccccc" class="textos_form">MONTO PAGADO</td>
			
			
			
		</tr>
		<?php 
		$TOTAL1=0;
		$TOTAL2=0;
		$TOTAL3=0;
		do { ?>
			<tr bgcolor=
	<?php 
	if($row_CONSULTA['MONTO_DOCUMENTO']==$row_CONSULTA['MONTO_PAGADO']){  ?>
	"#B3FFB3"
	<?php } else {?>
	"#FFFF99"
	<?php }
	$TOTAL1=$TOTAL1+$row_CONSULTA['MONTO_DOCUMENTO'];
	$TOTAL2=$TOTAL2+$row_CONSULTA['MONTO_PAGADO'];
	?> >
				<td align="center"><?php echo $row_CONSULTA['ID_DOCUMENTO']; ?></td>
				<td align="center"><?php echo $row_CONSULTA['NOMBRE_TIPO']; ?></td>
				<td align="center"><?php echo $row_CONSULTA['NUMERO_DOCUMENTO']; ?></td>
				<td align="center"><?php echo $row_CONSULTA['FECHA_DOCUMENTO_DATE']; ?></td>
				
				<td><?php echo $row_CONSULTA['DESCRIPCION_DOCUMENTO']; ?></td>
				<td align="right"><?php echo number_format($row_CONSULTA['MONTO_DOCUMENTO'],2); ?></td>
				<td align="right"><?php echo number_format($row_CONSULTA['MONTO_PAGADO'],2); ?></td>
										
			</tr>
			<?php } while ($row_CONSULTA = mysql_fetch_assoc($CONSULTA)); ?>
					  	 <tr class="menu">
      <td  align="center" bgcolor="#cccccc" class="textos_form"></td>
      
      <td  align="center" bgcolor="#cccccc" class="textos_form"></td>
      <td  align="center" bgcolor="#cccccc" class="textos_form"></td>
      <td  align="center" bgcolor="#cccccc" class="textos_form"></td>
      
      
      <td  align="right" bgcolor="#cccccc" class="textos_form">TOTAL</td>
      <td  align="right" bgcolor="#cccccc" class="textos_form"><?php echo number_format($TOTAL1,2); ?></td>
      <td  align="right" bgcolor="#cccccc" class="textos_form"><?php echo number_format($TOTAL2,2); ?></td>
      </tr>
		<tr>
			<td colspan="12" align="center">
				
				
			</td>
		</tr>
	</table>
	<?php } // Show if recordset not empty ?>

	<?php if ($totalRows_CONSULTA == 0) { // Show if recordset empty ?>
	<div class="textos_form" align="center">No existen registros asociados a su busqueda</div>
	<?php } // Show if recordset empty ?>
<div id="dialog-confirm" title="Borrar?">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Este proceso NO es reversible.Desea BORRAR este registro?</p>
</div>
</body>
</html>
<?php
mysql_free_result($CONSULTA);

?>
