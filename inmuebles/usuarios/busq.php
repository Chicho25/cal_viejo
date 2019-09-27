<form id="form1" name="form1" method="get" action="list.php">
<br/>
<br/>
<br/>
<br/>
  <table width="406" border="0" align="center">
    <tr>
      <th width="73" height="40" scope="col">Busqueda</th>
      <th width="152" scope="col"><label for="busqueda"></label>
      <input type="text" name="busqueda" id="busqueda" /></th>
      <th width="167" class="txt_4" scope="col">Ingrese la palabra a buscar.</th>
    </tr>
    <tr align="center">
      <td colspan="3">
      <input type="hidden" name="titulo_formulario" id="titulo_formulario" 
      value="<?php echo $_GET['titulo_formulario'] ?>"/><input type="submit" name="buscar" class="ui-state-hover" id="buscar" value="Buscar" /></td>
    </tr>
  </table>
</form>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
