<?php require_once('../Connections/conexion.php'); ?>
<?php
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form_add_inmueble")) {
  $insertSQL = sprintf("INSERT INTO inmuebles_master (ID_INMUEBLES_GRUPO, CODIGO, NOMBRE, ID_INMUEBLES_TIPO, MODELO, AREA, HABITACIONES, SANITARIOS, DEPOSITOS, ESTACIONAMIENTOS, OBSERVACIONES, PRECIO_REAL, ID_PARTIDA_COMISION, PORCENTAJE_COMISION) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID_INMUEBLES_GRUPO'], "int"),
                       GetSQLValueString($_POST['CODIGO'], "text"),
                       GetSQLValueString($_POST['NOMBRE'], "text"),
                       GetSQLValueString($_POST['ID_INMUEBLES_TIPO'], "int"),
                       GetSQLValueString($_POST['MODELO'], "text"),
                       GetSQLValueString($_POST['AREA'], "double"),
                       GetSQLValueString($_POST['HABITACIONES'], "int"),
                       GetSQLValueString($_POST['SANITARIOS'], "int"),
                       GetSQLValueString($_POST['DEPOSITOS'], "int"),
                       GetSQLValueString($_POST['ESTACIONAMIENTOS'], "int"),
                       GetSQLValueString($_POST['OBSERVACIONES'], "text"),
                       GetSQLValueString($_POST['PRECIO_REAL'], "double"),
                       GetSQLValueString($_POST['ID_PARTIDA_COMISION'], "int"),
                       GetSQLValueString($_POST['PORCENTAJE_COMISION'], "double"));
	$menu=15;
	$usua=$_SESSION['i'];
	  aud($usua,mysql_insert_id(),'Insertando el Usuario cod. '.mysql_insert_id(),$menu);

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());

  $insertGoTo = "list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  @header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conexion, $conexion);
$query_rst_tipo = "SELECT * FROM inmuebles_tipo";
$rst_tipo = mysql_query($query_rst_tipo, $conexion) or die(mysql_error());
$row_rst_tipo = mysql_fetch_assoc($rst_tipo);
$totalRows_rst_tipo = mysql_num_rows($rst_tipo);

mysql_select_db($database_conexion, $conexion);
$query_rst_grupo = "SELECT * FROM inmuebles_grupo";
$rst_grupo = mysql_query($query_rst_grupo, $conexion) or die(mysql_error());
$row_rst_grupo = mysql_fetch_assoc($rst_grupo);
$totalRows_rst_grupo = mysql_num_rows($rst_grupo);
?>
<link href="../css/encabezados.css" rel="stylesheet" type="text/css" />

<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

<form action="<?php echo $editFormAction; ?>" method="post" name="form_add_inmueble" id="form_add_inmueble">
  <table width="990" align="center" class="Campos">
    <tr valign="baseline">
      <td width="88" align="right" nowrap="nowrap">Codigo:</td>
      <td width="144"><span id="sprytextfield2">
        <label for="CODIGO"></label>
        <input type="text" name="CODIGO" id="CODIGO" />
      <span class="textfieldRequiredMsg">Informacion necesaria...</span></span></td>
      <td width="77" align="right">Nombre:</td>
      <td colspan="3"><span id="sprytextfield3">
        <label for="NOMBRE"></label>
        <input name="NOMBRE" type="text" id="NOMBRE" size="60" />
      <span class="textfieldRequiredMsg">Informacion necesaria...</span></span>        <label for="ID_INMUEBLES_GRUPO"></label></td>
      <td width="103" align="right">Grupo:</td>
      <td width="188"><span id="spryselect1">
        <label for="ID_INMUEBLES_TIPO2">
          <select name="ID_INMUEBLES_GRUPO" id="ID_INMUEBLES_GRUPO">
            <option value=" ">Seleccione...</option>
            <?php
