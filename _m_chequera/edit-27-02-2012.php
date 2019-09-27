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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE banco_chequeras SET ID_CUENTA_BANCARIA=%s, CHEQUE_INICIO=%s, CHEQUE_FIN=%s, LONGITUD_NUMERO=%s, ULTIMO_CHEQUE=%s, AUTOMATICA=%s, ACTIVA=%s, ANULADA=%s WHERE ID_CHEQUERA=%s",
                       GetSQLValueString($_POST['ID_CUENTA_BANCARIA'], "int"),
                       GetSQLValueString($_POST['CHEQUE_INICIO'], "int"),
                       GetSQLValueString($_POST['CHEQUE_FIN'], "int"),
                       GetSQLValueString($_POST['LONGITUD_NUMERO'], "int"),
                       GetSQLValueString($_POST['ULTIMO_CHEQUE'], "int"),
                       GetSQLValueString(isset($_POST['AUTOMATICA']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['ACTIVA']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['ANULADA']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['ID_CHEQUERA'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
}

$codigo="";
			$nombre="";?>
<?php


mysql_select_db($database_conexion, $conexion);
$query_CONSULTAS = "SELECT * FROM vista_banco_chequeras ORDER BY ID_CHEQUERA ASC";
$CONSULTAS = mysql_query($query_CONSULTAS, $conexion) or die(mysql_error());
$row_CONSULTAS = mysql_fetch_assoc($CONSULTAS);
$totalRows_CONSULTAS = mysql_num_rows($CONSULTAS);

mysql_select_db($database_conexion, $conexion);
$query_CUENTAS_BANCARIAS = "SELECT * FROM vista_banco_cuentas";
$CUENTAS_BANCARIAS = mysql_query($query_CUENTAS_BANCARIAS, $conexion) or die(mysql_error());
$row_CUENTAS_BANCARIAS = mysql_fetch_assoc($CUENTAS_BANCARIAS);
$totalRows_CUENTAS_BANCARIAS = mysql_num_rows($CUENTAS_BANCARIAS);

$colname_EDITAR = "-1";
if (isset($_GET['ID_CHEQUERA'])) {
  $colname_EDITAR = $_GET['ID_CHEQUERA'];
}
mysql_select_db($database_conexion, $conexion);
$query_EDITAR = sprintf("SELECT * FROM banco_chequeras WHERE ID_CHEQUERA = %s", GetSQLValueString($colname_EDITAR, "int"));
$EDITAR = mysql_query($query_EDITAR, $conexion) or die(mysql_error());
$row_EDITAR = mysql_fetch_assoc($EDITAR);
$totalRows_EDITAR = mysql_num_rows($EDITAR);



/*Definiciones*/
$formulario="Banco00-add";
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<title>Untitled Document</title>
<?php include("../include/_js.php"); ?>
<?php include("../include/_css.php"); ?>

<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
<?php $opcion_menu=2; ?>
<?php include("../include/menu.php"); ?>

      <table width="1100" align="center" class="ui-widget-header" >
    <tr>
          <td width="100%" align="center" ><div class="titulo_formulario">Editar Chequera</div>
    </tr>
  </table>
<?php //include("_menu.php"); ?><div class="ui-state-error-text"><center><?php echo $alerta ?></center></div>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form2" id="form2">
  <table width="1100" align="center">
    <tr valign="baseline">
      <td width="502" align="right" nowrap="nowrap" bgcolor="#F3F3F3" class="textos_form_derecha">Cuentas Bancaria:</td>
      <td width="586" bgcolor="#F3F3F3"><select name="ID_CUENTA_BANCARIA">
        <?php
do {  
?>
        <option value="<?php echo $row_CUENTAS_BANCARIAS['ID_CUENTA']?>"<?php if (!(strcmp($row_CUENTAS_BANCARIAS['ID_CUENTA'], $row_EDITAR['ID_CUENTA_BANCARIA']))) {echo "selected=\"selected\"";} ?>><?php echo $row_CUENTAS_BANCARIAS['NOMBRE_PROYECTO']; ?> - <?php echo $row_CUENTAS_BANCARIAS['NOMBRE_BANCO']; ?> - <?php echo $row_CUENTAS_BANCARIAS['NUMERO_CUENTA']?></option>
        <?php
} while ($row_CUENTAS_BANCARIAS = mysql_fetch_assoc($CUENTAS_BANCARIAS));
  $rows = mysql_num_rows($CUENTAS_BANCARIAS);
  if($rows > 0) {
      mysql_data_seek($CUENTAS_BANCARIAS, 0);
	  $row_CUENTAS_BANCARIAS = mysql_fetch_assoc($CUENTAS_BANCARIAS);
  }
?>
      </select><input name="ID_CHEQUERA" type="hidden" id="ID_CHEQUERA" value="<?php echo $row_EDITAR['ID_CHEQUERA']; ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#F3F3F3" class="textos_form_derecha">Cheque inicial:</td>
      <td bgcolor="#F3F3F3"><input type="text" name="CHEQUE_INICIO" value="<?php echo $row_EDITAR['CHEQUE_INICIO']; ?>" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#F3F3F3" class="textos_form_derecha">Cheque Final:</td>
      <td bgcolor="#F3F3F3"><input type="text" name="CHEQUE_FIN" value="<?php echo $row_EDITAR['CHEQUE_FIN']; ?>" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#F3F3F3" class="textos_form_derecha">Cantidad Digitos Numero de Cheque:</td>
      <td bgcolor="#F3F3F3"><input type="text" name="LONGITUD_NUMERO" value="<?php echo $row_EDITAR['LONGITUD_NUMERO']; ?>" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#F3F3F3" class="textos_form_derecha">Ultimo Cheque Emitido:</td>
      <td bgcolor="#F3F3F3"><input type="text" name="ULTIMO_CHEQUE" value="<?php echo $row_EDITAR['ULTIMO_CHEQUE']; ?>" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#F3F3F3" class="textos_form_derecha">Automatica:</td>
      <td bgcolor="#F3F3F3"><input <?php if (!(strcmp($row_EDITAR['AUTOMATICA'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" name="AUTOMATICA" value="1" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#F3F3F3" class="textos_form_derecha">Activa:</td>
      <td bgcolor="#F3F3F3"><input <?php if (!(strcmp($row_EDITAR['ACTIVA'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" name="ACTIVA" value="1" checked="checked" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#F3F3F3" class="textos_form_derecha">Anulada:</td>
      <td bgcolor="#F3F3F3"><input <?php if (!(strcmp($row_EDITAR['ANULADA'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" name="ANULADA" value="1" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#F3F3F3"><input type="submit" class="ui-widget-header" value="Editar Registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form2" />
</form>
<form method="POST" name="form1" id="form1">
      <p>&nbsp;</p>
  <table width="1100" align="center">
    <tr>
      <td align="center" bgcolor="#F3F3F3"  >ID
      <td align="center" bgcolor="#F3F3F3"  >Empresa      
      <td align="center" bgcolor="#F3F3F3"  >Proyecto      
      <td align="center" bgcolor="#F3F3F3"  >Banco      
      <td align="center" bgcolor="#F3F3F3"  >Numero      
      <td align="center" bgcolor="#F3F3F3"  >Movimiento
      <td align="center" bgcolor="#F3F3F3"  >Inicio
      <td align="center" bgcolor="#F3F3F3"  >Fin      
      <td align="center" bgcolor="#F3F3F3"  >		
      <td align="center" bgcolor="#F3F3F3"  >			
    </tr>
          <?php do { ?>
          	<tr>
          		<td align="center" bgcolor="#FFFFFF" ><?php echo $row_CONSULTAS['ID_CHEQUERA']; ?>
	          <td align="center" bgcolor="#FFFFFF" ><?php echo $row_CONSULTAS['NOMBRE_EMPRESA']; ?>                
   		      <td align="center" bgcolor="#FFFFFF" ><?php echo $row_CONSULTAS['NOMBRE_PROYECTO']; ?>                
   		      <td align="center" bgcolor="#FFFFFF" ><?php echo $row_CONSULTAS['NOMBRE_BANCO']; ?>                
   		      <td align="center" bgcolor="#FFFFFF" ><?php echo $row_CONSULTAS['NUMERO_CUENTA']; ?>                
   		      <td align="center" bgcolor="#FFFFFF" ><?php echo $row_CONSULTAS['TIENE_MOVIMIENTOS']; ?>
   		      <td align="center" bgcolor="#FFFFFF" ><?php echo $row_CONSULTAS['CHEQUE_INICIO']; ?>
	          <td align="center" bgcolor="#FFFFFF" ><?php echo $row_CONSULTAS['CHEQUE_FIN']; ?>              
	          <td align="left" bgcolor="#FFFFFF" ><a href="edit.php?ID_CHEQUERA=<?php echo $row_CONSULTAS['ID_CHEQUERA']; ?>"><img src="../img/write.png" width="24" height="24" /></a>				
   		  <td align="left" bgcolor="#FFFFFF" ><img src="../image/Delete-iconbw.png" width="24" height="24" />				          	</tr>
          	<?php } while ($row_CONSULTAS = mysql_fetch_assoc($CONSULTAS)); ?>
  </table>
</form>
<p>&nbsp;</p>
<?php include("../include/_foot.php"); ?>

<p>&nbsp;</p>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
</script>
</body>
</html>
<?php
mysql_free_result($VERIFICA);

mysql_free_result($CONSULTAS);

mysql_free_result($CUENTAS_BANCARIAS);

mysql_free_result($EDITAR);




?>
