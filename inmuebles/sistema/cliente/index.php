
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
<title>Untitled Document</title>
<script src="../js/jquery-1.4.2.min.js" language="javascript"></script>
<script src="../js/jquery-ui-1.8.5.custom.min.js" language="javascript"></script>
<script src="../js/jquery.ui.datepicker-es.js" language="javascript"></script>
<script src="../js/jquery.infieldlabel.min.js" language="javascript"></script>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<title>Untitled Document</title>
<link href="../js/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="../css/form.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {

}
#form1 #listado {
	text-decoration: none;
}
</style>
	<style>
	.ui-button { margin-left: -1px; }
	.ui-button-icon-only .ui-button-text { padding: 0.35em; } 
	.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; width:600px; font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bolder }
	body, td, th {
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
}
</style>






</head>


<body><?php $opcion_menu=7; ?>
<?php include("../include/menu.php"); ?><table width="1100" align="center" class="ui-widget-header" >
	<tr>
	<td width="1100" align="center" class="textos_form"><div class="titulo_formulario">Buscar Cliente</div></tr></table>
<table width="1100" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#999999">
	<tr class="textos_form">
		<td width="50" align="center" bgcolor="#FFFFFF">
		<table width="100%" border="0" cellspacing="0" cellpadding="4">
			<tr>
				<td align="right" bgcolor="#E5E5E5"><input type="button" name="button3" id="button3" value="Insertar" onClick="parent.location='add.php'"/></td>
				<td bgcolor="#E5E5E5"><input type="button" name="button" id="button" value="Buscar" onClick="parent.location='index.php'"/></td>
			</tr>
		</table>
		</td>
	</tr>
</table>
<form action="listado.php" method="get" name="form1" id="form1">
<table width="1100" border="0" cellpadding="0" cellspacing="2" align="center" bgcolor="#F0F0F0">
	<tr>
		<td width="50%" align="right" bgcolor="#F0F0F0" class="textos_form">Cliente:
			<label for="TIPO"></label></td>
		<td align="left" bgcolor="#F0F0F0" class="textos_form"><label for="PROVEEDOR"></label>
			<input name="PROVEEDOR" type="text" id="PROVEEDOR" size="50" />
			<input name="col" type="hidden" id="col" value="ID_PRO_CLI" />
			<input name="orden" type="hidden" id="orden" value="1" /></td>
		</tr>
	<tr>
		<td width="50%" align="right" bgcolor="#F0F0F0" class="textos_form">Tipo:</td>
		<td align="left" bgcolor="#F0F0F0" class="textos_form"><label for="TIPO"></label>
			<select name="TIPO" id="TIPO">
				<option selected="selected">Todos</option>
				<option value="2">Cliente</option>
				<option value="3">Proveedor-Cliente</option>
			</select></td>
	</tr>
	<tr>
		<td width="50%" align="right" bgcolor="#F0F0F0" class="textos_form">Contacto:</td>
		<td align="left" bgcolor="#F0F0F0" class="textos_form"><label for="CONTACTO"></label>
			<input name="CONTACTO" type="text" id="CONTACTO" size="50" />			<label for="TIPO"></label></td>
	</tr>
	<tr>
		<td width="50%" align="right" bgcolor="#F0F0F0" class="textos_form">Vendedor:</td>
		<td align="left" bgcolor="#F0F0F0" class="textos_form"><input name="VENDEDOR" type="checkbox" id="VENDEDOR" value="Si" />
	  <label for="VENDEDOR"></label></td>
	</tr>
	<tr>
		<td colspan="2" align="center" bgcolor="#F0F0F0" class="textos_form"><input name="button" type="submit" class="textos_form" id="button" value="Buscar" /></td>
	</tr>
</table>
</span>
</form>


</body>
</html>

