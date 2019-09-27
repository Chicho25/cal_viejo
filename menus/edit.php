<?php 
mysql_select_db($database_conexion, $conexion);
$query_menus = "SELECT ID_MENU, DESCRIPCION FROM usuarios_menu";
$menus = mysql_query($query_menus, $conexion) or die(mysql_error());
$row_menus = mysql_fetch_assoc($menus);
$totalRows_menus = mysql_num_rows($menus);


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE usuarios_formularios SET TITULO=%s, DESCRIPCION=%s, LINK=%s, PARAMETROS=%s, LINK_AYUDA=%s WHERE ID_FORMULARIO=%s",
                       GetSQLValueString(htmlentities($_POST['TITULO'], ENT_QUOTES, "UTF-8"), "text"),
                       GetSQLValueString(htmlentities($_POST['DESCRIPCION'], ENT_QUOTES, "UTF-8"), "text"),
                       GetSQLValueString($_POST['LINK'], "text"),
                       GetSQLValueString($_POST['PARAMETROS'], "text"),
                       GetSQLValueString($_POST['LINK_AYUDA'], "text"),
                       GetSQLValueString($_POST['ID_FORMULARIO'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
  //echo $updateSQL;
     $ids=$_POST['ID_FORMULARIO'];
  aud($_SESSION['i'],$ids,'Modifico registro con el id',$menu);
  
    $updateSQL = sprintf("UPDATE usuarios_menu SET DESCRIPCION=%s, ID_GRUPO=%s, NIVEL=%s, ORDEN=%s, ID_FORMULARIO=%s, ACTIVO=%s WHERE ID_MENU=%s",
                       GetSQLValueString(htmlentities($_POST['DESCRIPCION'], ENT_QUOTES, "UTF-8"), "text"),
                       GetSQLValueString($_POST['ID_GRUPO'], "int"),
                       GetSQLValueString($_POST['NIVEL'], "int"),
                       GetSQLValueString($_POST['ORDEN'], "int"),
                       GetSQLValueString($_POST['ID_FORMULARIO'], "int"),
                       GetSQLValueString($_POST['ACTIVO'], "int"),
                       GetSQLValueString($_POST['ID_MENU'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());

    $ids=$_POST['ID_MENU'];
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
$colname_rst_formulario = "-1";
if (isset($_GET['ID_MENU'])) {
  $colname_rst_formulario = $_GET['ID_MENU'];
}
mysql_select_db($database_conexion, $conexion);

$query_formulario_menu_menu = sprintf("SELECT usuarios_formularios.ID_FORMULARIO,   usuarios_formularios.TITULO,   usuarios_formularios.DESCRIPCION,  usuarios_menu.DESCRIPCION, usuarios_formularios.LINK,   usuarios_formularios.PARAMETROS,   usuarios_formularios.LINK_AYUDA,   usuarios_menu.ID_MENU,   usuarios_menu.ID_GRUPO,   usuarios_menu.NIVEL,   usuarios_menu.ORDEN,   usuarios_menu.ACTIVO FROM usuarios_menu   LEFT JOIN usuarios_formularios ON (usuarios_menu.ID_FORMULARIO = usuarios_formularios.ID_FORMULARIO) WHERE usuarios_menu.ID_MENU = %s", GetSQLValueString($colname_rst_formulario, "int"));
$formulario_menu_menu = mysql_query($query_formulario_menu_menu, $conexion) or die(mysql_error());
$row_formulario_menu_menu = mysql_fetch_assoc($formulario_menu_menu);
$totalRows_formulario_menu_menu = mysql_num_rows($formulario_menu_menu);
?>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
      
    <tr valign="baseline">
      <td nowrap align="right">Titulo del Formulario:</td>
      <td><input type="text" name="TITULO" value="<?php echo $row_formulario_menu_menu['TITULO']; ?>" size="32"></td>
  </tr>
    <tr valign="baseline">
      <td nowrap align="right">Titulo del Menu:</td>
      <td><input type="text" name="DESCRIPCION" value="<?php echo $row_formulario_menu_menu['DESCRIPCION']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Link:</td>
      <td><input type="text" name="LINK" value="<?php echo $row_formulario_menu_menu['LINK']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Parametros:</td>
      <td><input type="text" name="PARAMETROS" value="<?php echo $row_formulario_menu_menu['PARAMETROS']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Link de Ayuda:</td>
      <td><input type="text" name="LINK_AYUDA" value="<?php echo $row_formulario_menu_menu['LINK_AYUDA']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Grupo al que pertenece:</td>
      <td><span id="spryselect1">
      <label for="ID_GRUPO"></label>
        <select name="ID_GRUPO" id="ID_GRUPO">
          <option value="0" <?php if (!(strcmp(0, $row_formulario_menu_menu['ID_GRUPO']))) {echo "selected=\"selected\"";} ?>>Principal</option>
          <?php
do {  
?>
          <option value="<?php echo $row_menus['ID_MENU']?>"<?php if (!(strcmp($row_menus['ID_MENU'], $row_formulario_menu_menu['ID_GRUPO']))) {echo "selected=\"selected\"";} ?>><?php echo $row_menus['DESCRIPCION']?></option>
          <?php
} while ($row_menus = mysql_fetch_assoc($menus));
  $rows = mysql_num_rows($menus);
  if($rows > 0) {
      mysql_data_seek($menus, 0);
	  $row_menus = mysql_fetch_assoc($menus);
  }
?>
        </select>
      <span class="selectRequiredMsg">Seleccione un Item.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Nivel:</td>
      <td>
        <div id="niveles">
        <label for="NIVEL"></label>
        <input name="NIVEL" type="text" id="NIVEL" value="<?php echo $row_formulario_menu_menu['NIVEL']; ?>" size="3" readonly />
      </div>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Orden:</td>
      <td><input name="ORDEN" type="text" value="<?php echo $row_formulario_menu_menu['ORDEN']; ?>" size="3"></td>
    </tr>
  <tr valign="baseline">
      <td nowrap align="right">Activo:</td>
      <td><span id="spryselect2">
        <label for="ACTIVO"></label>
        <select name="ACTIVO" id="ACTIVO">
          <option value="1">Si</option>
          <option value="0">No</option>
        </select>
      <span class="selectRequiredMsg">Seleccione un Item.</span></span></td>
    </tr>
    
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap><input type="submit" value="Aceptar" class="ui-widget-header"></td>
    </tr>
</table>
  <input type="hidden" name="MM_update" value="form1">
  <input name="ID_MENU" type="hidden" id="ID_MENU" value="<?php echo $row_formulario_menu_menu['ID_MENU']; ?>">
  <input name="ID_FORMULARIO" type="hidden" id="ID_FORMULARIO" value="<?php echo $row_formulario_menu_menu['ID_FORMULARIO']; ?>">
</form>
<?php

mysql_free_result($formulario_menu_menu);

mysql_free_result($menus);
?>
