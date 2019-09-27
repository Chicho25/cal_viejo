<?php require_once('../Connections/conexion.php'); 
mysql_select_db($database_conexion, $conexion);
$query_rst_nacionalidad = "SELECT * FROM terceros_nacionalidad";
$rst_nacionalidad = mysql_query($query_rst_nacionalidad, $conexion) or die(mysql_error());
$row_rst_nacionalidad = mysql_fetch_assoc($rst_nacionalidad);
$totalRows_rst_nacionalidad = mysql_num_rows($rst_nacionalidad);

mysql_select_db($database_conexion, $conexion);
$query_rst_relacion_laborar = "SELECT * FROM terceros_relacion_laborar";
$rst_relacion_laborar = mysql_query($query_rst_relacion_laborar, $conexion) or die(mysql_error());
$row_rst_relacion_laborar = mysql_fetch_assoc($rst_relacion_laborar);
$totalRows_rst_relacion_laborar = mysql_num_rows($rst_relacion_laborar);

mysql_select_db($database_conexion, $conexion);
$query_rst_edo_civil = "SELECT * FROM terceros_estado_civil";
$rst_edo_civil = mysql_query($query_rst_edo_civil, $conexion) or die(mysql_error());
$row_rst_edo_civil = mysql_fetch_assoc($rst_edo_civil);
$totalRows_rst_edo_civil = mysql_num_rows($rst_edo_civil);
 
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE pro_cli_master SET CODIGO=%s, TIPO=%s, RESIDENCIADO=%s, NOMBRE=%s, ID_NACIONALIDAD=%s, PROFESION=%s, ID_RELACION_LABORAR=%s, ID_ESTADO_CIVIL=%s, CONTACTO=%s, ID_PRO_CLI_GRUPO=%s, ID_TRIBUTARIA_CEDULA=%s, DIRECCION=%s, TELEFONO_FIJO_1=%s, TELEFONO_FIJO_2=%s, TELEFONO_MOVIL_1=%s, TELEFONO_MOVIL_2=%s, EMAIL_1=%s, EMAIL_2=%s, WEB_SITE=%s, OBSERVACIONES=%s WHERE ID_PRO_CLI_MASTER=%s",
                       GetSQLValueString($_POST['CEDULA'], "text"),
                       GetSQLValueString($_POST['TIPO'], "int"),
                       GetSQLValueString($_POST['RESIDENCIADO'], "int"),
                       GetSQLValueString($_POST['NOMBRE'], "text"),
                       GetSQLValueString($_POST['ID_NACIONALIDAD'], "int"),
                       GetSQLValueString($_POST['PROFESION'], "text"),
                       GetSQLValueString($_POST['ID_RELACION_LABORAR'], "int"),
                       GetSQLValueString($_POST['ID_ESTADO_CIVIL'], "int"),
                       GetSQLValueString($_POST['CONTACTO'], "text"),
                       GetSQLValueString($_POST['ID_PRO_CLI_GRUPO'], "int"),
                       GetSQLValueString($_POST['ID_TRIBUTARIA_CEDULA'], "text"),
                       GetSQLValueString($_POST['DIRECCION'], "text"),
                       GetSQLValueString($_POST['TELEFONO_FIJO_1'], "text"),
                       GetSQLValueString($_POST['TELEFONO_FIJO_2'], "text"),
                       GetSQLValueString($_POST['TELEFONO_MOVIL_1'], "text"),
                       GetSQLValueString($_POST['TELEFONO_MOVIL_2'], "text"),
                       GetSQLValueString($_POST['EMAIL_1'], "text"),
                       GetSQLValueString($_POST['EMAIL_2'], "text"),
                       GetSQLValueString($_POST['WEB_SITE'], "text"),
                       GetSQLValueString($_POST['OBSERVACIONES'], "text"),
                       GetSQLValueString($_POST['ID_PRO_CLI_MASTER'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());


  
 aud($usua,$_POST['ID_PRO_CLI_MASTER'],'Editando el cliente ID. '.$_POST['ID_PRO_CLI_MASTER'],$menu);
 

errores(mysql_errno($conexion),"list.php",$usua,$_POST['ID_PRO_CLI_MASTER'],'Editando el cliente ID. '.$_POST['ID_PRO_CLI_MASTER'],$menu);
?>

<script type="text/javascript">
alert("Se edito con exito");
window.location = "list.php?titulo_formulario=Clientes"
</script>
<?php
  $updateGoTo = "list.php?titulo_formulario=Clientes";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  //@header(sprintf("Location: %s", $updateGoTo));
}

