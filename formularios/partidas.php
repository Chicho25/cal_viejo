<?php function changueFormatDate($cdate){
    list($day,$month,$year)=explode("/",$cdate);
    return $year."-".$month."-".$day;
}?>
<?php require_once('../Connections/conexion.php'); ?>
<?php //require_once('../include/funciones.php'); ?>
<?php require_once('../include/header.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

mysql_select_db($database_conexion, $conexion);
$query_partida = sprintf("SELECT a.*,
	a.MONTO_ESTIMADO-IFNULL(b.monto_asignado_dinamico,0) AS MONTO_ASIGNADO_DISPONIBLE_DINAMICO,
	a.MONTO_ESTIMADO-IFNULL(b.monto_pagado_dinamico,0) AS MONTO_PAGADO_DISPONIBLE_DINAMICO
FROM vista_partidas a
LEFT JOIN 
(SELECT id_partida,
	SUM(monto_documento) AS monto_asignado_dinamico,
	SUM(monto_pagado) AS monto_pagado_dinamico
FROM vista_documentos
GROUP BY id_partida) AS b
ON a.ID_PARTIDA=b.ID_PARTIDA
WHERE a.`ID_PARTIDA`=".$_POST['id_partida']);
$partida = mysql_query($query_partida, $conexion) or die(mysql_error());
$row_partida = mysql_fetch_assoc($partida);
$totalRows_partida = mysql_num_rows($partida);

	 

require_once('../include/funciones.php'); 
	
 
 if($_POST['total'] > $row_partida['MONTO_ASIGNADO_DISPONIBLE_DINAMICO'])
 
 
 
 {echo  '<script language="javascript">alert("El monto del documento excede el monto estimado disponible.");</script>';
 
  if (validador1(12, $_POST['usuarioactivo'],"oth")==1) { 
  
/*ESTO FUE EDITADO PORQUE NO QUERIAN QUE SE PASARA LAS PARTIDAS CUNADO EL MONTO ESTIMADO SEA INFERIOR AL MONTO ASIGNADO QUE ES LO MISMO QUE LOS DOCUMENTOS NO SEAN MAYORES A LO ESTIMADO 5/5/2014 */
 
/*  $insertSQL = sprintf("INSERT INTO documentos (NUMERO, ID_PRO_CLI, TIPO, FECHA_EMISION, FECHA_VENCIMIENTO, DESCRIPCION, ID_PARTIDA, MONTO_EXENTO, MONTO_GRABADO, COD_PROYECTO, MONTO_IMPUESTO) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['numero'], "text"),
                       GetSQLValueString($_POST['id_pro_cli'], "int"),
                       GetSQLValueString($_POST['tipo'], "int"),
                       GetSQLValueString(changueFormatDate($_POST['fecha_emision']), "date"),
                       GetSQLValueString(changueFormatDate($_POST['fecha_vencimiento']), "date"),
                       GetSQLValueString($_POST['descripcion'], "text"),
                       GetSQLValueString($_POST['id_partida'], "int"),
                       GetSQLValueString($_POST['exento'], "double"),
                       GetSQLValueString($_POST['bruto'], "double"),
			     	   GetSQLValueString($_POST['COD_PROYECTO'], "text"),
                       GetSQLValueString($_POST['total_impuesto'], "double"));

  mysql_select_db($database_conexion, $conexion);
 $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
 //echo  $insertSQL;
	 */
	  ?>
 <script type="text/javascript">

alert("Proceso Completado con Exito.");
window.location = "partidas.php?CODIGO="<?php echo $_POST['COD_PROYECTO']; ?>;

</script>
	<?php
	
	} else {echo  '<script language="javascript">alert("El monto del documento excede el monto estimado disponible. por favor revise los monto o solicite a una persona que este autorizada, que ingrese este documento excedido...");location.href="partidas_proyecto.php?" ;</script>';}



} else { $insertSQL = sprintf("INSERT INTO documentos (NUMERO, ID_PRO_CLI, TIPO, FECHA_EMISION, FECHA_VENCIMIENTO, DESCRIPCION, ID_PARTIDA, MONTO_EXENTO, MONTO_GRABADO, COD_PROYECTO, MONTO_IMPUESTO) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['numero'], "text"),
                       GetSQLValueString($_POST['id_pro_cli'], "int"),
                       GetSQLValueString($_POST['tipo'], "int"),
                       GetSQLValueString(changueFormatDate($_POST['fecha_emision']), "date"),
                       GetSQLValueString(changueFormatDate($_POST['fecha_vencimiento']), "date"),
                       GetSQLValueString($_POST['descripcion'], "text"),
                       GetSQLValueString($_POST['id_partida'], "int"),
                       GetSQLValueString($_POST['exento'], "double"),
                       GetSQLValueString($_POST['bruto'], "double"),
			     	   GetSQLValueString($_POST['COD_PROYECTO'], "text"),
                       GetSQLValueString($_POST['total_impuesto'], "double"));

  mysql_select_db($database_conexion, $conexion);
 $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
 //echo  $insertSQL;
 ?>
 <script type="text/javascript">

alert("Proceso Completado con Exito.");
//window.location = "partidas.php?CODIGO="<?php echo $_POST['COD_PROYECTO']; ?>;

</script>
	<?php
	}}
	
	
	////////////////////////////////////////
	

	
mysql_select_db($database_conexion, $conexion);
$query_proveeedor = "SELECT * FROM pro_cli WHERE tipo=1 or tipo=3";
$proveeedor = mysql_query($query_proveeedor, $conexion) or die(mysql_error());
$row_proveeedor = mysql_fetch_assoc($proveeedor);
$totalRows_proveeedor = mysql_num_rows($proveeedor);

mysql_select_db($database_conexion, $conexion);
$query_Tipo_doc = "SELECT * FROM doc_tipo WHERE MODULO=1";
$Tipo_doc = mysql_query($query_Tipo_doc, $conexion) or die(mysql_error());
$row_Tipo_doc = mysql_fetch_assoc($Tipo_doc);
$totalRows_Tipo_doc = mysql_num_rows($Tipo_doc);

$colname_partidas = "-1";
if (isset($_GET['CODIGO'])) {
  $colname_partidas = $_GET['CODIGO'];
}
mysql_select_db($database_conexion, $conexion);
//$query_partidas = sprintf("SELECT ID_PARTIDA AS ID, DESCRIPCION_COMPLETA, MONTO_ESTIMADO_DISPONIBLE FROM vista_partidas WHERE TIPO = 2 AND COD_PROYECTO = %s", GetSQLValueString($colname_partidas, "text"));
$query_partidas = sprintf("SELECT a.*,
	a.MONTO_ESTIMADO-IFNULL(b.monto_asignado_dinamico,0) AS MONTO_ASIGNADO_DISPONIBLE_DINAMICO,
	a.MONTO_ESTIMADO-IFNULL(b.monto_pagado_dinamico,0) AS MONTO_PAGADO_DISPONIBLE_DINAMICO
FROM vista_partidas a
LEFT JOIN 
(SELECT id_partida,
	SUM(monto_documento) AS monto_asignado_dinamico,
	SUM(monto_pagado) AS monto_pagado_dinamico
FROM  vista_documentos
GROUP BY id_partida) AS b
ON a.ID_PARTIDA=b.ID_PARTIDA WHERE TIPO = 2 AND COD_PROYECTO = %s", GetSQLValueString($colname_partidas, "text"));


$partidas = mysql_query($query_partidas, $conexion) or die(mysql_error());
$row_partidas = mysql_fetch_assoc($partidas);
$totalRows_partidas = mysql_num_rows($partidas);

$colname_proyecto = "-1";
if (isset($_GET['CODIGO'])) {
  $colname_proyecto = $_GET['CODIGO'];
}
mysql_select_db($database_conexion, $conexion);
$query_proyecto = sprintf("SELECT * FROM proyectos WHERE CODIGO = %s", GetSQLValueString($colname_proyecto, "text"));
$proyecto = mysql_query($query_proyecto, $conexion) or die(mysql_error());
$row_proyecto = mysql_fetch_assoc($proyecto);
$totalRows_proyecto = mysql_num_rows($proyecto);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<?php //include('../include/header.php'); ?>
<script src="../js/jquery-1.4.2.min.js" language="javascript"></script>
<script src="../js/jquery-ui-1.8.5.custom.min.js" language="javascript"></script>
<script src="../js/jquery.ui.datepicker-es.js" language="javascript"></script>
<script src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js" language="javascript"></script>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="../js/jquery.autocomplete.css" /> 
<link href="../js/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
	<style>
	.ui-button { margin-left: -1px; }
	.ui-button-icon-only .ui-button-text { padding: 0.35em; } 
	.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; width:850px; font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bolder }
	</style>
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
label.error { float: none; color: red; padding-left: .5em; vertical-align: top; font-family:Arial, Helvetica, sans-serif; size:12px }
</style>
<script>

function formatNumber(num)
{    
    var n = num.toString();
    var nums = n.split('.');
    var newNum = "";
    if (nums.length > 1)
    {
        var dec = nums[1].substring(0,2);
        newNum = nums[0] + "," + dec;
    }
    else
    {
    newNum = num;
    }
    //alert(newNum)
}

</script>


<script>
$(function() {
	$( "#fecha_emision" ).datepicker({
			changeMonth: true,
			changeYear: true,
			currentText: 'Now'
	});
	$( "#fecha_vencimiento" ).datepicker({
			changeMonth: true,
			changeYear: true,
			currentText: 'Now'
		});
		var myDate = new Date();
		var month = myDate.getMonth() + 1;
		var prettyDate = myDate.getDate()  + '/' + month + '/' + myDate.getFullYear();
		$("#fecha_emision").val(prettyDate);
		$("#fecha_vencimiento").val(prettyDate);
		
		$("#fecha_emision").change( function() {
  			$("#fecha_vencimiento").val($("#fecha_emision").val());
		});
		
		$("#exento").change( function() {
  			if ($("#exento").val()==""){
				$("#exento").val(0);
					var value = $(this).val();
	//var total_impuesto = valor*impuesto/100;
      //$("#total_impuesto").val(value*.07);
	  $("#total").val(Math.round(100*(parseFloat(value)+parseFloat($("#total_impuesto").val())+parseFloat($("#bruto").val())))/100);
				};
				});
		
		$("#bruto").change( function() {
  			if ($("#bruto").val()==""){
				$("#bruto").val(0);
					var value = $(this).val();
	var totalimpuesto = value*.07;
      $("#total_impuesto").val(totalimpuesto.toFixed(2));
	  $("#total").val(Math.round(100*(parseFloat(value)+parseFloat($("#total_impuesto").val())+parseFloat($("#exento").val())))/100);
			};
		});
				
		
	$("#exento").keyup(function () {
	//var impuesto = $("#impuesto").val();
	var value = $(this).val();
	//var total_impuesto = valor*impuesto/100;
      //$("#total_impuesto").val(value*.07);
	  $("#total").val(Math.round(100*(parseFloat(value)+parseFloat($("#total_impuesto").val())+parseFloat($("#bruto").val())))/100);
    }).keyup();
	
    $("#bruto").keyup(function () {
	//var impuesto = $("#impuesto").val();
	var value = $(this).val();
	var totalimpuesto = value*.07;
      $("#total_impuesto").val(totalimpuesto.toFixed(2));
	  $("#total").val(Math.round(100*(parseFloat(value)+parseFloat($("#total_impuesto").val())+parseFloat($("#exento").val())))/100);
    }).keyup();
	

   $("#form1").validate( {
   	messages: 	{
			proveedor: "Selecciones un proveedor",
			fecha_emision: "Selecciones una fecha",
			fecha_vencimiento: "Selecciones una fecha",
			total: "Introduzca los montos"
			},
			rules: {
    				total: {
      			required: true,
      			min: 0.01
    				}
  			}
	})



		
	});
	
	</script>
		<script>
	(function( $ ) {
		$.widget( "ui.combobox2", {
			_create: function() {
				var self = this,
					select = this.element.hide(),
					selected = select.children( ":selected" ),
					value = selected.val() ? selected.text() : "";
				var input = this.input = $( "<input>" )
					.insertAfter( select )
					.val( value )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: function( request, response ) {
							var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
							response( select.children( "option" ).map(function() {
								var text = $( this ).text();
								if ( this.value && ( !request.term || matcher.test(text) ) )
									return {
										label: text.replace(
											new RegExp(
												"(?![^&;]+;)(?!<[^<>]*)(" +
												$.ui.autocomplete.escapeRegex(request.term) +
												")(?![^<>]*>)(?![^&;]+;)", "gi"
											), "<strong>$1</strong>" ),
										value: text,
										option: this
									};
							}) );
						},
						select: function( event, ui ) {
							ui.item.option.selected = true;
							self._trigger( "selected", event, {
								item: ui.item.option
							});
						},
						change: function( event, ui ) {
							if ( !ui.item ) {
								var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
									valid = false;
								select.children( "option" ).each(function() {
									if ( $( this ).text().match( matcher ) ) {
										this.selected = valid = true;
										return false;
									}
								});
								if ( !valid ) {
									// remove invalid value, as it didn't match anything
									$( this ).val( "" );
									select.val( "" );
									input.data( "autocomplete" ).term = "";
									return false;
								}
							}
						}
					})
				

				input.data( "autocomplete" )._renderItem = function( ul, item ) {
					return $( "<li></li>" )
						.data( "item.autocomplete", item )
						.append( "<a>" + item.label + "</a>" )
						.appendTo( ul );
				};

				
			},

			destroy: function() {
				this.input.remove();
				this.button.remove();
				this.element.show();
				$.Widget.prototype.destroy.call( this );
			}
		});
	})( jQuery );

	$(function() {
		$( "#combobox2" ).combobox();
		$( "#toggle" ).click(function() {
			$( "#combobox2" ).toggle();
		});
	});
	</script>
	<script>
	(function( $ ) {
		$.widget( "ui.combobox", {
			_create: function() {
				var self = this,
					select = this.element.hide(),
					selected = select.children( ":selected" ),
					value = selected.val() ? selected.text() : "";
				var input = this.input = $( "<input>" )
					.insertAfter( select )
					.val( value )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: function( request, response ) {
							var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
							response( select.children( "option" ).map(function() {
								var text = $( this ).text();
								if ( this.value && ( !request.term || matcher.test(text) ) )
									return {
										label: text.replace(
											new RegExp(
												"(?![^&;]+;)(?!<[^<>]*)(" +
												$.ui.autocomplete.escapeRegex(request.term) +
												")(?![^<>]*>)(?![^&;]+;)", "gi"
											), "<strong>$1</strong>" ),
										value: text,
										option: this
									};
							}) );
						},
						select: function( event, ui ) {
							ui.item.option.selected = true;
							self._trigger( "selected", event, {
								item: ui.item.option
							});
						},
						change: function( event, ui ) {
							if ( !ui.item ) {
								var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
									valid = false;
								select.children( "option" ).each(function() {
									if ( $( this ).text().match( matcher ) ) {
										this.selected = valid = true;
										return false;
									}
								});
								if ( !valid ) {
									// remove invalid value, as it didn't match anything
									$( this ).val( "" );
									select.val( "" );
									input.data( "autocomplete" ).term = "";
									return false;
								}
							}
						}
					})
				

				input.data( "autocomplete" )._renderItem = function( ul, item ) {
					return $( "<li></li>" )
						.data( "item.autocomplete", item )
						.append( "<a>" + item.label + "</a>" )
						.appendTo( ul );
				};

				
			},

			destroy: function() {
				this.input.remove();
				this.button.remove();
				this.element.show();
				$.Widget.prototype.destroy.call( this );
			}
		});
	})( jQuery );

	$(function() {
		$( "#combobox" ).combobox();
		$( "#toggle" ).click(function() {
			$( "#combobox" ).toggle();
		});
	});
	</script>


