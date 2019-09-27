<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "0,1,2,3,4,5,6,7,8,9";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php //include("../include/_funciones.php"); ?>
<?php 
$col1="ID_PARTIDA";
$col2="COD_PROYECTO";
$col3="DESCRIPCION_COMPLETA";
$col4="MONTO_ESTIMADO";
$col5="MONTO_PAGADO";
$col6="ESTIMADO_EXCEDIDO";
/*$col7="VENDIDO";
$col8="CODIGO_INMUEBLE";*/




$titulo_col1="ID";
$titulo_col2="PROYECTO";
$titulo_col3="NOMBRE";
$titulo_col4="MONTO ESTIMADO";
$titulo_col5="MONTO PAGADO";
$titulo_col6="SALDO";/**/
/*$titulo_col8="CODIGO INMUEBLE";
*/
$where='WHERE TIPO>0 ';

include('_columnas.php');

if($valor_col1!="")
{
		if(isset($_GET['DETALLE']) && $_GET['DETALLE']==1){
		$where=$where.' AND ID_GRUPO='.$valor_col1;
		
	}else{
	if($where=='')
	{
		$where=' WHERE '.$col1. '="'.$valor_col1.'" ';
	}else{
		$where=$where.' AND '.$col1.'="'.$valor_col1.'" ';
	}}
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
/*
if($valor_col7!="")
{
	if($where=='')
	{
		$where=' WHERE '.$col7.'='.$valor_col7;
	}else{
		$where=$where.' AND '.$col7.'='.$valor_col7;
	}
}*/
/*if($valor_col7!="")
{
	if($valor_col8=="")
	{
		if($where=='')
		{
			$where=' WHERE '.$col7.'='.DMAtoAMD($valor_col7);
		}else{
			$where=$where.' AND '.$col7.'='.DMAtoAMD($valor_col7);
		}
	}else{
		
		if($where=='')
		{
			$where=' WHERE '.$col7.' BETWEEN '.DMAtoAMD($valor_col7).' AND '.DMAtoAMD($valor_col8);
		}else{
			$where=$where.' AND '.$col7.' BETWEEN '.DMAtoAMD($valor_col7).' AND '.DMAtoAMD($valor_col8);
		}
	}
}*/

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

mysql_select_db($database_conexion, $conexion);
//$query_CONSULTA = "SELECT * FROM vista_partidas ".$where." ".$_GET['NIVEL']." ORDER BY ".$ordenar;
$query_CONSULTA = "SELECT * FROM vista_partidas ".$where." ORDER BY ".$ordenar;

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
		var url = "del.php?ID="+local_id;    
		window.location =   url;
            //alert('Do something with ' + local_id);
        };

</script>
</head>

<body>
<?php $opcion_menu=2; ?>
<?php include('../include/header.php'); ?>
<?php //include("../include/funciones.php"); ?>
<table width="1100" align="center" class="ui-widget-header" >
  <tr>
    <td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Partidas</div>
  </tr>
