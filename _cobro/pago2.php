<?php $_POST['elegido'];
?>
<?php function changueFormatDate($cdate){
    list($year,$month,$day)=explode("-",$cdate);
    return $day."/".$month."/".$year;
}?>
<?php require_once('../../Connections/conexion.php'); ?>
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

$colname_documentos = "-1";
if (isset($_POST['elegido'])) {
  $colname_documentos = $_POST['elegido'];
}
mysql_select_db($database_conexion, $conexion);
$query_documentos = sprintf("SELECT * FROM vista_documentos WHERE MODULO='2' AND STATUS_DOCUMENTO=1 AND MONTO_DOCUMENTO>0 AND COD_PROYECTO='".$_POST['CODIGO']."' AND ID_PRO_CLI = %s ORDER BY FECHA_DOCUMENTO", GetSQLValueString($colname_documentos, "int"));
//echo $query_documentos;
$documentos = mysql_query($query_documentos, $conexion) or die(mysql_error());
$row_documentos = mysql_fetch_assoc($documentos);
$totalRows_documentos = mysql_num_rows($documentos);
//echo $query_documentos;
mysql_select_db($database_conexion, $conexion);
$query_proveeedor = "SELECT * FROM pro_cli WHERE ID_PRO_CLI=".$_POST['elegido'];
//echo $query_proveeedor;
$proveeedor = mysql_query($query_proveeedor, $conexion) or die(mysql_error());
$row_proveeedor = mysql_fetch_assoc($proveeedor);
$totalRows_proveeedor = mysql_num_rows($proveeedor);

mysql_select_db($database_conexion, $conexion);
$query_tipo_pago = "SELECT * FROM tesoreria_tipo_mov WHERE MODULO=2 ORDER BY NOMBRE ASC";
$tipo_pago = mysql_query($query_tipo_pago, $conexion) or die(mysql_error());
//echo $query_proveeedor;
$row_tipo_pago = mysql_fetch_assoc($tipo_pago);
$totalRows_tipo_pago = mysql_num_rows($tipo_pago);

mysql_select_db($database_conexion, $conexion);
$query_cuenta_banco = "SELECT * FROM vista_banco_cuentas WHERE CODIGO_PROYECTO=".$_POST['CODIGO'];
$cuenta_banco = mysql_query($query_cuenta_banco, $conexion) or die(mysql_error());
$row_cuenta_banco = mysql_fetch_assoc($cuenta_banco);
$totalRows_cuenta_banco = mysql_num_rows($cuenta_banco);

$colname_proyecto = "-1";
if (isset($_POST['CODIGO'])) {
  $colname_proyecto = $_POST['CODIGO'];
}
mysql_select_db($database_conexion, $conexion);
$query_proyecto = sprintf("SELECT NOMBRE FROM proyectos WHERE CODIGO = %s", GetSQLValueString($colname_proyecto, "text"));
$proyecto = mysql_query($query_proyecto, $conexion) or die(mysql_error());
$row_proyecto = mysql_fetch_assoc($proyecto);
$totalRows_proyecto = mysql_num_rows($proyecto);





?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html"/>
<title>Untitled Document</title>
<script src="../js/jquery-1.4.2.min.js" language="javascript"></script>
<script src="../js/jquery-ui-1.8.5.custom.min.js" language="javascript"></script>
<script src="../js/jquery.ui.datepicker-es.js" language="javascript"></script>
<script src="../js/jquery.infieldlabel.min.js" language="javascript"></script>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<title>Untitled Document</title>
<link href="../js/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="../css/form.css" rel="stylesheet" type="text/css" />

<!--Autocompletar--->
<style>
#project-label {
	display: block;
	font-weight: bold;
	margin-bottom: 1em;
}
#project-icon {
	float: left;
	height: 32px;
	width: 32px;
}
#project-description {
	margin: 0;
	padding: 0;
	color:#F00;
}
body, td, th {
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
}

input:focus, input.focused {
	border-color: #000;
	color: #333;
}
</style>
<script>
function calculateTotal() {
    var total = 0;

    $(".quantity").each(function() {
        if (!isNaN(this.value) && this.value.length != 0) {
            total += parseFloat(this.value);
        }
    });

    $("#total_quantity").val(total.toFixed(2));
}

