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
$query_menus = "SELECT ID_MENU, DESCRIPCION FROM usuarios_menu";
$menus = mysql_query($query_menus, $conexion) or die(mysql_error());
$row_menus = mysql_fetch_assoc($menus);
$totalRows_menus = mysql_num_rows($menus);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	  $insertSQL = sprintf("INSERT INTO usuarios_formularios (TITULO, DESCRIPCION, LINK, PARAMETROS, LINK_AYUDA) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString(htmlentities($_POST['TITULO'], ENT_QUOTES, "UTF-8"), "text"),
                       GetSQLValueString(htmlentities($_POST['DESCRIPCION'], ENT_QUOTES, "UTF-8"), "text"),
                       GetSQLValueString($_POST['LINK'], "text"),
                       GetSQLValueString($_POST['PARAMETROS'], "text"),
                       GetSQLValueString($_POST['LINK_AYUDA'], "text"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
//echo $insertSQL;
	 $ids=mysql_insert_id();
   aud($_SESSION['i'],$ids,'Creo en formulario registro con el id',$menu);

  $insertSQL = sprintf("INSERT INTO usuarios_menu (DESCRIPCION, ID_GRUPO, NIVEL, ORDEN, ID_FORMULARIO, ACTIVO) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString(htmlentities($_POST['DESCRIPCION'], ENT_QUOTES, "UTF-8"), "text"),
                       GetSQLValueString($_POST['ID_GRUPO'], "int"),
                       GetSQLValueString($_POST['NIVEL'], "int"),
                       GetSQLValueString($_POST['ORDEN'], "int"),
                       GetSQLValueString($ids, "int"),
                       GetSQLValueString($_POST['ACTIVO'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  
  //echo $insertSQL;
   $ids=mysql_insert_id();
   aud($_SESSION['i'],$ids,'Creo en menus registro con el id',$menu);
   
    $insertSQL = sprintf("INSERT INTO usuarios_acceso (ID_ROLE, ID_MENU, DETALLE_ACCESO) VALUES (%s, %s, %s)",
                       GetSQLValueString(1, "int"),
                       GetSQLValueString($ids, "int"),
					   GetSQLValueString('111100', "text"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  
  //echo $insertSQL;
   $ids=mysql_insert_id();
   aud($_SESSION['i'],$ids,'Creo en acceso registro con el id',$menu);

?>

 <script type="text/javascript">
alert("Los cambios se realizaron con exito...");

window.location = "index.php?titulo_formulario=<?php echo $_GET['titulo_formulario'] ?>&id_menu=<?php echo $_GET['id_menu'] ?>"


</script>
<?php

}


?>

 <script type="text/javascript">
$("document").ready
(function()
		{$("#ID_GRUPO").change(function () {//alert('entro');
		if($("#ID_GRUPO").val()!=' '){//alert('aqui');
					 $("#ID_GRUPO option:selected").each(function () {//alert($("#ID_GRUPO").val());
									$.post("niveles.php",{ID_GRUPOS: $("#ID_GRUPO").val()}, function(data){$("#niveles").html(data);})})											
										
	
	}})
}

)
</script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">


<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
      
    <tr valign="baseline">
      <td nowrap align="right">Titulo del Formulario:</td>
      <td><input type="text" name="TITULO" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Titulo del Menu:</td>
      <td><input type="text" name="DESCRIPCION" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Link:</td>
      <td><input type="text" name="LINK" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Parametros:</td>
      <td><input type="text" name="PARAMETROS" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Link de Ayuda:</td>
      <td><input type="text" name="LINK_AYUDA" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Grupo al que pertenece:</td>
      <td><span id="spryselect1">
        <label for="ID_GRUPO"></label>
        <select name="ID_GRUPO" id="ID_GRUPO">
          <option value="0">Principal</option>
          <?php
do {  
?>
          <option value="<?php echo $row_menus['ID_MENU']?>"><?php echo $row_menus['DESCRIPCION']?></option>
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
        <input name="NIVEL" type="text" id="NIVEL" size="3" readonly />
      </div>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Orden:</td>
      <td><input name="ORDEN" type="text" value="" size="3"></td>
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
  <input type="hidden" name="MM_insert" value="form1">
</form>

<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
</script>
<?php
mysql_free_result($menus);
?>