</table>
<?php include("_menu.php"); ?>
<table width="1100" border="0" align="center" cellpadding="4" cellspacing="4" bgcolor="#cccccc">
  <tr>
    <td colspan="2" align="center"><table width="400" border="0" cellpadding="2" cellspacing="0" class="textos_form">
					<tr>
						<td width="50" bgcolor="#ffcaca">&nbsp;</td>
						<td width="150" class="textos_form">Excedidas</td>
						<td width="50" bgcolor="#B3FFB3">&nbsp;</td>
						<td width="75">Normal</td>
						<td width="75" bgcolor="#ffff99">&nbsp;</td>
						<td width="150">Alicuota</td>
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
      <td width="50" align="center" bgcolor="#cccccc" class="textos_form"><?php echo $url_col1?></td>
      <td width="100" align="center" bgcolor="#cccccc" class="textos_form"><?php echo $url_col2?></td>
      <td align="center" bgcolor="#cccccc" class="textos_form"><?php echo $url_col3?></td>
      <td width="150" align="center" bgcolor="#cccccc" class="textos_form"><?php echo $url_col4?></td>
      <td width="150" align="center" bgcolor="#cccccc" class="textos_form"><?php echo $url_col5?></td>
      <td width="150" align="center" bgcolor="#cccccc" class="textos_form"><?php echo $url_col6?></td>
      <td colspan="2" align="center" bgcolor="#cccccc">&nbsp;</td>
    </tr>
    <?php 
	$MONTO1=0;
	$MONTO2=0;
	$MONTO3=0;
	
	
	do { ?>
    <?php
		$MONTO1=$MONTO1+$row_CONSULTA['MONTO_ESTIMADO'];
	$MONTO2=$MONTO2+$row_CONSULTA['MONTO_PAGADO'];
	$MONTO3=$MONTO3+$row_CONSULTA['MONTO_ESTIMADO_DISPONIBLE'];
	 
		$color='#b3ffb3';
		$equis="../image/Delete-icon.png";
		$funcion='onClick="openDialog('. $row_CONSULTA['ID_PARTIDA'].')"';
	if($row_CONSULTA['ESTIMADO_EXCEDIDO']==1)
	{
		$color='#ffcaca';
		//$equis="../image/Delete-iconbw.png";
		//$funcion='';
	}
	if($row_CONSULTA['ALICUOTA']==1)
	{
		$color='#ffff99';
		$equis="../image/Delete-iconbw.png";
		$funcion='';
	}
	if(($row_CONSULTA['TIENE_HIJOS']==1)||($row_CONSULTA['TIENE_DOCUMENTOS']==1))
	{
		//$color='#ffff99';
		$equis="../image/Delete-iconbw.png";
		$funcion='';
	}

		
		
		
		
		?>
      <tr style="font-family:Arial, Helvetica, sans-serif; font-size:12px" bgcolor=<?php echo $color ?> >
        <td align="center"><?php echo $row_CONSULTA['ID_PARTIDA']; ?></td>
        <td align="center"><?php echo $row_CONSULTA['COD_PROYECTO']; ?></td>
        <td><?php echo $row_CONSULTA['DESCRIPCION_COMPLETA']; ?></td>
        <td align="right"><?php echo number_format($row_CONSULTA['MONTO_ESTIMADO'],2); ?></td>
        <td align="right"><?php echo number_format($row_CONSULTA['MONTO_PAGADO'],2); ?></td>
        <td align="right"><?php echo number_format($row_CONSULTA['MONTO_ESTIMADO_DISPONIBLE'],2); ?></td>
        <?php if (validador(10,$_SESSION['i'],"edi")==1 && $_SESSION['partidasUser']==1){?><td width="50" align="center" ><?php if($row_CONSULTA['TIPO']==2){ ?>
          <a href="edit%20-%20Copy.php?ID_PARTIDA=<?php echo $row_CONSULTA['ID_PARTIDA']; ?>" title="Editar Partida"><img src="../image/icon_doc.png" width="24" height="24" /></a><?php }?></td><?php } ?>
        <?php if (validador(10,$_SESSION['i'],"eli")==1 && $_SESSION['partidasUser']==1){?><td width="50" align="center" ><a href="#" title="Eliminar Partida" ><img alt="Eliminar Registro"  src="<?php echo $equis ?>" width="24" height="24" <?php echo $funcion; ?>)/></a></td>
      </tr><?php } ?>
      <?php } while ($row_CONSULTA = mysql_fetch_assoc($CONSULTA)); ?>
	      <tr class="menu">
      <td width="50" align="center" bgcolor="#cccccc" class="textos_form"></td>
      <td width="100" align="center" bgcolor="#cccccc" class="textos_form"></td>
      <td align="center" bgcolor="#cccccc" class="textos_form"></td>
      <td width="150" align="right" bgcolor="#cccccc" class="textos_form"><?php echo number_format($MONTO1,2); ?></td>
      <td width="150" align="right" bgcolor="#cccccc" class="textos_form"><?php echo number_format($MONTO2,2); ?></td>
      <td width="150" align="right" bgcolor="#cccccc" class="textos_form"><?php echo number_format($MONTO3,2); ?></td>
      <td colspan="2" align="center" bgcolor="#cccccc">&nbsp;</td>
    </tr>
	  
	  
    <tr>
      <td colspan="8" align="center"><table border="0" cellspacing="10">
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

?>
