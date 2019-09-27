<?php include('../Connections/conexion.php'); ?>
<?php include('../include/css_js.php'); ?>
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
$query_rst_usuarios = "SELECT ID_USUARIO, NOMBRES, APELLIDOS FROM usuarios_master";
$rst_usuarios = mysql_query($query_rst_usuarios, $conexion) or die(mysql_error());
$row_rst_usuarios = mysql_fetch_assoc($rst_usuarios);
$totalRows_rst_usuarios = mysql_num_rows($rst_usuarios);

mysql_select_db($database_conexion, $conexion);
$query_rst_modulos = "SELECT ID_MENU, DESCRIPCION FROM usuarios_menu";
$rst_modulos = mysql_query($query_rst_modulos, $conexion) or die(mysql_error());
$row_rst_modulos = mysql_fetch_assoc($rst_modulos);
$totalRows_rst_modulos = mysql_num_rows($rst_modulos);
?>
<script> 
 


	$(function() 
	{
		var myDate = new Date();
		var month = myDate.getMonth() + 1;
		var prettyDate = myDate.getDate() + '/' + month + '/' + myDate.getFullYear();
		$("#fecha1").val(prettyDate);

		$( "#fecha1" ).datepicker(
		{
			changeMonth: true,
			changeYear: true,
			currentText: 'Now'
});
	})
	</script>
    <script> 
 


	$(function() 
	{
		var myDate = new Date();
		var month = myDate.getMonth() + 1;
		var prettyDate = myDate.getDate() + '/' + month + '/' + myDate.getFullYear();
		$("#fecha2").val(prettyDate);

		$( "#fecha2" ).datepicker(
		{
			changeMonth: true,
			changeYear: true,
			currentText: 'Now'
});
	})
	</script>
	<link href="../js/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css">
	
<form name="form1" method="get" action="">
  <table width="990" border="0" align="center">
    <tr>
      <td width="446" align="right" class="Campos">Usuario</td>
      <td width="534"><label for="usuario2"></label>
        <select name="usuario" id="usuario2">
          <option value=" ">Seleccione...</option>
          <?php
do {  
?>
          <option value=" AND auditoria.ID_USUARIO=<?php echo $row_rst_usuarios['ID_USUARIO']?>"><?php echo $row_rst_usuarios['NOMBRES']?> <?php echo $row_rst_usuarios['APELLIDOS']?></option>
          <?php
} while ($row_rst_usuarios = mysql_fetch_assoc($rst_usuarios));
  $rows = mysql_num_rows($rst_usuarios);
  if($rows > 0) {
      mysql_data_seek($rst_usuarios, 0);
	  $row_rst_usuarios = mysql_fetch_assoc($rst_usuarios);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td align="right" class="Campos">Modulo</td>
      <td><label for="modulo"></label>
        <select name="modulo" id="modulo">
          <option value=" ">Seleccione...</option>
          <?php
do {  
?>
          <option value=" AND MODULO=<?php echo $row_rst_modulos['ID_MENU']?>"><?php echo $row_rst_modulos['DESCRIPCION']?></option>
          <?php
} while ($row_rst_modulos = mysql_fetch_assoc($rst_modulos));
  $rows = mysql_num_rows($rst_modulos);
  if($rows > 0) {
      mysql_data_seek($rst_modulos, 0);
	  $row_rst_modulos = mysql_fetch_assoc($rst_modulos);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td align="right" class="Campos"><input name="titulo_formulario" type="hidden" id="titulo_formulario" value="<?php echo $_GET['titulo_formulario'] ?>" />
      Rango de fechas</td>
      <td><label for="fecha1"></label>
        <input type="text" name="fecha1" id="fecha1">
        y
        <label for="fecha2"></label>
        <input type="text" name="fecha2" id="fecha2"></td>
    </tr>
    <tr>
      <td height="52" colspan="2" align="center" valign="middle"><input name="aceptar" type="submit" class="ui-state-hover" id="aceptar" value="Aceptar"></td>
    </tr>
  </table>
</form>

<?php
mysql_free_result($rst_usuarios);

mysql_free_result($rst_modulos);
?>
