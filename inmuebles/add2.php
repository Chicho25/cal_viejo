<?php 
/*! 
  @function num2letras () 
  @abstract Dado un n?mero lo devuelve escrito. 
  @param $num number - N?mero a convertir. 
  @param $fem bool - Forma femenina (true) o no (false). 
  @param $dec bool - Con decimales (true) o no (false). 
  @result string - Devuelve el n?mero escrito en letra. 

*/ 
function num2letras($num, $fem = true, $dec = true) { 
//if (strlen($num) > 14) die("El n?mero introducido es demasiado grande"); 
   $matuni[2]  = "dos"; 
   $matuni[3 ]  = "tres"; 
   $matuni[4 ]  = "cuatro"; 
   $matuni[5 ]  = "cinco"; 
   $matuni[6 ]  = "seis"; 
   $matuni[7 ]  = "siete"; 
   $matuni[8 ]  = "ocho"; 
   $matuni[9 ]  = "nueve"; 
   $matuni[10] = "diez"; 
   $matuni[11] = "once"; 
   $matuni[12] = "doce"; 
   $matuni[13] = "trece"; 
   $matuni[14] = "catorce"; 
   $matuni[15 ] = "quince" ; 
   $matuni[16 ] = "dieciseis"; 
   $matuni[17 ] = "diecisiete"; 
   $matuni[18 ] = "dieciocho"; 
   $matuni[19 ] = "diecinueve"; 
   $matuni[20 ] = "veinte"; 
   $matunisub[2] = "dos"; 
   $matunisub[3] = "tres"; 
   $matunisub[4] = "cuatro"; 
   $matunisub[5] = "quin"; 
   $matunisub[6] = "seis"; 
   $matunisub[7] = "sete"; 
   $matunisub[8] = "ocho"; 
   $matunisub[9] = "nove"; 

   $matdec[2] = "veint"; 
   $matdec[3] = "treinta"; 
   $matdec[4] = "cuarenta"; 
   $matdec[5] = "cincuenta"; 
   $matdec[6] = "sesenta"; 
   $matdec[7] = "setenta"; 
   $matdec[8] = "ochenta"; 
   $matdec[9] = "noventa"; 
   $matsub[3]  = 'mill' ; 
   $matsub[5]  = 'bill'; 
   $matsub[7]  = 'mill'; 
   $matsub[9]  = 'trill'; 
   $matsub[11] = 'mill'; 
   $matsub[13] = 'bill'; 
   $matsub[15] = 'mill'; 
   $matmil[4]  = 'millones'; 
   $matmil[6]  = 'billones'; 
   $matmil[7]  = 'de billones'; 
   $matmil[8]  = 'millones de billones'; 
   $matmil[10] = 'trillones'; 
   $matmil[11] = 'de trillones'; 
   $matmil[12] = 'millones de trillones'; 
   $matmil[13] = 'de trillones'; 
   $matmil[14] = 'billones de trillones'; 
   $matmil[15] = 'de billones de trillones'; 
   $matmil[16] = 'millones de billones de trillones'; 

   $num = trim((string)@$num); 
   if ($num[0] == '-') { 
      $neg = 'menos '; 
      $num = substr($num, 1); 
   }else 
      $neg = ''; 
   while ($num[0] == '0') $num = substr($num, 1); 
   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
   $zeros = true; 
   $punt = false; 
   $ent = ''; 
   $fra = ''; 
   for ($c = 0; $c < strlen($num); $c++) { 
      $n = $num[$c]; 
      if (! (strpos(".,'''", $n) === false)) { 
         if ($punt) break; 
         else{ 
            $punt = true; 
            continue; 
         } 

      }elseif (! (strpos('0123456789', $n) === false)) { 
         if ($punt) { 
            if ($n != '0') $zeros = false; 
            $fra .= $n; 
         }else 

            $ent .= $n; 
      }else 

         break; 

   } 
   $ent = '     ' . $ent; 
   if ($dec and $fra and ! $zeros) { 
      $fin = ' con'; 
      for ($n = 0; $n < strlen($fra); $n++) { 
         if (($s = $fra[$n]) == '0') 
            $fin .= ' cero'; 
         elseif ($s == '1') 
            $fin .= $fem ? ' una' : ' un'; 
         else 
            $fin .= ' ' . $matuni[$s]; 
      } 
   }else 
      $fin = ''; 
   if ((int)$ent === 0) return 'Cero ' . $fin; 
   $tex = ''; 
   $sub = 0; 
   $mils = 0; 
   $neutro = false; 
   while ( ($num = substr($ent, -3)) != '   ') { 
      $ent = substr($ent, 0, -3); 
      if (++$sub < 3 and $fem) { 
         $matuni[1] = 'una'; 
         $subcent = 'as' ; 
      }else{ 
         $matuni[1] = $neutro ? 'un' : 'uno'; 
         $subcent = 'os'; 
      } 
      $t = ''; 
      $n2 = substr($num, 1); 
      if ($n2 == '00') { 
      }elseif ($n2 < 21 ) 
         $t = ' ' . $matuni[(int)$n2]; 
      elseif ($n2 < 30) { 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = 'i' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      }else{ 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 

         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      } 
      $n = $num[0]; 
      if ($n == 1) { 
         $t = ' ciento' . $t; 
      }elseif ($n == 5){ 
         $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t; 
      }elseif ($n != 0){ 
         $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t; 
      } 
      if ($sub == 1) { 
      }elseif (! isset($matsub[$sub])) { 
         if ($num == 1) { 
            $t = ' mil'; 
         }elseif ($num > 1){ 
            $t .= ' mil'; 
         } 
      }elseif ($num == 1) { 
         $t .= ' ' . $matsub[$sub] . '?n'; 
      }elseif ($num > 1){ 
         $t .= ' ' . $matsub[$sub] . 'ones'; 
      }   
      if ($num == '000') $mils ++; 
      elseif ($mils != 0) { 
         if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
         $mils = 0; 
      } 
      $neutro = true; 
      $tex = $t . $tex; 
   } 
   $tex = $neg . substr($tex, 1) . $fin; 
   return ucfirst($tex); 
} 

