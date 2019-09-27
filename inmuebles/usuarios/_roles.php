<?php 
mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT ID_ROLE, NOMBRE_ROLE FROM usuarios_roles order by ID_ROLE";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_conexion, $conexion);
$query_Recordset2 = "SELECT ID_MENU, DESCRIPCION FROM usuarios_menu";
$Recordset2 = mysql_query($query_Recordset2, $conexion) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_conexion, $conexion);
$query_Recordset3 = "SELECT * FROM usuarios_menu a
WHERE a.nivel=1
AND EXISTS (SELECT 'x' FROM usuarios_menu b WHERE b.id_grupo=a.ID_MENU)";
$Recordset3 = mysql_query($query_Recordset3, $conexion) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
?>
   
<script>
	$(
	function()
	{		
	$("#ID_ROLE1").change(function () { 
   		$("#ID_ROLE1 option:selected").each(function () {
			//alert($(this).val());

				elegidos=$(this).val();
				valor=-1;
				$("#menus").val(valor);
				$("div.inmueble").html("");
		});
   	})


	})
	
    
    </script>
    <script>
	$(
	function()
	{		
	$("#menus").change(function () { 
   		$("#menus option:selected").each(function () {
			//alert($(this).val());

				elegidoss=$(this).val();
				valor=-1;
				$.post("subnivel_1.php", 
					{GRUPO: elegidoss}, function(data)
					{$("#NIVEL_1").html(data); 												
					$("div.inmueble").html(data);					
				});	
		});
   	})


	})
	
    
    </script>
      <script type="text/javascript">
$("document").ready  
  (function()
		{$("#menus").change(function () { 
		//alert("aqui estoy");
		if($(this).val()!=' '){
			//alert($(this).val());
					$("#menus option:selected").each(
					function () {
					elegido=$(this).val();
					$.post("check.php", 
					{COD_PROYECTOS_MASTER: elegidos, COD_PROYECTOS_MASTERS: elegido}, function(data)
					{//$(".inmueble").html(data); 												
					$("div.inmueble").html(data);					
				});	
       			});
		}
		else{
			//alert($(this).val());
					$("#proveedor option:selected").each(
					function () {
					//alert($(this).val());
					elegido=$(this).val();
					$.post("check.php", 
					{COD_PROYECTOS_MASTER: 0, COD_PROYECTOS_MASTERS: 0}, function(data)
					{$("div.inmueble").html(data);														
										
				});	
       			});
		}
	   	})

})
</script>
     <script type="text/javascript">
$("document").ready  
  (function()
		{$("#NIVEL_1").change(function () { 
		//alert("aqui estoy");
		if($(this).val()!=' '){
			//alert($(this).val());
					$("#NIVEL_1 option:selected").each(
					function () {
					elegido=$(this).val();
					$.post("check.php", 
					{COD_PROYECTOS_MASTER: elegidos, COD_PROYECTOS_MASTERS: elegido}, function(data)
					{//$(".inmueble").html(data); 												
					$("div.inmueble").html(data);					
				});	
       			});
		}
		else{
			
					$.post("check.php", 
					{COD_PROYECTOS_MASTER: 0, COD_PROYECTOS_MASTERS: 0}, function(data)
					{$("div.inmueble").html(data);														
										
					
       			});
		}
	   	})

})
</script>
<table width="990" align="center" class="Campos">
    <tr valign="baseline">
    <td width="445" align="right" nowrap>Rol:</td>
    <td width="533">
    <label for="ID_ROLE"></label>
    <select name="ID_ROLE1" id="ID_ROLE1">
    <option value="1">Seleccione...</option>
<?php
do {  
?>
<option value="<?php echo $row_Recordset1['ID_ROLE']?>">[<?php echo $row_Recordset1['ID_ROLE']?>] <?php echo $row_Recordset1['NOMBRE_ROLE']?></option>
<?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
        </select>
      </td>
    </tr>
  <tr valign="baseline">
      <td align="right" nowrap>Menus:</td>
      <td><label for="menus"></label>
        <select name="menus" id="menus">
          <option value="-1">Seleccione...</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset3['ID_MENU']?>"><?php echo $row_Recordset3['DESCRIPCION']?></option>
          <?php
} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
  $rows = mysql_num_rows($Recordset3);
  if($rows > 0) {
      mysql_data_seek($Recordset3, 0);
	  $row_Recordset3 = mysql_fetch_assoc($Recordset3);
  }
?>
    </select></td>
    </tr>
  <tr valign="baseline">
    <td align="right" nowrap>Sub Menus Nivel 1:</td>
    <td>
      <label for="NIVEL_1"></label>
      <select name="NIVEL_1" id="NIVEL_1">
      <option value="-1">Seleccione...</option>
      </select>
    </td>
  </tr>

  </table>
  
 <div class="inmueble">
  
 </div>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);
?>