do {  
?>
            <option value="<?php echo $row_rst_grupo['ID_INMUEBLES_GRUPO']?>"><?php echo $row_rst_grupo['NOMBRE']?></option>
            <?php
} while ($row_rst_grupo = mysql_fetch_assoc($rst_grupo));
  $rows = mysql_num_rows($rst_grupo);
  if($rows > 0) {
      mysql_data_seek($rst_grupo, 0);
	  $row_rst_grupo = mysql_fetch_assoc($rst_grupo);
  }
?>
          </select>
        </label>
      <span class="selectInvalidMsg">Seleccione...</span><span class="selectRequiredMsg">Seleccione...</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Modelo:</td>
      <td><span id="sprytextfield1">
        <label for="MODELO"></label>
        <input type="text" name="MODELO" id="MODELO" />
      <span class="textfieldRequiredMsg">Informacion necesaria...</span></span></td>
      <td align="right">Area:</td>
      <td width="148"><span id="sprytextfield4">
        <input type="text" name="AREA" value="" />
      <span class="textfieldRequiredMsg">Informacion necesaria...</span></span></td>
      <td width="92" align="right">Tipo:</td>
      <td width="114"><span id="spryselect2">
        <select name="ID_INMUEBLES_TIPO" id="ID_INMUEBLES_TIPO">
          <option value="' '">Seleccione...</option>
          <?php
do {  
?>
          <option value="<?php echo $row_rst_tipo['ID_INMUEBLES_TIPO']?>"><?php echo $row_rst_tipo['NOMBRE']?></option>
          <?php
} while ($row_rst_tipo = mysql_fetch_assoc($rst_tipo));
  $rows = mysql_num_rows($rst_tipo);
  if($rows > 0) {
      mysql_data_seek($rst_tipo, 0);
	  $row_rst_tipo = mysql_fetch_assoc($rst_tipo);
  }
?>
        </select>
      <span class="selectInvalidMsg">Seleccione...</span><span class="selectRequiredMsg">Seleccione...</span></span></td>
      <td align="right">Precio:</td>
      <td><span id="sprytextfield5">
        <input type="text" name="PRECIO_REAL" value="" />
      <span class="textfieldRequiredMsg">Informacion necesaria...</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Habitaciones:</td>
      <td><label for="SANITARIOS"></label>
        <select name="HABITACIONES" id="HABITACIONES">
          <option value="0">0</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
      </select></td>
      <td align="right">Ba&ntilde;os</td>
      <td><select name="SANITARIOS" id="HABITACIONES2">
          <option value="0">0</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
      </select></td>
      <td align="right">Depositos:</td>
      <td><select name="DEPOSITOS" id="HABITACIONES3">
          <option value="0">0</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
      </select></td>
      <td align="right">Estacionamientos:</td>
      <td><select name="ESTACIONAMIENTOS" id="HABITACIONES4">
          <option value="0">0</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
      </select></td>
    </tr>
    <tr valign="top">
      <td align="right" nowrap="nowrap">Porc. Comision:</td>
      <td><input type="text" name="PORCENTAJE_COMISION" value="" /></td>
      <td align="right">Partida comision:</td>
      <td><input name="ID_PARTIDA_COMISION" type="text" value="" /></td>
      <td align="right">Observaciones: </td>
      <td colspan="3"><textarea name="OBSERVACIONES" cols="48" rows="3"></textarea></td>
    </tr>
    <tr valign="middle">
      <td height="54" colspan="8" align="center" nowrap="nowrap"><input type="submit" class="ui-state-hover" value="Aceptar" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form_add_inmueble" />
</form>
<?php
mysql_free_result($rst_tipo);

mysql_free_result($rst_grupo);
?>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur", "change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur", "change"]});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {validateOn:["blur", "change"], invalidValue:"-1"});
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2", {invalidValue:"-1", validateOn:["blur", "change"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur", "change"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {validateOn:["blur", "change"]});
</script>
