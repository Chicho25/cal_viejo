<?php //include("../include/_funciones.php"); ?>
<?php include('../include/header.php'); ?>
<?php 
$col1="ID_CUENTA_BANCARIA";
$col2="ID_TESORERIA_TIPO_MOV";
$col3="TIPO_IO";
$col4="NUMERO_PAGO";
$col5="DESCRIPCION";
$col6="ID_MOV_BANCO_CAJA";
$col7="FROM";
$col8="TO";
$col9="DEBITO";
$col10="CREDITO";
$col11="FECHA_DATE";
$col12="NOMBRE_TIPO_MOV";




$titulo_col1="ID";
$titulo_col2="TIPO MOVIMIENTO";
$titulo_col3="TIPO PAGO";
$titulo_col4="NUMERO";
$titulo_col5="DESCRIPCION";
$titulo_col6="ID";
$titulo_col9="DEBITO";
$titulo_col10="CREDITO";
$titulo_col11="FECHA";
$titulo_col12="TIPO MOVIMIENTO";

$where=' WHERE AFECTA_BANCO=1 ';

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

if($valor_col3!="T")
{
	if($where=='')
	{
		$where=' WHERE '.$col3.'="'.$valor_col3.'"';
	}else{
		$where=$where.' AND '.$col3.'="'.$valor_col3.'"';
	}
}

