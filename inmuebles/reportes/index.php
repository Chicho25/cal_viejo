<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<title></title>
<?php include('../include/header.php'); ?>

<?php 
$activa=0;?>
<script>
	$(
	function()
	{
		$( "#accordion" ).accordion({ active:<?php echo $activa; ?>, autoHeight: false});
	}
	);
	</script>	
<h1 align="center"><?php echo $_GET['titulo_formulario'] ?></h1>
<div id="accordion">
          
   	  <h3><a href="#">Busqueda</a></h3>
		  <div><?php include('bus.php');?></div>
          </div>
 


</br>
</br>
<?php include('../include/pie.php'); ?>
</body>
</html>