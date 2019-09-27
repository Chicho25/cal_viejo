<?php 

//Modulo 1=Costos 2=Ventas
$modulo=2;

/////////////////////////////////////////////

$where="";

if($_GET['PROVEEDOR']!=""){
	if($where!=""){
		$where=$where." AND UPPER(NOMBRE) LIKE '%".strtoupper($_GET['PROVEEDOR'])."%' ";
	}
	else
	{
		$where=" WHERE UPPER(NOMBRE) LIKE '%".strtoupper($_GET['PROVEEDOR'])."%' ";
	}
}

if($_GET['CONTACTO']!=""){
	if($where!=""){
		$where=$where." AND UPPER(CONTACTO) LIKE '%".strtoupper($_GET['CONTACTO'])."%' ";
	}
	else
	{
		$where=" WHERE UPPER(CONTACTO) LIKE '%".strtoupper($_GET['CONTACTO'])."%' ";
	}
}

if($_GET['TIPO']!="Todos"){
	if($where!=""){
		$where=$where." AND COD_TIPO =".$_GET['TIPO']." ";
	}
	else
	{
		$where=" WHERE COD_TIPO=".$_GET['TIPO']." ";
	}
}else
{
	if($where!=""){
		$where=$where." AND COD_TIPO IN (2,3) ";
	}
	else
	{
		$where=" WHERE COD_TIPO IN (2,3) ";
	}
}
$VENDEDOR="";


		

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
$query_CONSULTA = "SELECT * FROM vista_pro_cli ".$where." ORDER BY ".$ordenar." ";
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
<script src="../js/jquery-1.4.2.min.js" language="javascript"></script>
<script src="../js/jquery-ui-1.8.5.custom.min.js" language="javascript"></script>
<script src="../js/jquery.ui.datepicker-es.js" language="javascript"></script>
<script src="../js/jquery.infieldlabel.min.js" language="javascript"></script>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<title>Untitled Document</title>
<link href="../js/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="../css/form.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/menu_style.css" type="text/css" media="all" />
<link href="../css/redmond/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
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
		var url = "del.php?ID_PRO_CLI="+local_id;    
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
		<td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Listado Clientes</div>
	</tr>
</table>

