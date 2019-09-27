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

$colname_CONSULTA = "-1";
if (isset($_GET['ID_INMUEBLES_MOV'])) {
  $colname_CONSULTA = $_GET['ID_INMUEBLES_MOV'];
}
mysql_select_db($database_conexion, $conexion);
$query_CONSULTA = sprintf("SELECT * FROM vista_documentos WHERE ID_INMUEBLES_MOV = %s ORDER BY FECHA_VENCIMIENTO_DATE", GetSQLValueString($colname_CONSULTA, "int"));
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

$colname_Inmueble = "-1";
if (isset($_GET['ID_INMUEBLES_MOV'])) {
  $colname_Inmueble = $_GET['ID_INMUEBLES_MOV'];
}
mysql_select_db($database_conexion, $conexion);
$query_Inmueble = sprintf("SELECT * FROM vista_ventas WHERE ID_INMUEBLES_MOV = %s", GetSQLValueString($colname_Inmueble, "int"));
$Inmueble = mysql_query($query_Inmueble, $conexion) or die(mysql_error());
$row_Inmueble = mysql_fetch_assoc($Inmueble);
$totalRows_Inmueble = mysql_num_rows($Inmueble);

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
		window.location =   url;
            //alert('Do something with ' + local_id);
        };

</script>
</head>

<body>
<?php $opcion_menu=2; ?>
<?php include("../include/menu.php"); ?>
<table width="1100" align="center" class="ui-widget-header" >
  <tr>
    <td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Documentos Ventas</div>
  </tr>
</table>
<?php include("_menu.php"); ?>
<table width="1100" border="0" align="center" cellpadding="4" cellspacing="4" bgcolor="#cccccc">
  <tr>
    <td colspan="2" align="center"><table width="400" border="0" cellpadding="2" cellspacing="0" class="textos_form">
					<tr>
						<td width="50" bgcolor="#ffcaca">&nbsp;</td>
						<td width="150" class="textos_form">Sin Pagos</td>
						<td width="50" bgcolor="#B3FFB3">&nbsp;</td>
						<td width="150">Con Pagos</td>
					</tr>
				</table></td>
  </tr>
</table>
</td>
</tr>
</table>
<?php if ($totalRows_CONSULTA > 0) { // Show if recordset not empty ?>
  <table width="1100" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#999999">
  <tr class="ui-widget-header"><td colspan="10" class="textos_form"><?php echo $row_Inmueble['NOMBRE_INMUEBLE']; ?>-<?php echo $row_Inmueble['NOMBRE_CLIENTE']; ?></td></tr>
    <tr class="menu">
      <td width="24" align="center" bgcolor="#cccccc" class="textos_form">ID</td>
      <td width="25" align="center" bgcolor="#cccccc" class="textos_form">Tipo</td>
      <td width="100" align="center" bgcolor="#cccccc" class="textos_form">Numero</td>
      <td width="100" align="center" bgcolor="#cccccc" class="textos_form">Fecha Vencimiento</td>
      <td width="139" align="center" bgcolor="#cccccc" class="textos_form">Descripcion</td>
      <td width="100" align="center" bgcolor="#cccccc" class="textos_form">Monto Documento</td>
      <td width="100" align="center" bgcolor="#cccccc" class="textos_form">Monto Pagado</td>
      <td width="25" align="center" bgcolor="#cccccc">&nbsp;</td>
      <td width="24" align="center" bgcolor="#cccccc">&nbsp;</td>
      <td width="25" align="center" bgcolor="#cccccc">&nbsp;</td>
    </tr>
    <?php 
	$TOTAL_1=0;
	$TOTAL_2=0;
	
	do { ?>
    <?php 
		$color='#ffcaca';
		$equis="../image/Delete-icon.png";
		$funcion='onClick="openDialog('. $row_CONSULTA['ID_DOCUMENTO'].')"';
	if($row_CONSULTA['TIENE_PAGOS']==1)
	{
		$color='#b3ffb3';
		$equis="../image/Delete-iconbw.png";
		$funcion='';
	}
	$TOTAL_1=$TOTAL_1+$row_CONSULTA['MONTO_DOCUMENTO'];
	$TOTAL_2=$TOTAL_2+$row_CONSULTA['MONTO_PAGADO'];
	?>
      <tr style="font-family:Arial, Helvetica, sans-serif; font-size:12px" bgcolor=<?php echo $color ?> >
        <td align="center"><?php echo $row_CONSULTA['ID_DOCUMENTO']; ?></td>
        <td align="left"><?php echo $row_CONSULTA['TIPO_DOCUMENTO']; ?></td>
        <td align="center"><?php echo $row_CONSULTA['NUMERO_DOCUMENTO']; ?></td>
        <td align="center"><?php echo $row_CONSULTA['FECHA_VENCIMIENTO']; ?></td>
        <td align="center"><?php echo $row_CONSULTA['DESCRIPCION_DOCUMENTO']; ?></td>
        <td align="right"><?php echo number_format($row_CONSULTA['MONTO_DOCUMENTO'],2); ?></td>
        <td align="right"><?php echo number_format($row_CONSULTA['MONTO_PAGADO'],2); ?></td>
        <td align="center" >
          <a href="edit.php?ID_DOCUMENTO=<?php echo $row_CONSULTA['ID_DOCUMENTO']; ?>" title="Editar Documento"><img src="../image/icon_doc.png" width="24" height="24" /></a></td>
        <td align="center" ><?php if ($row_CONSULTA['STATUS_DOCUMENTO']==1){?>
				<a href="../_ventas_pago/add.php?ID_DOCUMENTO=<?php echo $row_CONSULTA['ID_DOCUMENTO']; ?>&ID_INMUEBLES_MOV=<?php echo $_GET['ID_INMUEBLES_MOV'] ?>" title="Nuevo Pagos"><img src="../image/dollar.png" width="24" height="28" /></a>					<?php }?>
          </td>
        <td align="center" ><a href="#" title="Eliminar Documento" ><img alt="Eliminar Registro"  src="<?php echo $equis ?>" width="24" height="24" <?php echo $funcion ?> /></a></td>
      </tr>
      
      <?php } while ($row_CONSULTA = mysql_fetch_assoc($CONSULTA)); ?>
	  <tr style="font-family:Arial, Helvetica, sans-serif; font-size:12px" bgcolor="#CCC" >
      	<td align="center">&nbsp;</td>
      	<td align="left">&nbsp;</td>
      	<td align="center">&nbsp;</td>
      	<td align="center">&nbsp;</td>
      	<td align="left">Total</td>
      	<td align="right"><?php echo number_format($TOTAL_1,2) ?></td>
      	<td align="right"><?php echo number_format($TOTAL_2,2) ?></td>
      	<td align="center" >&nbsp;</td>
      	<td align="center" >&nbsp;</td>
      	<td align="center" >&nbsp;</td>
      	</tr>
    <tr>
      <td colspan="10" align="center"><table border="0" cellspacing="10">
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
        </table></td>
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

mysql_free_result($Inmueble);

?>
