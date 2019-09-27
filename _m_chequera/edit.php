<?php
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "editar")) {
  $updateSQL = sprintf("UPDATE banco_chequeras SET ID_CUENTA_BANCARIA=%s, CHEQUE_INICIO=%s, CHEQUE_FIN=%s, LONGITUD_NUMERO=%s, ULTIMO_CHEQUE=%s, MARGEN_TOPE=%s, AUTOMATICA=%s, ACTIVA=%s, ANULADA=%s WHERE ID_CHEQUERA=%s",
                       GetSQLValueString($_POST['ID_CUENTA_BANCARIA'], "int"),
                       GetSQLValueString($_POST['CHEQUE_INICIO'], "int"),
                       GetSQLValueString($_POST['CHEQUE_FIN'], "int"),
                       GetSQLValueString($_POST['LONGITUD_NUMERO'], "int"),
                       GetSQLValueString($_POST['ULTIMO_CHEQUE'], "int"),
					   GetSQLValueString($_POST['MARGEN_TOPE'], "int"),
                       GetSQLValueString(isset($_POST['AUTOMATICA']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['ACTIVA']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['ANULADA']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['ID_CHEQUERA'], "int"));
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
   $ids=$_POST['ID_CHEQUERA'];
  aud($_SESSION['i'],$ids,'Modifico registro con el id',$menu);
?>
 <script type="text/javascript">
alert("Los cambios se realizaron con exito...");

window.location = "index.php?titulo_formulario=<?php echo $_GET['titulo_formulario'] ?>&id_menu=<?php echo $_GET['id_menu'] ?>"
</script>
<?php 
}
 ?>

<?php


mysql_select_db($database_conexion, $conexion);
$query_CONSULTAS = "SELECT * FROM vista_banco_chequeras ORDER BY ID_CHEQUERA ASC";
$CONSULTAS = mysql_query($query_CONSULTAS, $conexion) or die(mysql_error());
$row_CONSULTAS = mysql_fetch_assoc($CONSULTAS);
$totalRows_CONSULTAS = mysql_num_rows($CONSULTAS);

mysql_select_db($database_conexion, $conexion);
$query_CUENTAS_BANCARIAS = "SELECT * FROM vista_banco_cuentas";
$CUENTAS_BANCARIAS = mysql_query($query_CUENTAS_BANCARIAS, $conexion) or die(mysql_error());
$row_CUENTAS_BANCARIAS = mysql_fetch_assoc($CUENTAS_BANCARIAS);
$totalRows_CUENTAS_BANCARIAS = mysql_num_rows($CUENTAS_BANCARIAS);

$colname_EDITAR = "-1";
if (isset($_GET['ID_CHEQUERA'])) {
  $colname_EDITAR = $_GET['ID_CHEQUERA'];
}
mysql_select_db($database_conexion, $conexion);
$query_EDITAR = "SELECT * FROM banco_chequeras WHERE ID_CHEQUERA =". $_GET['ID_CHEQUERA'];
$EDITAR = mysql_query($query_EDITAR, $conexion) or die(mysql_error());
$row_EDITAR = mysql_fetch_assoc($EDITAR);
$totalRows_EDITAR = mysql_num_rows($EDITAR);

?>
<form action="<?php echo $editFormAction; ?>" method="POST" name="editar" id="editar">
  <table width="1100" align="center">
    <tr valign="baseline">
      <td width="502" align="right" nowrap="nowrap">Cuentas Bancaria:</td>
      <td width="586"><select name="ID_CUENTA_BANCARIA">
        <?php
do {  
?>
        <option value="<?php echo $row_CUENTAS_BANCARIAS['ID_CUENTA']?>"<?php if (!(strcmp($row_CUENTAS_BANCARIAS['ID_CUENTA'], $row_EDITAR['ID_CUENTA_BANCARIA']))) {echo "selected=\"selected\"";} ?>><?php echo $row_CUENTAS_BANCARIAS['NOMBRE_PROYECTO']; ?> - <?php echo $row_CUENTAS_BANCARIAS['NOMBRE_BANCO']; ?> - <?php echo $row_CUENTAS_BANCARIAS['NUMERO_CUENTA']?></option>
        <?php
} while ($row_CUENTAS_BANCARIAS = mysql_fetch_assoc($CUENTAS_BANCARIAS));
  $rows = mysql_num_rows($CUENTAS_BANCARIAS);
  if($rows > 0) {
      mysql_data_seek($CUENTAS_BANCARIAS, 0);
	  $row_CUENTAS_BANCARIAS = mysql_fetch_assoc($CUENTAS_BANCARIAS);
  }
?>
      </select><input name="ID_CHEQUERA" type="hidden" id="ID_CHEQUERA" value="<?php echo $row_EDITAR['ID_CHEQUERA']; ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Cheque inicial:</td>
      <td><input type="text" name="CHEQUE_INICIO" value="<?php echo $row_EDITAR['CHEQUE_INICIO']; ?>" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Cheque Final:</td>
      <td><input type="text" name="CHEQUE_FIN" value="<?php echo $row_EDITAR['CHEQUE_FIN']; ?>" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Cantidad Digitos Numero de Cheque:</td>
      <td><input type="text" name="LONGITUD_NUMERO" value="<?php echo $row_EDITAR['LONGITUD_NUMERO']; ?>" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Ultimo Cheque Emitido:</td>
      <td><input type="text" name="ULTIMO_CHEQUE" value="<?php echo $row_EDITAR['ULTIMO_CHEQUE']; ?>" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Margen  superior del cheque:</td>
      <td><input name="MARGEN_TOPE" type="text" id="MARGEN_TOPE" value="<?php echo $row_EDITAR['MARGEN_TOPE']; ?>" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Automatica:</td>
      <td><input <?php if (!(strcmp($row_EDITAR['AUTOMATICA'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" name="AUTOMATICA" value="1" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Activa:</td>
      <td><input name="ACTIVA" type="checkbox" value="1" <?php if (!(strcmp($row_EDITAR['ACTIVA'],1))) {echo "checked=\"checked\"";} ?> /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Anulada:</td>
      <td><input <?php if (!(strcmp($row_EDITAR['ANULADA'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" name="ANULADA" value="1" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap"><input type="submit" class="ui-widget-header" value="Aceptar" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="editar" />
</form>


<?php

mysql_free_result($CONSULTAS);

mysql_free_result($CUENTAS_BANCARIAS);

mysql_free_result($EDITAR);




?>
