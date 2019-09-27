<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html" />
<?php include('../include/header.php');?>
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

   <?php 
	$menu=33;
	$usua=$_SESSION['i'];
	aud($usua,'','Ingreso al modulo de usuarios',$menu);
 ?>
  <?php if(validador(33,$_SESSION['i'],"view")==1){ ?>
 <h1 align="center"><?php echo $_GET['titulo_formulario'] ?></h1>
            <div id="accordion">
             <?php if(isset($_GET['ID_USUARIO']) && validador(33,$_SESSION['i'],"edi")==1) { ?>
                  <h3><a href="#">Editar</a></h3>
                  <div><?php include('edit.php');?></div>
             <?php }elseif (validador(33,$_SESSION['i'],"inc")==1) {?>     
                  <h3><a href="#">Incluir</a></h3>
                  <div><?php include('new.php');?></div>
             <?php }else {?> 
                  <h3><a href="#"></a></h3>
                  <div></div>
        
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
<?php } else {
	echo '<script language="javascript">alert("No tiene acceso a este formulario");location.href="../home/inicio.php";</script>';	
};?>
<br/>
<?php include('../include/pie.php'); ?>
</body>

</html>