<link href="../css/form.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/menu_style.css" type="text/css" media="all" />
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>

<?php $opcion_menu=2; ?>


<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>"><table width="1100" align="center" class="ui-widget-header" >
	<tr>
	<td width="1100" align="center" class="textos_form"><div class="titulo_formulario">Nuevo Documento - <?php echo $row_proyecto['NOMBRE']; ?></div></tr></table>
	<table width="1100" border="0" align="center" cellpadding="0" cellspacing="2" bgcolor="#F0F0F0" >
		<tr>
			<td width="100" bgcolor="#F0F0F0" class="textos_form">Proveedor:</td>
			<td colspan="2"><select name="id_pro_cli" id="combobox" style="width: 300px; font-size:10px" width="300">
				<option value="" <?php if (!(strcmp("", 0))) {echo "selected=\"selected\"";} ?>></option>
				<?php
do {  
?>
				<option value="<?php echo $row_proveeedor['ID_PRO_CLI']?>"<?php if (!(strcmp($row_proveeedor['ID_PRO_CLI'], 0))) {echo "selected=\"selected\"";} ?>>[ID:<?php echo $row_proveeedor['ID_PRO_CLI']?>] <?php echo $row_proveeedor['NOMBRE']?></option>
				<?php
} while ($row_proveeedor = mysql_fetch_assoc($proveeedor));
  $rows = mysql_num_rows($proveeedor);
  if($rows > 0) {
      mysql_data_seek($proveeedor, 0);
	  $row_proveeedor = mysql_fetch_assoc($proveeedor);
  }
