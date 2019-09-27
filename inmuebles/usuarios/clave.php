<?php //require_once('../Connections/conexion.php'); ?>
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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	$sql=sprintf("SELECT * FROM usuarios_master where PASSWORD ='" .$_POST['PASSWORD']."' AND ALIAS='".$_POST['ALIAS']."'");
	mysql_select_db($database_conexion, $conexion);
	$Rst = mysql_query($sql, $conexion)or die(mysql_error());
	$totalRows_rst_sql = mysql_num_rows($Rst);
 // echo $totalRows_rst_sql;
		  if ($totalRows_rst_sql > 0)
			  {
				  $updateSQL = sprintf("UPDATE usuarios_master SET PASSWORD= '".$_POST['password1']."' WHERE ID_USUARIO=".$_POST['ID_USUARIO']);
				  //echo $updateSQL;
				  mysql_select_db($database_conexion, $conexion);
				  $Result1 = mysql_query($updateSQL, $conexion)or die(mysql_error());
				  echo aud($_SESSION['i'],'','Cambio la clave de acceso de '.$_POST['ID_USUARIO'],36);
			  }
			  else
			  {
				   echo  aud($_SESSION['i'],"",'Cambio la clave de acceso fallida de '.$_POST['ID_USUARIO'],36);
				  echo '<script language="javascript">alert("El USUARIO o la CLAVE ACTUAL es incorrecta, por favor revise los datos ingresados e intente de nuevo");</script>';
				
			  }}

$colname_rst_usuarios = "-1";
if (isset($_GET['ID_USUARIO'])) {
  $colname_rst_usuarios = $_GET['ID_USUARIO'];
}
mysql_select_db($database_conexion, $conexion);
$query_rst_usuarios = sprintf("SELECT * FROM usuarios_master WHERE ID_USUARIO = ".$_SESSION['i']);
$rst_usuarios = mysql_query($query_rst_usuarios, $conexion) or die(mysql_error());
$row_rst_usuarios = mysql_fetch_assoc($rst_usuarios);
$totalRows_rst_usuarios = mysql_num_rows($rst_usuarios);
?>
<script src="../SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css">
<script src="../SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
  <td align="right" nowrap="nowrap" class="Campos">Nombre:</td>
      <td class="Campos">
        <input name="NOMBRES" type="text" value="<?php echo htmlentities($row_rst_usuarios['NOMBRES'], ENT_COMPAT, ''); ?>" size="32" readonly />
      </td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="Campos">Apellido:</td>
      <td class="Campos">
        <input name="APELLIDOS" type="text" value="<?php echo htmlentities($row_rst_usuarios['APELLIDOS'], ENT_COMPAT, ''); ?>" size="32" readonly />
      </td>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="Campos">Usuario:</td>
      <td class="Campos">
        <input name="ALIAS" type="text" value="<?php echo htmlentities($row_rst_usuarios['ALIAS'], ENT_COMPAT, ''); ?>" size="32" readonly />
      </td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="Campos">Clave Actual:</td>
      <td class="Campos">
        <input type="password" name="PASSWORD"  size="32" />
      </td>
    </tr>
    <td align="right" nowrap="nowrap" class="Campos">Nueva Clave:</td>
      <td align="left" nowrap="nowrap"><label for="password1"></label>
        <span id="sprypassword1">
        <label for="password3"></label>
        <input name="password1" type="password" id="password3" size="32">
      <span class="passwordRequiredMsg">La clave no puede quedar en blanco.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="Campos">Repetir nueva clave</td>
      <td align="left" nowrap="nowrap"><span id="spryconfirm1">
        <label for="repassword"></label>
        <input name="repassword" type="password" id="repassword" size="32">
      <span class="confirmRequiredMsg">La clave no puede quedar en blanco.</span><span class="confirmInvalidMsg">Los datos de la nueva clave y la confirmacion no son iguales.</span></span></td>
    <tr valign="baseline">
      
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap"><input type="submit" class="ui-state-hover"  value="Aceptar" /></td>
    </tr>
    <tr valign="baseline">
      
    </tr>
  </table>
      <br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>

  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="ID_USUARIO" value="<?php echo $row_rst_usuarios['ID_USUARIO']; ?>" />
</form>
<p>&nbsp;</p>
<script type="text/javascript">
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1");
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "password3", {validateOn:["blur", "change"]});
</script>
