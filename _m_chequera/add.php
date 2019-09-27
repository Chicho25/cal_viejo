<?php
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "incluir")) {
  $insertSQL = sprintf("INSERT INTO banco_chequeras (ID_CUENTA_BANCARIA, CHEQUE_INICIO, CHEQUE_FIN, LONGITUD_NUMERO, ULTIMO_CHEQUE, AUTOMATICA, ACTIVA, ANULADA) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID_CUENTA_BANCARIA'], "int"),
                       GetSQLValueString($_POST['CHEQUE_INICIO'], "int"),
                       GetSQLValueString($_POST['CHEQUE_FIN'], "int"),
                       GetSQLValueString($_POST['LONGITUD_NUMERO'], "int"),
                       GetSQLValueString($_POST['ULTIMO_CHEQUE'], "int"),
                       GetSQLValueString(isset($_POST['AUTOMATICA']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['ACTIVA']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['ANULADA']) ? "true" : "", "defined","1","0"));
//echo $insertSQL;
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
     $ids=mysql_insert_id();
  aud($_SESSION['i'],$ids,'Creo registro con el id',$menu);
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
$query_CUENTAS_BANCARIAS = "SELECT * FROM vista_banco_cuentas";
$CUENTAS_BANCARIAS = mysql_query($query_CUENTAS_BANCARIAS, $conexion) or die(mysql_error());
$row_CUENTAS_BANCARIAS = mysql_fetch_assoc($CUENTAS_BANCARIAS);
$totalRows_CUENTAS_BANCARIAS = mysql_num_rows($CUENTAS_BANCARIAS);

?>
<form action="<?php echo $editFormAction; ?>" method="post" name="incluir" id="incluir">
  <table width="1100" align="center">
    <tr valign="baseline">
      <td width="502" align="right" nowrap="nowrap" >Cuentas Bancaria:</td>
      <td width="586"><select name="ID_CUENTA_BANCARIA">
        <?php 
do {  
?>
        <option value="<?php echo $row_CUENTAS_BANCARIAS['ID_CUENTA']?>" ><?php echo $row_CUENTAS_BANCARIAS['NOMBRE_PROYECTO']; ?> - <?php echo $row_CUENTAS_BANCARIAS['NOMBRE_BANCO']; ?> - <?php echo $row_CUENTAS_BANCARIAS['NUMERO_CUENTA']?></option>
        <?php
} while ($row_CUENTAS_BANCARIAS = mysql_fetch_assoc($CUENTAS_BANCARIAS));
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" >Cheque inicial:</td>
      <td><input type="text" name="CHEQUE_INICIO" value="" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" >Cheque Final:</td>
      <td><input type="text" name="CHEQUE_FIN" value="" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" >Cantidad Digitos Numero de Cheque:</td>
      <td><input type="text" name="LONGITUD_NUMERO" value="6" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" >Ultimo Cheque Emitido:</td>
      <td><input type="text" name="ULTIMO_CHEQUE" value="0" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" >Automatica:</td>
      <td><input type="checkbox" name="AUTOMATICA" value="" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" >Activa:</td>
      <td><input type="checkbox" name="ACTIVA" value="" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" >Anulada:</td>
      <td><input type="checkbox" name="ANULADA" value="" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap"><input type="submit" class="ui-widget-header" value="Aceptar" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="incluir" />
</form>