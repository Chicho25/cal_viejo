
<?php include("../include/header.php"); 
$colname_validacion = "-1";
if (isset($_POST['NUMERO_PAGO'])) {
  $colname_validacion = $_POST['NUMERO_PAGO'];
}
mysql_select_db($database_conexion, $conexion);
$query_validacion = "SELECT * FROM mov_banco_caja WHERE NUMERO_PAGO = '".$_POST['NUMERO_PAGO']."' AND ID_CUENTA_BANCARIA=".$_POST['ID_CUENTA_BANCARIA'].";";
$validacion = mysql_query($query_validacion, $conexion) or die(mysql_error());
$row_validacion = mysql_fetch_assoc($validacion);
$totalRows_validacion = mysql_num_rows($validacion);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
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


</head>

<body>
<?php $opcion_menu=2; ?>
<?php //include("../include/menu.php"); ?>

<table width="1100" align="center" class="ui-widget-header" >
		<tr>
			<td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Cheque Anulado</div>
		</tr>
</table><?php //echo $query_validacion."------------".$totalRows_validacion ?>
	<?php if ($totalRows_validacion > 0) { // Show if recordset not empty ?>
	<BR /><br /><div align="center" class="textos_form">El cheque ya existe y esta asignado a un pago. No se puede anular</div>
	
	<?php } // Show if recordset not empty ?>
	

	<?php if ($totalRows_validacion == 0) { // Show if recordset empty ?>
	<BR /><br /><div align="center" class="textos_form">Cheque anulado correctamente.</div>
	<?php 
						 $query_detalle_banco = "INSERT INTO mov_banco_caja (TIPO_PAGO, NUMERO_PAGO, ANULADO, DESCRIPCION, ID_CUENTA_BANCARIA, FECHA, COD_PROYECTO) VALUES (11,'".$_POST['NUMERO_PAGO']."', 1, 'CHEQUE ANULADO ".$_POST['DESCRIPCION']."', ".$_POST['ID_CUENTA_BANCARIA'].", now(), '".$_POST['PROYECTO']."')";
	//$query_detalle_banco = "INSERT INTO mov_banco_caja (TIPO_PAGO, NUMERO_PAGO, ANULADO, DESCRIPCION, ID_CUENTA_BANCARIA, FECHA) VALUES (2,'".$_POST['NUMERO_PAGO']."', 1, 'CHEQUE ANULADO ".$_POST['DESCRIPCION']."', ".$_POST['ID_CUENTA_BANCARIA'].", ".DMAtoAMD($_POST['FECHA']).")";
	//echo $query_detalle_banco;
	$detalle_banco = mysql_query($query_detalle_banco, $conexion) or die(mysql_error("aqui"));
			$ids=mysql_insert_id();
   aud($_SESSION['i'],$ids,'Anulacion de cheque en mov_banco_caja con el id ',25);

	?>
	<?php } // Show if recordset empty ?>
</body>
</html>
