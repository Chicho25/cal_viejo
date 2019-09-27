<?php require_once('../Connections/conexion.php'); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form_reserva")) {
 $insertSQL = sprintf("INSERT INTO inmuebles_mov (ID_INMUEBLES_MASTER, ID_PRO_CLI_MASTER, DESCRIPCION, BROKER, VENDEDOR,PRECIO_VENTA, FECHA, ID_TIPO) VALUES (%s, %s, %s, %s, %s, %s, %s, 2)",
                       GetSQLValueString(strtoupper ( $_POST['CODIGO_INMUEBLE_MASTER']), "int"),
                       GetSQLValueString(strtoupper ( $_POST['clientes']), "int"),
                       GetSQLValueString(strtoupper ( $_POST['descripcion']), "text"),
					   GetSQLValueString(strtoupper ( $_POST['broker']), "text"),
					   GetSQLValueString(strtoupper ( $_POST['vendedor']), "text"),
                       GetSQLValueString(strtoupper ( $_POST['precio']), "double"),
					   GetSQLValueString(DMAtoAMD( $_POST['fecha1']), "date"));
					   aud($usuario_activo,$_POST['CODIGO_INMUEBLE_MASTER'],'Reservando el inmueble ID. '.$_POST['CODIGO_INMUEBLE_MASTER'],15);
//echo $insertSQL;
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion);
   //errores(mysql_errno($conexion),"list.php",$usuario_activo,$_GET['CODIGO_INMUEBLE_MASTER'],'Reservando el inmueble ID. '.$_GET['CODIGO_INMUEBLE_MASTER'],15);

}


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$_fechas=date("d/m/Y");
	$menu=18;
	$usua=$_SESSION['i'];
	mysql_select_db($database_conexion, $conexion);
	$query_rst_acceso = "SELECT * FROM vista_usuarios_acceso WHERE ID_USUARIO= ".$usua." AND ID_MENU= ".$menu;
	//echo $query_rst_acceso;
	$rst_acceso = mysql_query($query_rst_acceso, $conexion) or die(mysql_error());
	$row_rst_acceso = mysql_fetch_assoc($rst_acceso);
	$totalRows_rst_acceso = mysql_num_rows($rst_acceso);


mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM pro_cli_master WHERE tipo IN (2,3)";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_conexion, $conexion);
$query_rstvendedores = "SELECT ID_PRO_CLI_MASTER, NOMBRE FROM vista_vendedores ORDER BY NOMBRE ASC";
$rstvendedores = mysql_query($query_rstvendedores, $conexion) or die(mysql_error());
$row_rstvendedores = mysql_fetch_assoc($rstvendedores);
$totalRows_rstvendedores = mysql_num_rows($rstvendedores);
$colname_Recordset2 = "-1";
if (isset($_GET['ID_INMUEBLE_MASTER_RESERVA'])) {
  $colname_Recordset2 = $_GET['ID_INMUEBLE_MASTER_RESERVA'];
}
mysql_select_db($database_conexion, $conexion);
$query_Recordset2 = sprintf("SELECT ID_INMUEBLES_MASTER, NOMBRE, inmuebles_master.PRECIO_REAL FROM inmuebles_master WHERE ID_INMUEBLES_MASTER = %s", GetSQLValueString($colname_Recordset2, "int"));
//echo $query_Recordset2;
$Recordset2 = mysql_query($query_Recordset2, $conexion) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>

<script> 
 


	$(function() 
	{
		var myDate = new Date();
		var month = myDate.getMonth() + 1;
		var prettyDate = myDate.getDate() + '/' + month + '/' + myDate.getFullYear();
		//$("#fecha1").val(prettyDate);

		$( "#fecha1" ).datepicker(
		{
			changeMonth: true,
			changeYear: true,
			currentText: 'Now'
});
	})
	</script>
    
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">

