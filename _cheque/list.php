<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<!-- TemplateBeginEditable name="doctitle" -->
<title></title>
<!-- TemplateEndEditable -->
<?php include('../include/header.php'); ?>
<?php //include('../include/css_js.php'); ?>

</head>	
<body>

<?php $activa=0; ?>
<!-- TemplateBeginEditable name="EditRegion2" -->

<!-- TemplateEndEditable -->

<script>
	$(
	function()
	{
		$( "#accordion" ).accordion({ active:<?php echo $activa; ?>, autoHeight: false});
	}
	);
	</script>	
    <?php 
	$menu=36;
	$usua=$_SESSION['i'];
	aud($usua,'','Ingreso al modulo de Pagos Directos',$menu);
?>
<h1 align="center"><?php echo $_GET['titulo_formulario'] ?></h1>
<div id="accordion">
		<!--despues de la busqueda-->
       <?php if (validador(36,$_SESSION['i'],"inc")==1){?>
  <h3><a href="#">Incluir</a></h3>
  <div><?php include('directos.php');?></div><?php } ?>
<!-- <h3><a href="#">Cheques Indirectos</a></h3>
--> <!-- <div><?php include('confirnacion.php');?></div>
-->
    </div>
     
          
<!--  </div>
TemplateEndEditable -->



</br>
</br>
<?php include('../include/pie.php'); ?>
</body>
</html>