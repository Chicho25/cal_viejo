<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('../include/header.php'); ?>
<meta http-equiv="Content-Type" content="text/html" />
    <?php if(isset($_GET['ID_PRO_CLI_MASTER']))  { $activa=0;
	 } elseif(isset($_GET['RESERV']))  { $activa=0;
	 }else {$activa=2;};?> 
<script>
	$(
	function()
	{
		$( "#accordion" ).accordion({ active:<?php echo $activa; ?>, autoHeight: false});
	}
	);</script>
    <?php
	$menu=18;
	$usua=$_SESSION['i'];
	aud($usua,'','Ingreso al modulo de Clientes',$menu);

	?>
</head>
<h1 align="center"><?php echo $_GET['titulo_formulario'] ?></h1>
    <div id="accordion">
     <?php if(isset($_GET['ID_PRO_CLI_MASTER'])&& isset($_GET['EDITA']) && validador(18,$_SESSION['i'],"edi")==1) { ?>
    	  <h3><a href="#">Editar</a></h3>
		  <div><?php include('edit.php');?></div><?php } if (validador(18,$_SESSION['i'],"inc")==1) {?>     
    	  <h3><a href="#">Incluir</a></h3>
		  <div><?php include('add.php');?></div>
    <?php }else {?> 
          <h3><a href="#"></a></h3>
		  <div></div>

    <?php };?>        
          
        
          <h3><a href="#">Busqueda</a></h3>
  		  <div><?php include('busq.php');?></div>
          
  <?php if(isset($_GET['buscar']))
  { ?>
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