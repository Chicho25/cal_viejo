<?php include('../Connections/conexion.php'); ?>
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
$query_grupos = "SELECT DISTINCT ID_MENU, DETALLE_ACCESO, DESCRIPCION_MENU FROM vista_usuarios_roles WHERE  ID_ROLE=".$_POST['COD_PROYECTOS_MASTER']." AND ID_GRUPO_MENU=".$_POST['COD_PROYECTOS_MASTERS']." ORDER BY ORDEN_MENU";
$grupos = mysql_query($query_grupos, $conexion) or die(mysql_error());
$row_grupos = mysql_fetch_assoc($grupos);
$totalRows_grupos = mysql_num_rows($grupos);
$roless =$_POST['COD_PROYECTOS_MASTER'];

?>

<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>  
<script language="javascript">  
 	$(document).ready(function(){
    $('.bincluir').toggle(function(){
        $('.incluir').attr('checked','checked');
        $(this).val('Ninguno')
    },function(){
        $('.incluir').removeAttr('checked');
        $(this).val('Todos');        
    })
	})
	
	$(document).ready(function(){
    $('.bnavegar').toggle(function(){
        $('.navegar').attr('checked','checked');
        $(this).val('Ninguno')
    },function(){
        $('.navegar').removeAttr('checked');
        $(this).val('Todos');        
    })
	})

	$(document).ready(function(){
	$('.beditar').toggle(function(){
        $('.editar').attr('checked','checked');
        $(this).val('Ninguno')
    },function(){
        $('.editar').removeAttr('checked');
        $(this).val('Todos');        
    })
	})
	$(document).ready(function(){
	$('.beliminar').toggle(function(){
        $('.eliminar').attr('checked','checked');
        $(this).val('Ninguno')
    },function(){
        $('.eliminar').removeAttr('checked');
        $(this).val('Todos');        
    })
	})
		$(document).ready(function(){
 	$('.botros').toggle(function(){
        $('.otros').attr('checked','checked');
        $(this).val('Ninguno')
    },function(){
        $('.otros').removeAttr('checked');
        $(this).val('Todos');        
    })
	
	
})
////////
$(document).ready(function(){
 	$('.liberar').toggle(function(){
        $('.liberar').attr('checked','checked');
        $(this).val('Ninguno')
    },function(){
        $('.liberar').removeAttr('checked');
        $(this).val('Todos');        
    })
	})
$(document).ready(function(){
 	$('.botros1').toggle(function(){
        $('.otros1').attr('checked','checked');
        $(this).val('Ninguno')
    },function(){
        $('.otros1').removeAttr('checked');
        $(this).val('Todos');        
    })
	})
	
	$(document).ready(function(){
 	$('.botros2').toggle(function(){
        $('.otros2').attr('checked','checked');
        $(this).val('Ninguno')
    },function(){
        $('.otros2').removeAttr('checked');
        $(this).val('Todos');        
    })
	})
	$(document).ready(function(){
 	$('.botros3').toggle(function(){
        $('.otros3').attr('checked','checked');
        $(this).val('Ninguno')
    },function(){
        $('.otros3').removeAttr('checked');
        $(this).val('Todos');        
    })
	})
	$(document).ready(function(){
 	$('.botros4').toggle(function(){
        $('.otros4').attr('checked','checked');
        $(this).val('Ninguno')
    },function(){
        $('.otros4').removeAttr('checked');
        $(this).val('Todos');        
    })
	})
	$(document).ready(function(){
 	$('.botros5').toggle(function(){
        $('.otros5').attr('checked','checked');
        $(this).val('Ninguno')
    },function(){
        $('.otros5').removeAttr('checked');
        $(this).val('Todos');        
    })
	})
	$(document).ready(function(){
 	$('.botros6').toggle(function(){
        $('.otros6').attr('checked','checked');
        $(this).val('Ninguno')
    },function(){
        $('.otros6').removeAttr('checked');
        $(this).val('Todos');        
    })
	})
	$(document).ready(function(){
 	$('.botros7').toggle(function(){
        $('.otros7').attr('checked','checked');
        $(this).val('Ninguno')
    },function(){
        $('.otros7').removeAttr('checked');
        $(this).val('Todos');        
    })
	})
	$(document).ready(function(){
 	$('.botros8').toggle(function(){
        $('.otros8').attr('checked','checked');
        $(this).val('Ninguno')
    },function(){
        $('.otros8').removeAttr('checked');
        $(this).val('Todos');        
    })
	})
	$(document).ready(function(){
 	$('.botros9').toggle(function(){
        $('.otros9').attr('checked','checked');
        $(this).val('Ninguno')
    },function(){
        $('.otros9').removeAttr('checked');
        $(this).val('Todos');        
    })
	})
	$(document).ready(function(){
 	$('.botros10').toggle(function(){
        $('.otros10').attr('checked','checked');
        $(this).val('Ninguno')
    },function(){
        $('.otros10').removeAttr('checked');
        $(this).val('Todos');        
    })
	})
	$(document).ready(function(){
 	$('.botros11').toggle(function(){
        $('.otros11').attr('checked','checked');
        $(this).val('Ninguno')
    },function(){
        $('.otros11').removeAttr('checked');
        $(this).val('Todos');        
    })
	})
		$(document).ready(function(){
 	$('.botros12').toggle(function(){
        $('.otros12').attr('checked','checked');
        $(this).val('Ninguno')
    },function(){
        $('.otros12').removeAttr('checked');
        $(this).val('Todos');        
    })
	})
	$(document).ready(function(){
 	$('.botros13').toggle(function(){
        $('.otros13').attr('checked','checked');
        $(this).val('Ninguno')
    },function(){
        $('.otros13').removeAttr('checked');
        $(this).val('Todos');        
    })
	})
	$(document).ready(function(){
 	$('.botros14').toggle(function(){
        $('.otros14').attr('checked','checked');
        $(this).val('Ninguno')
    },function(){
        $('.otros14').removeAttr('checked');
        $(this).val('Todos');        
    })
	})
	$(document).ready(function(){
 	$('.botros15').toggle(function(){
        $('.otros15').attr('checked','checked');
        $(this).val('Ninguno')
    },function(){
        $('.otros15').removeAttr('checked');
        $(this).val('Todos');        
    })
	})
