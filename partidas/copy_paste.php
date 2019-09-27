
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<!--; charset=utf-8"
--><title>.:: <?php echo $_GET['titulo_formulario'] ?> ::.</title>
<?php include('../include/header.php'); ?>
    <?php if(isset($_GET['id_grupo'])) { $activa=1;
	 }else if(isset($_GET['ID_CUENTA'])){ $activa=0;
	 }else {$activa=0;};?>    

<script>
	$(
	function()
	{
		$( "#accordion" ).accordion({ active:<?php echo $activa; ?>, autoHeight: false});
	}
	);
	</script>
 
    <?php 
	$menu=7;
	
	aud($_SESSION['i'],'','Ingreso al modulo',$menu);
	 ?>
<h1 align="center"><?php echo $_GET['titulo_formulario'] ?></h1>
<div id="accordion">
		         
       	  <h3><a href="#">Incluir</a></h3>
		  <div><?php 
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO contabilidad_cuentas (descripcion, id_sucursal, id_grupo, tipo, nivel) 
select descripcion, ".$_POST["DESTINO"].", id_grupo, tipo, nivel from contabilidad_cuentas where id_sucursal=%s",
                       GetSQLValueString($_POST['ORIGEN'], "int"));

  mysql_select_db($database_conexion, $conexion);
 // echo $insertSQL;
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
 $ids=mysql_insert_id();
   aud($_SESSION['i'],$ids,'Copiado de partidas desde sucursal '.$_POST['ORIGEN'].' a la sucursal '.$_POST["DESTINO"],$menu);
?>
 <script type="text/javascript">
alert("Los cambios se realizaron con exito...");

window.location = "index.php?titulo_formulario=<?php echo $_GET['titulo_formulario']; ?>"
</script>
<?php 
}


mysql_select_db($database_conexion, $conexion);
$query_rst_sucursales = "SELECT * FROM empresas_sucursales";
$rst_sucursales = mysql_query($query_rst_sucursales, $conexion) or die(mysql_error());
$row_rst_sucursales = mysql_fetch_assoc($rst_sucursales);
$totalRows_rst_sucursales = mysql_num_rows($rst_sucursales);
?>
<script src="../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
<table width="990" border="0" align="center">
  <tr>
    <td width="490" align="right">Proyecto o Sucursal de Origen:</td>
    <td width="490">
      <span id="spryselect1">
        <label for="ORIGEN"></label>
        <select name="ORIGEN" id="ORIGEN">
          <option value="-1">Seleccione...</option>
          <?php
do {  
?>
          <option value="<?php echo $row_rst_sucursales['ID_SUCURSAL']?>"><?php echo $row_rst_sucursales['NOMBRE_SUCURSAL']?></option>
          <?php
} while ($row_rst_sucursales = mysql_fetch_assoc($rst_sucursales));
  $rows = mysql_num_rows($rst_sucursales);
  if($rows > 0) {
      mysql_data_seek($rst_sucursales, 0);
	  $row_rst_sucursales = mysql_fetch_assoc($rst_sucursales);
  }
?>
        </select>
        <span class="selectRequiredMsg">Please select an item.</span></span>
    </td>
  </tr>
  <tr>
    <td align="right">Proyecto o Sucursal de Destino:</td>
    <td>
      <span id="spryselect2">
        <label for="DESTINO"></label>
        <select name="DESTINO" id="DESTINO">
        <option value="-1">Seleccione...</option>
          <?php
do {  
?>
          <option value="<?php echo $row_rst_sucursales['ID_SUCURSAL']?>"><?php echo $row_rst_sucursales['NOMBRE_SUCURSAL']?></option>
          <?php
} while ($row_rst_sucursales = mysql_fetch_assoc($rst_sucursales));
  $rows = mysql_num_rows($rst_sucursales);
  if($rows > 0) {
      mysql_data_seek($rst_sucursales, 0);
	  $row_rst_sucursales = mysql_fetch_assoc($rst_sucursales);
  }
?>
        </select>
        <span class="selectRequiredMsg">Please select an item.</span></span>
    </td>
  </tr>
  <tr align="center" valign="middle">
    <td colspan="2"><input type="submit" name="aceptar" id="aceptar" value="Aceptar"  class="ui-state-hover"></td>
    </tr>
</table>
<input type="hidden" name="MM_insert" value="form1">
</form>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
</script>
<?php
mysql_free_result($rst_sucursales);
?>
</div>
  </div>
<br/>
<?php mysql_close($conexion)//include('../include/pie.php'); ?>
</body>

</html>


