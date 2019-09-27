<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />

<link href="../css/encabezados.css" rel="stylesheet" type="text/css" />
<link href="../css/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
<link href="../css/txt_4.css" rel="stylesheet" type="text/css" />
<?php include('../include/header.php'); ?>
<title>.:: <?php echo $_GET['titulo_formulario'] ?> ::.</title>

</head>	
<body>

<?php $activa=0; ?>
<!-- TemplateBeginEditable name="EditRegion2" --><!-- TemplateEndEditable -->

<script>
	$(
	function()
	{
		$( "#accordion" ).accordion({ active:<?php echo $activa; ?>, autoHeight: false});
	}
	);
	</script>
    <h1 align="center"><?php echo $_GET['titulo_formulario'] ?></h1>
<!-- TemplateBeginEditable name="EditRegion1" -->
    <div id="accordion">
     
    	  <h3><a href="#">Cambio de Clave</a></h3>
		  <div><?php include('../usuarios/clave.php');?></div>
</div>

<!-- TemplateEndEditable -->




<?php include('../include/pie.php'); ?>
</body>
</html>
<?php
//mysql_free_result($rst_usuarios);
?>
