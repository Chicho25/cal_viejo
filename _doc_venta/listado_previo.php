<?php 

//Modulo 1=Costos 2=Ventas
$modulo=2;

/////////////////////////////////////////////
$tipo=$_GET['TIPO'];

$status=$_GET['STATUS'];

$proyecto=$_GET['PROYECTO'];


$where="WHERE modulo=".$modulo;
if($_GET['elegido']!=""){
$where=$where." AND ID_PRO_CLI=".$_GET['elegido']." ";
}

if($_GET['ID_DOCUMENTO']!=""){
	
	$where=$where." AND ID_DOCUMENTO=".$_GET['ID_DOCUMENTO']." ";
}

if($_GET['TIPO']!="0"){
	
	$where=$where." AND CODIGO_TIPO_DOCUMENTO=".$tipo." ";
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

$maxRows_CONSULTA = 10;
$pageNum_CONSULTA = 0;
if (isset($_GET['pageNum_CONSULTA'])) {
  $pageNum_CONSULTA = $_GET['pageNum_CONSULTA'];
}
$startRow_CONSULTA = $pageNum_CONSULTA * $maxRows_CONSULTA;

mysql_select_db($database_conexion, $conexion);
$query_CONSULTA = "SELECT * FROM vista_documentos ".$where." ORDER BY ".$ordenar." ";
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
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<title>Untitled Document</title>
<?php include("../include/_js.php"); ?>
<?php include("../include/_css.php"); ?>
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
<table width="1100" align="center" class="ui-widget-header" >
	<tr>
		<td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Cobro</div>
	</tr>
</table>
<?php include("_menu.php"); ?>
<table width="1100" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#999999">
	<tr class="textos_form">
		<td width="50" align="center" bgcolor="#FFFFFF">
		<table width="100%" border="0" cellspacing="0" cellpadding="4">
			<tr>
				<td align="right" bgcolor="#E5E5E5"><input type="button" name="button3" id="button3" value="Insertar" onClick="parent.location='../formularios/partidas_proyecto.php'"/></td>
				<td bgcolor="#E5E5E5"><input type="button" name="button" id="button" value="Buscar" onClick="parent.location='edit.php'"/></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><table width="450" border="0" cellpadding="2" cellspacing="0" class="textos_form">
					<tr>
						<td width="50" bgcolor="#ffcaca">&nbsp;</td>
						<td width="100" class="textos_form"><a title="Ver Solo Sin Abonos" href="../documentos/edit2.php?elegido=&col=FECHA_DOCUMENTO&orden=asc&TIPO=0&PROYECTO=0&STATUS=0" class="textos_ordenar_rojo">Sin Abonos</a></td>
						<td width="50" bgcolor="#FFFF99">&nbsp;</td>
						<td width="100"><a title="Ver Solo Con Abonos" href="../documentos/edit2.php?elegido=&col=FECHA_DOCUMENTO&orden=asc&TIPO=0&PROYECTO=0&STATUS=2" class="textos_ordenar_rojo">Con Abonos</a></td>
						<td width="50" bgcolor="#B3FFB3">&nbsp;</td>
						<td width="100"><a title="Ver Solo los Pagados" href="../documentos/edit2.php?elegido=&col=FECHA_DOCUMENTO&orden=asc&TIPO=0&PROYECTO=0&STATUS=3" class="textos_ordenar_rojo">Pagados</a></td>
					</tr>
				</table></td>
				</tr>
		</table>
		</td>
	</tr>
</table>
<?php if ($totalRows_CONSULTA > 0) { // Show if recordset not empty ?>
	<table width="1100" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#999999">
		<tr class="menu">
			<td width="50" align="center" bgcolor="#cccccc">
				<a title="Ordenar" href="edit2.php?elegido=<?php echo $_GET['elegido']?>&col=ID_DOCUMENTO&TIPO=<?php echo $tipo?>&PROYECTO=<?php echo $proyecto; ?>&STATUS=<?php echo $status; ?>&orden=<?php echo $orden;  ?>" class="<?php if ($_GET['col']=="ID_DOCUMENTO"){ ?>textos_ordenar_rojo<?php }else{?>textos_ordenar<?php }?>">ID  <?php if ($_GET['col']=="ID_DOCUMENTO"){ if($_GET['orden']==2){ ?><img src="../image/za.png" width="12" height="13" border="0" /><?php }else{?><img src="../image/az.png" width="12" height="13" border="0" /><?php }}else{?><img src="../image/azbw.png" width="12" height="13" border="0" /><?php }?></a>
			</td>
			<td width="150" align="center" bgcolor="#cccccc" class="textos_form">
				<a title="Ordenar" href="edit2.php?elegido=<?php $_GET['elegido']?>&col=COD_PROYECTO&TIPO=<?php echo $tipo?>&PROYECTO=<?php echo $proyecto; ?>&STATUS=<?php echo $status; ?>&orden=<?php echo $orden;  ?>" class="<?php if ($_GET['col']=="COD_PROYECTO"){ ?>textos_ordenar_rojo<?php }else{?>textos_ordenar<?php }?>">Proyecto  <?php if ($_GET['col']=="COD_PROYECTO"){ if($_GET['orden']==2){ ?><img src="../image/za.png" width="12" height="13" border="0" /><?php }else{?><img src="../image/az.png" width="12" height="13" border="0" /><?php }}else{?><img src="../image/azbw.png" width="12" height="13" border="0" /><?php }?></a>
			</td>
			<td width="100" align="center" bgcolor="#cccccc" class="textos_form">
			<a title="Ordenar" href="edit2.php?elegido=<?php $_GET['elegido']?>&col=CODIGO_TIPO_DOCUMENTO&TIPO=<?php echo $tipo?>&PROYECTO=<?php echo $proyecto; ?>&STATUS=<?php echo $status; ?>&orden=<?php echo $orden;  ?>" class="<?php if ($_GET['col']=="CODIGO_TIPO_DOCUMENTO"){ ?>textos_ordenar_rojo<?php }else{?>textos_ordenar<?php }?>">Tipo <?php if ($_GET['col']=="CODIGO_TIPO_DOCUMENTO"){ if($_GET['orden']=2){ ?><img src="../image/za.png" width="12" height="13" border="0" /><?php }else{?><img src="../image/az.png" width="12" height="13" border="0" /><?php }}else{?><img src="../image/azbw.png" width="12" height="13" border="0" /><?php }?></a></td>
			<td width="100" align="center" bgcolor="#cccccc" class="<?php if ($_GET['col']=="FECHA_DOCUMENTO"){ ?>textos_ordenar_rojo<?php }else{?>textos_ordenar<?php }?>"><a title="Ordenar" href="edit2.php?elegido=<?php $_GET['elegido']?>&col=FECHA_DOCUMENTO&TIPO=<?php echo $tipo?>&PROYECTO=<?php echo $proyecto; ?>&STATUS=<?php echo $status; ?>&orden=<?php echo $orden;  ?>" class="<?php if ($_GET['col']=="FECHA_DOCUMENTO_DATE"){ ?>textos_ordenar_rojo<?php }else{?>textos_ordenar<?php }?>">Fecha  <?php if ($_GET['col']=="FECHA_DOCUMENTO_DATE"){ if($_GET['orden']==2){ ?><img src="../image/za.png" width="12" height="13" border="0" /><?php }else{?><img src="../image/az.png" width="12" height="13" border="0" /><?php }}else{?><img src="../image/azbw.png" width="12" height="13" border="0" /><?php }?></a></td>
			<td width="100" align="center" bgcolor="#cccccc" class="textos_form">
			<a title="Ordenar" href="edit2.php?elegido=<?php $_GET['elegido']?>&col=NOMBRE_PRO_CLI&TIPO=<?php echo $tipo?>&PROYECTO=<?php echo $proyecto; ?>&STATUS=<?php echo $status; ?>&orden=<?php echo $orden;  ?>" class="<?php if ($_GET['col']=="NOMBRE_PRO_CLI"){ ?>textos_ordenar_rojo<?php }else{?>textos_ordenar<?php }?>">Proveedor  <?php if ($_GET['col']=="NOMBRE_PRO_CLI"){ if($_GET['orden']==2){ ?><img src="../image/za.png" width="12" height="13" border="0" /><?php }else{?><img src="../image/az.png" width="12" height="13" border="0" /><?php }}else{?><img src="../image/azbw.png" width="12" height="13" border="0" /><?php }?></a></td>
			<td align="center" bgcolor="#cccccc" class="textos_form">
			<a title="Ordenar" href="edit2.php?elegido=<?php $_GET['elegido']?>&col=DESCRIPCION_DOCUMENTO&TIPO=<?php echo $tipo?>&PROYECTO=<?php echo $proyecto; ?>&STATUS=<?php echo $status; ?>&orden=<?php echo $orden;  ?>" class="<?php if ($_GET['col']=="DESCRIPCION_DOCUMENTO"){ ?>textos_ordenar_rojo<?php }else{?>textos_ordenar<?php }?>">Descripcion  <?php if ($_GET['col']=="DESCRIPCION_DOCUMENTO"){ if($_GET['orden']==2){ ?><img src="../image/za.png" width="12" height="13" border="0" /><?php }else{?><img src="../image/az.png" width="12" height="13" border="0" /><?php }}else{?><img src="../image/azbw.png" width="12" height="13" border="0" /><?php }?></a></td>
			<td width="70" align="center" bgcolor="#cccccc">
			<a title="Ordenar" href="edit2.php?elegido=<?php $_GET['elegido']?>&col=MONTO_DOCUMENTO&TIPO=<?php echo $tipo?>&PROYECTO=<?php echo $proyecto; ?>&STATUS=<?php echo $status; ?>&orden=<?php echo $orden;  ?>" class="<?php if ($_GET['col']=="MONTO_DOCUMENTO"){ ?>textos_ordenar_rojo<?php }else{?>textos_ordenar<?php }?>">Monto  <?php if ($_GET['col']=="MONTO_DOCUMENTO"){ if($_GET['orden']==2){ ?><img src="../image/za.png" width="12" height="13" border="0" /><?php }else{?><img src="../image/az.png" width="12" height="13" border="0" /><?php }}else{?><img src="../image/azbw.png" width="12" height="13" border="0" /><?php }?></a></td>
			<td width="90" align="center" bgcolor="#cccccc">
			<a title="Ordenar" href="edit2.php?elegido=<?php $_GET['elegido']?>&col=MONTO_PAGADO&TIPO=<?php echo $tipo?>&PROYECTO=<?php echo $proyecto; ?>&STATUS=<?php echo $status; ?>&orden=<?php echo $orden;  ?>" class="<?php if ($_GET['col']=="MONTO_PAGADO"){ ?>textos_ordenar_rojo<?php }else{?>textos_ordenar<?php }?>">Pagado  <?php if ($_GET['col']=="MONTO_PAGADO"){ if($_GET['orden']==2){ ?><img src="../image/za.png" width="12" height="13" border="0" /><?php }else{?><img src="../image/az.png" width="12" height="13" border="0" /><?php }}else{?><img src="../image/azbw.png" width="12" height="13" border="0" /><?php }?></a></td>
			<td width="25" align="center" bgcolor="#cccccc">&nbsp;</td>
			<td width="12" align="center" bgcolor="#cccccc">&nbsp;</td>
			<td width="12" align="center" bgcolor="#cccccc">&nbsp;</td>
		</tr>
		<?php do { ?>
			<tr style="font-family:Arial, Helvetica, sans-serif; font-size:12px" bgcolor=
	<?php 
	if ($row_CONSULTA['TIENE_PAGOS']==0){ ?>
	"#ffcaca"
	<?php }else if($row_CONSULTA['STATUS_DOCUMENTO']==0){  ?>
	"#B3FFB3"
	<?php } else {?>
	"#FFFF99"
	<?php }?> >
				<td align="center"><?php echo $row_CONSULTA['ID_DOCUMENTO']; ?></td>
				<td><?php echo $row_CONSULTA['NOMBRE_PROYECTO']; ?></td>
				<td align="center"><?php echo $row_CONSULTA['TIPO_DOCUMENTO']; ?></td>
				<td align="center"><?php echo $row_CONSULTA['FECHA_DOCUMENTO']; ?></td>
				<td><?php echo $row_CONSULTA['NOMBRE_PRO_CLI']; ?></td>
				<td><?php echo $row_CONSULTA['DESCRIPCION_DOCUMENTO']; ?></td>
				<td align="right"><?php echo number_format($row_CONSULTA['MONTO_DOCUMENTO'],2); ?></td>
				<td align="right"><?php echo number_format($row_CONSULTA['MONTO_PAGADO'],2); ?></td>
				<td align="right">	<?php 
	if ($row_CONSULTA['TIENE_PAGOS']==0){ ?><a href="edit4.php?ID_DOCUMENTO=<?php echo $row_CONSULTA['ID_DOCUMENTO']; ?>&CODIGO=<?php echo $row_CONSULTA['COD_PROYECTO']; ?>" title="Ver/Editar"><img src="../image/icon_doc.png" width="24" height="24" /></a><?php }else{?><a href="edit3.php?ID_DOCUMENTO=<?php echo $row_CONSULTA['ID_DOCUMENTO']; ?>&CODIGO=<?php echo $row_CONSULTA['COD_PROYECTO']; ?>" title="Ver/Editar"><img src="../image/icon_doc.png" width="24" height="24" /></a><?php }?>
				<input name="CODIGO" type="hidden" id="CODIGO" value="<?php echo $_GET['CODIGO']; ?>" /></td>
				<td align="right" ><?php if ($row_CONSULTA['TIENE_PAGOS']==1){?>
				<a href="../pago_eliminar/del01.php?PROYECTO=&PROVEEDOR=&TIPO=&NUMERO=&FROM=&TO=&ID_DOCUMENTO=<?php echo $row_CONSULTA['ID_DOCUMENTO']; ?>" title="Ver Pagos"><img src="../image/dollar.png" width="24" height="28" /></a>					<?php }?></td>
				<td align="right" ><?php if ($row_CONSULTA['TIENE_PAGOS']==0){?>
				<a href="#" title="Eliminar Pagos" ><img alt="Eliminar Registro"  src="../image/Delete-icon.png" width="24" height="24" onClick="openDialog(<?php echo $row_CONSULTA['ID_DOCUMENTO']; ?>)" /></a><?php }?></td>
				
			</tr>
			<?php } while ($row_CONSULTA = mysql_fetch_assoc($CONSULTA)); ?>
		<tr>
			<td colspan="11" align="center">
				<table border="0" cellspacing="10">
					
					<tr>
						<td><?php if ($pageNum_CONSULTA > 0) { // Show if not first page ?>
							<a href="<?php printf("%s?pageNum_CONSULTA=%d%s", $currentPage, 0, $queryString_CONSULTA); ?>"><img src="First.gif" alt="" /></a>
							<?php } // Show if not first page ?></td>
						<td><?php if ($pageNum_CONSULTA > 0) { // Show if not first page ?>
							<a href="<?php printf("%s?pageNum_CONSULTA=%d%s", $currentPage, max(0, $pageNum_CONSULTA - 1), $queryString_CONSULTA); ?>"><img src="Previous.gif" alt="" /></a>
							<?php } // Show if not first page ?></td>
						<td><?php if ($pageNum_CONSULTA < $totalPages_CONSULTA) { // Show if not last page ?>
							<a href="<?php printf("%s?pageNum_CONSULTA=%d%s", $currentPage, min($totalPages_CONSULTA, $pageNum_CONSULTA + 1), $queryString_CONSULTA); ?>"><img src="Next.gif" alt="" /></a>
							<?php } // Show if not last page ?></td>
						<td><?php if ($pageNum_CONSULTA < $totalPages_CONSULTA) { // Show if not last page ?>
							<a href="<?php printf("%s?pageNum_CONSULTA=%d%s", $currentPage, $totalPages_CONSULTA, $queryString_CONSULTA); ?>"><img src="Last.gif" alt="" /></a>
							<?php } // Show if not last page ?></td>
					</tr>
				</table>
				
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
