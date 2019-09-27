<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css.css" rel="stylesheet" type="text/css" />
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="textos_form">Nombre:</td>
      <td class="campos"><span id="sprytextfield1">
        <input name="nombre" type="text" class="campos" value="" size="32" />
      <span class="textfieldRequiredMsg">Coloque un valor</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="textos_form">Proveedores:</td>
      <td><input type="checkbox" name="status_proveedores" value="" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="textos_form">Clientes:</td>
      <td><input type="checkbox" name="status_clientes" value="" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" class="botones" value="Insertar" /></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
</script>
</body>
</html>