

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html charset=utf-8" />
<!--; charset=utf-8"
--><title>.:: <?php echo htmlentities($_GET['titulo_formulario'], ENT_QUOTES, "UTF-8"); ?> ::.</title>
<?php include('../include/header.php'); ?>
    <?php if(isset($_GET['ID_MENU'])){ $activa=0;
	 }else if(isset($_GET['BUSCAR'])){ $activa=2;
	 } else {$activa=1;};?>    

<script>
	$(
	function()
	{
		$( "#accordion" ).accordion({ active:<?php echo $activa; ?>, autoHeight: false});
	}
	);
	</script>
 
    <?php 
	$menu=$_GET['id_menu'];
	aud($_SESSION['i'],'','Ingreso al modulo',$menu);
	 ?>
<h1 align="center"><?php echo htmlentities($_GET['titulo_formulario'], ENT_QUOTES, "UTF-8"); ?></h1>
<div id="accordion">
		<?php if(isset($_GET['ID_MENU']) && $_GET['ID_MENU']!="") { ?>
		  <h3><a href="#">Editar</a></h3>
		  <div><?php include('edit.php');?></div>
          <?php } ?>
         
       	  <h3><a href="#">Incluir</a></h3>
		  <div><?php include('add.php');?></div>
  		  
             	          
<!--          <h3><a href="#">Busqueda</a></h3>
  		  <div><?php //include('busq.php');?></div>
-->          
        
        	  <h3><a href="#">Listado</a></h3>
		  <div><?php include('lista.php');?></div>
      
          
  </div>
<br/>

<?php mysql_close($conexion)//include('../include/pie.php'); ?>
</body>

</html>
