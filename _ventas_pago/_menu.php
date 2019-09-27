 <style type="text/css">

input.groovybutton
{
   font-size:14px;
   font-family:Tahoma,sans-serif;
   font-weight:bold;
   text-align:left;
   color:#FFFFFF;
   width:96px;
   height:26px;
   background-color:#1858B8;
   border-top-style:solid;
   border-top-color:#2878C0;
   border-top-width:1px;
   border-bottom-style:solid;
   border-bottom-color:#2878C0;
   border-bottom-width:1px;
   border-left-style:solid;
   border-left-color:#2878C0;
   border-left-width:6px;
   border-right-style:solid;
   border-right-color:#508CC0;
   border-right-width:6px;
}

</style>

<script language="javascript">

function goLite(FRM,BTN)
{
   window.document.forms[FRM].elements[BTN].style.backgroundColor = "#6FA7D1";
   window.document.forms[FRM].elements[BTN].style.borderTopColor = "#2888D8";
   window.document.forms[FRM].elements[BTN].style.borderBottomColor = "#2888D8";
   window.document.forms[FRM].elements[BTN].style.borderLeftColor = "#1864D0";
   window.document.forms[FRM].elements[BTN].style.borderRightColor = "#58A4E0";
}

function goDim(FRM,BTN)
{
   window.document.forms[FRM].elements[BTN].style.backgroundColor = "#1858B8";
   window.document.forms[FRM].elements[BTN].style.borderTopColor = "#2878C0";
   window.document.forms[FRM].elements[BTN].style.borderBottomColor = "#2878C0";
   window.document.forms[FRM].elements[BTN].style.borderLeftColor = "#2878C0";
   window.document.forms[FRM].elements[BTN].style.borderRightColor = "#508CC0";
}

</script>

  <table width="1100" border="0" align="center" cellpadding="4" cellspacing="0"><form action="#" method="get" id="enviar" name="groovyform">
        <tr>
          <td align="center" bgcolor="#6FA7D1"><?php if (validador(21,$_SESSION['i'],"inc")==1){?><input type="button" name="groovybtn1" class="groovybutton" value=" Insertar" title="" onMouseOver="goLite(this.form.name,this.name)" onMouseOut="goDim(this.form.name,this.name)" onClick="parent.location='../_doc_venta_listado/edit2.php?ID_DOCUMENTO=&col=FECHA_DOCUMENTO_DATE&orden=asc&elegido=&TIPO=0&PROYECTO=0002&STATUS=Todos&button=Buscar'"><?php } ?>            <input type="button" name="groovybtn2" class="groovybutton" value="  Buscar" title="" onmouseover="goLite(this.form.name,this.name)" onmouseout="goDim(this.form.name,this.name)" onClick="parent.location='index.php'" /></td>
        </tr></form>
        
      </table>

      