?>
<?php require_once('../../Connections/conexion.php'); ?>
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

$colname_PAGOS = "-1";
if (isset($_GET['ID_PAGO'])) {
  $colname_PAGOS = $_GET['ID_PAGO'];
}
mysql_select_db($database_conexion, $conexion);
$query_PAGOS = sprintf("SELECT * FROM vista_pagos_partidas WHERE ID_PAGO = %s", GetSQLValueString($colname_PAGOS, "int"));
$PAGOS = mysql_query($query_PAGOS, $conexion) or die(mysql_error());
$row_PAGOS = mysql_fetch_assoc($PAGOS);
$totalRows_PAGOS = mysql_num_rows($PAGOS);

mysql_select_db($database_conexion, $conexion);
$query_CHEQUE = "SELECT * FROM vista_banco_chequeras WHERE CODIGO_PROYECTO = 'CODIGO_PROYECTO'";
$CHEQUE = mysql_query($query_CHEQUE, $conexion) or die(mysql_error());
$row_CHEQUE = mysql_fetch_assoc($CHEQUE);
$totalRows_CHEQUE = mysql_num_rows($CHEQUE);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<title>Untitled Document</title>
<?php include("../include/_js.php"); ?>
<?php include("../include/_css.php"); ?>
<?php 
$visivilidad="none";
?>
<script>
$(document).ready(function(){

        var current_id;

        $("#dialog-confirm").dialog({
            resizable: false,
            height:200,
            modal: true,
            autoOpen:true,
            buttons: {
                'Cancelar': function() {
                    $(this).dialog('close');
                },
                'Guardar': function() {
                    $(this).dialog('close');
                    DoSomething();
                }
            }
        });
            
    });
    
        
        // open dialog, set variable
        function openDialog() {
            //current_id = id;
            $("#dialog-confirm").dialog('open');
            };
            
         // Do something if OK
        function DoSomething() {
			//alert($("form.BENEFICIARIO").val());
            //local_id = current_id;
			var url = "_add.php?BENEFICIARIO=<?php echo $_GET['BENEFICIARIO']; ?>&ID_PAGO=<?php echo $_GET['ID_PAGO']; ?>&CHEQUE=<?php echo $_GET['CHEQUE']; ?>&ID_CHEQUERA=<?php //echo $_GET['ID_CHEQUERA']; ?>"; 
			window.location =   url; 
		//$(location).attr('href',url);
            //alert('Do something with ' + local_id);
        };