?>
			</select>
			<input name="COD_PROYECTO" type="hidden" id="COD_PROYECTO" value="<?php echo $_GET['CODIGO']; ?>" /></td>
		</tr>
		<tr>
			<td bgcolor="#F0F0F0" class="textos_form">Tipo:</td>
			<td colspan="2"><label for="tipo"></label>
				<select name="tipo" class="textos_form" id="tipo">
					<?php
do {  
?>
					<option value="<?php echo $row_Tipo_doc['TIPO']?>"><?php echo $row_Tipo_doc['DESCRIPCION']?></option>
					<?php
} while ($row_Tipo_doc = mysql_fetch_assoc($Tipo_doc));
  $rows = mysql_num_rows($Tipo_doc);
  if($rows > 0) {
      mysql_data_seek($Tipo_doc, 0);
	  $row_Tipo_doc = mysql_fetch_assoc($Tipo_doc);
  }
?>
				</select></td>
		</tr>
		<tr>
			<td bgcolor="#F0F0F0" class="textos_form">Numero:</td>
			<td colspan="2"><label for="numero"></label>
			  <span id="sprytextfield1">
			  <input name="numero" type="text" class="textos_form_derecha" id="numero" />
		    <span class="textfieldRequiredMsg">Introduzca el Numero</span></span></td>
		</tr>
		<tr>
			<td bgcolor="#F0F0F0" class="textos_form">Fecha Emision:</td>
			<td colspan="2"><label for="fecha_emision"></label>
				<input name="fecha_emision" type="text" class="textos_form required" id="fecha_emision" /></td>
		</tr>
		<tr>
			<td bgcolor="#F0F0F0" class="textos_form">Fecha Vencimiento:</td>
			<td colspan="2"><label for="fecha_vencimiento"></label>
				<input name="fecha_vencimiento" type="text" class="textos_form required" id="fecha_vencimiento" /></td>
		</tr>
		<tr>
			<td bgcolor="#F0F0F0" class="textos_form">Descripcion:</td>
			<td colspan="2"><label for="descripcion"></label>
				<textarea name="descripcion" cols="45" rows="5" class="textos_form" id="descripcion"></textarea></td>
		</tr>
		<tr>
			<td bgcolor="#F0F0F0" class="textos_form"><p>Partida:</p>
	      <p class="ui-state-error-text">&nbsp;</p></td>
			<td colspan="2"><span class="ui-state-error-text"></span>
			  <table border="0" width="100%" align="left" cellpadding="0" cellspacing="2" bgcolor="#F0F0F0">
				  <tr>
						<td align="left" bgcolor="#F0F0F0">		<select id="combobox2" name="id_partida" width="300" style="width: 300px; font-size:10px">
			<option value="" <?php if (!(strcmp(" ", 0))) {echo "selected=\"selected\"";} ?>></option>
			<?php
