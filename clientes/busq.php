<?php require_once('../Connections/conexion.php'); ?>
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
$query_Recordset1 = "SELECT * FROM vista_pro_cli where contacto <> '' ORDER BY NOMBRE ASC";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_conexion, $conexion);
$query_Recordset2 = "SELECT distinct TIPO, COD_TIPO FROM vista_pro_cli WHERE cod_tipo IN(2, 3)";
$Recordset2 = mysql_query($query_Recordset2, $conexion) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>

<link href="../css/encabezados.css" rel="stylesheet" type="text/css" />

<form action="list.php" method="get" name="form_buscar">
  <table width="990" border="0" align="center" class="Campos">
    <tr>
      <td width="505" align="right">&nbsp;</td>
      <td width="475"><label for="nombre"></label>
       <?php 
	  $tabla="vista_pro_cli";
	  $where=" WHERE COD_TIPO IN(2,3)";
	  $label="Nombre";
	  $nombre_campo_mostrar="NOMBRE";
	  $nombre_campo_value="ID_PRO_CLI";
	  $nombre_campo_form="nombre";
	  $parametro=" AND ID_PRO_CLI=";
	  $ancho=550;
	  $boton=0;
	  $accion="accion()";
	  
	  
	  include_once('../include/autocompletar.php');?> 
<!--        <select name="nombre" id="nombre">
          <option value=" ">Seleccione...</option>
          <?php
do {  
?>
          <option value=' AND NOMBRE="<?php echo $row_Recordset1['NOMBRE']?>"'><?php echo $row_Recordset1['NOMBRE']?></option>
          <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
      </select>--></td>
    </tr>
    <tr>
      <td align="right">Tipo:</td>
      <td><label for="contacto"></label>
        <select name="tipo" id="tipo">
          <option value=" ">TODO</option>
          <?php
do {  
?>
          <option value=' AND COD_TIPO=<?php echo $row_Recordset2['COD_TIPO']?>'><?php echo $row_Recordset2['TIPO']?></option>
          <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td align="right">Contacto:</td>
      <td><label for="contacto"></label>
       <?php 
	/*  $tabla="vista_pro_cli";
	  $where=" WHERE COD_TIPO IN(3,2) AND CONTACTO <> '' ";
	  $label="Contacto:";
	  $nombre_campo_mostrar="CONTACTO";
	  $nombre_campo_value="CONTACTO";
	  $nombre_campo_form="contacto";
	  $parametro=" AND CONTACTO=";
	  $ancho=550;
	  $boton=0;
	  $accion="accion()";
	  
	  
	  include_once('../include/autocompletar.php');*/?> 
        <select name="contacto" id="contacto">
          <option value=" ">TODO</option>
          <?php
do {  
?>
          <option value=" AND CONTACTO='<?php echo $row_Recordset1['CONTACTO']?>'"><?php echo $row_Recordset1['CONTACTO']?></option>
          <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td align="right">Tiene documentos:</td>
      <td><label for="tipo"></label>
        <label for="documentos"></label>
        <select name="documentos" id="documentos">
        <option value=" ">TODO</option>
          <option value=" AND DOCUMENTOS=1">SI</option>
          <option value=" AND DOCUMENTOS=0">NO</option>
      </select></td>
    </tr>
    <tr>
      <td height="52" colspan="2" align="center" valign="middle"><input name="titulo_formulario" type="hidden" id="titulo_formulario" value="Clientes" />
      <input type="hidden" name="titulo_menu" id="titulo_menu" value="Clientes" />        <input type="submit" name="buscar" id="buscar" value="Aceptar" class="ui-state-hover"/></td>
    </tr>
  </table>

</form>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
