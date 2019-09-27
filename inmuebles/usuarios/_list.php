<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('../include/header.php'); ?>
<meta http-equiv="Content-Type" content="text/html" />
    <?php if(isset($_GET['ID_USUARIO']))  { $activa=0;
	 }else {$activa=2;};?> 
<script>
	$(
	function()
	{
		$( "#accordion" ).accordion({ active:<?php echo $activa; ?>, autoHeight: false});
	}
	);</script>
</head>
    <div id="accordion">
     <?php if(isset($_GET['ID_USUARIO']))  { ?>
    	  <h3><a href="#">Editar</a></h3>
		  <div><?php include('edit.php');?></div>
     <?php }else {?>     
    	  <h3><a href="#">Incluir</a></h3>
		  <div><?php include('new.php');?></div>
    <?php };?>    
          
        
          <h3><a href="#">Busqueda</a></h3>
  		  <div><?php include('busq.php');?></div>
          
  <?php if(isset($_GET['busqueda']))
  { ?>
    	  <h3><a href="#">Resultado</a></h3>
		  <div><?php include('reslt.php');?></div>
    <?php }else {?>       
    	  <h3><a href="#">Listado</a></h3>
		  <div><?php include('listado.php');?></div>
    <?php };?>
    
</div>

</body>
</html>