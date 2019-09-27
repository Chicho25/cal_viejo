<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<title></title>
<?php include('../include/header.php'); ?>
<?php //include('../include/css_js.php'); ?>

</head>	
<body>

<?php 
if(isset($_GET['TO'])){$activa=2;} else{
$activa=1;} ?>
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
   <?php $modulo= $_GET['modulo']; 
   if($_GET['modulo']==1){$menu=13;}else{$menu=21;}?>
<!-- TemplateBeginEditable name="EditRegion1" -->
<h1 align="center"><?php echo $_GET['titulo_formulario'] ?></h1>
<!--<div style="z-index:9999; background-color:#fff; height:300px; width:300px; float:left"> </div>
--><div id="accordion">
		<!--despues de la busqueda-->
        <?php  if (validador($menu,$_SESSION['i'],"inc")==1) {?>     
    	  <h3><a href="#">Incluir</a></h3>
		  <div><?php include('add.php');?></div>
     <?php }else {?> 
          <h3><a href="#"></a></h3>
		  <div></div>

    <?php };?>    
          
        
          <h3><a href="#">Busqueda</a></h3>
          <div><?php include('busq.php');?></div>
          
  <?php if(isset($_GET['TO']))
  { ?>
    	  <h3><a href="#">Resultado</a></h3>
		  <div><?php include('resul.php');?></div>
    
    <?php };?>    
          
 <!--  </div>
TemplateEndEditable -->



</br>
</br>
<?php include('../include/pie.php'); ?>
</body>
</html>