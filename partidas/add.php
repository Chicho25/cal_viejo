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
 //require_once('../Connections/conexion.php'); ?>
<?php //include('../include/header.php'); 
mysql_select_db($database_conexion, $conexion);
$query_rst_centro_costo = "SELECT ID_CUENTA, DESCRIPCION FROM contabilidad_cuentas WHERE TIPO = 3";
$rst_centro_costo = mysql_query($query_rst_centro_costo, $conexion) or die(mysql_error());
$row_rst_centro_costo = mysql_fetch_assoc($rst_centro_costo);
$totalRows_rst_centro_costo = mysql_num_rows($rst_centro_costo);

mysql_select_db($database_conexion, $conexion);
$query_rst_sucursales = "SELECT * FROM empresas_sucursales";
$rst_sucursales = mysql_query($query_rst_sucursales, $conexion) or die(mysql_error());
$row_rst_sucursales = mysql_fetch_assoc($rst_sucursales);
$totalRows_rst_sucursales = mysql_num_rows($rst_sucursales);
?>
<script type="text/javascript">
$("document").ready

	(function()
	
		{$("#CENTRO_COSTOS").change(function () {// alert('entro');
		if($("#CENTRO_COSTOS").val()!=' '){//alert('aqui');
					 $("#CENTRO_COSTOS option:selected").each(function () {//alert($(this).val());
									$.post("formulario.php",{ID_CENTRO: $("#CENTRO_COSTOS").val(), ID_SUCURSAL: $("#SUCURSAL").val(), titulo_formularios: $("#titulo_formulario").val()}, function(data){$("#formula").html(data);	})
									})	
	
	}})
}
)
</script>
<script type="text/javascript">
$("document").ready

	(function()
	
		{$("#SUCURSAL").change(function () {// alert('entro');
		if($("#SUCURSAL").val()!=' '){//alert('aqui');
					 $("#SUCURSAL option:selected").each(function () {//alert($(this).val());
									$.post("centros.php",{ID_SUCURSAL: $("#SUCURSAL").val()}, function(data){$("#CENTRO_COSTOS").html(data);	})
									})	
	
	}})
}
)
</script>
  <table width="990" align="center">
  <tr valign="baseline">
      <td width="402" align="right" nowrap="nowrap">
  Proyecto:</td>
      <td width="576"><span id="spryselect2">
        <label for="SUCURSAL"></label>
        <select name="SUCURSAL" id="SUCURSAL">
          <option value="-1">Seleccione...</option>
          <?php
do {  
?>
          <option value="<?php echo $row_rst_sucursales['ID_SUCURSAL']?>"><?php echo $row_rst_sucursales['NOMBRE_SUCURSAL']?></option>
          <?php
} while ($row_rst_sucursales = mysql_fetch_assoc($rst_sucursales));
  $rows = mysql_num_rows($rst_sucursales);
  if($rows > 0) {
      mysql_data_seek($rst_sucursales, 0);
	  $row_rst_sucursales = mysql_fetch_assoc($rst_sucursales);
  }
?>
      </select>
    <span class="selectInvalidMsg">Seleccione un Items valido.</span><span class="selectRequiredMsg">Seleccione un Items.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td width="402" align="right" nowrap="nowrap">
        <input name="titulo_formulario" type="hidden" id="titulo_formulario" value="<?php echo $_GET['titulo_formulario']?>" />
      
      Centro de Costos:</td>
      <td width="576"><span id="spryselect1">
        <label for="SUCURSAL"></label>
        <select name="CENTRO_COSTOS" id="CENTRO_COSTOS">
          <option value="-1">Seleccione...</option>
         </select>
        <span class="selectInvalidMsg">Seleccione un Items valido.</span><span class="selectRequiredMsg">Seleccione un Items.</span></span></td>
    </tr>

  </table>
  <div id="formula">
  
  </div>
<p>&nbsp;</p>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {invalidValue:"-1", validateOn:["blur", "change"]});
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2", {invalidValue:"-1", validateOn:["blur", "change"]});
</script>
<?php
mysql_free_result($rst_centro_costo);

mysql_free_result($rst_sucursales);
?>
