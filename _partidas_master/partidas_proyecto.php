<?php require_once('../Connections/conexion.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "0,1,2,3,4,5,6,7,8,9";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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
$query_proveeedor = "SELECT * FROM pro_cli WHERE tipo=1 or tipo=3";
$proveeedor = mysql_query($query_proveeedor, $conexion) or die(mysql_error());
$row_proveeedor = mysql_fetch_assoc($proveeedor);
$totalRows_proveeedor = mysql_num_rows($proveeedor);

mysql_select_db($database_conexion, $conexion);
$query_proyectos = "SELECT CODIGO, NOMBRE FROM proyectos";
$proyectos = mysql_query($query_proyectos, $conexion) or die(mysql_error());
$row_proyectos = mysql_fetch_assoc($proyectos);
$totalRows_proyectos = mysql_num_rows($proyectos);

mysql_select_db($database_conexion, $conexion);
$query_tipo = "SELECT TIPO, DESCRIPCION FROM doc_tipo WHERE MODULO = 1";
$tipo = mysql_query($query_tipo, $conexion) or die(mysql_error());
$row_tipo = mysql_fetch_assoc($tipo);
$totalRows_tipo = mysql_num_rows($tipo);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
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
input {
	border: 1px solid #ccc;
	color: #999;
	font: inherit;
}
input:focus, input.focused {
	border-color: #000;
	color: #333;
}
</style>
<script>
$(function() {
	var projects = [
		<?php do { 
		$nombre=$row_proveeedor['NOMBRE'];
		$nombre=ucwords(strtolower($nombre));
		?>
		{
			value: "<?php echo $row_proveeedor['ID_PRO_CLI']; ?>",
			label: "<?php echo $nombre; ?>",
			desc: "Contacto: <?php echo ucwords($row_proveeedor['CONTACTO']); ?>",
		},
		<?php } while ($row_proveeedor = mysql_fetch_assoc($proveeedor)); ?>
		{
			value: "sizzlejs",
			label: "Sizzle JS",
			desc: "a pure-JavaScript CSS selector engine",
		}
	];

	$( "#project" ).autocomplete({
		minLength: 0,
		source: projects,
		focus: function( event, ui ) {
			$( "#project" ).val( ui.item.label );
			return false;
		},
		select: function( event, ui ) {
			$( "#project" ).val( ui.item.label );
			$( "#elegido" ).val( ui.item.value );
			$( "#project-description" ).html( ui.item.desc );
			return false;
		}
	})
	
	.data( "autocomplete" )._renderItem = function( ul, item ) {
		return $( "<li></li>" )
		.data( "item.autocomplete", item )
		.append( "<a>" + item.label + "<br>&nbsp;&nbsp;&nbsp;&nbsp;" + item.desc + "</a>" )
		.appendTo( ul );
	};





//////////////////////////

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
});

///////////////////////////////////////




});
</script>
<?php 
$visivilidad="none";
?>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/menu_style.css" type="text/css" media="all" />
</head>

<body>
<?php echo $_SESSION['MM_UserGroup']?>
<?php $opcion_menu=2; ?>
<?php include("../include/menu.php"); ?>
 <?php include('../include/funciones.php'); ?>
<table width="1100" align="center" class="ui-widget-header" >
	<tr>
		<td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Insertar Partida</div>
	</tr>
</table><?php include("../_partidas/_menu.php"); ?><form action="index.php" method="get">
<table width="1100" border="0" cellpadding="0" cellspacing="2" align="center">
	<tr>
		<td width="346" bgcolor="#F0F0F0" class="textos_form_derecha">Proyecto:</td>
		<td width="654" bgcolor="#F0F0F0"><label for="CODIGO"></label>
			<select name="CODIGO" id="CODIGO" style="font-size:16px">
				<?php
do {  
?>
				<option value="<?php echo $row_proyectos['CODIGO']?>"><?php echo $row_proyectos['NOMBRE']?></option>
				<?php
} while ($row_proyectos = mysql_fetch_assoc($proyectos));
  $rows = mysql_num_rows($proyectos);
  if($rows > 0) {
      mysql_data_seek($proyectos, 0);
	  $row_proyectos = mysql_fetch_assoc($proyectos);
  }
?>
			</select></td>
	</tr>
	<tr>
		<td colspan="2" align="center" bgcolor="#999999" class="textos_form"><input name="button" type="submit" class="ui-widget-header" id="button" value="Siguiente" /></td>
	</tr>
</table>
</form>

</body>
</html>
<?php
mysql_free_result($proveeedor);

mysql_free_result($proyectos);

mysql_free_result($tipo);

?>
