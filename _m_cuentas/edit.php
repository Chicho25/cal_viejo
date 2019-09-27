<?php
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "editar")) {
  $updateSQL = sprintf("UPDATE banco_cuentas SET NUMERO_CUENTA=%s, DESCRIPCION_CUENTA=%s, ID_BANCO_MASTER=%s, CODIGO_EMPRESA=%s, PREDETERMINADA=%s WHERE ID_CUENTA_BANCARIA=%s",
                       GetSQLValueString($_POST['NUMERO_CUENTA'], "text"),
                       GetSQLValueString(strtoupper($_POST['DESCRIPCION_CUENTA']), "text"),
                       GetSQLValueString($_POST['ID_BANCO_MASTER'], "int"),
                       GetSQLValueString($_POST['CODIGO_EMPRESA'], "text"),
					   GetSQLValueString(isset($_POST['PREDETERMINADA']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['ID_CUENTA_BANCARIA'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
   $ids=$_POST['ID_CUENTA_BANCARIA'];
  aud($_SESSION['i'],$ids,'Modifico registro con el id',$_GET['id_menu']);
?>
 <script type="text/javascript"> 
alert("Los cambios se realizaron con exito...");

window.location = "index.php?titulo_formulario=<?php echo $_GET['titulo_formulario'] ?>&id_menu=<?php echo $_GET['id_menu'] ?>"
</script>
<?php 
}
 

$colname_rst_cuentas = "-1";
if (isset($_GET['ID_CUENTA_BANCARIA'])) {
  $colname_rst_cuentas = $_GET['ID_CUENTA_BANCARIA'];
}
mysql_select_db($database_conexion, $conexion);
$query_rst_cuentas = sprintf("SELECT * FROM banco_cuentas WHERE ID_CUENTA_BANCARIA = %s", GetSQLValueString($colname_rst_cuentas, "int"));
$rst_cuentas = mysql_query($query_rst_cuentas, $conexion) or die(mysql_error());
$row_rst_cuentas = mysql_fetch_assoc($rst_cuentas);
$totalRows_rst_cuentas = mysql_num_rows($rst_cuentas);

mysql_select_db($database_conexion, $conexion);
$query_rst_bancos = "SELECT ID_BANCO_MASTER, NOMBRE FROM banco_master";
$rst_bancos = mysql_query($query_rst_bancos, $conexion) or die(mysql_error());
$row_rst_bancos = mysql_fetch_assoc($rst_bancos);
$totalRows_rst_bancos = mysql_num_rows($rst_bancos);

mysql_select_db($database_conexion, $conexion);
$query_rst_empresas = "SELECT CODIGO_EMPRESAS_MASTER, NOMBRE FROM empresas_master";
$rst_empresas = mysql_query($query_rst_empresas, $conexion) or die(mysql_error());
$row_rst_empresas = mysql_fetch_assoc($rst_empresas);
$totalRows_rst_empresas = mysql_num_rows($rst_empresas);
?>

<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">


<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<form action="<?php echo $editFormAction; ?>" method="post" name="editar" id="editar">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Numero de Cuenta:</td>
      <td><span id="sprytextfield2">
        <label for="NUMERO_CUENTA"></label>
        <input name="NUMERO_CUENTA" type="text" id="NUMERO_CUENTA" value="<?php echo htmlentities ($row_rst_cuentas['NUMERO_CUENTA']); ?>">
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Descripci&oacute;n de la Cuenta:</td>
      <td><span id="sprytextfield1">
        <label for="DESCRIPCION_CUENTA"></label>
        <input name="DESCRIPCION_CUENTA" type="text" id="DESCRIPCION_CUENTA" value="<?php echo htmlentities ($row_rst_cuentas['DESCRIPCION_CUENTA']); ?>">
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Banco:</td>
      <td><span id="spryselect1">
        <label for="ID_BANCO_MASTER"></label>
        <select name="ID_BANCO_MASTER" id="ID_BANCO_MASTER">
          <?php
do {  
?>
          <option value="<?php echo $row_rst_bancos['ID_BANCO_MASTER']?>"<?php if (!(strcmp($row_rst_bancos['ID_BANCO_MASTER'], $row_rst_cuentas['ID_BANCO_MASTER']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rst_bancos['NOMBRE']?></option>
          <?php
} while ($row_rst_bancos = mysql_fetch_assoc($rst_bancos));
  $rows = mysql_num_rows($rst_bancos);
  if($rows > 0) {
      mysql_data_seek($rst_bancos, 0);
	  $row_rst_bancos = mysql_fetch_assoc($rst_bancos);
  }
?>
        </select>
        <span class="selectInvalidMsg">Please select a valid item.</span><span class="selectRequiredMsg">Please select an item.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Empresa:</td>
      <td><span id="spryselect2">
        <label for="CODIGO_EMPRESA"></label>
        <select name="CODIGO_EMPRESA" id="CODIGO_EMPRESA">
          <?php
do {  
?>
          <option value="<?php echo $row_rst_empresas['CODIGO_EMPRESAS_MASTER']?>"<?php if (!(strcmp($row_rst_empresas['CODIGO_EMPRESAS_MASTER'], $row_rst_cuentas['CODIGO_EMPRESA']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rst_empresas['NOMBRE']?></option>
          <?php
} while ($row_rst_empresas = mysql_fetch_assoc($rst_empresas));
  $rows = mysql_num_rows($rst_empresas);
  if($rows > 0) {
      mysql_data_seek($rst_empresas, 0);
	  $row_rst_empresas = mysql_fetch_assoc($rst_empresas);
  }
?>
        </select>
        <span class="selectInvalidMsg">Please select a valid item.</span><span class="selectRequiredMsg">Please select an item.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td a align="right" nowrap>Predeterminada</td>
      <td align="left" nowrap><input <?php if (!(strcmp($row_rst_cuentas['PREDETERMINADA'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" name="PREDETERMINADA" id="PREDETERMINADA" />
      <label for="PREDETERMINADA"></label></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap><input type="submit" class="ui-state-hover" value="Aceptar"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="editar" />
  <input type="hidden" name="ID_CUENTA_BANCARIA" value="<?php echo htmlentities ($row_rst_cuentas['ID_CUENTA_BANCARIA']); ?>" />
</form>
<p>&nbsp;</p>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {invalidValue:"-1", validateOn:["blur", "change"]});
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2", {invalidValue:"-1", validateOn:["blur", "change"]});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur", "change"]});
</script>
<?php
mysql_free_result($rst_bancos);

mysql_free_result($rst_empresas);
mysql_free_result($rst_cuentas);
?>
