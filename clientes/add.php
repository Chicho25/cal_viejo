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
 
//include("../include/header.php");
/*require_once('../Connections/conexion.php'); ?>

<?php
}*/

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pro_cli_master (CODIGO, TIPO, RESIDENCIADO, NOMBRE, ID_NACIONALIDAD, PROFESION, ID_RELACION_LABORAR, ID_ESTADO_CIVIL, CONTACTO, ID_PRO_CLI_GRUPO, ID_TRIBUTARIA_CEDULA, DIRECCION, TELEFONO_FIJO_1, TELEFONO_FIJO_2, TELEFONO_MOVIL_1, TELEFONO_MOVIL_2, EMAIL_1, EMAIL_2, WEB_SITE, OBSERVACIONES) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
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
                       GetSQLValueString($_POST['OBSERVACIONES'], "text"));
//echo  $insertSQL;
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
	  aud($usua,$_POST['ID_TRIBUTARIA_CEDULA'],'Insertando el Usuario cod. '.mysql_insert_id(),$menu);
	  
	  ?>
     
	  <script type="text/javascript">
alert("Se Inserto con exito");
window.location = "list.php?titulo_formulario=Clientes"
</script>
 <?php
  $insertGoTo = "list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  //@header(sprintf("Location: %s", $insertGoTo));
}
?>
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
        <option value="1">SI</option>
        <option value="0">NO</option>
      </select></td>
      <td align="right" class="Campos">&nbsp;</td>
      <td class="Campos"><label for="fecha_residencia"></label></td>
    <tr align="right">
      <td width="132" nowrap="nowrap" class="Campos">Nombre:</td>
      <td colspan="3" align="left" class="Campos"><span id="sprytextfield_nombre">
        <input name="NOMBRE" type="text" value="" size="85" title="Nombre de el cliente o de la empresa quien adquiere el inmueble"/>
      <span class="textfieldRequiredMsg">Informaci&oacute;n necesaria.</span></span></td>
      <td width="147" class="Campos">C&eacute;dula:</td>
      <td width="193" align="left" class="Campos"><span id="sprytextfield_cedula">
        <input type="text" name="CEDULA" id="CEDULA" title="Cedula de identidad en caso de ser personal"/>
      <span class="textfieldRequiredMsg">Informaci&oacute;n necesaria.</span></span></td>
    </tr>
    <tr>
      <td align="right" nowrap="nowrap" class="Campos">RUC o Pasaporte:</td>
      <td width="181" class="Campos"><span id="sprytextfield_pasaporte">
        <input type="text" name="ID_TRIBUTARIA_CEDULA" value="" title="Documento de identificacion tributaria en caso de ser a una empresa" />
      <span class="textfieldRequiredMsg">Informaci&oacute;n necesaria.</span></span></td>
      <td width="138" align="right" class="Campos">Nacionalidad:</td>
      <td width="160" class="Campos"><select name="ID_NACIONALIDAD" id="NACIONALIDAD" title="Nacionalidad">
        <?php
do {  
?>
        <option value="<?php echo $row_rst_nacionalidad['ID_TERCEROS_NACIONALIDAD']?>"><?php echo $row_rst_nacionalidad['DESCRIPCION']?></option>
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
          <option value="<?php echo $row_rst_relacion_laborar['ID_TERCEROS_RELACION_LABORAR']?>"><?php echo $row_rst_relacion_laborar['DESCRIPCION']?></option>
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
          <option value="<?php echo $row_rst_edo_civil['ID_TERCEROS_ESTADO_CIVIL']?>"><?php echo $row_rst_edo_civil['DESCRIPCION']?></option>
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
        <input type="text" name="PROFESION" value="" title="Profesion u Ocupacion"/>
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
        <input name="TELEFONO_FIJO_1" type="text" id="TELEFONO_FIJO_1" value="" />
      <span class="textfieldRequiredMsg">Informaci&oacute;n necesaria.</span></span></td>
      <td align="right" class="Campos">Telefono Ofic:</td>
      <td class="Campos"><span id="sprytextfield_tlf2">
        <input type="text" name="TELEFONO_FIJO_2" value="" />
      <span class="textfieldRequiredMsg">Informaci&oacute;n necesaria.</span></span></td>
      <td align="right" class="Campos">M&oacute;vil 1:</td>
      <td class="Campos"><span id="sprytextfield_movil1">
        <input type="text" name="TELEFONO_MOVIL_1" value="" />
      <span class="textfieldRequiredMsg">Informaci&oacute;n necesaria.</span></span></td>
    </tr>
    <tr>
      <td align="right" nowrap="nowrap" class="Campos">M&oacute;vil 2:</td>
      <td class="Campos">
        <span class="Campos">
        <input type="text" name="TELEFONO_MOVIL_2" value="" />
      </span></td>
      <td align="right" class="Campos">Email 1:</td>
      <td class="Campos"><span id="sprytextfield_email">
      <input type="text" name="EMAIL_1" value="" />
      <span class="textfieldRequiredMsg">Informaci&oacute;n necesaria.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
      <td align="right" class="Campos">Email 2:</td>
      <td class="Campos">
        <span class="Campos">
        <input type="text" name="EMAIL_2" value="" />
      </span></td>
    </tr>
    <tr>
      <td align="right" nowrap="nowrap" class="Campos">Web Site:</td>
      <td class="Campos">
        <span class="Campos">
        <input type="text" name="WEB_SITE" value="" />
      </span></td>
      <td align="right" class="Campos">Direcci&oacute;n:</td>
      <td colspan="3" align="left" class="Campos"><span id="sprytextarea_direccion">
        <textarea name="DIRECCION" cols="80" rows="2"></textarea>
      <span class="textareaRequiredMsg">Informaci&oacute;n necesaria.</span></span></td>
      </tr>
    <tr align="center" valign="baseline">
      <td height="28" colspan="6" valign="middle" nowrap="nowrap"><h2>Informacion del Contacto</h2></td>
    </tr>
    
    
    <!--informacion del contacto-->
    <tr valign="top">
      <td width="132" align="right" nowrap="nowrap" class="Campos">Nombre del Contacto:</td>
      <td class="Campos"><span id="sprytextfield_contactos">
        <input type="text" name="CONTACTO" value="" title="Nombre del contacto en caso de ser una empresa el cliente" /> 
      <span class="textfieldRequiredMsg">Informaci&oacute;n necesaria..</span></span></td>
      <td align="right" class="Campos">Observaciones:</td>
      <td colspan="3" class="Campos"><textarea name="OBSERVACIONES" cols="80" rows="3"></textarea></td>
      </tr>
    <tr align="center" valign="baseline">
      <td height="47" colspan="6" valign="middle" nowrap="nowrap"><input type="submit" value="Aceptar" class="ui-state-hover"  /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
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
</script>
<?php
mysql_free_result($rst_nacionalidad);

mysql_free_result($rst_relacion_laborar);

mysql_free_result($rst_edo_civil);
?>
