<!--<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />-->
<?php include('../include/header.php'); 
/* include('../connections/conexion.php');
 include('../include/css_js.php'); 
 include('../include/funciones.php');*/ ?>
<!--<meta http-equiv="Content-Type" content="text/html" />
--><?php
 //$menu=34;
//$usua=$_SESSION['i'];
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
 
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	mysql_select_db($database_conexion, $conexion);
	$rows_menu="SELECT * FROM usuarios_menu";
	$querys = mysql_query($rows_menu, $conexion) or die(mysql_error());
	$row_querys = mysql_fetch_assoc($querys);
	$totalRows_querys = mysql_num_rows($querys);

				    $val1=strtoupper ( $_POST['NOMBRE_ROLE']);
						$val2=strtoupper ( $_POST['DESCRIPCION_COMPLETA']);
						  $insertSQL = sprintf("INSERT INTO usuarios_roles (NOMBRE_ROLE, DESCRIPCION_COMPLETA) VALUES ('$val1','$val2')");
					    
   						$Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
						$id=mysql_insert_id();
					    aud($_SESSION['i'],'','Insertando el Rol cod. '.mysql_insert_id(),34);
					   
					   //echo $id;
					   

					   //for($a=1;$a<=$totalRows_querys;$a++){
						  
					   //$insertSQL1 = "INSERT INTO usuarios_acceso (ID_ROLE, ID_MENU) VALUES (".$id.", ".$a.")";
					   
					   $insertSQL1 = "INSERT INTO usuarios_acceso (id_role, id_menu) SELECT ".$id." AS id_role, id_menu AS id_menu FROM usuarios_menu";
					  // echo $insertSQL1;
					    mysql_select_db($database_conexion, $conexion);
  						$Result2 = mysql_query($insertSQL1, $conexion) or die(mysql_error());
 
					   //}

  $insertGoTo = "roles.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $insertGoTo));
}
?>

<?php
  $menu=34;
$usua=$_SESSION['i'];
mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT ID_ROLE, NOMBRE_ROLE FROM usuarios_roles";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_conexion, $conexion);
$query_Recordset2 = "SELECT ID_MENU, DESCRIPCION FROM usuarios_menu";
$Recordset2 = mysql_query($query_Recordset2, $conexion) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
    <?php if(isset($_GET['ID_USUARIO']))  { $activa=0;
	 }else {$activa=1;};?> 
<script>
	$(
	function()
	{
		$( "#accordion" ).accordion({ active:<?php echo $activa; ?>, autoHeight: false});
	} 
	);</script>
  
     <h1 align="center"><?php echo $_GET['titulo_formulario'] ?></h1>
<div id="accordion">
    <?php //if (validador(34,$_SESSION['i'],"inc")==1) {?> 
       	  <h3><a href="#">Crear Rol</a></h3>
		  <div><form method="post" name="form1" action="<?php echo $editFormAction; ?>">
          	<table width="990" height="104" align="center" class="Campos">
            <tr valign="baseline">
              <td width="445" align="right" nowrap>Nombre del Rol:</td>
              <td width="533"><span id="sprytextfield1">
                <input type="text" name="NOMBRE_ROLE" value="" size="32" />
              <span class="textfieldRequiredMsg">Informacion necesaria.</span></span></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Descripcion:</td>
              <td><span id="sprytextfield2">
                <input type="text" name="DESCRIPCION_COMPLETA" value="" size="32" />
              <span class="textfieldRequiredMsg">Informacion necesaria.</span></span></td>
            </tr>
            <tr valign="baseline">
              <td colspan="2" align="center" valign="middle" nowrap><input type="submit" value="Aceptar" class="ui-state-hover"></td>
            </tr>
          </table>
  <input type="hidden" name="MM_insert" value="form1">
</form></div>
      
    	  <h3><a href="#">Crear Acceso al Rol</a></h3>
		  <div><?php include('_roles.php');?></div>
      
      <?php //};?>   

<?php
//mysql_free_result($Recordset1);
//mysql_free_result($querys);
//mysql_free_result($Recordset2);
?>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur", "change"]});
</script>
