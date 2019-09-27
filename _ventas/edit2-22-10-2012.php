<?php include("../include/_funciones.php"); ?>
<?php 
$col1="ID_INMUEBLES_MOV";
$col2="ID_PROYECTO";
$col3="ID_GRUPO";
$col4="FECHA_VENTA_DATE";
$col5="ID_CLIENTE";
$col6="MONTO_VENTA";
$col7="FECHA_VENTA_DATE";
$col8="FECHA_HASTA";
$col9="CODIGO_INMUEBLE";
$col10="ID_INMUEBLES";




$titulo_col1="ID";
$titulo_col2="PROYECTO";
$titulo_col3="GRUPO";
$titulo_col4="FECHA";
$titulo_col5="CLIENTE";
$titulo_col6="MONTO VENTA";
$titulo_col9="CODIGO INMUEBLE";
$titulo_col10="CODIGO INMUEBLE";

$where='';

include('_columnas.php');

if($valor_col1!="")
{
	if($where=='')
	{
		$where=' WHERE '.$col1.'='.$valor_col1;
	}else{
		$where=$where.' AND '.$col1.'='.$valor_col1;
	}
}

if($valor_col2!="")
{
	if($where=='')
	{
		$where=' WHERE '.$col2.'='.$valor_col2;
	}else{
		$where=$where.' AND '.$col2.'='.$valor_col2;
	}
}

if($valor_col3!="")
{
	if($where=='')
	{
		$where=' WHERE '.$col3.'='.$valor_col3;
	}else{
		$where=$where.' AND '.$col3.'='.$valor_col3;
	}
}

/*if($valor_col4!="")
{
	if($where=='')
	{
		$where=' WHERE '.$col4.'='.$valor_col4;
	}else{
		$where=$where.' AND '.$col4.'='.$valor_col4;
	}
}*/

if($valor_col5!="")
{
	if($where=='')
	{
		$where=' WHERE '.$col5.'='.$valor_col5;
	}else{
		$where=$where.' AND '.$col5.'='.$valor_col5;
	}
}

if($valor_col6!="")
{
	if($where=='')
	{
		$where=' WHERE '.$col6.'='.$valor_col6;
	}else{
		$where=$where.' AND '.$col6.'='.$valor_col6;
	}
}
if($valor_col7!="")
{
	if($valor_col8=="")
	{
		if($where=='')
		{
			$where=' WHERE '.$col7.'="'.DMAtoAMD($valor_col7).'" ';
		}else{
			$where=$where.' AND '.$col7.'="'.DMAtoAMD($valor_col7).'" ';
		}
	}else{
		
		if($where=='')
		{
			$where=' WHERE '.$col7.' BETWEEN "'.DMAtoAMD($valor_col7).'" AND "'.DMAtoAMD($valor_col8).'" ';
		}else{
			$where=$where.' AND '.$col7.' BETWEEN "'.DMAtoAMD($valor_col7).'" AND "'.DMAtoAMD($valor_col8).'" ';
		}
	}
}
if($valor_col10!="")
{
	if($where=='')
	{
		$where=' WHERE '.$col10.'='.$valor_col10;
	}else{
		$where=$where.' AND '.$col10.'='.$valor_col10;
	}
}
?>
<?php
/////////////////////////////////////////
 /*?>$tipo=$_GET['TIPO'];

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
	<?php */?>
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

$maxRows_CONSULTA = 1000;
$pageNum_CONSULTA = 0;
if (isset($_GET['pageNum_CONSULTA'])) {
  $pageNum_CONSULTA = $_GET['pageNum_CONSULTA'];
}
$startRow_CONSULTA = $pageNum_CONSULTA * $maxRows_CONSULTA;

mysql_select_db($database_conexion, $conexion);
$query_CONSULTA = "SELECT * FROM vista_ventas ".$where." ORDER BY ".$ordenar;
//echo $query_CONSULTA;
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
            height:230,
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
		var url = "del.php?ID_INMUEBLES_MOV="+local_id;  
		window.location =   url;
		//$(this).attr('href',url);
            //alert('Do something with ' + local_id);
        };

</script>
</head>

<body>
<?php $opcion_menu=2; ?>
<?php include("../include/menu.php"); ?>
<?php //include("../include/funciones.php"); ?>
<table width="1100" align="center" class="ui-widget-header" >
  <tr>
    <td width="100%" align="center" class="textos_form"><div class="titulo_formulario"> Contratos de Ventas</div>
  </tr>
</table>
<table width="1100" align="center" class="ui-widget-header" >
  <tr>
    <td width="100%" align="center" class="textos_form"><div align="center" style="background-color:#6FA7D1" ><?php include("_menu.php"); ?></div>
  </tr>
</table>

