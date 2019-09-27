<?php $modulo=$modulo; ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_rst_proyecto = "SELECT CODIGO, NOMBRE FROM proyectos";
$rst_proyecto = mysql_query($query_rst_proyecto, $conexion) or die(mysql_error());
$row_rst_proyecto = mysql_fetch_assoc($rst_proyecto);
$totalRows_rst_proyecto = mysql_num_rows($rst_proyecto);
?>
 <script type="text/javascript">
 function accion()
 {
//este es el parametro que pasa del objeto a la variable que envias al formulario result.php
			proyecto=$("#proyecto").val();
			proveedor=$("#proveedor").val();
			modulos=$("#tmodulo").val();
			titulos=$("#formula").val();
			//
			if(($("#proyecto").val()!="")&&($("#proveedor").val()!="")){$.post("result.php",{ID_PRO_CLI: proveedor, PROYECTO: proyecto, MODULO:modulos, FORMULARIO:titulos}, function(data){$("#resul").html(data);});	
				}else
				{alert("Por favor seleccione el proyecto para realizar la busqueda...");}
				
 }
   </script>

<form id="form1" name="form1" method="post" action="">
 <table width="990" border="0" align="center" class="Campos">
    <tr>
      <th width="137" height="24" align="right" class="Campos">Proyecto:</th>
      <th width="453" align="left" scope="col"> <select name="proyecto" id="proyecto">
        <option value="">Seleccione el Proyecto</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rst_proyecto['CODIGO']?>" ><?php echo $row_rst_proyecto['NOMBRE']?></option>
        <?php
} while ($row_rst_proyecto = mysql_fetch_assoc($rst_proyecto));
  $rows = mysql_num_rows($rst_proyecto);
  if($rows > 0) {
      mysql_data_seek($rst_proyecto, 0);
	  $row_rst_proyecto = mysql_fetch_assoc($rst_proyecto);
  }
?>
      </select>
      <input name="tmodulo" type="hidden" id="tmodulo" value="<?php echo $modulo ?>" />
      <input name="formula" type="hidden" id="formula" value="<?php echo $_GET['titulo_formulario'] ?>" /></th>
    </tr>
  </table>
  <table width="990" align="center">
    <tr>
      <td align="center">
	  <?php 
	  if ($modulo == 1){
	  $tabla="pro_cli_master";
	  $where=" WHERE TIPO IN(1,3)";
	  $label="Proveedores";
	  $nombre_campo_mostrar="NOMBRE";
	  $nombre_campo_value="ID_PRO_CLI_MASTER";
	  $nombre_campo_form="proveedor";
	  $ancho=550;
	  $parametro="";
	  $boton=1;
	  $accion="accion()";}
	  else
	  {	  $tabla="pro_cli_master";
	  $where=" WHERE TIPO IN(2,3)";
	  $label="Clientes";
	  $nombre_campo_mostrar="NOMBRE";
	  $nombre_campo_value="ID_PRO_CLI_MASTER";
	  $nombre_campo_form="proveedor";
	  $ancho=550;
	  $parametro="";
	  $boton=1;
	  $accion="accion()";}
	  
	  
	  include_once('../include/autocompletar.php');?>
</td>
    </tr>
  </table>
  
</form><div id="resul">
</div>
<?php
mysql_free_result($rst_proyecto);
?>
