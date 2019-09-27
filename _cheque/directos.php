<?php
mysql_select_db($database_conexion, $conexion);
$query_rst_cuentas = "SELECT * FROM vista_banco_chequeras WHERE vista_banco_chequeras.AUTOMATICA=1";
$rst_cuentas = mysql_query($query_rst_cuentas, $conexion) or die(mysql_error());
$row_rst_cuentas = mysql_fetch_assoc($rst_cuentas);
$totalRows_rst_cuentas = mysql_num_rows($rst_cuentas);
$fecha_actual=date("d/m/Y");
?>
<script type="text/javascript">
$("document").ready
	(function()
		{$("#CUENTA").change(function () { 
		if($(this).val()!=' '){
						 $("#CUENTA option:selected").each(
								function () {
								//alert($(this).val());
									$.post("form.php", 
									{ID_CHEQUERA: $(this).val()}, function(data)
									{$(".che").html(data);});
									
/*									$.post("validate.php", 
									{ID_CUENTA_BANCARIA: $(this).val(), ULTIMO_CHEQUE: $("#cheque").val()}, function(data)
									{$(".listas2").html(data);});	
*/
		});} 
		
   	})
})
</script>
<script>
$(function() {
	var dates = $( "#FECHA" ).datepicker({
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		onSelect: function( selectedDate ) {
			var option = this.id == "from" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" );
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});

});
</script>
<script type="text/javascript">
$("document").ready
	(function()

		
		//////////////funcion de numeros a letras
		{$("#MONTO").change(function () { 
		
		if($(this).val()!=' '){//alert($(this).val());
						$("#MONTO").each(
								function () {
								//alert($(this).val());
									$.post("../include/letras.php", 
									{NUM: $(this).val()}, function(data)
									{
										//$(".letra").val(data);
										$(".letra").html(data);	
										$("#MONTO_LETRAS").val(data);	
																			
										
				});	
        	});} 
				
   	})
})
</script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<form action="add2.php" method="get" name="frmDirecto">
<!--<form action="list.php?activa=1&CUENTA=&BENEFICIARIO=&cheque=&MONTO=&MONTO_LETRAS=&titulo_menu=Cheque%20Directo%20(Autom%E1tico)" method="get" name="frmDirecto">-->
<table width="990" border="0" align="center">
  <tr bgcolor="#FFFFFF">
    <td width="244" align="right">Cuenta del Proyecto</td>
    <td width="736"><label for="CUENTA"></label>
      <span id="spryselect1">
      <select name="CUENTA" id="CUENTA">
        <option value="-1">Seleccione la chequera...</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rst_cuentas['ID_CHEQUERA']?>"><?php echo $row_rst_cuentas['NOMBRE_PROYECTO']?>-<?php echo $row_rst_cuentas['NOMBRE_BANCO']?>-<?php echo $row_rst_cuentas['NUMERO_CUENTA']?>-Rango Desde:<?php echo $row_rst_cuentas['CHEQUE_INICIO']?> Hasta:<?php echo $row_rst_cuentas['CHEQUE_FIN']?></option>
        <?php
} while ($row_rst_cuentas = mysql_fetch_assoc($rst_cuentas));
  $rows = mysql_num_rows($rst_cuentas);
  if($rows > 0) {
      mysql_data_seek($rst_cuentas, 0);
	  $row_rst_cuentas = mysql_fetch_assoc($rst_cuentas);
  }
?>
      </select>
      <span class="selectInvalidMsg">Seleccione una de las opciones.</span><span class="selectRequiredMsg">Seleccione la chequera.</span></span></td>
  </tr>
  </table>
<table width="990" border="0" align="center">
  <tr bgcolor="#FFFFFF">
    <td width="244" align="right">Cheque</td>
    <td width="736">
      <label for="cheque"></label>
      </div><div class="che" id="che">
                  <input name="cheque" type="text" id="cheque" readonly="readonly">
      </div><div class="listas2" id="listas2" style=" color:#FF0000">
      </td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">Monto</td>
    <td><span id="sprytextfield1">
    <input type="text" name="MONTO" id="MONTO" />
    <span class="textfieldRequiredMsg">Informacion requerida.</span><span class="textfieldInvalidFormatMsg">El formato de monto debe ser expresado en numeros, los decimales separados por punto.</span></span>
      <div class="letra" id="letra"></div><input name="MONTO_LETRAS" id="MONTO_LETRAS" type="hidden"  />
      </td>
  </tr>
  
  <tr bgcolor="#FFFFFF">
    <td align="right">Beneficiario</td>
    <td><span id="sprytextfield2">
      <input type="text" name="BENEFICIARIO" id="BENEFICIARIO" />
      <span class="textfieldRequiredMsg">Informacion requerida.</span></span></td>
  </tr>
    <tr bgcolor="#FFFFFF">
    <td align="right">Fecha:</td>
    <td><span id="sprytextfield2">
      <input type="text" name="FECHA" id="FECHA" value="<?php echo $fecha_actual ?>" />
      <span class="textfieldRequiredMsg">Informacion requerida.</span></span></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">Descripcion</td>
    <td>
      <label for="descripcion"></label>
      <span id="sprytextarea1">
      <textarea name="DESCRIPCION" id="DESCRIPCION" cols="45" rows="5"></textarea>
      <span class="textareaRequiredMsg">Informacion requerida.</span></span>
    </td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td colspan="2" align="center"><input type="submit" name="aceptar" class="ui-state-hover" id="aceptar" value="Aceptar" /></td>
    </tr>
</table>
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur", "change"]});
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["blur", "change"]});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {invalidValue:"-1", validateOn:["blur", "change"]});
</script>
<?php
mysql_free_result($rst_cuentas);
?>