</script>
</head>

<body>
<?php $opcion_menu=2; ?>
<?php include("../include/menu.php"); ?>

<table width="1100" align="center" class="ui-widget-header" >
	<tr>
		<td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Nuevo Cheque</div>
	</tr>
</table>
<form action="_add.php" method="get" target="pdf">
<table width="1100" border="0" cellpadding="2" cellspacing="2" align="center">
	<tr>
	  <td width="346" bgcolor="#F0F0F0" class="textos_form_derecha">Cheque:</td>
	  <td bgcolor="#F0F0F0" class="textos_form"><input name="CHEQUE" type="text" class="textos_form_derecha" value="<?php echo $_GET['CHEQUE'] ?>" readonly="readonly" /></td>
    </tr>
	
	<tr>
	  <td rowspan="2" bgcolor="#F0F0F0" class="textos_form_derecha">Monto Cheque:</td>
	  <td width="654" bgcolor="#F0F0F0" class="textos_form"><input name="MONTO" type="text" class="textos_form_derecha" value="<?php echo $_GET['MONTO'] ?>" readonly="readonly" /></td>
    </tr>
	<tr>
		<td bgcolor="#F0F0F0" class="textos_form"><?php echo $_GET['MONTO_LETRAS'] ?><input name="MONTO_LETRAS" type="hidden" value="<?php echo $GET['MONTO_LETRAS']; ?>" /></td>
	</tr>
	<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Cuenta:</td>
	  <td bgcolor="#F0F0F0" class="textos_form"><input name="textfield" type="text" class="textos_form" id="textfield" value="<?php echo $_GET['TEXTO_CUENTA']; ?>" size="70" readonly="readonly" /></td>
    </tr>
	<tr>	<?php  
 
$r=($MONTO-intval($MONTO))*100; 

?>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Beneficiario:</td>
	  <td width="654" bgcolor="#F0F0F0"><input name="BENEFICIARIO" type="text" class="textos_form" value="<?php echo $_GET['BENEFICIARIO'] ?>" size="80" />
      <input type="hidden" name="MONTO_LETRAS" id="MONTO_LETRAS" value="<?php echo $_GET['MONTO_LETRAS'] ?>" />
      </td>
    </tr>


	<tr>
	  <td colspan="2" align="center" bgcolor="#F0F0F0" class="textos_form"><input name="button3" type="submit" class="ui-widget-header" id="button3" value="Guardar" />	    <input name="button" type="button" class="ui-state-error" id="button" value="Anular Cheque" onClick="window.location='cheque_anulado.php?CHEQUE=<?php echo $_GET['CHEQUE'] ?>'" /></td>
	</tr>
</table>
</form><center>
<iframe height="400" width="1000" src="print.php?ID_PAGO=<?php echo $_GET['ID_PAGO'] ?>&BENEFICIARIO=<?php echo $_GET['BENEFICIARIO'] ?>&MONTO=<?php echo $_GET['MONTO'] ?>&MONTO_LETRAS=<?php echo $_GET['MONTO_LETRAS'] ?>"></iframe></center>

<div id="dialog-confirm" title="Impresion Correcta?">
	<p><span class="ui-icon-document" style="float:left; margin:0 7px 20px 0;"></span>
  Espere unos segundos, e imprima el cheque.<br>Si la impresion es correcta, proceda a guardar el pago?</p>
</div>
</body>
</html>
<?php
mysql_free_result($PAGOS);

mysql_free_result($CHEQUE);
?>