<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

	<link href="../css/encabezados.css" rel="stylesheet" type="text/css" />

	<form id="form_reserva" name="form_reserva"  method="post" action="<?php echo $editFormAction; ?>">
  <p>
    <label for="clientes"></label>
  </p>
  <p>
    <input name="CODIGO_INMUEBLE_MASTER" type="hidden" id="CODIGO_INMUEBLE_MASTER" value="<?php echo $row_Recordset2['ID_INMUEBLES_MASTER']; ?>" />
  </p>
  <p>
    <label for="inmueble"></label>
    <label for="fecha1"></label>
  </p>
  <p>
    <label for="descripcion"></label>
  </p>
  <table width="990" border="0" align="center">
   <tr align="center">  <td height="37" colspan="2" class="Encabezados">Reservacion de Inmuebles</td>
    <tr align="left">
      <th colspan="2" align="center" class="Campos" scope="col">
        <?php 
	  $tabla="vista_pro_cli";
	  $where=" WHERE COD_TIPO IN(2,3)";
	  $label="Clientes";
	  $nombre_campo_mostrar="NOMBRE";
	  $nombre_campo_value="ID_PRO_CLI";
	  $nombre_campo_form="clientes";
	  $ancho=550;
	  $parametro='';
	  $boton=4;
	  $accion="accion()";
	  
	  
	  include_once('../include/autocompletar.php');?>     </th>
    </tr>
    <tr>
      <td width="393" align="right" class="Campos">Inmueble:</td>
      <td>
      <input name="inmueble" type="text" id="inmueble" value="<?php echo $row_Recordset2['NOMBRE']; ?>" size="50" readonly="readonly" />
     </td>
    </tr>
    <tr>
      <td align="right" class="Campos">Fecha:</td>
      <td><span id="sprytextfield1">
      <input type="text" name="fecha1" id="fecha1" value="<?php echo $_fechas; ?>" />
      <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Formato de la fecha invalido.</span></span></td>
    </tr>
    
    <tr>
      <td align="right" class="Campos">Precio del Inmueble:</td>
      <td><span id="sprytextfield2">
      <input name="precio" type="text" id="precio" value="<?php echo $row_Recordset2['PRECIO_REAL']; ?>" />
      <span class="textfieldRequiredMsg">Ingrese el precio de venta.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
    </tr>
        <tr>
      <td align="right" class="Campos">Vendedor:</td>
      <td>
        <label for="vendedor"><span id="spryselect2">
          <select name="vendedor" id="vendedor">
            <option value="-1">Seleccione el Vendedor</option>
            <?php
do {  
?>
            <option value="<?php echo $row_rstvendedores['ID_PRO_CLI_MASTER']?>"><?php echo $row_rstvendedores['NOMBRE']?></option>
            <?php
} while ($row_rstvendedores = mysql_fetch_assoc($rstvendedores));
  $rows = mysql_num_rows($rstvendedores);
  if($rows > 0) {
      mysql_data_seek($rstvendedores, 0);
	  $row_rstvendedores = mysql_fetch_assoc($rstvendedores);
  }
?>
          </select>
        <span class="selectInvalidMsg">Seleccione el Vendedor.</span><span class="selectRequiredMsg">Seleccione el Vendedor.</span></span></label></td>
    </tr>
    <tr>
      <td align="right" class="Campos">Broker:</td>
      <td><label for="broker"></label>
      <input type="text" name="broker" id="broker"></td>
    </tr>
    <tr>
      <td align="right" class="Campos">Observaciones:</td>
      <td><textarea name="descripcion" id="descripcion" cols="45" rows="5"></textarea></td>
    </tr>
    <tr align="center">
      <td colspan="2"><input type="hidden" name="titulo_formulario" id="titulo_formulario" value="<?php echo $_GET["titulo_formulario"]; ?>" />
        <input type="submit" name="reservar" id="reservar" value="Reservar" class="ui-state-hover" />
      <input name="defecto" type="hidden" id="defecto" value="2"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form_reserva" />
</form>

<?php
mysql_free_result($Recordset1);

mysql_free_result($rstvendedores);
?>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {validateOn:["blur", "change"], invalidValue:"-1"});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"dd/mm/yyyy", validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "currency", {validateOn:["blur"]});
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2", {invalidValue:"-1", validateOn:["blur", "change"]});
</script>
	