<?php include("../include/header.php"); 
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO banco_chequeras (ID_CUENTA_BANCARIA, CHEQUE_INICIO, CHEQUE_FIN, LONGITUD_NUMERO, ULTIMO_CHEQUE, AUTOMATICA, ACTIVA, ANULADA) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID_CUENTA_BANCARIA'], "int"),
                       GetSQLValueString($_POST['CHEQUE_INICIO'], "int"),
                       GetSQLValueString($_POST['CHEQUE_FIN'], "int"),
                       GetSQLValueString($_POST['LONGITUD_NUMERO'], "int"),
                       GetSQLValueString($_POST['ULTIMO_CHEQUE'], "int"),
                       GetSQLValueString(isset($_POST['AUTOMATICA']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['ACTIVA']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['ANULADA']) ? "true" : "", "defined","1","0"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
    	$ids=mysql_insert_id();
   aud($_SESSION['i'],$ids,'Creacion de chequera con el id ',30);


}

$codigo="";
			$nombre="";?>
<?php


mysql_select_db($database_conexion, $conexion);
$query_CONSULTAS = "SELECT * FROM vista_banco_chequeras ORDER BY ID_CHEQUERA ASC";
$CONSULTAS = mysql_query($query_CONSULTAS, $conexion) or die(mysql_error());
$row_CONSULTAS = mysql_fetch_assoc($CONSULTAS);
$totalRows_CONSULTAS = mysql_num_rows($CONSULTAS);

mysql_select_db($database_conexion, $conexion);
$query_CUENTAS_BANCARIAS = "SELECT * FROM vista_banco_cuentas";
$CUENTAS_BANCARIAS = mysql_query($query_CUENTAS_BANCARIAS, $conexion) or die(mysql_error());
$row_CUENTAS_BANCARIAS = mysql_fetch_assoc($CUENTAS_BANCARIAS);
$totalRows_CUENTAS_BANCARIAS = mysql_num_rows($CUENTAS_BANCARIAS);



/*Definiciones*/
$formulario="Banco00-add";
?>


<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
<?php $opcion_menu=2; ?>
<?php //include("../include/menu.php"); ?>

      <table width="990" align="center" class="ui-widget-header" >
    <tr>
          <td width="100%" align="center" class="textos_form"><div class="titulo_formulario">A&ntilde;adir Chequera</div>
    </tr>
  </table>
<?php //include("_menu.php"); ?><!--<div class="ui-state-error-text"><center><?php echo $alerta ?></center></div>-->
<form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
  <table width="990" align="center">
    <tr valign="baseline">
      <td width="502" align="right" nowrap="nowrap" bgcolor="#F3F3F3" class="textos_form_derecha">Cuentas Bancaria:</td>
      <td width="586" bgcolor="#F3F3F3"><select name="ID_CUENTA_BANCARIA">
        <?php 
do {  
?>
        <option value="<?php echo $row_CUENTAS_BANCARIAS['ID_CUENTA']?>" ><?php echo $row_CUENTAS_BANCARIAS['NOMBRE_PROYECTO']; ?> - <?php echo $row_CUENTAS_BANCARIAS['NOMBRE_BANCO']; ?> - <?php echo $row_CUENTAS_BANCARIAS['NUMERO_CUENTA']?></option>
        <?php
} while ($row_CUENTAS_BANCARIAS = mysql_fetch_assoc($CUENTAS_BANCARIAS));
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#F3F3F3" class="textos_form_derecha">Cheque inicial:</td>
      <td bgcolor="#F3F3F3"><input type="text" name="CHEQUE_INICIO" value="" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#F3F3F3" class="textos_form_derecha">Cheque Final:</td>
      <td bgcolor="#F3F3F3"><input type="text" name="CHEQUE_FIN" value="" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#F3F3F3" class="textos_form_derecha">Cantidad Digitos Numero de Cheque:</td>
      <td bgcolor="#F3F3F3"><input type="text" name="LONGITUD_NUMERO" value="6" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#F3F3F3" class="textos_form_derecha">Ultimo Cheque Emitido:</td>
      <td bgcolor="#F3F3F3"><input type="text" name="ULTIMO_CHEQUE" value="0" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#F3F3F3" class="textos_form_derecha">Automatica:</td>
      <td bgcolor="#F3F3F3"><input type="checkbox" name="AUTOMATICA" value="" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#F3F3F3" class="textos_form_derecha">Activa:</td>
      <td bgcolor="#F3F3F3"><input type="checkbox" name="ACTIVA" value="" checked="checked" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#F3F3F3" class="textos_form_derecha">Anulada:</td>
      <td bgcolor="#F3F3F3"><input type="checkbox" name="ANULADA" value="" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#F3F3F3"><?php if (validador(30,$_SESSION['i'],"inc")==1){?><input type="submit" class="ui-widget-header" value="Insertar registro" /><?php } ?></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form2" />
