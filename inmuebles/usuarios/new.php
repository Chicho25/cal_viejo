<?php

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form_usuario_insertar")) {
  $insertSQL = sprintf("INSERT INTO usuarios_master (ALIAS, PASSWORD, NOMBRES, APELLIDOS, CARGO, NIVEL, ID_ROLE) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString ( $_POST['ALIAS'], "text"),
                       GetSQLValueString ( $_POST['PASSWORD'], "text"),
                       GetSQLValueString(strtoupper ( $_POST['NOMBRES']), "text"),
                       GetSQLValueString(strtoupper ( $_POST['APELLIDOS']), "text"),
                       GetSQLValueString(strtoupper ( $_POST['CARGO']), "text"),
                       GetSQLValueString ( $_POST['NIVEL'], "int"),
					   GetSQLValueString( $_POST['ROLES'], "int"));
					   
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  aud($usua,'','Insertando el Usuario cod. '.mysql_insert_id(),$menu);

  $insertGoTo = "list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
 }
  header(sprintf("Location: %s", $insertGoTo)); 
}

mysql_select_db($database_conexion, $conexion);
$query_rst_roles = "SELECT * FROM usuarios_roles";
$rst_roles = mysql_query($query_rst_roles, $conexion) or die(mysql_error());
$row_rst_roles = mysql_fetch_assoc($rst_roles);
$totalRows_rst_roles = mysql_num_rows($rst_roles);
?>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

<link href="../css/encabezados.css" rel="stylesheet" type="text/css" />

<link href="../js/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />

<link href="../css/SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

<form action="<?php echo $editFormAction; ?>" method="post" name="form_usuario_insertar" id="form_usuario_insertar">
  <table width="990" align="center">
    <tr valign="baseline">
      <td width="445" align="right" nowrap="nowrap" class="Campos">Login:</td>
      <td width="533" align="left" class="Campos">
        <span id="sprytextfield6">
        <input type="text" name="ALIAS" value="" size="32" />
      <span class="textfieldRequiredMsg">Informacion necesaria.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="Campos">Password:</td>
      <td align="left" class="Campos">
        <span id="sprytextfield1">
        <input type="password" name="PASSWORD" value="" size="32" />
      <span class="textfieldRequiredMsg">Informacion necesaria.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="Campos">Nombre:</td>
      <td align="left" class="Campos">
        <span id="sprytextfield2">
        <input type="text" name="NOMBRES" value="" size="32" />
      <span class="textfieldRequiredMsg">Informacion necesaria.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="Campos">Apellido:</td>
      <td align="left" class="Campos">
        <span id="sprytextfield3">
        <input type="text" name="APELLIDOS" value="" size="32" />
      <span class="textfieldRequiredMsg">Informacion necesaria.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="Campos">Cargo:</td>
      <td align="left" class="Campos">
        <input type="text" name="CARGO" value="" size="32" /></td>
    </tr>
        <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="Campos">Rol:</td>
      <td align="left" class="Campos">
        <span id="spryselect1">
        <select name="ROLES" id="ROLES">
          <option value="-1">Seleccione...</option>
          <?php
do {  
?>
          <option value="<?php echo $row_rst_roles['ID_ROLE']?>"><?php echo $row_rst_roles['NOMBRE_ROLE']?></option>
          <?php
} while ($row_rst_roles = mysql_fetch_assoc($rst_roles));
  $rows = mysql_num_rows($rst_roles);
  if($rows > 0) {
      mysql_data_seek($rst_roles, 0);
	  $row_rst_roles = mysql_fetch_assoc($rst_roles);
  }
?>
        </select>
        </span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="Campos">Nivel:</td>
      <td align="left" class="Campos"><span id="spryselect2">
        <select name="NIVEL" id="NIVEL">
          <option value="-1">Seleccione...</option>
          <option value="0">0</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
        </select>
      </span></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" class="Campos"><input type="submit" class="ui-state-hover" value="Aceptar" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form_usuario_insertar" />
</form>
<p>&nbsp;</p>
<script type="text/javascript">
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "none", {validateOn:["blur"]});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur"]});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {invalidValue:"-1", validateOn:["blur"]});
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2", {invalidValue:"-1", validateOn:["blur"]});
</script>
<?php
mysql_free_result($rst_roles);
?>