do {  
?>
	
    		<!--<option value="<?php echo $row_partidas['ID_PARTIDA']?>"<?php if (!(strcmp($row_partidas['ID_PARTIDA'], 0))) {echo "selected=\"selected\"";} ?>>[ID:<?php echo $row_partidas['ID_PARTIDA']?>] - [Disponible:<?php echo number_format($row_partidas['MONTO_ASIGNADO_DISPONIBLE'],2)?>] - <?php echo $row_partidas['DESCRIPCION_COMPLETA']?> </option>-->
            <option value="<?php echo $row_partidas['ID_PARTIDA']?>"<?php if (!(strcmp($row_partidas['ID_PARTIDA'], 0))) {echo "selected=\"selected\"";} ?>>[ID:<?php echo $row_partidas['ID_PARTIDA']?>] - [Disponible:<?php echo number_format($row_partidas['MONTO_ASIGNADO_DISPONIBLE_DINAMICO'],2)?>] - <?php echo $row_partidas['DESCRIPCION_COMPLETA']?> </option>
			<?php
} while ($row_partidas = mysql_fetch_assoc($partidas));
  $rows = mysql_num_rows($partidas);
  if($rows > 0) {
      mysql_data_seek($partidas, 0);
	  $row_partidas = mysql_fetch_assoc($partidas);
  }