$colname_rst_edit_cliente = "-1";
if (isset($_GET['ID_PRO_CLI_MASTER'])) {
  $colname_rst_edit_cliente = $_GET['ID_PRO_CLI_MASTER'];
}
mysql_select_db($database_conexion, $conexion);
$query_rst_edit_cliente = sprintf("SELECT * FROM pro_cli_master WHERE ID_PRO_CLI_MASTER = %s", GetSQLValueString($colname_rst_edit_cliente, "int"));
$rst_edit_cliente = mysql_query($query_rst_edit_cliente, $conexion) or die(mysql_error());
$row_rst_edit_cliente = mysql_fetch_assoc($rst_edit_cliente);
$totalRows_rst_edit_cliente = mysql_num_rows($rst_edit_cliente);

$colname_rst_tipos = "-1";
if (isset($_GET['TIPO'])) {
  $colname_rst_tipos = $_GET['TIPO'];
}
mysql_select_db($database_conexion, $conexion);
$query_rst_tipos = sprintf("SELECT COD_TIPO, TIPO FROM vista_pro_cli WHERE COD_TIPO = %s", GetSQLValueString($colname_rst_tipos, "int"));
$rst_tipos = mysql_query($query_rst_tipos, $conexion) or die(mysql_error());
$row_rst_tipos = mysql_fetch_assoc($rst_tipos);
$totalRows_rst_tipos = mysql_num_rows($rst_tipos);
?>
<link href="../css/encabezados.css" rel="stylesheet" type="text/css" />


<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>

<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

 <script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script type="css"> 

</script>
<link href="../css/encabezados.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
   <table width="990" align="center">
          <td align="right" nowrap="nowrap" class="Campos">Tipo:</td>
      <td class="Campos">        <span class="Campos">
        <select name="TIPO" id="TIPO2" title="Tipo de clientes">
          <option value="2">CLIENTE</option>
          <option value="3">CLIENTE - PROVEEDOR</option>
        </select>
      </span></td>
      <td align="right" class="Campos">Residenciado:</td>
      <td class="Campos"><select name="RESIDENCIADO" id="RESIDENCIADO"  title="Si tiene una residencia permanente o no en el pais">
        <option value="1" <?php if (!(strcmp(1, $row_rst_edit_cliente['RESIDENCIADO']))) {echo "selected=\"selected\"";} ?>>SI</option>
        <option value="0" <?php if (!(strcmp(0, $row_rst_edit_cliente['RESIDENCIADO']))) {echo "selected=\"selected\"";} ?>>NO</option>
      </select></td>
      <td align="right" class="Campos">&nbsp;</td>
      <td class="Campos"><label for="fecha_residencia"></label></td>
    <tr align="right">
      <td width="132" nowrap="nowrap" class="Campos">Nombre:</td>
      <td colspan="3" align="left" class="Campos"><span id="sprytextfield_nombre">
        <input name="NOMBRE" type="text" value="<?php echo $row_rst_edit_cliente['NOMBRE']; ?>" size="85" title="Nombre de el cliente o de la empresa quien adquiere el inmueble"/>
      <span class="textfieldRequiredMsg">Informaci&oacute;n necesaria.</span></span></td>
      <td width="147" class="Campos">C&eacute;dula:</td>
      <td width="193" align="left" class="Campos"><span id="sprytextfield_cedula">
        <input name="CEDULA" type="text" id="CEDULA" title="Cedula de identidad en caso de ser personal" value="<?php echo $row_rst_edit_cliente['CODIGO']; ?>"/>
      <span class="textfieldRequiredMsg">Informaci&oacute;n necesaria.</span></span></td>
    </tr>
    <tr>
      <td align="right" nowrap="nowrap" class="Campos">RUC o Pasaporte:</td>
      <td width="181" class="Campos"><span id="sprytextfield_pasaporte">
        <input type="text" name="ID_TRIBUTARIA_CEDULA" value="<?php echo $row_rst_edit_cliente['ID_TRIBUTARIA_CEDULA']; ?>" title="Documento de identificacion tributaria en caso de ser a una empresa" />
      <span class="textfieldRequiredMsg">Informaci&oacute;n necesaria.</span></span></td>
      <td width="138" align="right" class="Campos">Nacionalidad:</td>
      <td width="160" class="Campos"><select name="ID_NACIONALIDAD" id="NACIONALIDAD" title="Nacionalidad">
        <?php
