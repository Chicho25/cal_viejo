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
if (isset($_GET['ID_ALICUOTA'])){$id_alicuota=$_GET['ID_ALICUOTA'];} else {$id_alicuota=" ";}
if (isset($_GET['PORCENTAJE_ALICUOTA'])){$porc_alicuota=$_GET['PORCENTAJE_ALICUOTA'];} else {$porc_alicuota=" ";}
if (isset($_GET['MONTO_ESTIMADO'])){$monto_estimado=$_GET['MONTO_ESTIMADO'];} else {$monto_estimado="0.00";}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if(isset($_POST['ID_GRUPO']) && $_POST['ID_GRUPO']!=""){$groups=$_POST['ID_GRUPO'];} else {$groups=0;}
//echo $groups;
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE contabilidad_cuentas SET ID_CLASIFICACION=%s, DESCRIPCION=%s, ID_GRUPO=%s, TIPO=%s, NIVEL=%s WHERE ID_CUENTA=%s",
                       GetSQLValueString($_POST['ID_CLASIFICACION'], "int"),
                       GetSQLValueString($_POST['DESCRIPCION'], "text"),
                       GetSQLValueString($_POST['ID_GRUPO'], "int"),
                       GetSQLValueString($_POST['TIPO'], "int"),
                       GetSQLValueString($_POST['NIVEL'], "int"),
                       GetSQLValueString($_POST['ID_CUENTA'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
  $ids=$_POST['ID_CUENTA'];
  aud($_SESSION['i'],$ids,'Modifico registro con el id',$menu);
?>
 <script type="text/javascript">
alert("Los cambios se realizaron con exito...");

window.location = "index.php?titulo_formulario=<?php echo $_GET['titulo_formulario']; ?>"
</script>
<?php 
}
?>
<?php
/*if (isset($_POST['ID_CENTRO']) && $_POST['ID_CENTRO']!="-1"){
mysql_select_db($database_conexion, $conexion);
$query_rst_sucursal = "SELECT * FROM contabilidad_cuentas WHERE ID_CUENTA =".$_POST['ID_CENTRO'];
//echo $query_rst_sucursal;
$rst_sucursal = mysql_query($query_rst_sucursal, $conexion) or die(mysql_error());
$row_rst_sucursal = mysql_fetch_assoc($rst_sucursal);
$totalRows_rst_sucursal = mysql_num_rows($rst_sucursal);
$sucursal= $row_rst_sucursal['ID_SUCURSAL'];
 //echo $sucursal;*/
 
 mysql_select_db($database_conexion, $conexion);
$query_rst_vista = "SELECT * FROM vista_contabilidad_partidas WHERE ID_CUENTA =".$_GET['ID_CUENTA'];
//echo $query_rst_vista;
$rst_vista = mysql_query($query_rst_vista, $conexion) or die(mysql_error());
$row_rst_vista = mysql_fetch_assoc($rst_vista);
$totalRows_rst_vista = mysql_num_rows($rst_vista);
 
 
mysql_select_db($database_conexion, $conexion);
$query_rst_centro_costos = "SELECT ID_CUENTA FROM vista_contabilidad_cuentas WHERE TIENE_HIJOS =1 AND ID_CUENTA =".$_GET['ID_CUENTA'];
$rst_centro_costos = mysql_query($query_rst_centro_costos, $conexion) or die(mysql_error());
$row_rst_centro_costos = mysql_fetch_assoc($rst_centro_costos);
$totalRows_rst_centro_costos = mysql_num_rows($rst_centro_costos);

if ($totalRows_rst_centro_costos > 0){//Esto es para cuando no tenga partidas se coloque el centro de costo como id de grupo

mysql_select_db($database_conexion, $conexion);
$query_rst_centro_costo = "SELECT ID_CUENTA, DESCRIPCION FROM contabilidad_cuentas WHERE TIPO = 11";
$rst_centro_costo = mysql_query($query_rst_centro_costo, $conexion) or die(mysql_error());
$row_rst_centro_costo = mysql_fetch_assoc($rst_centro_costo);
$totalRows_rst_centro_costo = mysql_num_rows($rst_centro_costo);

} else {
mysql_select_db($database_conexion, $conexion);
$query_rst_centro_costo = "SELECT ID_CUENTA, DESCRIPCION FROM contabilidad_cuentas WHERE TIPO = 3";
$rst_centro_costo = mysql_query($query_rst_centro_costo, $conexion) or die(mysql_error());
$row_rst_centro_costo = mysql_fetch_assoc($rst_centro_costo);
$totalRows_rst_centro_costo = mysql_num_rows($rst_centro_costo);
}

mysql_select_db($database_conexion, $conexion);
$query_rst_partidas = "SELECT ID_CUENTA, DESCRIPCION FROM contabilidad_cuentas WHERE TIPO IN (11, 12)";
$rst_partidas = mysql_query($query_rst_partidas, $conexion) or die(mysql_error());
$row_rst_partidas = mysql_fetch_assoc($rst_partidas);
$totalRows_rst_partidas = mysql_num_rows($rst_partidas);


?>


<script type="text/javascript">
$("document").ready

	(function()
	
		{$("#ID_ALICUOTA").attr('disabled','disabled');
		$("#PORCENTAJE_ALICUOTA").attr('disabled','disabled');
		$("#MONTO").attr('disabled','disabled');
		$("#TIPO").change(function () {// alert('entro');
		if($("#TIPO").val()!=' '){//alert('aqui');
					 $("#TIPO option:selected").each(function () {//alert($(this).val());
									if($("#TIPO").val()!=13){
										$("#ID_ALICUOTA").attr('disabled','disabled');
										$("#PORCENTAJE_ALICUOTA").attr('disabled','disabled');
										
										} else
										{
										$("#ID_ALICUOTA").removeAttr('disabled');
										$("#PORCENTAJE_ALICUOTA").removeAttr('disabled');
											
										}
										
										if($("#TIPO").val()!=12){
										$("#MONTO").attr('disabled','disabled');
																			
										} else
										{
										$("#MONTO").removeAttr('disabled');
											
										}
									})	
	
	}})
}
)
</script>
<form action="<?php echo $editFormAction; ?>" method="get" name="form1" id="form1">
  <table align="center">
 <?php if ($totalRows_rst_centro_costos > 0){ ?>
 <script type="text/javascript">
$("document").ready
(function()
		{$("#ID_GRUPO").change(function () {//alert('entro');
		if($("#ID_GRUPO").val()!=' '){//alert('aqui');
					 $("#ID_GRUPO option:selected").each(function () {//alert($("#ID_GRUPO").val());
									$.post("niveles.php",{ID_CUENTA: $("#ID_GRUPO").val()}, function(data){$("#niveles").html(data);	})})											
										
	
	}})
}

)
</script>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">
      <?php if ($totalRows_rst_vista > 0){echo "Grupo";} else {echo "Centro de Costos";}?>:</td>
      <td><span id="spryselect1">
        <label for="ID_GRUPO"></label>
        <select name="ID_GRUPO" id="ID_GRUPO">
          <option value="202" <?php if (!(strcmp(202, $row_rst_vista['ID_CUENTA']))) {echo "selected=\"selected\"";} ?>>Principal</option>
          <?php
do {  
?>
<option value="<?php echo $row_rst_centro_costo['ID_CUENTA']?>"<?php if (!(strcmp($row_rst_centro_costo['ID_CUENTA'], $row_rst_vista['ID_CUENTA']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rst_centro_costo['DESCRIPCION']?></option>
          <?php
} while ($row_rst_centro_costo = mysql_fetch_assoc($rst_centro_costo));
  $rows = mysql_num_rows($rst_centro_costo);
  if($rows > 0) {
      mysql_data_seek($rst_centro_costo, 0);
	  $row_rst_centro_costo = mysql_fetch_assoc($rst_centro_costo);
  }
?>
        </select>
        <span class="selectInvalidMsg">Seleccione un Items valido.</span><span class="selectRequiredMsg">Seleccione un Items.</span></span>
        <input name="ID_SUCURSAL" type="hidden" id="ID_SUCURSAL" value="<?php echo $sucursal; ?>" /></td>
    </tr>
    <?php } else { ?>
     <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap">Primera partida de este centro de costos
        <input type="hidden" name="ID_GRUPO" value="<?php echo $_POST['ID_CENTRO']; ?>" size="32" /> 
        <input name="ID_SUCURSAL" type="hidden" id="ID_SUCURSAL" value="<?php echo $sucursal; ?>" />
             </td>
      </tr>
    <?php } ?>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nivel:</td>
      <td><label for="NIVEL"></label>
      <div id="niveles">
        <label for="NIVEL"></label>
        <input name="NIVEL" type="text" id="NIVEL" value="<?php echo $row_rst_vista['NIVEL']; ?>" size="3" readonly />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td width="129" align="right" nowrap="nowrap">Descripcion:</td>
      <td width="192"><span id="sprytextfield1">
        <input type="text" name="DESCRIPCION" value="<?php echo $row_rst_vista['DESCRIPCION']; ?>" size="32" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tipo:</td>
      <td><span id="spryselect2">
        <label for="TIPO"></label>
        <select name="TIPO" id="TIPO">
          <option value="11" <?php if (!(strcmp(11, $row_rst_vista['TIPO']))) {echo "selected=\"selected\"";} ?>>GRUPO</option>
          <option value="12" <?php if (!(strcmp(12, $row_rst_vista['TIPO']))) {echo "selected=\"selected\"";} ?>>MOVIMIENTO</option>
          <option value="13" <?php if (!(strcmp(13, $row_rst_vista['TIPO']))) {echo "selected=\"selected\"";} ?>>ALICUOTA</option>
        </select>
        <span class="selectInvalidMsg">Seleccione un Items valido.</span><span class="selectRequiredMsg">Seleccione un Items.</span></span></td>
    </tr>
    <div class="alic">
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">% de la Alicuota:</td>
        <td><input type="text" name="PORCENTAJE_ALICUOTA" id="PORCENTAJE_ALICUOTA" value="<?php echo $row_rst_vista['PORCENTAJE_ALICUOTA']; ?>" size="5" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Partida a aplicarle la Alicuota:</td>
        <td><label for="ID_ALICUOTA"></label>
          <select name="ID_ALICUOTA" id="ID_ALICUOTA">
            <option value=" " <?php if (!(strcmp(" ", $row_rst_vista['ID_ALICUOTA']))) {echo "selected=\"selected\"";} ?>>Seleccione...</option>
            <?php
do {  
?>
<option value="<?php echo $row_rst_partidas['ID_CUENTA']?>"<?php if (!(strcmp($row_rst_partidas['ID_CUENTA'], $row_rst_vista['ID_ALICUOTA']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rst_partidas['DESCRIPCION']?></option>
            <?php
} while ($row_rst_partidas = mysql_fetch_assoc($rst_partidas));
  $rows = mysql_num_rows($rst_partidas);
  if($rows > 0) {
      mysql_data_seek($rst_partidas, 0);
	  $row_rst_partidas = mysql_fetch_assoc($rst_partidas);
  }
?>
        </select></td>
      </tr>
    </div>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Monto Estimado:</td>
      <td><input type="text" name="MONTO_ESTIMADO" value="<?php echo $row_rst_vista['MONTO_ESTIMADO']; ?>" id="MONTO" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="6" align="center" nowrap="nowrap"><input name="titulo_formulario" type="hidden" id="titulo_formulario" value="<?php echo $_POST['titulo_formularios'] ?>" /><input type="submit" value="Aceptar" class="ui-state-hover"/></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="ID_CUENTA" value="<?php echo $row_rst_cuentas_contables['ID_CUENTA']; ?>" />

</form>
<?php //} ?>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {invalidValue:"-1", validateOn:["blur", "change"]});
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2", {invalidValue:"-1", validateOn:["blur", "change"]});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur", "change"]});
</script>
