<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<!--; charset=utf-8"
--><title>.:: Reportes ::.</title>
<?php include('../include/header.php'); ?>
<?php if(isset($_GET['aceptar'])) { $activa=1;} else {$activa=0;} ?>
<?php //echo 'valor ' .$activa; ?>
 <script type="text/javascript">
            var ns4 = (document.layers)? true:false
            var ie4 = (document.all)? true:false
            var ns6 = (document.getElementById && !document.all) ? true: false;
            var coorX, coorY;

            if (ns6) document.addEventListener("mousemove", mouseMove, true)
            if (ns4) {document.captureEvents(Event.MOUSEMOVE); document.mousemove = mouseMove;}

            function mouseMove(e)    {
                if (ns4||ns6)    {
                    coorX = e.pageX;
                    coorY = e.pageY;
                }
                if (ie4)    {
                    coorX = event.x;
                    coorY = event.y;
                }
                coorX += document.body.scrollLeft;
                coorY += document.body.scrollTop;
                return true;
            }

            function ini()    {
                if (ie4)    document.body.onmousemove = mouseMove;
            }

            function mostrar(dato)    {
                with(document.getElementById("ayuda"))    {
                    style.top = coorY + 20 + 'px';
                    style.left = coorX + 20 + 'px';
                    style.visibility = "visible";
					innerHTML = dato;
                }
            }

            function ocultar()    {
                document.getElementById("ayuda").style.visibility = "hidden";
            }

            function mover()    {
                with(document.getElementById("ayuda"))    {
                    style.top = coorY + 20 + 'px';
                    style.left = coorX + 20 + 'px';
                }
            }

        </script> 
<script>
	$(
	function()
	{
		$( "#accordion" ).accordion({ active:0, autoHeight: true});
	}
	);
	</script>
    <h1 align="center"><?php echo $_GET['titulo_formulario'] ?></h1>
<div id="accordion" style="height:420px">
		          
          <h3><a href="#">Busqueda</a></h3>
  		  <div><?php include('form.php');?></div>
   
          
  </div>
<br/>
<?php include('../include/pie.php'); ?>
