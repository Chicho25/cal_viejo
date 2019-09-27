
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<!--; charset=utf-8"
--><title>.:: <?php echo $_GET['titulo_formulario'] ?> ::.</title>
<?php include('../include/header.php'); ?>
    <?php if(isset($_GET['ID_INMUEBLE_MASTER']))  { $activa=0;
	 }elseif(isset($_GET['ID_INMUEBLE_MASTER_RESERVA'])) {$activa=0;
	 }else {$activa=2;};?>    

<script>
	$(
	function()
	{
		$( "#accordion" ).accordion({ active:<?php echo $activa; ?>, autoHeight: false});
	}
	);
	</script>
    <?php 
	$menu=15;
	$usua=$_SESSION['i'];
	aud($usua,'','Ingreso al modulo de Inmueble',$menu);
/*	mysql_select_db($database_conexion, $conexion);
	//$query_rst_acceso = "SELECT FORMULARIO_VIEW, FORMULARIO_INSERT, FORMULARIO_UPDATE, FORMULARIO_DELETE, FORMULARIO_OTHER FROM vista_usuarios_acceso WHERE ID_USUARIO= ".$usua." AND ID_MENU= ".$menu;
	$query_rst_acceso = "SELECT DETALLE_ACCESO FROM vista_usuarios_acceso WHERE ID_USUARIO= ".$usua." AND ID_MENU= ".$menu;
	//echo $query_rst_acceso;
	$rst_acceso = mysql_query($query_rst_acceso, $conexion) or die(mysql_error());
	$row_rst_acceso = mysql_fetch_assoc($rst_acceso);
	$totalRows_rst_acceso = mysql_num_rows($rst_acceso);
$view=substr($row_rst_acceso['DETALLE_ACCESO'],0,1);
$inc=substr($row_rst_acceso['DETALLE_ACCESO'],1,1);
$edi=substr($row_rst_acceso['DETALLE_ACCESO'],2,1);
$eli=substr($row_rst_acceso['DETALLE_ACCESO'],3,1);
$oth=substr($row_rst_acceso['DETALLE_ACCESO'],4,1);
$lib=substr($row_rst_acceso['DETALLE_ACCESO'],5,1);
*/	 ?>
<h1 align="center"><?php echo $_GET['titulo_formulario'] ?></h1>
<div id="accordion">
		<!--despues de la busqueda-->
        <?php  if(isset($_GET['ID_INMUEBLE_MASTER'])&& validador(15,$_SESSION['i'],"edi")==1) { ?>
    	  <h3><a href="#">Editar</a></h3>
		  <div><?php include('edit.php');?></div>
    <?php }elseif(isset($_GET['ID_INMUEBLE_MASTER_RESERVA'])&& validador1(15,$_SESSION['i'],"oth")==1) {?>       
    	  <h3><a href="#">Reservar</a></h3>
		  <div><?php include('reserv.php');?></div>
    <?php }elseif (validador(15,$_SESSION['i'],"inc")==1) {?>     
    	  <h3><a href="#">Incluir</a></h3>
		  <div><?php include('add.php');?></div>
     <?php }else {?> 
          <h3><a href="#"></a></h3>
		  <div></div>

    <?php };?>    
          
        
          <h3><a href="#">Busqueda</a></h3>
  		  <div><?php include('busq.php');?></div>
          
  <?php if(isset($_GET['status'])) { ?>
    	  <h3><a href="#">Resultado</a></h3>
		  <div><?php include('reslt.php');?></div>
   <?php }else {?>       
    	  <h3><a href="#">Listado</a></h3>
		  <div><?php include('lista.php');?></div>
    <?php };?>    
          
  </div>
<br/>
<?php include('../include/pie.php'); ?>
</body>

</html>

