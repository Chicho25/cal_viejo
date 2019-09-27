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

mysql_select_db($database_conexion, $conexion);
$query_proveedores = "SELECT idprovecliente, razon_social FROM proveedores_clientes ORDER BY razon_social ASC";
$proveedores = mysql_query($query_proveedores, $conexion) or die(mysql_error());
$row_proveedores = mysql_fetch_assoc($proveedores);
$totalRows_proveedores = mysql_num_rows($proveedores);

mysql_select_db($database_conexion, $conexion);
$query_documentos = "SELECT iddocumento, nombre FROM documentos ORDER BY nombre ASC";
$documentos = mysql_query($query_documentos, $conexion) or die(mysql_error());
$row_documentos = mysql_fetch_assoc($documentos);
$totalRows_documentos = mysql_num_rows($documentos);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../a/menu_style.css" type="text/css" media="all" />
<link href="../css.css" rel="stylesheet" type="text/css" />
<title>Calpe</title>
<link href="../css/redmond/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<!-- ALL jQuery Tools. No jQuery library -->
<script src="http://cdn.jquerytools.org/1.2.5/all/jquery.tools.min.js"></script>

        <script src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.js" type="text/javascript"> 
        </script> 
        <script src="js/jquery.formContact.js" type="text/javascript"> 
        </script>
<script src="../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
        <script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
        <script src="../../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
    <script type="text/javascript">
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
        </script>
<link href="../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
</head>

<body onload="MM_preloadImages('../image/Add_over.png')">
<?php $opcion_menu=3; ?>
<?php include("../include/menu.php"); ?>
<form action="" method="get">
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="current" >
  <tr>
    <td width="100" align="right" class="textos_form">Proveedor:
      <label for="textfield"></label></td>
    <td width="114"><span id="spryselect1">
      <select name="select" class="campos" id="select">
        <option value="0">Seleccione</option>
        <?php
do {  
?>
        <option value="<?php echo $row_proveedores['idprovecliente']?>"><?php echo $row_proveedores['razon_social']?></option>
        <?php
} while ($row_proveedores = mysql_fetch_assoc($proveedores));
  $rows = mysql_num_rows($proveedores);
  if($rows > 0) {
      mysql_data_seek($proveedores, 0);
	  $row_proveedores = mysql_fetch_assoc($proveedores);
  }
?>
      </select>
    </span></td>
    <td width="20"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image5','','../image/Add_over.png',1)" id="form1" onClick="window.open('../proveedor/formulario.php','mywindow','width=400,height=600')"><img src="../image/Add.png" name="Image5" width="20" height="20" border="0" id="Image5" /></a></td>
    <td width="100" align="right" class="textos_form">Tipo de Documento:</td>
    <td width="114"><span id="spryselect2">
      <select name="select2" class="campos" id="select2">
        <option value="0">Seleccione</option>
        <?php
do {  
?>
        <option value="<?php echo $row_documentos['iddocumento']?>"><?php echo $row_documentos['nombre']?></option>
        <?php
} while ($row_documentos = mysql_fetch_assoc($documentos));
  $rows = mysql_num_rows($documentos);
  if($rows > 0) {
      mysql_data_seek($documentos, 0);
	  $row_documentos = mysql_fetch_assoc($documentos);
  }
?>
      </select>
    </span></td>
    <td width="20">&nbsp;</td>
    <td width="100" align="right" class="textos_form">Descripcion:</td>
    <td width="212"><input name="textfield3" type="text" class="campos" id="textfield3" /></td>
  </tr>
  <tr>
    <td colspan="8" align="center" class="textos_form"><label for="textarea2"></label>
    <textarea name="textarea2" id="textarea2" cols="120" rows="5"></textarea></td>
  </tr>
    <tr>
    <td width="100" align="right" class="textos_form">Partida:
      <label for="textfield"></label></td>
    <td><span id="sprytextfield1">
      <input name="textfield" type="text" class="campos" id="textfield" />
      </span></td>
    <td><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image7','','../image/Add_over.png',1)"><img src="../image/Add.png" name="Image7" width="20" height="20" border="0" id="Image7" /></a></td>
    <td width="100" align="right" class="textos_form">Numero de Doc.:</td>
    <td colspan="2" class="textos_form">
    <input name="textfield2" type="text" class="campos" id="textfield2" /><br />
      
      
        <input name="checkbox" type="checkbox" class="current" id="checkbox" />
        <label for="checkbox">Asignar automaticamente</label>
      </td>
    <td align="right" class="textos_form">Concepto:</td>
    <td><label for="textarea"></label>
      <span id="sprytextarea1">
      <textarea name="textarea" cols="45" rows="5" class="campos" id="textarea"></textarea>
      </span></td>
  </tr>
    <tr>
      <td width="100">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td width="100">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
      <tr>
    <td width="100" align="right" class="textos_form">Fecha Doc:
      <label for="textfield"></label></td>
    <td colspan="2"><input type="date"/></td>
    <td width="100" align="right" class="textos_form">Fecha Venc.:</td>
    <td colspan="2"><input type="date" name="mydate" /></td>
    <td align="right" class="textos_form">Dias:</td>
    <td><input name="textfield3" type="text" class="campos" id="textfield3" /></td>
  </tr>
        <tr>
    <td width="100" align="right" class="textos_form">Monto:
      <label for="textfield"></label></td>
    <td colspan="2"><input name="textfield4" type="text" class="campos" id="textfield4" /></td>
    <td width="100" align="right" class="textos_form">Impuesto:</td>
    <td><select name="select3" class="campos" id="select3">
      <option value="01"> ITBMS 7%</option>
    </select></td>
    <td><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image8','','../image/Add_over.png',1)"><img src="../image/Add.png" name="Image8" width="20" height="20" border="0" id="Image8" /></a></td>
    <td align="right" class="textos_form">Monto+Imp:</td>
    <td><input name="textfield6" type="text" class="campos" id="textfield6" /></td>
  </tr>
        <tr>
          <td colspan="8" align="center" class="textos_form"><input name="button" type="submit" class="botones" id="button" value="Guardar" /></td>
        </tr>
</table>
</form>

<!-- HTML5 date input --><!-- make it happen --> 
	<script> 
	// the french localization
$.tools.dateinput.localize("es",  {
   months:        'enero,febrero,marzo,abril,mayo,junio,julio,agosto,' +
                   	'septiembre,octubre,noviembre,diciembre',
   shortMonths:   'ene,feb,mar,abr,may,jun,jul,ago,sep,oct,nov,dic',
   days:          'domingo,lunes,martes,miercoles,jueves,viernes,sabado',
   shortDays:     'dom,lun,mar,mir,jue,vie,sab'
});
	
	
	$(":date").dateinput({ 
	lang: 'es', 
	format: 'dddd dd, mmmm yyyy',
	offset: [30, 0]
});
	</script>
<script>
$(document).ready(function(){
		   	
			   $("#form1").formContact({
                formid: 'formulario1',
               });
			
		   });
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
</script>
</body>
</html>
<?php
mysql_free_result($proveedores);

mysql_free_result($documentos);
?>
