
<?php
include('../include/header.php'); 
						$menu=34;
						$usua=$_SESSION['i'];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$rows_menu="SELECT * FROM usuarios_menu";
	$querys = mysql_query($rows_menu, $conexion) or die(mysql_error());
	$row_querys = mysql_fetch_assoc($querys);
	$totalRows_querys = mysql_num_rows($querys);

  $insertSQL = sprintf("INSERT INTO usuarios_roles (NOMBRE_ROLE, DESCRIPCION_COMPLETA) VALUES (%s, %s)",
                       GetSQLValueString($_POST['NOMBRE_ROLE'], "text"),
                       GetSQLValueString($_POST['DESCRIPCION_COMPLETA'], "text"));
					    mysql_select_db($database_conexion, $conexion);
   						$Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
						$id=mysql_insert_id();

					    aud($usua,'','Insertando el Rol cod. '.$id,$menu);
					   
					   //echo $id;
					   for($a=1;$a<=$totalRows_querys;$a++){
					   $insertSQL1 = "INSERT INTO usuarios_acceso (ID_ROLE, ID_MENU) VALUES (".$id.", ".$a.")";
					   //echo $insertSQL1;
					    mysql_select_db($database_conexion, $conexion);
  						$Result2 = mysql_query($insertSQL1, $conexion) or die(mysql_error());
 
					   }

  $insertGoTo = "roles.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $insertGoTo));
}


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
	 }else {$activa=2;};?> 
<script>
	$(
	function()
	{
		$( "#accordion" ).accordion({ active:<?php echo $activa; ?>, autoHeight: false});
	}
	);</script>
   <?php 
	mysql_select_db($database_conexion, $conexion);
	//$query_rst_acceso = "SELECT FORMULARIO_VIEW, FORMULARIO_INSERT, FORMULARIO_UPDATE, FORMULARIO_DELETE, FORMULARIO_OTHER FROM vista_usuarios_acceso WHERE ID_USUARIO= ".$usua." AND ID_MENU= ".$menu;
		$query_rst_acceso = "SELECT FORMULARIO_VIEW, FORMULARIO_INSERT, FORMULARIO_UPDATE, FORMULARIO_DELETE, FORMULARIO_OTHER FROM vista_usuarios_acceso WHERE ID_MENU= ".$menu;

	//echo $query_rst_acceso;
	$rst_acceso = mysql_query($query_rst_acceso, $conexion) or die(mysql_error());
	$row_rst_acceso = mysql_fetch_assoc($rst_acceso);
	$totalRows_rst_acceso = mysql_num_rows($rst_acceso);
	
	//echo $row_rst_acceso['FORMULARIO_INSERT'];
	//echo $row_rst_acceso['FORMULARIO_OTHER'];
	//echo $row_rst_acceso['FORMULARIO_UPDATE'];
	 ?>
    <div id="accordion">
    <?php //if ($row_rst_acceso['FORMULARIO_INSERT']==1) {?> 
       	  <h3><a href="#">Crear Rol</a></h3>
		  <div><form method="post" name="form1" action="<?php echo $editFormAction; ?>">
          	<table width="990" height="104" align="center" class="Campos">
            <tr valign="baseline">
              <td width="445" align="right" nowrap>Nombre del Rol:</td>
              <td width="533"><input type="text" name="NOMBRE_ROLE" value="" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Descripcion:</td>
              <td><input type="text" name="DESCRIPCION_COMPLETA" value="" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td colspan="2" align="center" class="ui-state-hover" valign="middle" nowrap><input type="submit" value="Aceptar"></td>
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