function valor(id,monto)
{
	if ($(this).attr('checked')) {
		
		$("#monto_"+id).val(0);
		//aler(1);
		

    
}
else
{
			$("#monto_"+id).val(monto);

	
    
}
a=calculateTotal();
	}
</script>


<script>
$(function() {


		$( "#dialog:ui-dialog" ).dialog( "destroy" );
	
		$( "#dialog-confirm" ).dialog({
			autoOpen: false,
			resizable: false,
			height:140,
			modal: true,
			buttons: {
				"Guardar": function() {
					document.enviar.submit();
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});
		
	$('form#enviar').submit(function(){
            //$("p#dialog-email").html($("input#emailJQ").val());
		if($("#total_quantity").val()>0){
            $('#dialog-confirm').dialog('open');
            return false;
		}
        });




		$( "#fecha" ).datepicker({
			changeMonth: true,
			changeYear: true,
			currentText: 'Now'
			
		});
		var myDate = new Date();
		var month = myDate.getMonth() + 1;
		var prettyDate = myDate.getDate()  + '/' + month + '/' + myDate.getFullYear();
		$("#fecha").val(prettyDate);
	
	
	
	
	
/*$("#TIPO_PAGO").change(function () {
elegido=$(this).val();
//alert("si");
if(elegido==3){
$("#con_banco").hide();
$("#sin_banco").show();
}else
{
$("#sin_banco").hide();
$("#con_banco").show()
}


});*/

//////////////////////////
/*
$('input[title]').each(function() {
if($(this).val() === '') {
$(this).val($(this).attr('title'));	
}

$(this).focus(function() {
if($(this).val() == $(this).attr('title')) {
$(this).val('').addClass('focused');	
}
});
$(this).blur(function() {
if($(this).val() === '') {
$(this).val($(this).attr('title')).removeClass('focused');	
}
});
});*/

///////////////////////////////////////

   $("#numero_cheque").change(function (){
	   
	   numero=$(this).val();
		//alert(numero);
		$.post("cheque.php", { numero: numero }, function(data){
				$("#valida_cheque").text(data);
				
		
		});
	   
	   });


});
</script>
<?php 
$visivilidad="none";
?>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/menu_style.css" type="text/css" media="all" />
</head>

<body>



<?php $opcion_menu=2; ?>
<?php include("../include/menu.php"); ?>
<form action="pago3.php" method="post" id="enviar" name="enviar">
	<table width="1100" align="center" class="ui-widget-header" >
		<tr>
			<td width="100%" align="center" class="textos_form"><div class="titulo_formulario">
				Pagos - ID:&nbsp;<?php echo $row_proveeedor['ID_PRO_CLI']; ?>&nbsp;-&nbsp;<?php echo $row_proveeedor['NOMBRE']; ?><br />
					<?php echo $row_proyecto['NOMBRE']; ?><br />
				
</div>
		</tr>
	</table>
	<center>
		<div id="movimiento">
			<?php if ($totalRows_documentos > 0) { // Show if recordset not empty ?>
				<table width="1100" border="0" cellspacing="2" cellpadding="0" bgcolor="#CCCCCC" align="center">
					<tr class="textos_form">
						<td width="49" align="center" bgcolor="#F0F0F0">Id Documento</td>
						<td width="100" align="center" bgcolor="#F0F0F0">Tipo</td>
						<td width="50" align="center" bgcolor="#F0F0F0">Numero</td>
						<td width="100" align="center" bgcolor="#F0F0F0">Fecha</td>
						<td align="center" bgcolor="#F0F0F0">Descripcion</td>
						<td width="100" align="center" bgcolor="#F0F0F0">Monto Total</td>
						<td width="100" align="center" bgcolor="#F0F0F0">Monto Pendiente</td>
						<td width="150" align="center" bgcolor="#F0F0F0">Monto a pagar</td>
					</tr>
					<?php
			$total=0;
			$total_pagado=0;
			 ?>
					<?php 
		$input=0;
		
		do { ?>
						<tr>
							<?php 
				
				mysql_select_db($database_conexion, $conexion);
				$query_pagado = "SELECT * FROM pagos_detalle WHERE ID_DOCUMENTO = ".$row_documentos['ID_DOCUMENTO'];
				$pagado = mysql_query($query_pagado, $conexion) or die(mysql_error());
				$row_pagado = mysql_fetch_assoc($pagado);
				$totalRows_pagado = mysql_num_rows($pagado);
				//echo $totalRows_pagado;
				//echo $query_pagado;
				mysql_select_db($database_conexion, $conexion);
				$query_tipo_documento = "SELECT * FROM doc_tipo WHERE TIPO = ".$row_documentos['CODIGO_TIPO_DOCUMENTO'];
				$tipo_documento = mysql_query($query_tipo_documento, $conexion) or die(mysql_error());
				$row_tipo_documento = mysql_fetch_assoc($tipo_documento);
				$totalRows_tipo_documento = mysql_num_rows($tipo_documento);
				
				mysql_select_db($database_conexion, $conexion);
$query_monto_pagado = "SELECT SUM(MONTO_PAGADO) as TOTAL_PAGADO FROM pagos_detalle WHERE ID_DOCUMENTO = ".$row_documentos['ID_DOCUMENTO'];
$monto_pagado = mysql_query($query_monto_pagado, $conexion) or die(mysql_error());
$row_monto_pagado = mysql_fetch_assoc($monto_pagado);
$totalRows_monto_pagado = mysql_num_rows($monto_pagado);
//echo $query_monto_pagado;
								
				$input=$input+1;
				
				$total=$total+$row_documentos['MONTO_DOCUMENTO'];
				$total_pagado=$total_pagado+$row_documentos['MONTO_DOCUMENTO']-$row_documentos['MONTO_PAGADO'];
				?>
							<td width="49" align="center" bgcolor="#FFFFFF"><?php echo $row_documentos['ID_DOCUMENTO']; ?></td>
							<td width="100" align="center" bgcolor="#FFFFFF"><?php echo $row_tipo_documento['DESCRIPCION'] ; ?></td>
							<td width="50" align="center" bgcolor="#FFFFFF"><?php echo $row_documentos['NUMERO_DOCUMENTO']; ?></td>
							<td align="center" bgcolor="#FFFFFF"><?php echo $row_documentos['FECHA_DOCUMENTO']; ?></td>
							<td bgcolor="#FFFFFF"><?php echo $row_documentos['DESCRIPCION_DOCUMENTO']; ?></td>
							<td width="100" align="right" bgcolor="#FFFFFF"><?php echo number_format($row_documentos['MONTO_DOCUMENTO'],2,',','.'); ?></td>
							<td width="100" align="right" bgcolor="#FFFFFF"><?php echo number_format($row_documentos['MONTO_DOCUMENTO']-$row_documentos['MONTO_PAGADO'],2,',','.'); ?></td>
							<td align="center" bgcolor="#FFFFFF"><label for="monto"></label>
								<input name="monto<?php echo $input; ?>" type="text" class="quantity textos_form_derecha" id="monto_<?php echo $input; ?>" size="6" onblur="calculateTotal();" onchange="calculateTotal();" />
								<input type="checkbox" name="checkbox" id="total_<?php echo $input; ?>" onchange="valor(<?php echo $input; ?>,<?php echo $row_documentos['MONTO_DOCUMENTO']-$row_monto_pagado['TOTAL_PAGADO']; ?>)" />
								<label for="checkbox" class="ui-accordion-content">Total
									<input name="id_documento_<?php echo $input; ?>" type="hidden" id="id_documento" value="<?php echo $row_documentos['ID_DOCUMENTO']; ?>" />
								</label></td>
						</tr>
						<?php } while ($row_documentos = mysql_fetch_assoc($documentos)); ?>
					<tr>
						<td colspan="5" align="right" bgcolor="#F0F0F0" class="textos_form">Totales:</td>
						<td width="100" align="right" bgcolor="#F0F0F0" class="textos_form"><?php echo number_format($total,2,',','.'); ?></td>
						<td width="100" align="right" bgcolor="#F0F0F0" class="textos_form"><?php echo number_format($total_pagado,2,',','.');; ?></td>
						<td align="center" bgcolor="#F0F0F0"><label for="monto"></label>
							<span id="sprytextfield2">
							<input name="total_quantity" type="text" id="total_quantity" onchange="valor(<?php echo $input ?>)" size="10" />
							<span class="textfieldRequiredMsg">*</span></span>
							<input name="cantidad" type="hidden" value="<?php echo $input ?>" />
							<!--<input type="checkbox" name="checkbox" id="checkbox" />
							<label for="checkbox" class="ui-accordion-content">Total</label>--></td>
					</tr>
				</table>
				<?php } // Show if recordset not empty ?>
			<?php if ($totalRows_documentos == 0) { // Show if recordset empty ?>
				<div class="textos_form" align="center"><br />
No Existe documentos por pagar asociados a este proveedor</div>
				<?php echo "<!--" ?>
				<?php } // Show if recordset empty ?>
				<br />

<table width="1100" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="12%" align="right" class="textos_form">Forma de Pago:</td>
		<td width="88%"><label for="TIPO_PAGO"></label>
		<select name="TIPO_PAGO" id="TIPO_PAGO">
			<?php
			do {  
			?>
			<option value="<?php echo $row_tipo_pago['ID_TESORERIA_TIPO_MOV']?>"<?php if (!(strcmp($row_tipo_pago['ID_TESORERIA_TIPO_MOV'], 2))) {echo "selected=\"selected\"";} ?>><?php echo $row_tipo_pago['NOMBRE']?></option>
			<?php
			} while ($row_tipo_pago = mysql_fetch_assoc($tipo_pago));
			$rows = mysql_num_rows($tipo_pago);
			if($rows > 0) 
			{
				mysql_data_seek($tipo_pago, 0);
				$row_tipo_pago = mysql_fetch_assoc($tipo_pago);
			}
		?>
		</select>
		<input name="CODIGO" type="hidden" id="CODIGO" value="<?php echo $_POST['CODIGO'] ?>" /></td>
	</tr><tr>
		<td align="right" class="textos_form">Fecha:</td><td><input name="fecha" type="text" id="fecha" /></td></tr>
	<tr>
		<td align="right" class="textos_form">Descripcion</td>
		<td><textarea name="descripcion" id="descripcion" cols="45" rows="5"></textarea></td>
	</tr>
</table>

			
<div id="con_banco" style="display: block">
	<table width="1100" cellpadding="0" cellspacing="0">
		<tr>
			<td width="12%" align="right" class="textos_form">Cuenta/Banco:</td>
			<td width="88%"><label for="textfield2"></label>
				<label for="id_cuenta_bancaria"></label>
				<select name="id_cuenta_bancaria" id="id_cuenta_bancaria">
					<?php
do {  
?>
					<option value="<?php echo $row_cuenta_banco['ID_CUENTA']?>"><?php echo $row_cuenta_banco['NOMBRE_BANCO']?>-<?php echo $row_cuenta_banco['NUMERO_CUENTA']?></option>
					<?php
} while ($row_cuenta_banco = mysql_fetch_assoc($cuenta_banco));
$rows = mysql_num_rows($cuenta_banco);
if($rows > 0) {
mysql_data_seek($cuenta_banco, 0);
$row_cuenta_banco = mysql_fetch_assoc($cuenta_banco);
}
?>
				</select></td>
		</tr>
		<tr>
			<td align="right" class="textos_form">Numero Manual:</td>
			<td><label for="textfield3"></label>
				<input name="numero_banco" type="text" id="numero_banco" title="Numero" size="10" /><div id="valida_cheque"></div>
				</td>
		</tr>
	</table>
</div>
			
			
			
	<div id="sin_banco" style="display: <?php echo $visivilidad ?>">
		<table width="1100" cellpadding="0" cellspacing="0">
		<tr>
			<td width="12%" align="right" class="textos_form">Numero:</td>
			<td width="88%"><label for="textfield3"></label>
			<input name="numero_nobanco" type="text" id="numero_nobanco" title="numero" size="50" height="12" /></td>
		</tr>
		</table>
	</div>
	</td>
	</tr>
	</table>
	<input name="button2" type="submit" class="textos_form" id="button2" value="Guardar" />
	</div>
	</center>
</form>
	<div id="dialog-confirm" title="Guardar?">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Desea guardar?</p>
</div>
<script type="text/javascript">
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
</body>
</html>
<?php
mysql_free_result($documentos);

mysql_free_result($proyecto);
?>
