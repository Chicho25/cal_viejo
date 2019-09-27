<?php include("../include/header.php"); 
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO banco_master (CODIGO, NOMBRE, NACIONAL) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['CODIGO'], "text"),
                       GetSQLValueString($_POST['NOMBRE'], "text"),
                       GetSQLValueString(isset($_POST['NACIONAL']) ? "true" : "", "defined","1","0"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  	$ids=mysql_insert_id();
   aud($_SESSION['i'],$ids,'Creacion de chequera con el id ',30);

   ?>
    <script type="text/javascript">
alert("Proceso Completado con Exito.");
 window.location="index.php";

</script>
<?php

}

/*Definiciones*/
$formulario="Partidas00-Editar";
?>


<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<?php $opcion_menu=2; ?>


      <table width="1100" align="center" class="ui-widget-header" >
    <tr>
          <td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Añadir Banco</div>
    </tr>
  </table>
<?php //include("_menu.php"); ?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <table width="1100" align="center" >
    <tr>
      <td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >

Codigo: 
      <td align="left" bgcolor="#F3F3F3" ><span id="sprytextfield1">
      <label for="textfield">
      	<input type="text" name="CODIGO" value="" size="32" />
      	</label>
      <span class="textfieldRequiredMsg">Requerido.</span></span></tr>
    <tr>
      <td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Nombre:      
      <td align="left" bgcolor="#F3F3F3" ><span id="sprytextfield2">
      <label for="MONTO_ESTIMADO2">
      	<input type="text" name="NOMBRE" value="" size="32" />
      	</label>
      <span class="textfieldRequiredMsg">Requerido.</span></span></tr>
    <tr>
      <td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Nacional:      
      <td align="left" bgcolor="#F3F3F3" ><label for="textfield3">
      	<input type="checkbox" name="NACIONAL" value="" checked="checked" />
      </label>      </tr>
    <tr>
    	<td colspan="2" align="left" >
    		<div class="validity-summary-container" style="color:#F00">
    			
    			<ul></ul>
</div></tr>

          <td colspan="2" align="center" bgcolor="#999999" class="textos_form" ><input name="button" type="submit" class="ui-widget-header" id="button" value="Guardar" /></tr>
</table>
    <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
<?php include("../include/_foot.php"); ?>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
<?php
mysql_free_result($CONSULTA);

?>
