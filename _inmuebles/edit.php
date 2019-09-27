<?php
/*Definiciones*/
$formulario="inmuebles01";
?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE inmuebles_master SET ID_INMUEBLES_GRUPO=%s, CODIGO=%s, NOMBRE=%s, ID_INMUEBLES_TIPO=%s, AREA=%s, PRECIO_PREVENTA=%s, PRECIO_OFERTA=%s, PRECIO_REAL=%s, DISPONIBLE=%s, ID_PARTIDA_COMISION=%s, PORCENTAJE_COMISION=%s, DISPONIBLE=%s WHERE ID_INMUEBLES_MASTER=%s",
                       GetSQLValueString($_POST['ID_INMUEBLES_GRUPO'], "int"),
                       GetSQLValueString($_POST['CODIGO'], "text"),
                       GetSQLValueString($_POST['NOMBRE'], "text"),
                       GetSQLValueString($_POST['ID_INMUEBLES_TIPO'], "int"),
                       GetSQLValueString($_POST['AREA'], "double"),
                       GetSQLValueString($_POST['PRECIO_PREVENTA'], "double"),
                       GetSQLValueString($_POST['PRECIO_OFERTA'], "double"),
                       GetSQLValueString($_POST['PRECIO_REAL'], "double"),
                       GetSQLValueString(isset($_POST['DISPONIBLE']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['ID_PARTIDA_COMISION'], "int"),
                       GetSQLValueString($_POST['PORCENTAJE_COMISION'], "double"),
					   GetSQLValueString($_POST['DISPONIBLE'], "int"),
                       GetSQLValueString($_POST['ID_INMUEBLES_MASTER'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
}

mysql_select_db($database_conexion, $conexion);
$query_GRUPO = "SELECT * FROM inmuebles_grupo";
$GRUPO = mysql_query($query_GRUPO, $conexion) or die(mysql_error());
$row_GRUPO = mysql_fetch_assoc($GRUPO);
$totalRows_GRUPO = mysql_num_rows($GRUPO);

mysql_select_db($database_conexion, $conexion);
$query_TIPO = "SELECT * FROM inmuebles_tipo";
$TIPO = mysql_query($query_TIPO, $conexion) or die(mysql_error());
$row_TIPO = mysql_fetch_assoc($TIPO);
$totalRows_TIPO = mysql_num_rows($TIPO);

$colname_CONSULTA = "-1";
if (isset($_GET['ID_INMUEBLES_MASTER'])) {
  $colname_CONSULTA = $_GET['ID_INMUEBLES_MASTER'];
}
mysql_select_db($database_conexion, $conexion);
$query_CONSULTA = sprintf("SELECT * FROM inmuebles_master WHERE ID_INMUEBLES_MASTER = %s", GetSQLValueString($colname_CONSULTA, "int"));
$CONSULTA = mysql_query($query_CONSULTA, $conexion) or die(mysql_error());
$row_CONSULTA = mysql_fetch_assoc($CONSULTA);
$totalRows_CONSULTA = mysql_num_rows($CONSULTA);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<title>Untitled Document</title>
<?php include("../include/_js.php"); ?>
<?php include("../include/_css.php"); ?>
<style>
	.ui-button { margin-left: -1px; }
	.ui-button-icon-only .ui-button-text { padding: 0.35em; } 
	.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; width:850px; font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bolder }
</style>
<script src="../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
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

<link href="../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php $opcion_menu=2; ?>
<?php include("../include/menu.php"); ?>

  <table width="1100" align="center" class="ui-widget-header" >
    <tr>
      <td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Editar Inmueble</div>
    </tr>
  </table>
<?php include("_menu.php"); ?>

<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <table width="1100" align="center" cellpadding="4" cellspacing="1">
    <tr valign="baseline">
      <td colspan="3" align="right" nowrap="nowrap" bgcolor="#f3f3f3"><span class="textos_form">Grupo:</span></td>
      <td colspan="3" bgcolor="#f3f3f3"><span id="spryselect1">
        <select name="ID_INMUEBLES_GRUPO">
          <option value="" <?php if (!(strcmp("", $row_CONSULTA['ID_INMUEBLES_GRUPO']))) {echo "selected=\"selected\"";} ?>>Seleccione....</option>
          <?php
do {  
?>
          <option value="<?php echo $row_GRUPO['ID_INMUEBLES_GRUPO']?>"<?php if (!(strcmp($row_GRUPO['ID_INMUEBLES_GRUPO'], $row_CONSULTA['ID_INMUEBLES_GRUPO']))) {echo "selected=\"selected\"";} ?>><?php echo $row_GRUPO['NOMBRE']?></option>
          <?php
} while ($row_GRUPO = mysql_fetch_assoc($GRUPO));
  $rows = mysql_num_rows($GRUPO);
  if($rows > 0) {
      mysql_data_seek($GRUPO, 0);
	  $row_GRUPO = mysql_fetch_assoc($GRUPO);
  }
?>
        </select>
      </span>
        <label for="ID_INMUEBLES_MASTER"></label>
        <input name="ID_INMUEBLES_MASTER" type="hidden" id="ID_INMUEBLES_MASTER" value="<?php echo $_GET['ID_INMUEBLES_MASTER']; ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#f3f3f3"><span class="textos_form">Codigo:</span></td>
      <td align="left" nowrap="nowrap" bgcolor="#f3f3f3"><span id="sprytextfield1">
        <input type="text" name="CODIGO" value="<?php echo $row_CONSULTA['CODIGO']; ?>" size="8" />
      </span></td>
      <td align="right" nowrap="nowrap" bgcolor="#f3f3f3"><span class="textos_form">Nombre:</span></td>
      <td bgcolor="#f3f3f3"><span id="sprytextfield2">
        <input type="text" name="NOMBRE" value="<?php echo $row_CONSULTA['NOMBRE']; ?>" size="32" />
      </span></td>
      <td align="right" bgcolor="#f3f3f3"><span class="textos_form">Tipo:</span></td>
      <td width="177" bgcolor="#f3f3f3"><span id="spryselect2">
        <select name="ID_INMUEBLES_TIPO">
          <option value="" <?php if (!(strcmp("", $row_CONSULTA['ID_INMUEBLES_TIPO']))) {echo "selected=\"selected\"";} ?>>Seleccione....</option>
          <?php
do {  
?>
          <option value="<?php echo $row_TIPO['ID_INMUEBLES_TIPO']?>"<?php if (!(strcmp($row_TIPO['ID_INMUEBLES_TIPO'], $row_CONSULTA['ID_INMUEBLES_TIPO']))) {echo "selected=\"selected\"";} ?>><?php echo $row_TIPO['NOMBRE']?></option>
          <?php
} while ($row_TIPO = mysql_fetch_assoc($TIPO));
  $rows = mysql_num_rows($TIPO);
  if($rows > 0) {
      mysql_data_seek($TIPO, 0);
	  $row_TIPO = mysql_fetch_assoc($TIPO);
  }
?>
        </select>
      </span></td>
    </tr>
    <tr valign="baseline">
      <td colspan="3" align="right" nowrap="nowrap" bgcolor="#f3f3f3"><span class="textos_form">Area:</span></td>
      <td colspan="3" bgcolor="#f3f3f3"><span id="sprytextfield3">
        <input type="text" name="AREA" value="<?php echo $row_CONSULTA['AREA']; ?>" size="32"  />
      <span class="textfieldInvalidFormatMsg">Debe ser numerico</span></span></td>
    </tr>
    <tr valign="baseline">
      <td width="205" align="right" nowrap="nowrap" bgcolor="#f3f3f3"><span class="textos_form">Precio Preventa:</span></td>
      <td width="215" align="left" nowrap="nowrap" bgcolor="#f3f3f3"><span id="sprytextfield4">
      <input type="text" name="PRECIO_PREVENTA" value="<?php echo $row_CONSULTA['PRECIO_PREVENTA']; ?>" size="8" />
<span class="textfieldInvalidFormatMsg">Debe ser numerico</span></span></td>
      <td width="101" align="right" nowrap="nowrap" bgcolor="#f3f3f3"><span class="textos_form">Precio Oferta:</span></td>
      <td width="246" align="left" nowrap="nowrap" bgcolor="#f3f3f3"><span id="sprytextfield5">
        <input type="text" name="PRECIO_OFERTA" value="<?php echo $row_CONSULTA['PRECIO_OFERTA']; ?>" size="6" />
      <span class="textfieldInvalidFormatMsg">Debe ser numerico</span></span></td>
      <td width="99" align="right" nowrap="nowrap" bgcolor="#f3f3f3"><span class="textos_form">Precio Real:</span></td>
      <td align="left" bgcolor="#f3f3f3"><span id="sprytextfield6">
      <input type="text" name="PRECIO_REAL" value="<?php echo $row_CONSULTA['PRECIO_REAL']; ?>" size="6" />
<span class="textfieldInvalidFormatMsg">Debe ser numerico</span></span></td>
    </tr>
    <tr valign="baseline">
      <td colspan="3" align="right" nowrap="nowrap" bgcolor="#f3f3f3"><span class="textos_form">Disponible:</span></td>
      <td colspan="3" bgcolor="#f3f3f3"><span class="textos_form">
        <input name="DISPONIBLE" type="checkbox" id="DISPONIBLE" value="1" <?php if (!(strcmp($row_CONSULTA['DISPONIBLE'],1))) {echo "checked=\"checked\"";} ?> />
        </span></td>
    </tr>
    <tr valign="baseline">
      <td colspan="6" align="center" nowrap="nowrap" bgcolor="#f3f3f3"><span class="textos_form">Partida Comision:</span><span class="textos_form">
        <?php 
		mysql_select_db($database_conexion, $conexion);
		$query_partidas = "SELECT ID, DESCRIPCION_COMPLETA FROM partidas WHERE TIPO = 2";
		$partidas = mysql_query($query_partidas, $conexion) or die(mysql_error());
		$row_partidas = mysql_fetch_assoc($partidas);
		$totalRows_partidas = mysql_num_rows($partidas);


    ?>
        <span id="spryselect3">
        <select id="combobox" name="ID_PARTIDA_COMISION" width="300" style="width: 300px; font-size:10px">
          <option value="" <?php if (!(strcmp("", $row_CONSULTA['ID_PARTIDA_COMISION']))) {echo "selected=\"selected\"";} ?>></option>
          <?php
do {  
?>
          <option value="<?php echo $row_partidas['ID']?>"<?php if (!(strcmp($row_partidas['ID'], $row_CONSULTA['ID_PARTIDA_COMISION']))) {echo "selected=\"selected\"";} ?>><?php echo $row_partidas['DESCRIPCION_COMPLETA']?></option>
          <?php
} while ($row_partidas = mysql_fetch_assoc($partidas));
  $rows = mysql_num_rows($partidas);
  if($rows > 0) {
      mysql_data_seek($partidas, 0);
	  $row_partidas = mysql_fetch_assoc($partidas);
  }
?>
        </select>
        <span class="selectRequiredMsg">Seleccione</span></span>
        <?php
	mysql_free_result($partidas);

mysql_free_result($GRUPO);

mysql_free_result($CONSULTA);
	?>
      </span></td>
    </tr>
    <tr valign="baseline">
      <td colspan="3" align="right" nowrap="nowrap" bgcolor="#f3f3f3"><span class="textos_form">Comision %:</span></td>
      <td colspan="3" bgcolor="#f3f3f3"><span id="sprytextfield7">
        <input type="text" name="PORCENTAJE_COMISION" value="<?php echo $row_CONSULTA['PORCENTAJE_COMISION']; ?>" size="6" />
      <span class="textfieldInvalidFormatMsg">Debe ser numerico</span></span></td>
    </tr>
    <tr valign="baseline">
      <td colspan="6" align="center" bgcolor="#999999"><span class="textos_form">
        <input type="submit" class="ui-widget-header" value="Guardar" />
        <input name="Reset" type="reset" class="ui-state-hover" id="button" value="Reiniciar" />
        </span></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
<p>&nbsp;</p>
<?php include("../include/_foot.php"); ?>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "real", {isRequired:false, validateOn:["change"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "real", {isRequired:false, validateOn:["change"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "real", {isRequired:false, validateOn:["change"]});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "real", {validateOn:["change"], isRequired:false});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "real", {isRequired:false, validateOn:["change"]});
</script>
</body>
</html>
