<?php
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE usuarios_master SET `ALIAS`=%s, PASSWORD=%s, NOMBRES=%s, APELLIDOS=%s, CARGO=%s, NIVEL=%s, ID_ROLE=%s, ACTIVO=%s WHERE ID_USUARIO=%s",
                       GetSQLValueString($_POST['ALIAS'], "text"),
                       GetSQLValueString($_POST['PASSWORD'], "text"),
                       GetSQLValueString(strtoupper ( $_POST['NOMBRES']), "text"),
                       GetSQLValueString(strtoupper ( $_POST['APELLIDOS']), "text"),
                       GetSQLValueString(strtoupper ( $_POST['CARGO']), "text"),
                       GetSQLValueString($_POST['NIVEL'], "int"),
                       GetSQLValueString($_POST['ID_ROLE'], "int"),
                       GetSQLValueString($_POST['ACTIVO'], "int"),
                       GetSQLValueString($_POST['ID_USUARIO'], "int"));
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());

  $ids=$_POST['ID_USUARIO'];
  aud($_SESSION['i'],$ids,'Modifico registro con el id',$menu);
?>
 <script type="text/javascript">
alert("Los cambios se realizaron con exito...");

window.location = "list.php?titulo_formulario=<?php echo $_GET['titulo_formulario'] ?>"
</script>
<?php 
}
 
$colname_rst_edit_usuarios = "-1";
if (isset($_GET['ID_USUARIO'])) {
  $colname_rst_edit_usuarios = $_GET['ID_USUARIO'];
}
mysql_select_db($database_conexion, $conexion);
$query_rst_edit_usuarios = sprintf("SELECT 
  usuarios_master.ID_USUARIO,
  usuarios_master.ALIAS,
  usuarios_master.PASSWORD,
  usuarios_master.NOMBRES,
  usuarios_master.APELLIDOS,
  usuarios_master.CARGO,
  usuarios_master.NIVEL,
  usuarios_master.ID_ROLE,
  usuarios_master.ACTIVO,
  usuarios_roles.NOMBRE_ROLE
FROM
  usuarios_roles
  INNER JOIN usuarios_master ON (usuarios_roles.ID_ROLE = usuarios_master.ID_ROLE) WHERE ID_USUARIO = %s", GetSQLValueString($colname_rst_edit_usuarios, "int"));
$rst_edit_usuarios = mysql_query($query_rst_edit_usuarios, $conexion) or die(mysql_error());
$row_rst_edit_usuarios = mysql_fetch_assoc($rst_edit_usuarios);
$totalRows_rst_edit_usuarios = mysql_num_rows($rst_edit_usuarios);

mysql_select_db($database_conexion, $conexion);
$query_rst_role = "SELECT * FROM usuarios_roles";
$rst_role = mysql_query($query_rst_role, $conexion) or die(mysql_error());
$row_rst_role = mysql_fetch_assoc($rst_role);
$totalRows_rst_role = mysql_num_rows($rst_role);
?>
<link href="../js/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />


<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="990" align="center">
    <tr valign="baseline">
      <td width="445" align="right" nowrap="nowrap" class="Campos">Usuario:</td>
      <td width="533" class="Campos"><span id="sprytextfield1">
        <input type="text" name="ALIAS" value="<?php echo htmlentities($row_rst_edit_usuarios['ALIAS'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      <span class="textfieldRequiredMsg">Informacion necesaria.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="Campos">Password:</td>
      <td width="533" class="Campos"><span id="sprytextfield2">
        <input type="password" name="PASSWORD" value="<?php echo htmlentities($row_rst_edit_usuarios['PASSWORD'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      <span class="textfieldRequiredMsg">Informacion necesaria.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="Campos">Nombre:</td>
      <td width="533" class="Campos"><span id="sprytextfield3">
        <input type="text" name="NOMBRES" value="<?php echo htmlentities($row_rst_edit_usuarios['NOMBRES'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      <span class="textfieldRequiredMsg">Informacion necesaria.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="Campos">Apellido:</td>
      <td width="533" class="Campos"><span id="sprytextfield4">
        <input type="text" name="APELLIDOS" value="<?php echo htmlentities($row_rst_edit_usuarios['APELLIDOS'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      <span class="textfieldRequiredMsg">Informacion necesaria.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="Campos">Cargo:</td>
      <td width="533" class="Campos">
        <input type="text" name="CARGO" value="<?php echo htmlentities($row_rst_edit_usuarios['CARGO'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      </td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="Campos">Nivel:</td>
      <td width="533" class="Campos"><span id="sprytextfield5">
      <input type="text" name="NIVEL" value="<?php echo htmlentities($row_rst_edit_usuarios['NIVEL'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      <span class="textfieldRequiredMsg">Formato Invalido.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="Campos">Rol:</td>
      <td width="533" class="Campos"><label for="ID_ROLE"></label>
        <span id="spryselect1">
        <select name="ID_ROLE" id="ID_ROLE">
          <?php
do {  
?>
          <option value="<?php echo $row_rst_role['ID_ROLE']?>"<?php if (!(strcmp($row_rst_role['ID_ROLE'], $row_rst_edit_usuarios['ID_ROLE']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rst_role['NOMBRE_ROLE']?></option>
          <?php
} while ($row_rst_role = mysql_fetch_assoc($rst_role));
  $rows = mysql_num_rows($rst_role);
  if($rows > 0) {
      mysql_data_seek($rst_role, 0);
	  $row_rst_role = mysql_fetch_assoc($rst_role);
  }
?>
        </select>
      <span class="selectInvalidMsg">Please select a valid item.</span><span class="selectRequiredMsg">Seleccione un rol para este usuario.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="Campos">Activo:</td>
      <td width="533" class="Campos"><label for="ACTIVO"></label>
        <select name="ACTIVO" id="ACTIVO">
          <option value="1" <?php if (!(strcmp(1, $row_rst_edit_usuarios['ACTIVO']))) {echo "selected=\"selected\"";} ?>>ACTIVO</option>
          <option value="0" <?php if (!(strcmp(0, $row_rst_edit_usuarios['ACTIVO']))) {echo "selected=\"selected\"";} ?>>INACTIVO</option>
        </select>
      <label for="ID_ROLE2"></label></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap"><input name="hiddenField" type="hidden" id="hiddenField" value="<?php echo $_GET['titulo_formulario']; ?>" />        <input type="submit" class="ui-state-hover" value="Aceptar" /></td>
    </tr>
  </table>
  <input type="hidden" name="ID_USUARIO" value="<?php echo htmlentities($row_rst_edit_usuarios['ID_USUARIO'], ENT_COMPAT, 'utf-8'); ?>" />
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="ID_USUARIO" value="<?php echo $row_rst_edit_usuarios['ID_USUARIO']; ?>" />
</form>
<p>&nbsp;</p>
<?php
mysql_free_result($rst_edit_usuarios);

mysql_free_result($rst_role);
?>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "integer", {validateOn:["blur"]});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {invalidValue:"-1", validateOn:["blur"]});
</script>
