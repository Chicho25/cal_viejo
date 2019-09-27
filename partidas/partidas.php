<script type="text/javascript">

function cesta($id){ 

//alert($("#id_menu").val());
//alert($("#titulo_formulario").val());
if($id!=' '){//alert('entro')
$.post("pagos_partidas.php",{id_grupo: $id, id_menu:$("#id_menu").val(), titulo_formulario:$("#titulo_formulario").val()}, function(data){$("#resul").html(data);})}}

</script>

<script type="text/javascript">

function cesta2($id){ 

//alert($("#id_menu").val());
//alert($("#titulo_formulario").val());
if($id!=' '){//alert('entro')
$.post("pagos_realizados.php",{id: $id, id_menu:$("#id_menu").val(), titulo_formulario:$("#titulo_formulario").val()}, function(data){$("#resul").html(data);})}}

</script>


<table width="990" border="0" align="center">
  <tr>
    <td width="20%" valign="top" class="Campos" ><input name="id_menu" id="id_menu" type="hidden" value="<?php echo $_GET['id_menu']; ?>" /><input name="titulo_formulario" id="titulo_formulario" type="hidden" value="<?php echo $_GET['titulo_formulario']; ?>" /><?php include('tree - Copy.php'); ?></td>
    <td width="80%" align="center" valign="top" bgcolor="#FFFFFF"><div id="resul"><?php include('pagos_partidas.php'); ?></div></td>
  </tr>
</table>
 