do {  
?>
        <option value="<?php echo $row_rst_nacionalidad['ID_TERCEROS_NACIONALIDAD']?>"<?php if (!(strcmp($row_rst_nacionalidad['ID_TERCEROS_NACIONALIDAD'], $row_rst_edit_cliente['ID_NACIONALIDAD']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rst_nacionalidad['DESCRIPCION']?></option>
        <?php
} while ($row_rst_nacionalidad = mysql_fetch_assoc($rst_nacionalidad));
  $rows = mysql_num_rows($rst_nacionalidad);
  if($rows > 0) {
      mysql_data_seek($rst_nacionalidad, 0);
	  $row_rst_nacionalidad = mysql_fetch_assoc($rst_nacionalidad);
  }
?>
      </select></td>
      <td align="right" class="Campos">Relaci&oacute;n laborar:</td>
      <td class="Campos"><label for="ID_RELACION_LABORAR"></label>
        <select name="ID_RELACION_LABORAR" id="ID_RELACION_LABORAR" title="Relacion laboral">
          <?php
do {  
?>
          <option value="<?php echo $row_rst_relacion_laborar['ID_TERCEROS_RELACION_LABORAR']?>"<?php if (!(strcmp($row_rst_relacion_laborar['ID_TERCEROS_RELACION_LABORAR'], $row_rst_edit_cliente['ID_RELACION_LABORAR']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rst_relacion_laborar['DESCRIPCION']?></option>
          <?php
} while ($row_rst_relacion_laborar = mysql_fetch_assoc($rst_relacion_laborar));
  $rows = mysql_num_rows($rst_relacion_laborar);
  if($rows > 0) {
      mysql_data_seek($rst_relacion_laborar, 0);
	  $row_rst_relacion_laborar = mysql_fetch_assoc($rst_relacion_laborar);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td align="right" nowrap="nowrap" class="Campos">Edo. Civil:</td>
      <td class="Campos">
        <span class="Campos">
        <select name="ID_ESTADO_CIVIL" id="ID_ESTADO_CIVIL" title="Estado Civil">
          <?php
do {  
?>
          <option value="<?php echo $row_rst_edo_civil['ID_TERCEROS_ESTADO_CIVIL']?>"<?php if (!(strcmp($row_rst_edo_civil['ID_TERCEROS_ESTADO_CIVIL'], $row_rst_edit_cliente['ID_ESTADO_CIVIL']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rst_edo_civil['DESCRIPCION']?></option>
          <?php
} while ($row_rst_edo_civil = mysql_fetch_assoc($rst_edo_civil));
  $rows = mysql_num_rows($rst_edo_civil);
  if($rows > 0) {
      mysql_data_seek($rst_edo_civil, 0);
	  $row_rst_edo_civil = mysql_fetch_assoc($rst_edo_civil);
  }
?>
        </select>
      </span></td>
      <td align="right" class="Campos">Profesi&oacute;n:</td>
      <td class="Campos"><span id="sprytextfield_profesion">
        <input type="text" name="PROFESION" value="<?php echo $row_rst_edit_cliente['PROFESION']; ?>" title="Profesion u Ocupacion"/>
      <span class="textfieldRequiredMsg">Informaci&oacute;n necesaria.</span></span></td>
      <td align="right" class="Campos">Grupo de Cliente:</td>
      <td class="Campos">
        <span class="Campos">
        <select name="ID_PRO_CLI_GRUPO" id="ID_PRO_CLI_GRUPO">
          <option value="1">Todos</option>
        </select>
      </span></td>
    </tr>
    <tr>
      <td align="right" nowrap="nowrap" class="Campos">Telefono Hab:</td>
      <td class="Campos"><span id="sprytextfield_tlf1">
        <input name="TELEFONO_FIJO_1" type="text" id="TELEFONO_FIJO_1" value="<?php echo $row_rst_edit_cliente['TELEFONO_FIJO_1']; ?>" />
      <span class="textfieldRequiredMsg">Informaci&oacute;n necesaria.</span></span></td>
      <td align="right" class="Campos">Telefono Ofic:</td>
      <td class="Campos"><span id="sprytextfield_tlf2">
        <input type="text" name="TELEFONO_FIJO_2" value="<?php echo $row_rst_edit_cliente['TELEFONO_FIJO_2']; ?>" />
      <span class="textfieldRequiredMsg">Informaci&oacute;n necesaria.</span></span></td>
      <td align="right" class="Campos">M&oacute;vil 1:</td>
      <td class="Campos"><span id="sprytextfield_movil1">
        <input type="text" name="TELEFONO_MOVIL_1" value="<?php echo $row_rst_edit_cliente['TELEFONO_MOVIL_1']; ?>" />
      <span class="textfieldRequiredMsg">Informaci&oacute;n necesaria.</span></span></td>
    </tr>
    <tr>
      <td align="right" nowrap="nowrap" class="Campos">M&oacute;vil 2:</td>
      <td class="Campos">
        <span class="Campos">
        <input type="text" name="TELEFONO_MOVIL_2" value="<?php echo $row_rst_edit_cliente['TELEFONO_MOVIL_2']; ?>" />
      </span></td>
      <td align="right" class="Campos">Email 1:</td>
      <td class="Campos"><span id="sprytextfield_email">
      <input type="text" name="EMAIL_1" value="<?php echo $row_rst_edit_cliente['EMAIL_1']; ?>" />
      <span class="textfieldRequiredMsg">Informaci&oacute;n necesaria.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
      <td align="right" class="Campos">Email 2:</td>
      <td class="Campos">
        <span class="Campos">
        <input type="text" name="EMAIL_2" value="<?php echo $row_rst_edit_cliente['EMAIL_2']; ?>" />
      </span></td>
    </tr>
    <tr>
      <td align="right" nowrap="nowrap" class="Campos">Web Site:</td>
      <td class="Campos">
        <span class="Campos">
        <input type="text" name="WEB_SITE" value="<?php echo $row_rst_edit_cliente['WEB_SITE']; ?>" />
      </span></td>
      <td align="right" class="Campos">Direcci&oacute;n:</td>
      <td colspan="3" align="left" class="Campos"><span id="sprytextarea_direccion">
        <textarea name="DIRECCION" cols="80" rows="2"><?php echo $row_rst_edit_cliente['DIRECCION']; ?></textarea>
      <span class="textareaRequiredMsg">Informaci&oacute;n necesaria.</span></span></td>
      </tr>
    <tr align="center" valign="baseline">
      <td height="28" colspan="6" valign="middle" nowrap="nowrap"><h2>Informacion del Contacto</h2></td>
    </tr>
    
    
    <!--informacion del contacto-->
    <tr valign="top">
      <td width="132" align="right" nowrap="nowrap" class="Campos">Nombre del Contacto:</td>
      <td class="Campos"><span id="sprytextfield_contactos">
        <input type="text" name="CONTACTO" value="<?php echo $row_rst_edit_cliente['CONTACTO']; ?>" title="Nombre del contacto en caso de ser una empresa el cliente" /> 
      <span class="textfieldRequiredMsg">Informaci&oacute;n necesaria..</span></span></td>
      <td align="right" class="Campos">Observaciones:</td>
      <td colspan="3" class="Campos"><textarea name="OBSERVACIONES" cols="80" rows="3"><?php echo $row_rst_edit_cliente['OBSERVACIONES']; ?></textarea></td>
      </tr>
     <tr align="center" valign="baseline">
      <td height="47" colspan="6" valign="middle" nowrap="nowrap"><input type="submit" value="Aceptar"  class="ui-state-hover"/></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="ID_PRO_CLI_MASTER" value="<?php echo $row_rst_edit_cliente['ID_PRO_CLI_MASTER']; ?>" />
</form>
<p>&nbsp;</p>
<div id="texto"> 
</div>
<script type="text/javascript">
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield_contactos", "none", {validateOn:["blur", "change"]});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield_cedula", "none", {validateOn:["blur", "change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield_nombre", "none", {validateOn:["blur", "change"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield_pasaporte", "none", {validateOn:["blur", "change"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield_profesion", "none", {validateOn:["blur", "change"]});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield_tlf1", "none", {validateOn:["blur", "change"]});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield_tlf2", "none", {validateOn:["blur", "change"]});
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield_movil1", "none", {validateOn:["blur", "change"]});
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield_email", "email", {validateOn:["blur", "change"]});
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea_direccion", {validateOn:["blur", "change"]});
var sprytextfield10 = new Spry.Widget.ValidationTextField("sprytextfield_TLF_CONTACTO", "none", {validateOn:["blur", "change"]});

</script>
<?php
mysql_free_result($rst_nacionalidad);

mysql_free_result($rst_relacion_laborar);

mysql_free_result($rst_edo_civil);

mysql_free_result($rst_edit_cliente);
?>
