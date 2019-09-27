<?php //require_once('../Connections/conexion.php'); ?>
<?php include('../include/header.php'); 
mysql_select_db($database_conexion, $conexion);
$query_rst_centro_costo = "SELECT ID_CUENTA, DESCRIPCION FROM contabilidad_cuentas WHERE TIPO = 3";
$rst_centro_costo = mysql_query($query_rst_centro_costo, $conexion) or die(mysql_error());
$row_rst_centro_costo = mysql_fetch_assoc($rst_centro_costo);
$totalRows_rst_centro_costo = mysql_num_rows($rst_centro_costo);
?>
<script type="text/javascript">
$("document").ready

	(function()
	
		{$("#ID_GRUPO").change(function () {// alert('entro');
		if($("#ID_GRUPO").val()!=' '){//alert('aqui');
					 $("#ID_GRUPO option:selected").each(function () {alert($(this).val());
									$.post("formulario.php",{ID_CENTRO: $("#ID_GRUPO").val()}, function(data){$("#formula").html(data);	})
									})	
	
	}})
}
)
</script>
  <table width="990" align="center">
    <tr valign="baseline">
      <td width="129" align="right" nowrap="nowrap">Centro de Costos:</td>
      <td width="192"><span id="spryselect1">
        <label for="ID_GRUPO"></label>
        <select name="ID_GRUPO" id="ID_GRUPO">
          <option value="-1">Seleccione...</option>
          <?php
do {  
?>
          <option value="<?php echo $row_rst_centro_costo['ID_CUENTA']?>"><?php echo $row_rst_centro_costo['DESCRIPCION']?></option>
          <?php
} while ($row_rst_centro_costo = mysql_fetch_assoc($rst_centro_costo));
  $rows = mysql_num_rows($rst_centro_costo);
  if($rows > 0) {
      mysql_data_seek($rst_centro_costo, 0);
	  $row_rst_centro_costo = mysql_fetch_assoc($rst_centro_costo);
  }
?>
        </select>
        <span class="selectInvalidMsg">Please select a valid item.</span><span class="selectRequiredMsg">Please select an item.</span></span></td>
    </tr>

  </table>
  <div id="formula">
  
  </div>
<p>&nbsp;</p>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {invalidValue:"-1", validateOn:["blur", "change"]});
</script>
<?php
mysql_free_result($rst_centro_costo);
?>