?>
		</select></td>
					</tr>
					<tr>
						<td align="center" bgcolor="#F0F0F0"><!-- <table width="400" border="0" cellspacing="5" cellpadding="5">
              <tr>
                <td align="center"><input name="button4" type="submit" class="botones" id="button4" value="Ver Reporte" /></td>
                <td align="center">&nbsp;</td>
                <td align="center"><input name="button4" type="submit" class="botones" id="button6" value="Reiniciar" /></td>
              </tr>
            </table> --><br /></td>
					</tr>
					<tr>
						<td align="center" bgcolor="#CCCCCC"></td>
					</tr>
					<tr>
						<td align="center" bgcolor="#FFFFFF"><!--<table width="400" border="0" cellspacing="5" cellpadding="5">
              <tr>
                <td align="center"><input name="button" type="submit" class="botones" id="button" value="Imprimir" /></td>
                <td align="center"><input name="button2" type="submit" class="botones" id="button2" value="Exp. a Excel" /></td>
                <td align="center"><input name="button3" type="submit" class="botones" id="button3" value="Exp. a PDF" /></td>
              </tr>
            </table>--></td>
					</tr>
				</table></td>
		</tr>
		<tr>
			<td rowspan="5" valign="middle" bgcolor="#F0F0F0" class="textos_form">Monto:</td>
			<td width="446" class="textos_form">Monto Exento:</td>
			<td width="538"><label for="exento"></label>
				<input name="exento" type="text" class="textos_form_derecha" id="exento" value="0" /></td>
		</tr>
		<tr>
			<td><span class="textos_form">Monto Gravable:</span></td>
			<td width="538"><input name="bruto" type="text" class="textos_form_derecha" id="bruto" value="0" /></td>
		</tr>
		<tr>
			<td><span class="textos_form">Impuesto:</span></td>
			<td><label for="total_impuesto"></label>
				<input name="total_impuesto" type="text" class="textos_form_derecha" id="total_impuesto" value="0" readonly /></td>
		</tr>
		<tr>
			<td class="textos_form">Total:</td>
			<td><label for="total"></label>
				<input name="total" type="text" class="textos_form_derecha required" id="total" value="0" readonly /></td>
		</tr>
				<tr>
			<td colspan="2" class="textos_form" align="center"><input type="hidden" name="usuarioactivo" id="usuarioactivo" value="<?php echo $_SESSION['i']; ?>" />
			  <?php if (validador1(12,$_SESSION['i'],"inc")==1){ ?><input name="button" type="submit" class="ui-button" id="button" value="Guardar" /><?php } ?></td>
		</tr>
	</table>
	<input type="hidden" name="MM_insert" value="form1" />
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
</script>
</body>
</html>
<?php
mysql_free_result($proveeedor);

mysql_free_result($Tipo_doc);

mysql_free_result($proyecto);

mysql_free_result($partidas);

//mysql_free_result($partida);
?>
