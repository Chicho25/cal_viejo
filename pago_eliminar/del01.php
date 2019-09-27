<?php 
function changueFormatDate($cdate){
    list($day,$month,$year)=explode("/",$cdate);
    return $year."-".$month."-".$day;
}

$where=" WHERE vista_pagos.modulo='1' ";
if($_GET['FROM']!=""&&$_GET['TO']!=""){
	$where=$where." AND STR_TO_DATE(vista_pagos.FECHA,'%d/%m/%Y') BETWEEN STR_TO_DATE('".$_GET['FROM']."','%d/%m/%Y') AND STR_TO_DATE('".$_GET['TO']."','%d/%m/%Y')";
	
}
if($_GET['FROM']!=""&&$_GET['TO']==""){
	$where=$where." AND vista_pagos.FECHA='".$_GET['FROM']."'";
	
}



if(isset($_GET['ID_DOCUMENTO'])){
if($_GET['ID_DOCUMENTO']!=""){
	$where=$where." AND vista_pagos.ID_DOCUMENTO='".$_GET['ID_DOCUMENTO']."'";
	
}}
if($_GET['ID_PAGO']!=""){
	$where=$where." AND vista_pagos.ID_PAGO='".$_GET['ID_PAGO']."'";
	
}
if($_GET['PROYECTO']!=""){
	$where=$where." AND vista_pagos.COD_PROYECTO='".$_GET['PROYECTO']."'";
	
}
if($_GET['PROVEEDOR']!=""){
	$where=$where." AND vista_pagos.ID_PRO_CLI='".$_GET['PROVEEDOR']."'";
	
}
if($_GET['TIPO']!=""){
	$where=$where." AND vista_pagos.TIPO_PAGO='".$_GET['TIPO']."'";
	
}
if($_GET['NUMERO']!=""){
	$where=$where." AND vista_pagos.NUMERO_PAGO='".$_GET['NUMERO']."'";
	
}

if(isset($_GET['STATUS'])){
	$STATUS=$_GET['STATUS'];
	if($STATUS==0){
		$where=$where." AND vista_pagos.TIPO_PAGO='CHEQUE' AND vista_pagos.NUMERO_PAGO=''";
	}
	else if($STATUS==1)
	{
		$where=$where." AND vista_pagos.TIPO_PAGO='CHEQUE' AND vista_pagos.NUMERO_PAGO<>''";
	}
	
}


/*


$proyecto="";
if($_GET['p']!=0)
{
$proyecto=" AND partidas.COD_PROYECTO = "	.$_GET['p']." ";
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

*/?>


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

$maxRows_CONSULTA = 10000000;
$pageNum_CONSULTA = 0;
if (isset($_GET['pageNum_CONSULTA'])) {
  $pageNum_CONSULTA = $_GET['pageNum_CONSULTA'];
}
$startRow_CONSULTA = $pageNum_CONSULTA * $maxRows_CONSULTA;

mysql_select_db($database_conexion, $conexion);
$query_CONSULTA = "SELECT vista_pagos.ID_PAGO, vista_pagos.COD_PROYECTO, vista_pagos.ID_DOCUMENTO, vista_pagos.NOMBRE_PRO_CLI, vista_pagos.TIPO_PAGO, vista_pagos.NUMERO_PAGO, vista_pagos.FECHA, FORMAT(SUM(vista_pagos.MONTO_PAGADO),2) AS MONTO_PAGADO, MONTO_PAGADO AS MONTO, vista_pagos.DESCRIPCION_PAGO FROM vista_pagos ".$where." GROUP BY vista_pagos.ID_PAGO ORDER BY cod_proyecto, id_pago";
$query_limit_CONSULTA = sprintf("%s LIMIT %d, %d", $query_CONSULTA, $startRow_CONSULTA, $maxRows_CONSULTA);

$CONSULTA = mysql_query($query_limit_CONSULTA, $conexion) or die(mysql_error());
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
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html"/>
<title>Untitled Document</title>
<?php include("../include/_js.php"); ?>
<?php include("../include/_css.php"); ?>
<style type="text/css">
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>

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
		var url = "del02.php?CODIGO="+local_id;
		window.location =   url;    
		//$(location).attr('href',url);
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
			<td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Pagos</div>
		</tr>
	</table>
	<center>
	</center>
