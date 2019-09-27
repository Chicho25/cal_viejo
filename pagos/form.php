
<?php
//echo $CODIGO_PROYECTO;
//include('../connections/conexion.php');
//include('../include/css_js.php');
//mysql_select_db($database_conexion, $conexion);
$query_rst_tipo_pago = "SELECT ID_TESORERIA_TIPO_MOV, NOMBRE, CAMPOS_REQUERIDOS FROM tesoreria_tipo_mov WHERE tesoreria_tipo_mov.MODULO=$modulo";
$rst_tipo_pago = mysql_query($query_rst_tipo_pago, $conexion) or die(mysql_error());
$row_rst_tipo_pago = mysql_fetch_assoc($rst_tipo_pago);
$totalRows_rst_tipo_pago = mysql_num_rows($rst_tipo_pago);




?>
<!--Descripcion de los datos que se muestra desde la base de datos para saber si se muestra o no
posicion 1 campo de fecha
posicion 2 campo de descripcion
posicion 3 campo de cuenta bancaria
posicion 4 campo de numero
posicion 5 campo de numero
-->
<script type="text/javascript">
$("document").ready
	(function()
	{
		

$(".fecha1").hide();
$(".descrip").hide();
$(".ctabanca").hide();
$(".nume").hide();
//alert('entro');
				var myDate = new Date();
		var month = myDate.getMonth() + 1;
		var prettyDate = myDate.getDate() + '/' + month + '/' + myDate.getFullYear();
		$("#fecha").val(prettyDate);

		$( "#fecha" ).datepicker(
		{
			changeMonth: true,
			changeYear: true,
			currentText: 'Now'
});
		$("#TIPO_PAGO").change(function () 
		{//alert($(this).val())
		
		if($(this).val()!=' ')
		//alert($(this).val())
			{valors=$(this).val();
			 variables = valors.split('-');
			 	//alert('valor='+variables[0]+" valor="+variables[1]);
			 $("#Tpago").val(variables[0]);
			 pos1=variables[1].substr(0,1);pos2=variables[1].substr(1,1);pos3=variables[1].substr(2,1);pos4=variables[1].substr(3,1);pos5=variables[1].substr(4,1);

		
				if(pos1 == 1) {
					//alert('pos1='+variables[1]);
				$(".fecha1").show();} else {
					//alert('pos1='+variables[1]);
					$(".fecha1").hide();};
				
				if(pos2 == 1) {
					//alert('pos2='+pos2);
				$(".descrip").show();} else {
					//alert('pos2='+pos2);
					$(".descrip").hide();};
					
					if(pos1 == 1) {
					//alert('pos3='+pos3);
				$(".ctabanca").show();} else {
					//alert('pos3='+pos3);
					$(".ctabanca").hide();};
					
					if(pos4 == 1) {
					//alert('pos4='+pos4);
				$(".nume").show();} else {
					//alert('pos4='+pos4);
					$(".nume").hide();};
			} 
				
		})
	}
	)

	</script>
<script>
function addCommas(nStr)
{//alert('Aqui');
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
	x1 = x1.replace(rgx, '$1' + ',' + '$2');
}
return x1 + x2;
}

function calculateTotal() {//alert('calcula total');
    var total = 0;

    $(".quantity").each(function() {
        if (!isNaN(this.value) && this.value.length != 0) {
            total += parseFloat(this.value);
        }
    });
	monto=addCommas(total);

    $("#total_quantity").val(monto);
}

function valor(id,monto)
{//alert('Funcion Valor antes');
	if ($("#total_"+id).attr('checked')) {//alert('Funcion Valor');
		//alert('check');
					$("#monto_"+id).val(monto.toFixed(2));
		

    
}
else
{
		
$("#monto_"+id).val(0);
		//alert(1);
	
    
}
a=calculateTotal();
	}
</script>
<!--<form action="../pagos/guardar_sp.php" method="get" name="pagos">-->
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

<table width="990" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr align="left"  class="Campos">
		<td width="126px" class="Campos">Forma de Pago</td>
		<td><span id="spryforma_pago">
		  <select name="TIPO_PAGO" id="TIPO_PAGO">
		    <option value="-0">Seleccione el tipo de pago</option>
		    <?php
do {  
?>
		    <option value="<?php echo $row_rst_tipo_pago['ID_TESORERIA_TIPO_MOV']?>-<?php echo $row_rst_tipo_pago['CAMPOS_REQUERIDOS']?>"><?php echo $row_rst_tipo_pago['NOMBRE']?></option>
		    <?php
} while ($row_rst_tipo_pago = mysql_fetch_assoc($rst_tipo_pago));
  $rows = mysql_num_rows($rst_tipo_pago);
  if($rows > 0) {
      mysql_data_seek($rst_tipo_pago, 0);
	  $row_rst_tipo_pago = mysql_fetch_assoc($rst_tipo_pago);
  }
?>
	    </select>
		  <span class="selectInvalidMsg">Selecione el tipo de pago.</span><span class="selectRequiredMsg">Selecione el tipo de pago.</span></span>
		  <input type="hidden" name="Tpago" id="Tpago" />
		  <input name="proyecto" type="hidden" id="proyecto" value="<?php echo $CODIGO_PROYECTO; ?>" />
<input name="CANT" type="hidden" id="CANT" value="<?php echo $input; ?>" />
	  <form id="form1" name="form1" method="post" action="">
	    <input name="MODULO" type="hidden" id="MODULO" value="<?php echo $modulo; ?>" />
        <input name="titulo_formulario" type="hidden" id="titulo_formulario" value="<?php echo $titulo_formulario; ?>" />
      </form></td>
	</tr>
    </table>
    <tr align="left">
    <table width="990" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
    <td width="126px"></td>
    <td></td></tr> 
     <?php include('_fecha.php') ?>
    
	
     <?php include('_descripcion.php') ?>
    
   
     <?php include('_cuenta_bancario.php') ?>
    
     <?php include('_numero.php') ?> 
</table>

<table width="990" align="center" cellpadding="0" cellspacing="0">
	  <tr>
			<td align="center" class="Campos"><input name="aceptar" type="submit" class="ui-state-hover" id="aceptar" value="Aceptar"></td>
  </tr>
</table>


</form>
<?php
mysql_free_result($rst_tipo_pago);
?>
    <script type="text/javascript">
var spryforma_pago = new Spry.Widget.ValidationSelect("spryforma_pago", {invalidValue:"-0", validateOn:["blur", "change"]});
    </script>
