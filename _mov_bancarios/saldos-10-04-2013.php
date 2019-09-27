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

mysql_select_db($database_conexion, $conexion);
$query_CUENTAS = "SELECT NOMBRE_PROYECTO, NOMBRE_BANCO, NUMERO_CUENTA, SUM(DEBITO) as TOTAL_DEBITO, SUM(CREDITO) AS TOTAL_CREDITO  FROM vista_banco_movimientos WHERE AFECTA_BANCO=1 GROUP BY NUMERO_CUENTA ";
$CUENTAS = mysql_query($query_CUENTAS, $conexion) or die(mysql_error());
$row_CUENTAS = mysql_fetch_assoc($CUENTAS);
$totalRows_CUENTAS = mysql_num_rows($CUENTAS);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html" />
<title>Untitled Document</title>
<?php include("../include/_js.php"); ?>
<?php include("../include/_css.php"); ?>
	<style>
	.ui-button { margin-left: -1px; }
	.ui-button-icon-only .ui-button-text { padding: 0.35em; } 
	.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; width:690px; font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bolder }
	</style>
<!--Autocompletar--->
<style>
#project-label {
	display: block;
	font-weight: bold;
	margin-bottom: 1em;
}
#project-icon {
	float: left;
	height: 32px;
	width: 32px;
}
#project-description {
	margin: 0;
	padding: 0;
	color:#F00;
}
body, td, th {
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
}

</style>
	
	
<?php 
$visivilidad="none";
?>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/menu_style.css" type="text/css" media="all" />
</head>

<body>
<?php $opcion_menu=2; ?>
<?php include("../include/menu.php"); ?>

<table width="1100" align="center" class="ui-widget-header" >
	<tr>
		<td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Saldos Cuentas Bancarias</div>
	</tr>
</table><form action="listado.php" method="get">
<table width="1100" border="0" align="center" cellpadding="4" cellspacing="2" class="textos_form">
	<tr class="textos_form">
	  <td align="center" bgcolor="#F0F0F0" class="textos_form">Cuenta</td>
	  <td width="150" align="center" bgcolor="#F0F0F0">Debito</td>
	  <td width="150" align="center" bgcolor="#F0F0F0">Credito</td>
	  <td width="150" align="center" bgcolor="#F0F0F0">Saldo</td>
    </tr>
    	<?php do { ?><tr>
	      
          <td align="left" bgcolor="#ffffff" class="textos_form"><?php echo $row_CUENTAS['NOMBRE_PROYECTO']; ?> - <?php echo $row_CUENTAS['NOMBRE_BANCO']; ?> - <?php echo $row_CUENTAS['NUMERO_CUENTA']; ?></td>
	        <td bgcolor="#ffffff" class="textos_form_derecha"><?php echo number_format($row_CUENTAS['TOTAL_DEBITO'],2); ?></td>
	        <td bgcolor="#ffffff" class="textos_form_derecha"><?php echo number_format($row_CUENTAS['TOTAL_CREDITO'],2); ?></td>
	        <td bgcolor="#FFFFFF" class="textos_form_derecha" style="color:<?php if (($row_CUENTAS['TOTAL_CREDITO']-$row_CUENTAS['TOTAL_DEBITO'])>0){ ?>#000000<?php }else{?>#FF0000<?php }?>"><?php echo number_format($row_CUENTAS['TOTAL_CREDITO']-$row_CUENTAS['TOTAL_DEBITO'],2); ?></td>
	        
    </tr><?php } while ($row_CUENTAS = mysql_fetch_assoc($CUENTAS)); ?>
	<tr>
		<td colspan="4" align="center" bgcolor="#F0F0F0" class="textos_form">Nota: Este reporte solo muestra las cuentas con algun movimiento bancario.</td>
	</tr>
</table>
</form>



</body>
</html>
<?php

mysql_free_result($CUENTAS);


?>