<table width="1100" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#999999">
	<tr class="textos_form">
<td width="50" align="center" bgcolor="#6FA7D1"><table width="1080" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="center" bgcolor="#6FA7D1"><?php if (validador(13,$_SESSION['i'],"inc")==1){?><input type="button" class="groovybutton" name="button3" id="button3" value="Insertar" onClick="parent.location='../formularios/pago_proyecto.php'"/><?php } ?>		  <input type="button" name="button" id="button" value="Buscar" onClick="parent.location='index.php'"/></td>
		</tr>
  </table></td></tr></table>
<?php if ($totalRows_CONSULTA > 0) { // Show if recordset not empty ?>
<table width="1100" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#999999">
	<tr class="textos_form">
		<td width="24" align="center" bgcolor="#CCCCCC">ID</td>
		<td width="25" align="center" bgcolor="#CCCCCC">Proyecto</td>
		<td width="200" align="center" bgcolor="#CCCCCC">Proveedor</td>
		<td width="200" align="center" bgcolor="#CCCCCC">Descripcion</td>
		<td width="150" align="center" bgcolor="#CCCCCC">Tipo</td>
		<td width="100" align="center" bgcolor="#CCCCCC">Numero</td>
		<td width="100" align="center" bgcolor="#CCCCCC">Fecha</td>
		<td width="100" align="center" bgcolor="#CCCCCC">Monto</td>
		<td colspan="4" align="center" bgcolor="#CCCCCC">&nbsp;</td>
	</tr>
	<?php 
	$MONTO_TOTAL=0;
	do {  
	$MONTO_TOTAL=$MONTO_TOTAL+$row_CONSULTA['MONTO'];
	?>
<tr>

			<td width="24" align="center" bgcolor="#FFFFFF"><?php echo $row_CONSULTA['ID_PAGO']; ?></td>
			<td width="25" align="center" bgcolor="#FFFFFF"><?php echo $row_CONSULTA['COD_PROYECTO']; ?></td>
			<td width="200" bgcolor="#FFFFFF"><?php echo $row_CONSULTA['NOMBRE_PRO_CLI']; ?></td>
			<td width="200" align="left" bgcolor="#FFFFFF"><?php echo $row_CONSULTA['DESCRIPCION_PAGO']; ?></td>
			<td width="150" bgcolor="#FFFFFF"><?php echo $row_CONSULTA['TIPO_PAGO']; ?></td>
			<td align="center" bgcolor="#FFFFFF"><?php echo $row_CONSULTA['NUMERO_PAGO']; ?></td>
			<td width="100" align="center" bgcolor="#FFFFFF"><?php echo $row_CONSULTA['FECHA']; ?></td>
			<td width="100" align="right" bgcolor="#FFFFFF"><?php echo $row_CONSULTA['MONTO_PAGADO']; ?></td>
            <?php if (validador(12,$_SESSION['i'],"view")==1){?><td width="17" align="center" bgcolor="#FFFFFF"><!--<a href="../documentos/edit2.php?ID_DOCUMENTO=&amp;elegido=&amp;col=FECHA_DOCUMENTO&amp;orden=asc&amp;TIPO=0&amp;PROYECTO=0&amp;STATUS=Todos&amp;ID_PAGO=<?php echo $row_CONSULTA['ID_PAGO']; ?>" title="Ver Documento Asociado a este pago"><img src="../image/icon_doc.gif" width="24" height="24" /></a>--><a href="../documentos/pago_detalle_doc.php?ID_DOCUMENTO=&amp;elegido=&amp;col=FECHA_DOCUMENTO&amp;orden=asc&amp;TIPO=0&amp;PROYECTO=0&amp;STATUS=Todos&amp;ID_PAGO=<?php echo $row_CONSULTA['ID_PAGO']; ?>" title="Ver Documento Asociado a este pago"><img src="../image/icon_doc.gif" width="24" height="24" /></a>&nbsp;</td><?php } ?>
			<?php if (validador(13,$_SESSION['i'],"edi")==1){?><td width="5" align="center" bgcolor="#FFFFFF">
			<img src="../image/icon_doc.png" width="24" height="24" /></td><?php } ?>
			<td width="6" align="center" bgcolor="#FFFFFF"><?php if (($row_CONSULTA['TIPO_PAGO']=='CHEQUE')&&($row_CONSULTA['NUMERO_PAGO']=='')){ ?><a href="../_banco/add.php?ID_PAGO=<?php echo $row_CONSULTA['ID_PAGO']; ?>"><img src="../image/cheque.png" width="24" height="24" /></a><?php }?></td>
			
			<?php if (validador(13,$_SESSION['i'],"eli")==1){?><td width="25" align="center" bgcolor="#FFFFFF">
			<a href="#" title="Eliminar este Pago" ><img alt="Eliminar Registro"  src="../image/Delete-icon.png" width="24" height="24" onClick="openDialog(<?php echo $row_CONSULTA['ID_PAGO']; ?>)" /></a></td><?php } ?>
			
	</tr>
	
	

	
	<?php } while ($row_CONSULTA = mysql_fetch_assoc($CONSULTA)); ?>
		<tr class="textos_form">
		<td width="24" align="center" bgcolor="#CCCCCC"></td>
		<td width="25" align="center" bgcolor="#CCCCCC"></td>
		<td width="200" align="center" bgcolor="#CCCCCC"></td>
		<td width="200" align="center" bgcolor="#CCCCCC"></td>
		<td width="150" align="center" bgcolor="#CCCCCC"></td>
		<td width="100" align="center" bgcolor="#CCCCCC"></td>
		<td width="100" align="center" bgcolor="#CCCCCC">Total</td>
		<td width="100" align="right" bgcolor="#CCCCCC"><?php echo number_format($MONTO_TOTAL,2) ?></td>
		<td colspan="4" align="center" bgcolor="#CCCCCC">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="12" align="center">&nbsp;
			<table border="0" cellspacing="10">
				<tr>
					<td><?php if ($pageNum_CONSULTA > 0) { // Show if not first page ?>
							<a href="<?php printf("%s?pageNum_CONSULTA=%d%s", $currentPage, 0, $queryString_CONSULTA); ?>"><img src="First.gif" /></a>
							<?php } // Show if not first page ?></td>
					<td><?php if ($pageNum_CONSULTA > 0) { // Show if not first page ?>
							<a href="<?php printf("%s?pageNum_CONSULTA=%d%s", $currentPage, max(0, $pageNum_CONSULTA - 1), $queryString_CONSULTA); ?>"><img src="Previous.gif" /></a>
							<?php } // Show if not first page ?></td>
					<td><?php if ($pageNum_CONSULTA < $totalPages_CONSULTA) { // Show if not last page ?>
							<a href="<?php printf("%s?pageNum_CONSULTA=%d%s", $currentPage, min($totalPages_CONSULTA, $pageNum_CONSULTA + 1), $queryString_CONSULTA); ?>"><img src="Next.gif" /></a>
							<?php } // Show if not last page ?></td>
					<td><?php if ($pageNum_CONSULTA < $totalPages_CONSULTA) { // Show if not last page ?>
							<a href="<?php printf("%s?pageNum_CONSULTA=%d%s", $currentPage, $totalPages_CONSULTA, $queryString_CONSULTA); ?>"><img src="Last.gif" /></a>
							<?php } // Show if not last page ?></td>
				</tr>
		</table></td></tr>
</table>
<p>
	<?php } // Show if recordset not empty ?>
</p>
<?php if ($totalRows_CONSULTA == 0) { // Show if recordset empty ?>
<p class="textos_form" align="center">No hay registros que coincidan con los datos de la busqueda</p>
<?php } // Show if recordset empty ?>
<div id="dialog-confirm" title="Borrar?">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Este proceso NO es reversible.Desea BORRAR este registro?</p>
</div>	
</body>
</html>
<?php
mysql_free_result($CONSULTA);
?>