</script>
<link href="../css/encabezados.css" rel="stylesheet" type="text/css" />
<link href="../js/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
 -->
<form method="get" name="form2" action="_roles2.php">
  <input name="roles-1" type="hidden" value="<?php echo $roless ?>" />
  <table border="0" align="center" bgcolor="#CCCCCC">
    <tr align="center" valign="middle" class="ui-widget-header">
      <td width="250">Menus</td>
      <td width="63"><p>Navegar</p>
        <p>&nbsp;</p></td>
      <td width="63"><p>Incluir</p>
      <p>&nbsp;</p></td>
      <td width="63"><p>Editar</p>
      <p>&nbsp;</p></td>
      <td width="63"><p>Eliminar</p>
      <p>&nbsp;</p></td>
      
           </tr>
    <?php $a=1;
	do { 
	?>
  
      <tr align="center" bgcolor="#CCCCCC" class="Campos">
        <td width="250" align="left"><?php echo htmlentities($row_grupos['DESCRIPCION_MENU']); ?>
          <input name="ID_MENU-<?php echo $row_grupos['ID_MENU']; ?>" type="hidden" id="ID_MENU<?php echo $row_grupos['ID_MENU']; ?>" value="<?php echo $row_grupos['ID_MENU']; ?>" />
        <!--<input type="hidden" name="ID_ACCESO-<?php echo $row_grupos['ID_MENU']; ?>" id="ID_ACCESO<?php echo $row_grupos['ID_ACCESO']; ?>"  value="<?php echo $row_grupos['ID_ACCESO']; ?>"/--></td>
        <td width="63"><p>
          <input type="radio" name="radio" id="rd" value="1" />
          <label for="rd"></label>
          <input type="radio" name="radio" id="rd" value="0" />
          <label for="rd"></label>
        </p>          
        <label for="select"></label></td>
        <td width="63"><p>&nbsp;</p></td>
        <td width="63">&nbsp;</td>
        <td width="63">&nbsp;</td>
           </tr>
      <?php 
	  $a=$a+1;
	   } while ($row_grupos = mysql_fetch_assoc($grupos)); ?>
  </table>
  <table width="990" border="0" align="center">
  <tr>
    <td height="37" align="center" valign="middle"><input type="radio" name="radio" id="p1" value="p1" />
      <label for="p1"></label>      <input name="guardar-1" align="middle"type="submit" class="ui-state-hover" id="guardar" value="Aceptar" /></td>
  </tr>
</table>

  <p>&nbsp;</p>
</form>

<?php
mysql_free_result($grupos);
?>