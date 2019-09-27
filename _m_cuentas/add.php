<?php
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "incluir")) {
  $insertSQL = sprintf("INSERT INTO banco_cuentas (NUMERO_CUENTA, DESCRIPCION_CUENTA, ID_BANCO_MASTER, CODIGO_EMPRESA, PREDETERMINADA) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['NUMERO_CUENTA'], "text"),
                       GetSQLValueString(strtoupper($_POST['DESCRIPCION_CUENTA']), "text"),
                       GetSQLValueString($_POST['ID_BANCO_MASTER'], "int"),			  
                       GetSQLValueString($_POST['CODIGO_EMPRESA'], "text"),
					   GetSQLValueString(isset($_POST['PREDETERMINADA']) ? "true" : "", "defined","1","0"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
 $ids=mysql_insert_id();   
   aud($_SESSION['i'],$ids,'Creo registro con el id',$_GET['id_menu']);
?>
 <script type="text/javascript">
alert("Los cambios se realizaron con exito...");

window.location = "index.php?titulo_formulario=<?php echo $_GET['titulo_formulario'] ?>&id_menu=<?php echo $_GET['id_menu'] ?>"
</script>
<?php 
}
mysql_select_db($database_conexion, $conexion);
$query_rst_bancos = "SELECT * FROM banco_master";
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

<form method="post" name="incluir" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Numero de Cuenta:</td>
      <td><span id="sprytextfield2">
        <label for="NUMERO_CUENTA"></label>
        <input type="text" name="NUMERO_CUENTA" id="NUMERO_CUENTA">
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Descripci&oacute;n de la Cuenta:</td>
      <td><span id="sprytextfield1">
        <label for="DESCRIPCION_CUENTA"></label>
        <input type="text" name="DESCRIPCION_CUENTA" id="DESCRIPCION_CUENTA">
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
          <option value="<?php echo $row_rst_bancos['ID_BANCO_MASTER']?>"><?php echo $row_rst_bancos['NOMBRE']?></option>
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
          <option value="<?php echo $row_rst_empresas['CODIGO_EMPRESAS_MASTER']?>"><?php echo $row_rst_empresas['NOMBRE']?></option>
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
      <td align="left" nowrap><input type="checkbox" name="PREDETERMINADA" id="PREDETERMINADA" />
      <label for="PREDETERMINADA"></label></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap><input type="submit" class="ui-state-hover" value="Aceptar"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="incluir">
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
?>
