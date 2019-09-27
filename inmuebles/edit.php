<?php $editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE inmuebles_master SET ID_INMUEBLES_GRUPO=%s, CODIGO=%s, NOMBRE=%s, ID_INMUEBLES_TIPO=%s, MODELO=%s, AREA=%s, HABITACIONES=%s, SANITARIOS=%s, DEPOSITOS=%s, ESTACIONAMIENTOS=%s, OBSERVACIONES=%s, PRECIO_REAL=%s, ID_PARTIDA_COMISION=%s, PORCENTAJE_COMISION=%s WHERE ID_INMUEBLES_MASTER=%s",
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
                       GetSQLValueString($_POST['PORCENTAJE_COMISION'], "double"),
                       GetSQLValueString($_POST['ID_INMUEBLES_MASTER'], "int"));
					   aud($usua,$_POST['ID_INMUEBLES_MASTER'],'Editando el inmueble ID. '.$_POST['ID_INMUEBLES_MASTER'],$menu);

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or mysql_error($conexion);

errores(mysql_errno($conexion),"list.php",$usua,$_POST['ID_INMUEBLES_MASTER'],'Error numero'.mysql_errno($conexion). ' editando el inmueble id '.$_POST['ID_INMUEBLES_MASTER'],$menu);

  $updateGoTo = "list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  @header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['ID_INMUEBLE_MASTER'])) {
  $colname_Recordset1 = $_GET['ID_INMUEBLE_MASTER'];
}
mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = sprintf("SELECT * FROM vista_inmuebles WHERE ID_INMUEBLE = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_rst_inmueble_edit = "-1";
if (isset($_GET['ID_INMUEBLE_MASTER'])) {
  $colname_rst_inmueble_edit = $_GET['ID_INMUEBLE_MASTER'];
}
mysql_select_db($database_conexion, $conexion);
$query_rst_inmueble_edit = sprintf("SELECT * FROM inmuebles_master WHERE ID_INMUEBLES_MASTER = %s", GetSQLValueString($colname_rst_inmueble_edit, "int"));
//echo $query_rst_inmueble_edit;
$rst_inmueble_edit = mysql_query($query_rst_inmueble_edit, $conexion) or die(mysql_error());
$row_rst_inmueble_edit = mysql_fetch_assoc($rst_inmueble_edit);
$totalRows_rst_inmueble_edit = mysql_num_rows($rst_inmueble_edit);

mysql_free_result($rst_inmueble_edit);
?>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table width="990" align="center" class="Campos">
    <tr valign="baseline">
      <td width="88" align="right" nowrap="nowrap">Codigo:</td>
      <td width="144"><input type="text" name="CODIGO" value="<?php echo $row_rst_inmueble_edit['CODIGO']; ?>" /></td>
      <td width="77" align="right">Nombre:</td>
      <td colspan="3"><input name="NOMBRE" type="text" value="<?php echo $row_rst_inmueble_edit['NOMBRE']; ?>" size="60" />        <label for="ID_INMUEBLES_GRUPO"></label></td>
      <td width="103" align="right">Grupo:</td>
      <td width="188"><label for="ID_INMUEBLES_TIPO">
        <select name="ID_INMUEBLES_GRUPO" id="ID_INMUEBLES_GRUPO" title="<?php echo $row_rst_inmueble_edit['ID_INMUEBLES_GRUPO']; ?>">
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset1['ID_GRUPO']?>"><?php echo $row_Recordset1['NOMBRE_GRUPO']?></option>
          <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Modelo:</td>
      <td><input type="text" name="MODELO" value="<?php echo $row_rst_inmueble_edit['MODELO']; ?>" /></td>
      <td align="right">Area:</td>
      <td width="148"><input type="text" name="AREA" value="<?php echo $row_Recordset1['AREA']; ?>" /></td>
      <td width="92" align="right">Tipo:</td>
      <td width="114"><select name="ID_INMUEBLES_TIPO" id="ID_INMUEBLES_TIPO">
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset1['ID_TIPO_INMUEBLE']?>"><?php echo $row_Recordset1['NOMBRE_TIPO']?></option>
        <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
      </select></td>
      <td align="right">Precio:</td>
      <td><input type="text" name="PRECIO_REAL" value="<?php echo $row_rst_inmueble_edit['PRECIO_REAL']; ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Habitaciones:</td>
      <td><label for="SANITARIOS"></label>
        <label for="SANITARIOS"></label>
      <input name="HABITACIONES" type="text" id="HABITACIONES" value="<?php echo $row_Recordset1['HABITACIONES']; ?>" size="5"></td>
      <td align="right">Ba&ntilde;os</td>
      <td><input name="SANITARIOS" type="text" id="SANITARIOS" value="<?php echo $row_Recordset1['SANITARIOS']; ?>" size="5"></td>
      <td align="right">Depositos:</td>
      <td><input name="DEPOSITOS" type="text" id="DEPOSITOS" value="<?php echo $row_Recordset1['DEPOSITOS']; ?>" size="5"></td>
      <td align="right">Estacionamientos:</td>
      <td><input name="ESTACIONAMIENTOS" type="text" id="HABITACIONES2" value="<?php echo $row_Recordset1['ESTACIONAMIENTOS']; ?>" size="5"></td>
    </tr>
    <tr valign="top">
      <td height="59" align="right" nowrap="nowrap">Porc. Comision:</td>
      <td><input type="text" name="PORCENTAJE_COMISION" value="<?php echo $row_rst_inmueble_edit['PORCENTAJE_COMISION']; ?>" /></td>
      <td align="right">Partida comision:</td>
      <td><input name="ID_PARTIDA_COMISION" type="text" value="<?php echo $row_rst_inmueble_edit['ID_PARTIDA_COMISION']; ?>" /></td>
      <td align="right">Observaciones: </td>
      <td colspan="3"><textarea name="OBSERVACIONES" cols="48" rows="3"><?php echo $row_rst_inmueble_edit['OBSERVACIONES']; ?></textarea></td>
    </tr>
    <tr valign="middle">
      <td height="54" colspan="8" align="center" nowrap="nowrap"><input type="submit" class="ui-state-hover" value="Aceptar" /></td>
    </tr>
  </table>
  <p>
    <input type="hidden" name="MM_update" value="form1">
    <input type="hidden" name="ID_INMUEBLES_MASTER" value="<?php echo $row_rst_inmueble_edit['ID_INMUEBLES_MASTER']; ?>">
  </p>
</form>
<p>&nbsp;</p>
<?php
mysql_free_result($Recordset1);
?>