<table width="1100" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#999999">
	<tr class="textos_form">
		<td width="50" align="center" bgcolor="#FFFFFF">
		<table width="100%" border="0" cellspacing="0" cellpadding="4">
			<tr>
				<td align="right" bgcolor="#E5E5E5"><input type="button" name="button3" id="button3" value="Insertar" onClick="parent.location='add.php'"/></td>
				<td bgcolor="#E5E5E5"><input type="button" name="button" id="button" value="Buscar" onClick="parent.location='index.php'"/></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><table width="400" border="0" cellpadding="2" cellspacing="0" class="textos_form">
					<tr>
						<td width="50" bgcolor="#ffcaca">&nbsp;</td>
						<td width="150" class="textos_form">Sin Documento</td>
						<td width="50" bgcolor="#B3FFB3">&nbsp;</td>
						<td width="150">Con Documentos</td>
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
				<a href="listado.php?PROVEEDOR=<?php echo $_GET['PROVEEDOR']?>&col=ID_PRO_CLI&TIPO=<?php echo $_GET['TIPO']?>&VENDEDOR=<?php echo  $VENDEDOR; ?>&CONTACTO=<?php echo  $_GET['CONTACTO']; ?>&orden=<?php echo $orden;  ?>" class="<?php if ($_GET['col']=="ID_PRO_CLI"){ ?>textos_ordenar_rojo<?php }else{?>textos_ordenar<?php }?>">ID  <?php if ($_GET['col']=="ID_PRO_CLI"){ if($_GET['orden']==2){ ?><img src="../image/za.png" width="12" height="13" border="0" /><?php }else{?><img src="../image/az.png" width="12" height="13" border="0" /><?php }}else{?><img src="../image/azbw.png" width="12" height="13" border="0" /><?php }?></a>
			</td>
			<td width="150" align="center" bgcolor="#cccccc" class="textos_form">
				<a href="listado.php?PROVEEDOR=<?php echo $_GET['PROVEEDOR']?>&col=TIPO&TIPO=<?php echo $_GET['TIPO']?>&VENDEDOR=<?php echo  $VENDEDOR; ?>&CONTACTO=<?php echo  $_GET['CONTACTO']; ?>&orden=<?php echo $orden;  ?>" class="<?php if ($_GET['col']=="TIPO"){ ?>textos_ordenar_rojo<?php }else{?>textos_ordenar<?php }?>">Tipo 
				<?php if ($_GET['col']=="TIPO"){ if($_GET['orden']==2){ ?><img src="../image/za.png" width="12" height="13" border="0" /><?php }else{?><img src="../image/az.png" width="12" height="13" border="0" /><?php }}else{?><img src="../image/azbw.png" width="12" height="13" border="0" /><?php }?></a>
			</td>
			<td width="200" align="center" bgcolor="#cccccc" class="textos_form">
				<a href="listado.php?PROVEEDOR=<?php echo $_GET['PROVEEDOR']?>&col=NOMBRE&TIPO=<?php echo $_GET['TIPO']?>&VENDEDOR=<?php echo  $VENDEDOR; ?>&CONTACTO=<?php echo  $_GET['CONTACTO']; ?>&orden=<?php echo $orden;  ?>" class="<?php if ($_GET['col']=="NOMBRE"){ ?>textos_ordenar_rojo<?php }else{?>textos_ordenar<?php }?>">Nombre <?php if ($_GET['col']=="NOMBRE"){ if($_GET['orden']==2){ ?><img src="../image/za.png" width="12" height="13" border="0" /><?php }else{?><img src="../image/az.png" width="12" height="13" border="0" /><?php }}else{?><img src="../image/azbw.png" width="12" height="13" border="0" /><?php }?></a>
			</td>
			<td width="200" align="center" bgcolor="#cccccc" class="textos_form">
				<a href="listado.php?PROVEEDOR=<?php echo $_GET['PROVEEDOR']?>&col=CONTACTO&TIPO=<?php echo $_GET['TIPO']?>&VENDEDOR=<?php echo  $VENDEDOR; ?>&CONTACTO=<?php echo  $_GET['CONTACTO']; ?>&orden=<?php echo $orden;  ?>" class="<?php if ($_GET['col']=="CONTACTO"){ ?>textos_ordenar_rojo<?php }else{?>textos_ordenar<?php }?>">Contacto <?php if ($_GET['col']=="CONTACTO"){ if($_GET['orden']==2){ ?><img src="../image/za.png" width="12" height="13" border="0" /><?php }else{?><img src="../image/az.png" width="12" height="13" border="0" /><?php }}else{?><img src="../image/azbw.png" width="12" height="13" border="0" /><?php }?></a>
			</td>
			<td width="80" align="center" bgcolor="#cccccc" class="textos_form">
				<a href="listado.php?PROVEEDOR=<?php echo $_GET['PROVEEDOR']?>&col=VENDEDOR&TIPO=<?php echo $_GET['TIPO']?>&VENDEDOR=<?php echo  $VENDEDOR; ?>&CONTACTO=<?php echo  $_GET['CONTACTO']; ?>&orden=<?php echo $orden;  ?>" class="<?php if ($_GET['col']=="VENDEDOR"){ ?>textos_ordenar_rojo<?php }else{?>textos_ordenar<?php }?>">Vendedor <?php if ($_GET['col']=="VENDEDOR"){ if($_GET['orden']==2){ ?><img src="../image/za.png" width="12" height="13" border="0" /><?php }else{?><img src="../image/az.png" width="12" height="13" border="0" /><?php }}else{?><img src="../image/azbw.png" width="12" height="13" border="0" /><?php }?></a>
			</td>
		  <td width="25" align="center" bgcolor="#cccccc">&nbsp;</td>
			<td width="25" align="center" bgcolor="#cccccc">&nbsp;</td>
		</tr>
		<?php do { ?>
			<tr style="font-family:Arial, Helvetica, sans-serif; font-size:12px" bgcolor=
	<?php 
	if ($row_CONSULTA['DOCUMENTOS']==0){ ?>
	"#ffcaca"
	<?php }else {  ?>
	"#B3FFB3"
	<?php }?> >
				<td align="center"><?php echo $row_CONSULTA['ID_PRO_CLI']; ?></td>
				<td align="center"><?php echo $row_CONSULTA['TIPO']; ?></td>
				<td align="left"><?php echo $row_CONSULTA['NOMBRE']; ?></td>
				<td align="left"><?php echo $row_CONSULTA['CONTACTO']; ?></td>
				<td align="center"><?php echo $row_CONSULTA['VENDEDOR']; ?></td>
				<td align="right"><a href="editar.php?ID_PRO_CLI=<?php echo $row_CONSULTA['ID_PRO_CLI']; ?>&CODIGO=<?php echo $row_CONSULTA['COD_PROYECTO']; ?>"><img src="../image/icon_doc.png" width="24" height="24" /></a>
		    <input name="CODIGO" type="hidden" id="CODIGO" value="<?php echo $_GET['CODIGO']; ?>" /></td>
				<td align="right" ><?php if (($row_CONSULTA['DOCUMENTOS']==0)&&($row_CONSULTA['TIENE_CONTRATOS']==0)){?>
				<a href="#" ><img alt="Eliminar Registro"  src="../image/Delete-icon.png" width="24" height="24" onClick="openDialog(<?php echo $row_CONSULTA['ID_PRO_CLI']; ?>)" /></a><input name="CODIGO" type="hidden" id="CODIGO" value="<?php echo $row_CONSULTA['ID_PAGO']; ?>" /><?php }?></td>
			</tr>
			<?php } while ($row_CONSULTA = mysql_fetch_assoc($CONSULTA)); ?>
		<tr>
			<td colspan="7" align="center">
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
