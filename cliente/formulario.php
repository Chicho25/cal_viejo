<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/redmond/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="../css.css" rel="stylesheet" type="text/css" />
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="textos_form">Codigo:</td>
      <td class="campos"><span id="sprytextfield1">
      <input name="codigo" type="text" value="" size="32" />
      <span class="textfieldRequiredMsg">Coloque un valor</span><span class="textfieldInvalidFormatMsg">Debe ser numerico.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="textos_form">Razon social:</td>
      <td class="campos"><span id="sprytextfield2">
        <input type="text" name="razon_social" value="" size="32" />
      <span class="textfieldRequiredMsg">Coloque un valor</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="textos_form">Alias:</td>
      <td class="campos"><input type="text" name="alias" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="textos_form">RUC:</td>
      <td class="campos"><span id="sprytextfield3">
        <input type="text" name="RUC" value="" size="32" />
      <span class="textfieldRequiredMsg">Coloque un valor</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="textos_form">NIT:</td>
      <td class="campos"><span id="sprytextfield4">
        <input type="text" name="NIT" value="" size="32" />
      <span class="textfieldRequiredMsg">Coloque un valor</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="textos_form">Digito verificador:</td>
      <td class="campos"><span id="sprytextfield5">
        <input type="text" name="digito_verificador" value="" size="32" />
      <span class="textfieldRequiredMsg">Coloque un valor</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="textos_form">Telefono oficina 1:</td>
      <td class="campos"><span id="sprytextfield6">
        <input type="text" name="telefono_oficina1" value="" size="32" />
      <span class="textfieldRequiredMsg">Coloque un valor</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="textos_form">Telefono oficina 2:</td>
      <td class="campos"><input type="text" name="telefono_oficina2" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="textos_form">Fax:</td>
      <td class="campos"><input type="text" name="fax" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="textos_form">Email Principal:</td>
      <td class="campos"><span id="sprytextfield7">
        <input type="text" name="email1" value="" size="32" />
      <span class="textfieldRequiredMsg">Coloque un valor</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="textos_form">EmailSecundario:</td>
      <td class="campos"><input type="text" name="email2" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="textos_form">Pagina web:</td>
      <td class="campos"><input type="text" name="pagina_web" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="textos_form">Direccion Principal:</td>
      <td class="campos"><span id="sprytextfield8">
        <input type="text" name="direccion1" value="" size="32" />
      <span class="textfieldRequiredMsg">Coloque un valor</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="textos_form">Direccion Secundaria:</td>
      <td class="campos"><input type="text" name="direccion2" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="textos_form">Persona contacto:</td>
      <td class="campos"><span id="sprytextfield9">
        <input type="text" name="persona_contacto" value="" size="32" />
      <span class="textfieldRequiredMsg">Coloque un valor</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="textos_form">Telefono contacto:</td>
      <td class="campos"><input type="text" name="telefono_contacto" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" class="botones" value="Insertar" /></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7");
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8");
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9");
</script>
</body>
</html>