if($valor_col4!="")
{
	if($where=='')
	{
		$where=' WHERE '.$col4.'='.$valor_col4;
	}else{
		$where=$where.' AND '.$col4.'='.$valor_col4;
	}
}

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
			$where=' WHERE '.$col11.'="'.DMAtoAMD($valor_col7).'" ';
		}else{
			$where=$where.' AND '.$col11.'="'.DMAtoAMD($valor_col7).'" ';
		}
	}else{
		
		if($where=='')
		{
			$where=' WHERE '.$col11.' BETWEEN "'.DMAtoAMD($valor_col7).'" AND "'.DMAtoAMD($valor_col8).'" ';
		}else{
			$where=$where.' AND '.$col11.' BETWEEN "'.DMAtoAMD($valor_col7).'" AND "'.DMAtoAMD($valor_col8).'" ';
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
<?php require_once('../Connections/conexion.php'); ?>
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
if(isset($_GET['ANULADO']) && $_GET['ANULADO']!=''){$anulado=$_GET['ANULADO'];} else {$anulado='';}

if(isset($_GET['DIRECTO']) && $_GET['DIRECTO']!=''){$directo=$_GET['DIRECTO'];} else {$directo='AND ID_TESORERIA_TIPO_MOV<>0';}
//echo $directo;
mysql_select_db($database_conexion, $conexion);
$query_CONSULTA = "SELECT * FROM vista_banco_movimientos ".$where." ".$anulado." ".$directo." ORDER BY ".$ordenar;
//echo $query_CONSULTA;
$query_limit_CONSULTA = sprintf("%s LIMIT %d, %d", $query_CONSULTA, $startRow_CONSULTA, $maxRows_CONSULTA);
$CONSULTA = mysql_query($query_limit_CONSULTA, $conexion) or die(mysql_error());
$row_CONSULTA = mysql_fetch_assoc($CONSULTA);

mysql_select_db($database_conexion, $conexion);
$query_CUENTAS = "SELECT NOMBRE_PROYECTO, NOMBRE_BANCO, NUMERO_CUENTA, SUM(DEBITO) as TOTAL_DEBITO, SUM(CREDITO) AS TOTAL_CREDITO  FROM vista_banco_movimientos WHERE AFECTA_BANCO=1  AND ID_CUENTA_BANCARIA = ".$_GET[$col1];
$CUENTAS = mysql_query($query_CUENTAS, $conexion) or die(mysql_error());
$row_CUENTAS = mysql_fetch_assoc($CUENTAS);
$totalRows_CUENTAS = mysql_num_rows($CUENTAS);

mysql_select_db($database_conexion, $conexion);
$query_CUENTAS_CONSULTA = "SELECT NOMBRE_PROYECTO, NOMBRE_BANCO, NUMERO_CUENTA, SUM(DEBITO) as TOTAL_DEBITO, SUM(CREDITO) AS TOTAL_CREDITO  FROM vista_banco_movimientos ".$where." ";
$CUENTAS_CONSULTA = mysql_query($query_CUENTAS_CONSULTA, $conexion) or die(mysql_error());
$row_CUENTAS_CONSULTA = mysql_fetch_assoc($CUENTAS_CONSULTA);
$totalRows_CUENTAS_CONSULTA = mysql_num_rows($CUENTAS_CONSULTA);

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
		var url = "del.php?ID_MOV_BANCO_CAJA="+local_id;  
		window.location =   url;
		//$(this).attr('href',url);
            //alert('Do something with ' + local_id);
        };

</script>
</head>

<body>
<?php $opcion_menu=2; ?>

<table width="1100" align="center" class="ui-widget-header" >
  <tr>
    <td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Movimientos Bancario</div>
  </tr>
</table>
<?php include("_menu.php"); ?>
</td>
</tr>
</table><?php if ($totalRows_CONSULTA > 0) { // Show if recordset not empty ?>
<table width="1100" border="0" align="center" cellpadding="4" cellspacing="2" class="textos_form">
	<tr class="textos_form">
	  <td colspan="4" align="center" bgcolor="#F0F0F0" class="textos_form"> <?php echo $row_CONSULTA['NOMBRE_PROYECTO']; ?> - <?php echo $row_CONSULTA['NOMBRE_BANCO']; ?> - <?php echo $row_CONSULTA['NUMERO_CUENTA']; ?></td>
    </tr>
			<tr class="textos_form">
	  <td align="left" bgcolor="#F0F0F0" class="textos_form">&nbsp;</td>
	  <td width="150" align="center" bgcolor="#F0F0F0">Debito</td>
	  <td width="150" align="center" bgcolor="#F0F0F0">Credito</td>
	  <td width="150" align="center" bgcolor="#F0F0F0">Saldo</td>
    </tr>
		
		<tr class="textos_form">
	  <td align="left" bgcolor="#FFFFFF" class="textos_form">Totales</td>
	  <td width="150" align="right" bgcolor="#FFFFFF"><?php echo number_format($row_CUENTAS_CONSULTA['TOTAL_DEBITO'],2); ?></td>
	  <td width="150" align="right" bgcolor="#FFFFFF"><?php echo number_format($row_CUENTAS_CONSULTA['TOTAL_CREDITO'],2); ?></td>
	  <td width="150" align="right" bgcolor="#FFFFFF" style="color:<?php if (($row_CUENTAS_CONSULTA['TOTAL_CREDITO']-$row_CUENTAS_CONSULTA['TOTAL_DEBITO'])>0){ ?>#000000<?php }else{?>#FF0000<?php }?>"><?php echo number_format($row_CUENTAS_CONSULTA['TOTAL_CREDITO']-$row_CUENTAS_CONSULTA['TOTAL_DEBITO'],2); ?></td>
    </tr>
	<!--<tr class="textos_form">
	  <td align="left" bgcolor="#FFFFFF" class="textos_form">Totales de esta Busqueda</td>
	  <td width="150" align="right" bgcolor="#FFFFFF"><?php echo number_format($row_CUENTAS_CONSULTA['TOTAL_DEBITO'],2); ?></td>
	  <td width="150" align="right" bgcolor="#FFFFFF"><?php echo number_format($row_CUENTAS_CONSULTA['TOTAL_CREDITO'],2); ?></td>
	  <td width="150" align="right" bgcolor="#FFFFFF" style="color:<?php if (($row_CUENTAS_CONSULTA['TOTAL_CREDITO']-$row_CUENTAS_CONSULTA['TOTAL_DEBITO'])>0){ ?>#000000<?php }else{?>#FF0000<?php }?>"><?php echo number_format($row_CUENTAS_CONSULTA['TOTAL_CREDITO']-$row_CUENTAS_CONSULTA['TOTAL_DEBITO'],2); ?></td>
    </tr>-->
</table>

  <table width="1100" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#999999">
    <tr class="menu">
      <td width="50" align="center" bgcolor="#cccccc" class="textos_form"><?php echo $url_col6?></td>
      <td width="100" align="center" bgcolor="#cccccc" class="textos_form"><?php echo $url_col12?></td>
      <td width="100" align="center" bgcolor="#cccccc" class="textos_form"><?php echo $url_col4?></td>
      <td width="100" align="center" bgcolor="#cccccc" class="textos_form"><?php echo $url_col11?></td>
      <td align="center" bgcolor="#cccccc" class="textos_form"><?php echo $url_col5?></td>
      <td width="150" align="center" bgcolor="#cccccc" class="textos_form"><?php echo $url_col9?></td>
      <td width="150" align="center" bgcolor="#cccccc" class="textos_form"><?php echo $url_col10?></td>
      <td width="25" align="center" bgcolor="#cccccc">&nbsp;</td>
      <td width="12" align="center" bgcolor="#cccccc">&nbsp;</td>
      <?php if (validador(24,$_SESSION['i'],"eli")==1){?><td width="12" align="center" bgcolor="#cccccc">&nbsp;</td><?php }?>

    </tr>
    <?php do { ?>
        <?php 
		$color='#ffFFFF';
		$equis="../image/Delete-icon.png";
		$funcion='onClick="openDialog('. $row_CONSULTA['ID_MOV_BANCO_CAJA'].')"';
		$mas='<a href="del.php?ID_MOV_BANCO_CAJA='.$row_CONSULTA['ID_MOV_BANCO_CAJA'].'" title="Eliminar Movimiento"><img src="../image/Add_over.png" width="20" height="20" /></a>';
	
	?>
      <tr style="font-family:Arial, Helvetica, sans-serif; font-size:12px" bgcolor='<?php echo $color ?>' >
        <td align="center"><?php echo $row_CONSULTA['ID_MOV_BANCO_CAJA']; ?></td>
        <td align="center"><?php echo $row_CONSULTA['NOMBRE_TIPO_MOV']; ?></td>
        <td align="center"><?php echo $row_CONSULTA['NUMERO_PAGO']; ?></td>
        <td align="center"><?php echo $row_CONSULTA['FECHA']; ?></td>
        <td><?php echo $row_CONSULTA['DESCRIPCION']; ?></td>
        <td align="right"><?php echo number_format($row_CONSULTA['DEBITO'],2); ?></td>
        <td align="right"><?php echo number_format($row_CONSULTA['CREDITO'],2); ?></td>
        <td align="center" ><?php if ($row_CONSULTA['MODULO_TIPO_MOV']==3){ ?>
          <a href="edit.php?ID_MOV_BANCO_CAJA=<?php echo $row_CONSULTA['ID_MOV_BANCO_CAJA']; ?>" title="Ver/Editar "><img src="../image/icon_doc.png" width="24" height="24" /></a><?php }?></td>
<td align="center" ><?php if (($row_CONSULTA['NOMBRE_TIPO_MOV']=='CHEQUE')&&($row_CONSULTA['MODULO_TIPO_MOV']=='3')){ ?><!--<img src="../image/cheque.png" width="24" height="24" />--><?php }?></td>
        <?php if (validador(24,$_SESSION['i'],"eli")==1){?><td align="center" ><?php if ($row_CONSULTA['MODULO_TIPO_MOV']==3){ ?> 
          <a href="#" title="Eliminar" ><img alt="Eliminar Registro"  src="<?php echo $equis ?>" width="24" height="24" <?php echo $funcion ?> /></a><?php }?></td><?php }?>
        
        
        
      </tr>
      
      <?php } while ($row_CONSULTA = mysql_fetch_assoc($CONSULTA)); ?>
    <tr>
      <td colspan="12" align="center"><table border="0" cellspacing="10">
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
  <p><span class="ui-icon ui-icon-trash" style="float:left; margin:0 7px 20px 0;"></span><strong>Este proceso NO es reversible.Desea BORRAR este registro?.</strong></p>
</div>
</body>
</html>
<?php
mysql_free_result($CONSULTA);

?>
