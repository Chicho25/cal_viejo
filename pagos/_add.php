<?php //require_once('../Connections/conexion.php'); ?>
<?php require_once('../include/header.php'); ?>
<p>
  <?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_conexion, $conexion);
$query_rst_proyecto = "SELECT CODIGO, NOMBRE FROM proyectos";
$rst_proyecto = mysql_query($query_rst_proyecto, $conexion) or die(mysql_error());
$row_rst_proyecto = mysql_fetch_assoc($rst_proyecto);
$totalRows_rst_proyecto = mysql_num_rows($rst_proyecto);
?>
  <script type="text/javascript">
$("document").ready
	(function()
		{$("#proyecto").change(function () { 
		//alert("aqui estoy");
		if($(this).val()!=' '){
			//alert($(this).val());
					$("#proyecto option:selected").each(
					function () {
					//alert($(this).val());
					$("#proveedor").attr("disabled",false);
					elegidos=$(this).val();
					$.post("proveedor.php", 
					{COD_PROYECTO: elegidos}, function(data)
					{$("#proveedor").html(data);													
										
				});	
       		
		});
		}
	 else{$("#proveedor").attr("disabled",true);}		
   	})
	
	//////////////
	
	
})
  </script>
  <script type="text/javascript">
$("document").ready  
  (function()
		{$("#proveedor").change(function () { 
		//alert("aqui estoy");
		if($(this).val()!=' '){
			//alert($(this).val());
					$("#proveedor option:selected").each(
					function () {
					//alert($(this).val());
					elegido=$(this).val();
					$.post("result.php", 
					{ID_PRO_CLI: elegido, PROYECTO: elegidos}, function(data)
					{$("#resul").html(data);													
										
				});	
       			});
		}
		else{
			//alert($(this).val());
					$("#proveedor option:selected").each(
					function () {
					//alert($(this).val());
					elegido=$(this).val();
					$.post("result.php", 
					{ID_PRO_CLI: 0, PROYECTO: 0}, function(data)
					{$("#resul").html(data);													
										
				});	
       			});
		}
	   	})

})
</script>
</p>
<form id="form1" name="form1" method="post" action="">
  <table width="600" border="0" align="center" class="Campos">
    <tr>
      <th width="143" height="32" align="right" class="Campos">Proyecto:</th>
      <th align="left" scope="col"> <select name="proyecto" id="proyecto">
        <option value=" ">Seleccione el Proyecto</option>
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
      </select></th>
    </tr>
    <tr align="center">
      <td width="143" height="32" align="right" class="Campos">Proveedor:</td>
      <td align="left"><select name="proveedor" id="proveedor" disabled="disabled">
        <option value=" " selected="selected">Seleccione el Proveedor</option>
      </select></td>
    </tr>
  </table>
</form>

<div id="resul">

</div>
<?php
mysql_free_result($rst_proyecto);
?>
