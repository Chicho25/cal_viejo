<?php 
if (isset($_GET['ID_ALICUOTA'])){$id_alicuota=$_GET['ID_ALICUOTA'];} else {$id_alicuota=" ";}
if (isset($_GET['PORCENTAJE_ALICUOTA'])){$porc_alicuota=$_GET['PORCENTAJE_ALICUOTA'];} else {$porc_alicuota=" ";}
if (isset($_GET['MONTO_ESTIMADO'])){$monto_estimado=$_GET['MONTO_ESTIMADO'];} else {$monto_estimado="0.00";}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET["MM_insert"])) && ($_GET["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO partidas (DESCRIPCION, ID_SUCURSAL, ID_GRUPO, TIPO, NIVEL, ID_ALICUOTA, PORCENTAJE_ALICUOTA,  MONTO_ESTIMADO) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_GET['DESCRIPCION'], "text"),
					   GetSQLValueString($_GET['ID_SUCURSAL'], "text"),
                       GetSQLValueString($_GET['ID_GRUPO'], "int"),
                       GetSQLValueString($_GET['TIPO'], "int"),
                       GetSQLValueString($_GET['NIVEL'], "int"),
                       GetSQLValueString($id_alicuota, "int"),
                       GetSQLValueString($porc_alicuota, "double"),
                       GetSQLValueString($monto_estimado, "double"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
 //echo $insertSQL;
 $ids=mysql_insert_id();
   aud($_SESSION['i'],$ids,'Creo registro con el id',$menu);
?>
 <script type="text/javascript">
alert("Los cambios se realizaron con exito...");

window.location = "index.php?titulo_formulario=<?php echo $_GET['titulo_formulario']; ?>"
</script>
<?php 
}
?>
<?php
/* 
mysql_select_db($database_conexion, $conexion);
$query_rst_centro_costos = "SELECT ID FROM vista_partidas WHERE TIENE_HIJOS =1";
$rst_centro_costos = mysql_query($query_rst_centro_costos, $conexion) or die(mysql_error());
$row_rst_centro_costos = mysql_fetch_assoc($rst_centro_costos);
$totalRows_rst_centro_costos = mysql_num_rows($rst_centro_costos);


*/mysql_select_db($database_conexion, $conexion);
$query_rst_centro_costo = "SELECT ID, DESCRIPCION FROM partidas WHERE TIPO = 1";
$rst_centro_costo = mysql_query($query_rst_centro_costo, $conexion) or die(mysql_error());
$row_rst_centro_costo = mysql_fetch_assoc($rst_centro_costo);
$totalRows_rst_centro_costo = mysql_num_rows($rst_centro_costo);


mysql_select_db($database_conexion, $conexion);
$query_rst_partidas = "SELECT ID, DESCRIPCION FROM partidas WHERE TIPO IN (1,2)";
$rst_partidas = mysql_query($query_rst_partidas, $conexion) or die(mysql_error());
$row_rst_partidas = mysql_fetch_assoc($rst_partidas);
$totalRows_rst_partidas = mysql_num_rows($rst_partidas);

mysql_select_db($database_conexion, $conexion);
$query_rst_sucursales = "SELECT * FROM proyectos";
$rst_sucursales = mysql_query($query_rst_sucursales, $conexion) or die(mysql_error());
$row_rst_sucursales = mysql_fetch_assoc($rst_sucursales);
$totalRows_rst_sucursales = mysql_num_rows($rst_sucursales);


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

 <script type="text/javascript">
$("document").ready
(function()
		{$("#ID_GRUPO").change(function () {//alert('entro');
		if($("#ID_GRUPO").val()!=' '){//alert('aqui');
					 $("#ID_GRUPO option:selected").each(function () {//alert($("#ID_GRUPO").val());
									$.post("niveles.php",{ID: $("#ID_GRUPO").val()}, function(data){$("#niveles").html(data);	})})											
										
	
	}})
}

)
</script>
 <script type="text/javascript">
$("document").ready
(function()
		{$("#ID_SUCURSAL").change(function () {//alert('entro');
		if($("#ID_SUCURSAL").val()!=' '){//alert('aqui');
					 $("#ID_SUCURSAL option:selected").each(function () {//alert($("#ID_GRUPO").val());
									$.post("centros.php",{ID_SUCURSAL: $("#ID_SUCURSAL").val()}, function(data){$("#ID_GRUPO").html(data);	})})											
										
	
	}})
}

)
</script>
<form action="<?php echo $editFormAction; ?>" method="get" name="form1" id="form1">
  <table align="center">
<tr valign="baseline">
      <td nowrap="nowrap" align="right">
      Sucursal:</td>
      <td width="274"><span id="spryselect1">
        <label for="ID_GRUPO"></label>
        <select name="ID_SUCURSAL" id="ID_SUCURSAL">
          <option value="0">Principal</option>
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
      <td width="47" align="center" valign="middle"><!--<a href="copy_paste.php"><img src="../img/copy_paste.jpg" width="64" height="32" title="Copiar partidas desde otro proyecto o sucursal" /></a>--></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">
     <?php /*?> <?php if ($totalRows_rst_centro_costos > 0){echo "Grupo";} else {echo "Centro de Costos";}?><?php */?>Grupo:</td>
      <td colspan="2"><span id="spryselect1">
        <label for="ID_GRUPO"></label>
        <select name="ID_GRUPO" id="ID_GRUPO">
          <option value="0">Principal</option>
         
        </select>
        <span class="selectInvalidMsg">Seleccione un Items valido.</span><span class="selectRequiredMsg">Seleccione un Items.</span></span></td>
    </tr>
    
  
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nivel:</td>
      <td colspan="2"><label for="NIVEL"></label>
      <div id="niveles">
        <label for="NIVEL"></label>
        <input name="NIVEL" type="text" id="NIVEL" value="1" size="3" readonly />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td width="179" align="right" nowrap="nowrap">Descripcion:</td>
      <td colspan="2"><span id="sprytextfield1">
        <input type="text" name="DESCRIPCION" value="" size="32" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tipo:</td>
      <td colspan="2"><span id="spryselect2">
        <label for="TIPO"></label>
        <select name="TIPO" id="TIPO">
          <option value="11">GRUPO</option>
          <option value="12">MOVIMIENTO</option>
          <option value="13">ALICUOTA</option>
        </select>
        <span class="selectInvalidMsg">Seleccione un Items valido.</span><span class="selectRequiredMsg">Seleccione un Items.</span></span></td>
    </tr>
    <div class="alic">
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">% de la Alicuota:</td>
        <td colspan="2"><input type="text" name="PORCENTAJE_ALICUOTA" id="PORCENTAJE_ALICUOTA" value="0" size="5" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Partida a aplicarle la Alicuota:</td>
        <td colspan="2"><label for="ID_ALICUOTA"></label>
          <select name="ID_ALICUOTA" id="ID_ALICUOTA">
            <option value=" ">Seleccione...</option>
            <?php
do {  
?>
            <option value="<?php echo $row_rst_partidas['ID']?>"><?php echo $row_rst_partidas['DESCRIPCION']?></option>
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
      <td colspan="2"><input type="text" name="MONTO_ESTIMADO" value="0.00" id="MONTO" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="11" align="center" nowrap="nowrap"><input name="titulo_formulario" type="hidden" id="titulo_formulario" value="<?php echo $_GET['titulo_formulario'] ?>" /><input type="submit" value="Aceptar" class="ui-state-hover"/></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>

<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {invalidValue:"-1", validateOn:["blur", "change"]});
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2", {invalidValue:"-1", validateOn:["blur", "change"]});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur", "change"]});
</script>
<?php
//mysql_free_result($rst_centro_costos);

mysql_free_result($rst_sucursales);
?>