</form>
<form method="POST" name="form1" id="form1">
      <p>&nbsp;</p>
  <table width="990" align="center">
    <tr>
      <td align="center" bgcolor="#F3F3F3" class="textos_form" >ID
      <td align="center" bgcolor="#F3F3F3" class="textos_form" >Empresa      
      <td align="center" bgcolor="#F3F3F3" class="textos_form" >Proyecto      
      <td align="center" bgcolor="#F3F3F3" class="textos_form" >Banco      
      <td align="center" bgcolor="#F3F3F3" class="textos_form" >Cuenta      
      <td align="center" bgcolor="#F3F3F3" class="textos_form" >Inicio
      <td align="center" bgcolor="#F3F3F3" class="textos_form" >Fin  
      <td align="center" bgcolor="#F3F3F3" class="textos_form" >Ultimo Cheque    
      <td align="center" bgcolor="#F3F3F3" class="textos_form" >		
      <td align="center" bgcolor="#F3F3F3" class="textos_form" >			
    </tr>
          <?php do { ?>
          	<tr>
          	  <td align="left" bgcolor="#FFFFFF" ><?php echo $row_CONSULTAS['ID_CHEQUERA']; ?>
	          <td align="left" bgcolor="#FFFFFF" ><?php echo $row_CONSULTAS['NOMBRE_EMPRESA']; ?>                
   		      <td align="left" bgcolor="#FFFFFF" ><?php echo $row_CONSULTAS['NOMBRE_PROYECTO']; ?>                
   		      <td align="center" bgcolor="#FFFFFF" ><?php echo $row_CONSULTAS['NOMBRE_BANCO']; ?>                
   		      <td align="right" bgcolor="#FFFFFF" ><?php echo $row_CONSULTAS['NUMERO_CUENTA']; ?>                
   		      <td align="right" bgcolor="#FFFFFF" ><?php echo $row_CONSULTAS['CHEQUE_INICIO']; ?>
	          <td align="right" bgcolor="#FFFFFF" ><?php echo $row_CONSULTAS['CHEQUE_FIN']; ?>   
              <td align="right" bgcolor="#FFFFFF" ><?php echo $row_CONSULTAS['ULTIMO_CHEQUE']; ?>           
	          <?php if (validador(30,$_SESSION['i'],"edi")==1){?><td align="left" bgcolor="#FFFFFF" ><a href="edit.php?ID_CHEQUERA=<?php echo $row_CONSULTAS['ID_CHEQUERA']; ?>"><img src="../image/icon_doc.png" width="24" height="24" /></a></td><?php } ?>				
   		  <?php if (validador(30,$_SESSION['i'],"eli")==1){?><td align="left" bgcolor="#FFFFFF" ><?php if($row_CONSULTAS['TIENE_MOVIMIENTOS']==1){ ?><img src="../image/Delete-iconbw.png" width="24" height="24" /><?php } else { ?><a href="del.php?ID_CHEQUERA=<?php echo $row_CONSULTAS['ID_CHEQUERA']; ?>"><img src="../image/Delete-icon.png" width="24" height="24" /></a> <?php } ?>				  </td><?php } ?>				          	</tr>
          	<?php } while ($row_CONSULTAS = mysql_fetch_assoc($CONSULTAS)); ?>
  </table>
</form>
<p>&nbsp;</p>
<?php include("../include/_foot.php"); ?>

<p>&nbsp;</p>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
</script>
</body>
</html>
<?php


mysql_free_result($CONSULTAS);

mysql_free_result($CUENTAS_BANCARIAS);




?>