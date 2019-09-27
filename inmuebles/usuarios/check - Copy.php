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
$query_grupos = "SELECT DISTINCT ID_MENU, DETALLE_ACCESO, DESCRIPCION_MENU FROM vista_usuarios_roles WHERE  ID_ROLE=".$_POST['COD_PROYECTOS_MASTER']." ORDER BY NIVEL_MENU";
$grupos = mysql_query($query_grupos, $conexion) or die(mysql_error());
$row_grupos = mysql_fetch_assoc($grupos);
$totalRows_grupos = mysql_num_rows($grupos);
$roless =$_POST['COD_PROYECTOS_MASTER'];

?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>  
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
 
<form method="post" name="form2" action="_roles2.php">
  <input name="roles-1" type="hidden" value="<?php echo $roless ?>" />
  <table border="0" align="center" bgcolor="#CCCCCC">
    <tr align="center" valign="middle" class="ui-widget-header">
      <td width="250">Menus</td>
      <td width="63"><p>Navegar</p>
        <p>
          <input type="button" class="bnavegar ui-state-hover" value="Todos" />
      </p></td>
      <td width="63"><p>Incluir</p>
      <p>
        <input type="button" class="bincluir ui-state-hover" value="Todos" />
      </p></td>
      <td width="63"><p>Editar</p>
      <p>
        <input type="button" class="beditar ui-state-focus" value="Todos" />
      </p></td>
      <td width="63"><p>Eliminar</p>
      <p>
        <input type="button" class="beliminar ui-state-focus " value="Todos" />
      </p></td>
      <td width="63"><p>Reservar</p>
      <p>
        <input type="button" class="botros ui-state-hover" value="Todos" />
      </p></td>
      
      
      <td width="63"><p>Liberar</p>
      <p>
        <input type="button" class="liberar ui-state-hover" value="Todos" />
      </p></td>
      <td width="63"><p>Otros1</p>
      <p>
        <input type="button" class="botros1 ui-state-hover" value="Todos" />
      </p></td>
      <td width="63"><p>Otros2</p>
      <p>
        <input type="button" class="botros2 ui-state-hover" value="Todos" />
      </p></td>
      <td width="63"><p>Otros3</p>
      <p>
        <input type="button" class="botros3 ui-state-hover" value="Todos" />
      </p></td>
      <td width="63"><p>Otros4</p>
      <p>
        <input type="button" class="botros4 ui-state-hover" value="Todos" />
      </p></td>
      <td width="63"><p>Otros5</p>
      <p>
        <input type="button" class="botros5 ui-state-hover" value="Todos" />
      </p></td>
      <td width="63"><p>Otros6</p>
      <p>
        <input type="button" class="botros6 ui-state-hover" value="Todos" />
      </p></td>
      <td width="63"><p>Otros7</p>
      <p>
        <input type="button" class="botros7 ui-state-hover" value="Todos" />
      </p></td>
      <td width="63"><p>Otros8</p>
      <p>
        <input type="button" class="botros8 ui-state-hover" value="Todos" />
      </p></td>
      <td width="63"><p>Otros9</p>
      <p>
        <input type="button" class="botros9 ui-state-hover" value="Todos" />
      </p></td>
      <td width="63"><p>Otros10</p>
      <p>
        <input type="button" class="botros10 ui-state-hover" value="Todos" />
      </p></td>
      <td width="63"><p>Otros11</p>
      <p>
        <input type="button" class="botros11 ui-state-hover" value="Todos" />
      </p></td>
      <td width="63"><p>Otros12</p>
      <p>
        <input type="button" class="botros12 ui-state-hover" value="Todos" />
      </p></td>
      <td width="63"><p>Otros13</p>
      <p>
        <input type="button" class="botros13 ui-state-hover" value="Todos" />
      </p></td>
      <td width="63"><p>Otros14</p>
      <p>
        <input type="button" class="botros14 ui-state-hover" value="Todos" />
      </p></td>
           </tr>
    <?php $a=1;
	do { 
	?>
  
      <tr align="center" bgcolor="#CCCCCC" class="Campos">
        <td width="250" align="left"><?php echo $row_grupos['DESCRIPCION_MENU']; ?>
          <input name="ID_MENU-<?php echo $row_grupos['ID_MENU']; ?>" type="hidden" id="ID_MENU<?php echo $row_grupos['ID_MENU']; ?>" value="<?php echo $row_grupos['ID_MENU']; ?>" />
        <!--<input type="hidden" name="ID_ACCESO-<?php echo $row_grupos['ID_MENU']; ?>" id="ID_ACCESO<?php echo $row_grupos['ID_ACCESO']; ?>"  value="<?php echo $row_grupos['ID_ACCESO']; ?>"/--></td>
        <td width="63">
          <input type="hidden" name="FORMULARIO_VIEW-<?php echo $row_grupos['ID_MENU']; ?>" id="hiddenField" value="0" />
          <input <?php if (!(strcmp(substr($row_grupos['DETALLE_ACCESO'],0,1),1))) {echo "checked=\"checked\"";} ?> class="navegar" type="checkbox" name="FORMULARIO_VIEW-<?php echo $row_grupos['ID_MENU']; ?>" id="left" value="1" />
		</td>
        <td width="63">
          <input type="hidden" name="FORMULARIO_INSERT-<?php echo $row_grupos['ID_MENU']; ?>" id="hiddenField" value="0" />
          <input <?php if (!(strcmp(substr($row_grupos['DETALLE_ACCESO'],1,1),1))) {echo "checked=\"checked\"";} ?> class="incluir" type="checkbox" name="FORMULARIO_INSERT-<?php echo $row_grupos['ID_MENU']; ?>" id="checkbox" value="1" />
</td>
        <td width="63">
        
                  <input type="hidden" name="FORMULARIO_UPDATE-<?php echo $row_grupos['ID_MENU']; ?>" id="hiddenField" value="0" />
          <input <?php if (!(strcmp(substr($row_grupos['DETALLE_ACCESO'],2,1),1))) {echo "checked=\"checked\"";} ?> class="editar" type="checkbox" name="FORMULARIO_UPDATE-<?php echo $row_grupos['ID_MENU']; ?>" id="checkbox" value="1" />
        </td>
        <td width="63">         
         <input type="hidden" name="FORMULARIO_DELETE-<?php echo $row_grupos['ID_MENU']; ?>" id="hiddenField" value="0" />
          <input <?php if (!(strcmp(substr($row_grupos['DETALLE_ACCESO'],3,1),1))) {echo "checked=\"checked\"";} ?> class="eliminar" type="checkbox" name="FORMULARIO_DELETE-<?php echo $row_grupos['ID_MENU']; ?>" id="checkbox" value="1" />
        </td>
                 <td width="63"><input type="hidden" name="FORMULARIO_OTHER-<?php echo $row_grupos['ID_MENU']; ?>" id="hiddenField" value="0" />
          <input <?php if (!(strcmp(substr($row_grupos['DETALLE_ACCESO'],4,1),1))) {echo "checked=\"checked\"";} ?> class="otros" type="checkbox" name="FORMULARIO_OTHER-<?php echo $row_grupos['ID_MENU']; ?>" id="checkbox" value="1" />
          </td>
          
          
                           <td width="63"><input type="hidden" name="FORMULARIO_LIBERAR-<?php echo $row_grupos['ID_MENU']; ?>" id="hiddenField" value="0" />
          <input <?php if (!(strcmp(substr($row_grupos['DETALLE_ACCESO'],5,1),1))) {echo "checked=\"checked\"";} ?> class="liberar" type="checkbox" name="FORMULARIO_LIBERAR-<?php echo $row_grupos['ID_MENU']; ?>" id="checkbox" value="1" />
          </td>
 
                  <td width="20"><input type="hidden" name="FORMULARIO_OTHER1-<?php echo $row_grupos['ID_MENU']; ?>" id="hiddenField" value="0" />
          <input <?php if (!(strcmp(substr($row_grupos['DETALLE_ACCESO'],6,1),1))) {echo "checked=\"checked\"";} ?> class="otros1" type="checkbox" name="FORMULARIO_OTHER1-<?php echo $row_grupos['ID_MENU']; ?>" id="checkbox" value="1" />
          </td>
 
                  <td width="20"><input type="hidden" name="FORMULARIO_OTHER2-<?php echo $row_grupos['ID_MENU']; ?>" id="hiddenField" value="0" />
          <input <?php if (!(strcmp(substr($row_grupos['DETALLE_ACCESO'],7,1),1))) {echo "checked=\"checked\"";} ?> class="otros2" type="checkbox" name="FORMULARIO_OTHER2-<?php echo $row_grupos['ID_MENU']; ?>" id="checkbox" value="1" />
          </td>
 
                  <td width="20"><input type="hidden" name="FORMULARIO_OTHER3-<?php echo $row_grupos['ID_MENU']; ?>" id="hiddenField" value="0" />
          <input <?php if (!(strcmp(substr($row_grupos['DETALLE_ACCESO'],8,1),1))) {echo "checked=\"checked\"";} ?> class="otros3" type="checkbox" name="FORMULARIO_OTHER3-<?php echo $row_grupos['ID_MENU']; ?>" id="checkbox" value="1" />
          </td>
 
                  <td width="20"><input type="hidden" name="FORMULARIO_OTHER4-<?php echo $row_grupos['ID_MENU']; ?>" id="hiddenField" value="0" />
          <input <?php if (!(strcmp(substr($row_grupos['DETALLE_ACCESO'],9,1),1))) {echo "checked=\"checked\"";} ?> class="otros4" type="checkbox" name="FORMULARIO_OTHER4-<?php echo $row_grupos['ID_MENU']; ?>" id="checkbox" value="1" />
          </td>
 
                  <td width="20"><input type="hidden" name="FORMULARIO_OTHER5-<?php echo $row_grupos['ID_MENU']; ?>" id="hiddenField" value="0" />
          <input <?php if (!(strcmp(substr($row_grupos['DETALLE_ACCESO'],10,1),1))) {echo "checked=\"checked\"";} ?> class="otros5" type="checkbox" name="FORMULARIO_OTHER5-<?php echo $row_grupos['ID_MENU']; ?>" id="checkbox" value="1" />
          </td>
 
                  <td width="20"><input type="hidden" name="FORMULARIO_OTHER6-<?php echo $row_grupos['ID_MENU']; ?>" id="hiddenField" value="0" />
          <input <?php if (!(strcmp(substr($row_grupos['DETALLE_ACCESO'],11,1),1))) {echo "checked=\"checked\"";} ?> class="otros6" type="checkbox" name="FORMULARIO_OTHER6-<?php echo $row_grupos['ID_MENU']; ?>" id="checkbox" value="1" />
          </td>
 
                  <td width="20"><input type="hidden" name="FORMULARIO_OTHER7-<?php echo $row_grupos['ID_MENU']; ?>" id="hiddenField" value="0" />
          <input <?php if (!(strcmp(substr($row_grupos['DETALLE_ACCESO'],12,1),1))) {echo "checked=\"checked\"";} ?> class="otros7" type="checkbox" name="FORMULARIO_OTHER7-<?php echo $row_grupos['ID_MENU']; ?>" id="checkbox" value="1" />
          </td>
 
                  <td width="20"><input type="hidden" name="FORMULARIO_OTHER8-<?php echo $row_grupos['ID_MENU']; ?>" id="hiddenField" value="0" />
          <input <?php if (!(strcmp(substr($row_grupos['DETALLE_ACCESO'],13,1),1))) {echo "checked=\"checked\"";} ?> class="otros8" type="checkbox" name="FORMULARIO_OTHER8-<?php echo $row_grupos['ID_MENU']; ?>" id="checkbox" value="1" />
          </td>
                  <td width="20"><input type="hidden" name="FORMULARIO_OTHER9-<?php echo $row_grupos['ID_MENU']; ?>" id="hiddenField" value="0" />
          <input <?php if (!(strcmp(substr($row_grupos['DETALLE_ACCESO'],14,1),1))) {echo "checked=\"checked\"";} ?> class="otros9" type="checkbox" name="FORMULARIO_OTHER9-<?php echo $row_grupos['ID_MENU']; ?>" id="checkbox" value="1" />
          </td>
                  <td width="20"><input type="hidden" name="FORMULARIO_OTHER10-<?php echo $row_grupos['ID_MENU']; ?>" id="hiddenField" value="0" />
          <input <?php if (!(strcmp(substr($row_grupos['DETALLE_ACCESO'],15,1),1))) {echo "checked=\"checked\"";} ?> class="otros10" type="checkbox" name="FORMULARIO_OTHER10-<?php echo $row_grupos['ID_MENU']; ?>" id="checkbox" value="1" />
          </td>
          
          <td width="20"><input type="hidden" name="FORMULARIO_OTHER11-<?php echo $row_grupos['ID_MENU']; ?>" id="hiddenField" value="0" />
          <input <?php if (!(strcmp(substr($row_grupos['DETALLE_ACCESO'],16,1),1))) {echo "checked=\"checked\"";} ?> class="otros11" type="checkbox" name="FORMULARIO_OTHER11-<?php echo $row_grupos['ID_MENU']; ?>" id="checkbox" value="1" />
          </td><td width="20"><input type="hidden" name="FORMULARIO_OTHER12-<?php echo $row_grupos['ID_MENU']; ?>" id="hiddenField" value="0" />
          <input <?php if (!(strcmp(substr($row_grupos['DETALLE_ACCESO'],17,1),1))) {echo "checked=\"checked\"";} ?> class="otros12" type="checkbox" name="FORMULARIO_OTHER12-<?php echo $row_grupos['ID_MENU']; ?>" id="checkbox" value="1" />
          </td><td width="20"><input type="hidden" name="FORMULARIO_OTHER13-<?php echo $row_grupos['ID_MENU']; ?>" id="hiddenField" value="0" />
          <input <?php if (!(strcmp(substr($row_grupos['DETALLE_ACCESO'],18,1),1))) {echo "checked=\"checked\"";} ?> class="otros13" type="checkbox" name="FORMULARIO_OTHER13-<?php echo $row_grupos['ID_MENU']; ?>" id="checkbox" value="1" />
          </td><td width="20"><input type="hidden" name="FORMULARIO_OTHER14-<?php echo $row_grupos['ID_MENU']; ?>" id="hiddenField" value="0" />
          <input <?php if (!(strcmp(substr($row_grupos['DETALLE_ACCESO'],19,1),1))) {echo "checked=\"checked\"";} ?> class="otros14" type="checkbox" name="FORMULARIO_OTHER14-<?php echo $row_grupos['ID_MENU']; ?>" id="checkbox" value="1" />
                          </tr>
      <?php 
	  $a=$a+1;
	   } while ($row_grupos = mysql_fetch_assoc($grupos)); ?>
  </table>
  <table width="990" border="0" align="center">
  <tr>
    <td height="37" align="center" valign="middle"><input name="guardar-1" align="middle"type="submit" class="ui-state-hover" id="guardar" value="Aceptar" /></td>
  </tr>
</table>

  <p>&nbsp;</p>
</form>

<?php
mysql_free_result($grupos);
?>