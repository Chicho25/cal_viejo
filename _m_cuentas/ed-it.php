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
  $updateSQL = sprintf("UPDATE banco_cuentas SET NUMERO_CUENTA=%s, DESCRIPCION_CUENTA=%s, ID_BANCO_MASTER=%s, CODIGO_EMPRESA=%s WHERE ID_CUENTA_BANCARIA=%s",
                       GetSQLValueString($_POST['NUMERO_CUENTA'], "text"),
                       GetSQLValueString($_POST['DESCRIPCION_CUENTA'], "text"),
                       GetSQLValueString($_POST['ID_BANCO_MASTER'], "int"),
                       GetSQLValueString($_POST['CODIGO_EMPRESA'], "text"),
                       GetSQLValueString($_POST['ID_CUENTA_BANCARIA'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
}

$codigo="";
			$nombre="";?>
<?php


mysql_select_db($database_conexion, $conexion);
$query_CONSULTAS = "SELECT * FROM vista_banco_cuentas";
$CONSULTAS = mysql_query($query_CONSULTAS, $conexion) or die(mysql_error());
$row_CONSULTAS = mysql_fetch_assoc($CONSULTAS);
$totalRows_CONSULTAS = mysql_num_rows($CONSULTAS);

mysql_select_db($database_conexion, $conexion);
$query_BANCOS = "SELECT * FROM banco_master ORDER BY NOMBRE ASC";
$BANCOS = mysql_query($query_BANCOS, $conexion) or die(mysql_error());
$row_BANCOS = mysql_fetch_assoc($BANCOS);
$totalRows_BANCOS = mysql_num_rows($BANCOS);

mysql_select_db($database_conexion, $conexion);
$query_EMPRESAS = "SELECT * FROM empresas_master ORDER BY NOMBRE ASC";
$EMPRESAS = mysql_query($query_EMPRESAS, $conexion) or die(mysql_error());
$row_EMPRESAS = mysql_fetch_assoc($EMPRESAS);
$totalRows_EMPRESAS = mysql_num_rows($EMPRESAS);

$colname_EDITAR = "-1";
if (isset($_GET['ID_CUENTA_BANCARIA'])) {
  $colname_EDITAR = $_GET['ID_CUENTA_BANCARIA'];
}
mysql_select_db($database_conexion, $conexion);
$query_EDITAR = sprintf("SELECT * FROM banco_cuentas WHERE ID_CUENTA_BANCARIA = %s", GetSQLValueString($colname_EDITAR, "int"));
$EDITAR = mysql_query($query_EDITAR, $conexion) or die(mysql_error());
$row_EDITAR = mysql_fetch_assoc($EDITAR);
$totalRows_EDITAR = mysql_num_rows($EDITAR);



/*Definiciones*/
$formulario="Cuentas00-add";
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
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
          <td width="100%" align="center" ><div class="titulo_formulario">Editar Cuenta</div>
    </tr>
  </table>
<?php //include("_menu.php"); ?><div class="ui-state-error-text"><center></center></div>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form2" id="form2">
  <table width="1100" align="center">
    <tr valign="baseline">
      <td width="543" align="right" nowrap="nowrap" bgcolor="#F3F3F3" class="textos_form_derecha">Numero Cuenta:</td>
      <td width="545" bgcolor="#F3F3F3"><span id="sprytextfield1">
        <input type="text" name="NUMERO_CUENTA" value="<?php echo $row_EDITAR['NUMERO_CUENTA']; ?>" size="32" />
      <span class="textfieldRequiredMsg">Requerido</span></span>        <input name="ID_CUENTA_BANCARIA" type="hidden" id="ID_CUENTA_BANCARIA" value="<?php echo $row_EDITAR['ID_CUENTA_BANCARIA']; ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#F3F3F3" class="textos_form_derecha">Descripcion:</td>
      <td bgcolor="#F3F3F3"><span id="sprytextfield2">
        <input type="text" name="DESCRIPCION_CUENTA" value="<?php echo $row_EDITAR['DESCRIPCION_CUENTA']; ?>" size="32" />
      <span class="textfieldRequiredMsg">Requerido</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#F3F3F3" class="textos_form_derecha">Banco:</td>
      <td bgcolor="#F3F3F3"><select name="ID_BANCO_MASTER">
        <?php
do {  
?>
        <option value="<?php echo $row_BANCOS['ID_BANCO_MASTER']?>"<?php if (!(strcmp($row_BANCOS['ID_BANCO_MASTER'], $row_EDITAR['ID_BANCO_MASTER']))) {echo "selected=\"selected\"";} ?>><?php echo $row_BANCOS['NOMBRE']?></option>
        <?php
} while ($row_BANCOS = mysql_fetch_assoc($BANCOS));
  $rows = mysql_num_rows($BANCOS);
  if($rows > 0) {
      mysql_data_seek($BANCOS, 0);
	  $row_BANCOS = mysql_fetch_assoc($BANCOS);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#F3F3F3" class="textos_form_derecha">Codigo Empresa:</td>
      <td bgcolor="#F3F3F3"><select name="CODIGO_EMPRESA">
        <?php
do {  
?>
        <option value="<?php echo $row_EMPRESAS['CODIGO_EMPRESAS_MASTER']?>"<?php if (!(strcmp($row_EMPRESAS['CODIGO_EMPRESAS_MASTER'], $row_EDITAR['CODIGO_EMPRESA']))) {echo "selected=\"selected\"";} ?>><?php echo $row_EMPRESAS['NOMBRE']?></option>
        <?php
} while ($row_EMPRESAS = mysql_fetch_assoc($EMPRESAS));
  $rows = mysql_num_rows($EMPRESAS);
  if($rows > 0) {
      mysql_data_seek($EMPRESAS, 0);
	  $row_EMPRESAS = mysql_fetch_assoc($EMPRESAS);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#999999"><input type="submit" class="ui-widget-header" value="Guardar" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form2" />
</form>
<form method="POST" name="form1" id="form1">

      <p><br />
        
      </p>
  <table width="1100" align="center">
    <tr>
      <td align="center" bgcolor="#F3F3F3"  >ID
      <td align="center" bgcolor="#F3F3F3"  >Empresa      
      <td align="center" bgcolor="#F3F3F3"  >Proyecto      
      <td align="center" bgcolor="#F3F3F3"  >Banco      
      <td align="center" bgcolor="#F3F3F3"  >Numero      
      <td align="center" bgcolor="#F3F3F3"  >Descripcion      
      <td align="center" bgcolor="#F3F3F3"  >		
          <td align="center" bgcolor="#F3F3F3"  >			
          </tr>
          <?php do { ?>
          	<tr>
          		<td align="center" bgcolor="#FFFFFF" ><?php echo $row_CONSULTAS['ID_CUENTA']; ?>
	          <td align="left" bgcolor="#FFFFFF" ><?php echo $row_CONSULTAS['NOMBRE_EMPRESA']; ?>
	          <td align="left" bgcolor="#FFFFFF" ><?php echo $row_CONSULTAS['NOMBRE_PROYECTO']; ?>              
	          <td align="left" bgcolor="#FFFFFF" ><?php echo $row_CONSULTAS['NOMBRE_BANCO']; ?>              
	          <td align="left" bgcolor="#FFFFFF" ><?php echo $row_CONSULTAS['NUMERO_CUENTA']; ?>              
	          <td align="left" bgcolor="#FFFFFF" ><?php echo $row_CONSULTAS['DESCRIPCION_CUENTA']; ?>              
	          <td align="left" bgcolor="#FFFFFF" ><a href="edit.php?ID_CUENTA_BANCARIA=<?php echo $row_CONSULTAS['ID_CUENTA']; ?>"><img src="../img/write.png" width="24" height="24" /></a>				
   		  <td align="left" bgcolor="#FFFFFF" ><img src="../image/Delete-iconbw.png" width="24" height="24" />				          	</tr>
          	<?php } while ($row_CONSULTAS = mysql_fetch_assoc($CONSULTAS)); ?>
	</table>
</form>
<p>&nbsp;</p>

<p>&nbsp;</p>
<?php include("../include/_foot.php"); ?>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
</body>
</html>
<?php


mysql_free_result($CONSULTAS);

mysql_free_result($BANCOS);

mysql_free_result($EMPRESAS);

mysql_free_result($EDITAR);




?>