<table width="1100" border="0" align="center" cellpadding="4" cellspacing="4" bgcolor="#cccccc">
  <tr>
    <td colspan="2" align="center"><table width="700" border="0" cellpadding="2" cellspacing="0" class="textos_form">
					<tr>
						<td width="50" bgcolor="#ffcaca">&nbsp;</td>
						<td width="150" class="textos_form">Sin Documentos</td>
                        <td width="50" bgcolor="#FFFF99">&nbsp;</td>
						<td width="150" class="textos_form">Con Documentos</td>
						<td width="50" bgcolor="#B3FFB3">&nbsp;</td>
						<td width="250">Todos Documentos Registrados</td>
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
      <td width="25" align="center" bgcolor="#cccccc" class="textos_form"><?php echo $url_col1?></td>
      <td width="49" align="center" bgcolor="#cccccc" class="textos_form"><?php echo $url_col9?></td>
      <td width="50" align="center" bgcolor="#cccccc" class="textos_form"><?php echo $url_col2?></td>
      <td width="100" align="center" bgcolor="#cccccc" class="textos_form"><?php echo $url_col3?></td>
      <td width="100" align="center" bgcolor="#cccccc" class="textos_form"><?php echo $url_col4?></td>
      <td width="100" align="center" bgcolor="#cccccc" class="textos_form"><?php echo $url_col5?></td>
      <td width="50" align="center" bgcolor="#cccccc" class="textos_form"><?php echo $url_col6?></td>
      <td colspan="4" align="center" bgcolor="#cccccc">&nbsp;</td>
    </tr>
    <?php
	$TOTAL=0;
	 do { ?>
        <?php 
		$color='#ffcaca';
		$equis="../image/Delete-icon.png";
		$funcion='onClick="openDialog('. $row_CONSULTA['ID_INMUEBLES_MOV'].')"';
		$mas='<a href="../_doc_venta/add.php?ID_INMUEBLES_MOV='.$row_CONSULTA['ID_INMUEBLES_MOV'].'" title="Nuevo Documentos"><img src="../image/Add_over.png" width="20" height="20" /></a>';
	if($row_CONSULTA['TIENE_DOCUMENTOS']==1)
	{
		$color='#FFFF99';
		$equis="../image/Delete-iconbw.png";
		$funcion='';
	}
	if($row_CONSULTA['VENTA_CERRADA']==1)
	{
		$color='#B3FFB3';
		$equis="../image/Delete-iconbw.png";
		$funcion='';
		$mas='<img src="../image/Add.png" width="20" height="20" /></a>';
	}
$TOTAL=$TOTAL+$row_CONSULTA['MONTO_VENTA'];
	?>
      <tr style="font-family:Arial, Helvetica, sans-serif; font-size:12px" bgcolor='<?php echo $color ?>' >
        <td align="center"><?php echo $row_CONSULTA['ID_INMUEBLES_MOV']; ?></td>
        <td align="center"><?php echo $row_CONSULTA['CODIGO_INMUEBLE']; ?></td>
        <td><?php echo $row_CONSULTA['PROYECTO']; ?></td>
        <td align="center"><?php echo $row_CONSULTA['NOMBRE_GRUPO']; ?></td>
        <td align="center"><?php echo $row_CONSULTA['FECHA_VENTA']; ?></td>
        <td><?php echo $row_CONSULTA['NOMBRE_CLIENTE']; ?></td>
        <td align="right"><?php echo number_format($row_CONSULTA['MONTO_VENTA'],2); ?></td>
        <?php if (validador(19,$_SESSION['i'],"edi")==1){?><td width="12" align="center" >
          <a href="view.php?ID_INMUEBLES_MOV=<?php echo $row_CONSULTA['ID_INMUEBLES_MOV']; ?>" title="Ver Contrato"><img src="../image/icon_doc.png" width="24" height="24" /></a></td><?php } ?>
        <?php if (validador(20,$_SESSION['i'],"inc")==1){?><td width="5" align="center" ><?php echo $mas; ?></td><?php } ?>
        <td width="2" align="center" ><a href="../_doc_venta/listado.php?ID_INMUEBLES_MOV=<?php echo $row_CONSULTA['ID_INMUEBLES_MOV']; ?>" title="Ver Documentos"><img src="../image/flecha.png" width="24" height="24" /></a></td>
        <?php if (validador(19,$_SESSION['i'],"eli")==1){?><td width="3" align="center" > 
          <a href="del.php?ID_INMUEBLES_MOV=<?php echo $row_CONSULTA['ID_INMUEBLES_MOV']; ?>" title="Eliminar Venta" ><img alt="Eliminar Registro"  src="../image/Delete-icon.png" width="24" height="24" <?php echo $funcion ?> /></a></td><?php } ?>
        
        
      </tr>
      
      <?php } while ($row_CONSULTA = mysql_fetch_assoc($CONSULTA)); ?>
	 <tr class="menu">
      <td width="25" align="center" bgcolor="#cccccc" class="textos_form"></td>
      <td width="49" align="center" bgcolor="#cccccc" class="textos_form"></td>
      <td width="50" align="center" bgcolor="#cccccc" class="textos_form"></td>
      <td width="100" align="center" bgcolor="#cccccc" class="textos_form"></td>
      <td width="100" align="center" bgcolor="#cccccc" class="textos_form"></td>
      <td width="100" align="right" bgcolor="#cccccc" class="textos_form">Total</td>
      <td width="50" align="right" bgcolor="#cccccc" class="textos_form"><?php echo number_format($TOTAL,2); ?></td>
      <td colspan="4" align="center" bgcolor="#cccccc">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="11" align="center"><table border="0" cellspacing="10">
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
  <p><span class="ui-icon ui-icon-trash" style="float:left; margin:0 7px 20px 0;"></span><strong>Este proceso NO es reversible.Desea BORRAR este registro?.</strong><br /> <br>Nota: Recuerde que este proceso NO elimina los Documentos Generados por concepto de Comisiones de Venta.</p>
</div>
</body>
</html>
<?php
mysql_free_result($CONSULTA);

?>
